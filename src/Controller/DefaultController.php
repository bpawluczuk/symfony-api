<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 09:43
 */

namespace App\Controller;

use App\Authentication\Annotation\TokenAuthentication;
use App\Tools\Util\ApiResponseObjects;
use Firebase\JWT\JWT;
use Google_Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     * @Route("/")
     */
    public function index(Request $request)
    {
        return new Response('
            <html>
                <body>
                    <h1>Hello Symfony 4 World</h1>
                </body>
            </html>
        ');
    }

//    /**
//     * @param Request $request
//     * @return Response
//     * @Route("/bp/hello")
//     */
//    public function hello(Request $request)
//    {
//        return new Response();
//    }
}