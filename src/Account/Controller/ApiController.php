<?php

namespace App\Account\Controller;

use App\Account\Entity\Account;
use App\Account\Security\PasswordEncoder;
use App\Account\ValueObject\Email;
use App\Account\ValueObject\FirstName;
use App\Account\ValueObject\LastName;
use App\Account\ValueObject\Password;
use App\Tools\Util\ApiResponseObjects;
use Doctrine\ORM\EntityManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Account\Controller
 * @Route("/v1")
 */
class ApiController extends Controller
{

    use ApiResponseObjects;

    /**
     * @SWG\Parameter(
     *    name="Create new account",
     *    in="body",
     *    description="account create object",
     *    required=true,
     *    @SWG\Schema(ref=@Model(type=Account::class, groups={"api"}))
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="account created",
     *     @SWG\Schema(
     *         @SWG\Property(property="_locale", type="string"),
     *         @SWG\Property(property="account", type="integer"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="wrong data",
     *     @SWG\Schema(
     *         @SWG\Property(property="status", type="string"),
     *         @SWG\Property(property="error_code", type="number"),
     *         @SWG\Property(property="message", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="account")
     *
     * @Route("/account", methods={"POST"}, name="create-account")
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @author Robert Glazer
     */
    public function createAction(Request $request)
    {
        $locale = $request->getLocale();
        $firstNamePost = $request->get('first_name');
        $lastNamePost = $request->get('last_name');
        $emailPost = $request->get('email');
        $passwordPost = $request->get('password');

        try {
            $firstName = new FirstName($firstNamePost);
        } catch (\Exception $exception) {
            return $this->getBadRequestErrorResponse($exception->getMessage());
        }

        try {
            $lastName = new LastName($lastNamePost);
        } catch (\Exception $exception) {
            return $this->getBadRequestErrorResponse($exception->getMessage());
        }

        try {
            $email = new Email($emailPost);
        } catch (\Exception $exception) {
            return $this->getBadRequestErrorResponse($exception->getMessage());
        }

        try {
            $password = new Password($passwordPost);
        } catch (\Exception $exception) {
            return $this->getBadRequestErrorResponse($exception->getMessage());
        }

        $accountEntity = new Account();
        $accountEntity
            ->setLocale($locale)
            ->setPassword(PasswordEncoder::encodePassword($password))
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->container->get('doctrine')->getManager();
        $entityManager->persist($accountEntity);
        $entityManager->flush();

        return $this->getSuccessResponse([
            '_locale' => $accountEntity->getLocale(),
            'email' => $accountEntity->getEmail()->get(),
            'firstname' => $accountEntity->getFirstName()->get(),
            'lastname' => $accountEntity->getLastName()->get(),
            'role' => ''
        ]);
    }

    /**
     * @SWG\Parameter(
     *    name="email",
     *    type="string",
     *    in="query",
     *    required=true,
     * )
     * @SWG\Parameter(
     *    name="password",
     *    type="string",
     *    in="query",
     *    required=true,
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="account id",
     *     @SWG\Schema(
     *         @SWG\Property(property="_locale", type="string"),
     *         @SWG\Property(property="account", type="integer"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response=403,
     *     description="account not exist or wrong password",
     *     @SWG\Schema(
     *         @SWG\Property(property="status", type="string"),
     *         @SWG\Property(property="error_code", type="number"),
     *         @SWG\Property(property="message", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="account")
     *
     * @Route("/account", methods={"GET"}, name="account-get")
     *
     * @param Request $request
     * @return JsonResponse
     * @author Borys Pawluczuk
     */
    public function getAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        /**
         * @var Account $account
         */
        $account = $this->getDoctrine()->getRepository(Account::class)->findOneBy([
            'email' => $email,
        ]);

        if (empty($account)) {
            return $this->getForbiddenErrorResponse("Account does not exist");
        }

        /**
         * @var PasswordEncoder $passwordEncoder
         */
        $passwordEncoder = new PasswordEncoder();
        $passwordOk = $passwordEncoder->isPasswordValid($account->getPassword(), $password);

        if (!$passwordOk) {
            return $this->getForbiddenErrorResponse("Wrong password");
        }

        return $this->getSuccessResponse([
            '_locale' => $account->getLocale(),
            'email' => $account->getEmail()->get(),
            'firstname' => $account->getFirstName()->get(),
            'lastname' => $account->getLastName()->get(),
            'role' => ''
        ]);
    }

}