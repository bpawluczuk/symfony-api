<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 14:12
 */

namespace App\Products\Controller;

use App\Authentication\Annotation\TokenAuthentication;
use App\Products\CQRS\query\ProductItem;
use App\Products\CQRS\query\ProductList;
use App\Products\Entity\Product;
use App\Tools\Util\ApiResponseObjects;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
class ApiController extends Controller
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
     *                      @SWG\Property(property="id", type="integer",),
     *                      @SWG\Property(property="_locale", type="string",),
     *                      @SWG\Property(property="name", type="string",),
     *                      @SWG\Property(property="code", type="string",),
     *                      @SWG\Property(property="price", type="string",),
     *                      @SWG\Property(property="currency", type="string",),
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
     * @Route("/list", methods={"GET"}, name="list")
     * @return JsonResponse
     */
    public function getProducts()
    {
        $itemList = new ProductList($this->container, Product::class);
        $result = $itemList->getList();

        return $this->getSuccessResponse($result);
    }

    /**
     * @SWG\Parameter(
     *    name="id",
     *    type="integer",
     *    in="query",
     *    required=true,
     * )
     * @SWG\Response(
     *     response=200,
     *     description="products list",
     *     @SWG\Schema(
     *          @SWG\Property(
     *                  property="products",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="id", type="integer",),
     *                      @SWG\Property(property="_locale", type="string",),
     *                      @SWG\Property(property="name", type="string",),
     *                      @SWG\Property(property="code", type="string",),
     *                      @SWG\Property(property="price", type="string",),
     *                      @SWG\Property(property="currency", type="string",),
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
     * @Route("/item", methods={"GET"}, name="item")
     * @param Request $request
     * @return JsonResponse
     */
    public function getProduct(Request $request)
    {
        $id = (int)$request->get('id');

        $item = new ProductItem($this->container, Product::class);
        $result = $item->getItem($id);

        return $this->getSuccessResponse($result);
    }
}