<?php

namespace App\Authentication\Controller;

use App\Authentication\AccountDto;
use App\Authentication\TokenManager;
use App\Tools\Util\ApiResponseObjects;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\Translation\TranslatorInterface;
use GuzzleHttp\Psr7;

/**
 * Class ApiController
 * @package App\Authentication\Controller
 * @author Borys Pawluczuk
 * @Route("/v1")
 */
class ApiController extends Controller
{
    use ApiResponseObjects;

    /**
     * @SWG\Parameter(
     *    name="login properties",
     *    in="body",
     *    description="login properties",
     *    required=true,
     *     @SWG\Schema(
     *          @SWG\Property(property="_locale", type="string", example="pl"),
     *          @SWG\Property(property="email", type="string", example="b.pawluczuk@companion.pl"),
     *          @SWG\Property(property="password", type="string", example="Qazwsx1"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Login to service and get access token",
     *     @SWG\Schema(
     *         @SWG\Property(property="_locale", type="string"),
     *         @SWG\Property(property="access_token", type="string"),
     *     )
     * )
     *
     * @SWG\Response(
     *     response=404,
     *     description="Account not exist",
     *     @SWG\Schema(
     *         @SWG\Property(property="status", type="string"),
     *         @SWG\Property(property="error_code", type="number"),
     *         @SWG\Property(property="message", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="authentication")
     *
     * @Route("/authenticate", methods={"POST"}, name="authenticate")
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author Borys Pawluczuk
     */
    public function authenticateAction(Request $request, TranslatorInterface $translator)
    {
        $locale = $request->getLocale();

        $email = $request->get('email');
        $password = $request->get('password');

        $client = new Client(['http_errors' => false]);

        $uri = 'http://friendback-api.localhost/api/' . $locale . '/v1/account';
        $response = $client->request('GET', $uri, [
            'query' => [
                '_locale' => $locale,
                'email' => $email,
                'password' => $password,
            ]
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            $response = json_decode($response->getBody(), true);
            $accountDto = new AccountDto(
                $response['data']['_locale'],
                $response['data']['firstname'],
                $response['data']['lastname'],
                $response['data']['email']
            );
        } else {
            return $this->getBadRequestErrorResponse("Wrong email or password");
        }

        $tokenManager = new TokenManager($this->container);
        $accountTokens = $tokenManager->generateJwtToken($accountDto);

        return $this->getSuccessResponse(
            [
                'access_token' => $accountTokens->getAccessToken(),
            ]
        );
    }

}