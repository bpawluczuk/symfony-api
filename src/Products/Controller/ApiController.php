<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 14:12
 */

namespace App\Products\Controller;

use App\Authentication\Annotation\TokenAuthentication;
use App\Tools\Util\ApiResponseObjects;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class ApiController
 * @package App\Products\Controller
 * @author Borys Pawluczuk
 * @Route("/v1/products")
 */
class ApiController extends AbstractController
{
    use ApiResponseObjects;

    /**
     * @SWG\Response(
     *     response=200,
     *     description="products list",
     *     @SWG\Schema(
     *          @SWG\Property(
     *                  property="products",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="_locale", type="string",),
     *                      @SWG\Property(property="code", type="string",),
     *                      @SWG\Property(property="name", type="string",),
     *                  ),
     *              ),
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
     * @SWG\Tag(name="products")
     *
     * @Route("/get", methods={"GET"}, name="get")
     * @return JsonResponse
     */
    public function getProducts()
    {
        $products[] = [
            'id' => 1,
            'name' => 'telewizor',
            'price' => 9800,
            'currency' => 'PLN',
        ];

        return $this->getSuccessResponse($products);
    }
}