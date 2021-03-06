<?php

namespace App\Controller;


use App\Authentication\Annotation\TokenAuthentication;
use App\Products\Entity\Product;
use App\Tools\Util\ApiResponseObjects;
use App\Tools\Util\Stream;
use Doctrine\Common\Collections\ArrayCollection;
use Firebase\JWT\JWT;
use Google_Client;
use React\EventLoop\Factory;
use Rx\Observable;
use Rx\React\Http;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use Rx\Observer\CallbackObserver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use GuzzleHttp\Psr7;

/**
 * Class BpTestController
 * @package App\Controller
 */
class BpTestController extends AbstractController
{
    use ApiResponseObjects;

    /**
     * @Route("/bp/google-oauth", name="google-oauth")
     */
    public function googleOAuth()
    {
        $client = new Google_Client();
        $client->setClientId('777630205386-cf041osdos4nkbimert63tc55hpjj15i.apps.googleusercontent.com');
        $client->setClientSecret('6pEF7_xzpUXbFpHVnvrcNCvJ');
        $client->setApplicationName("OAuth test");
        $client->setRedirectUri("https://test.itse.pl/auth.php");
        $client->setScopes("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

        echo $client->createAuthUrl();

        return new Response();
    }

    /**
     * @Route("/bp/token", name="bp_token")
     */
    public function createToken()
    {
        $privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDIBSovT8ooDGP6IA7CB/TMbBbTCuKAHJ2PG3/sv74lR1/jhv3x
mfiJkyV+yrUy4nkmsoiWQ4tww+2YHNpYncrPIC8XHpwBLwiR2syEBpEr4GF71pgG
AfxEWKKESR+fbSH5exrg1Ly7au7TL1NqpxKxu6rtRpV3aCLFg5RQVtIdIwIDAQAB
AoGBAIDjAxnVelhwE4Q7YAcbhVysUdDP9L/EsKpkd/wgWfA/m8RLWhtysbpEvSaE
jForoRGUfXsGLzYMqm8YOIJduy6y0Yz5ZB6BYdEuWZAGeYbidlcu5VAAw5Aum3c1
fqAGwezh4hbmad/jhlHj6b022+K+ZYMDCEOx06s+PfECwUoRAkEA/pEC8TQBYIo8
Cmdk0hzdL19kzAN3MxzR4Xi6N0CZeMAXw/GB/wNfn+O9TkUIRXJB/0eNwFd5J/pL
UbR6GZUvRwJBAMklhKitYtCc/lytoj3ju0ly7lVSgBnjHXAxq81iHJssc/tH6xuB
bafSUvV2mJi8cgzE8HCzuckOE6NDg3OmKUUCQFADVlBoDzK/4EVI4EimZ+M28aCq
SjIXkeRzpNwvAs4QWqfs5fY4ojrIQz0xt3rUgefyHpzhIaSuKDRjLKmT2YsCQFFQ
x4ZhQbdQIExbLWGTtN0Gh28awQq2E+qNSgTniuT4XZLSCiu+cRQNJNhyr1HfrMOY
whLttUegVzQDURrpq3kCQF5asXEf9T1My826yUN6Fxy3PdNAzUO1jJ56TMiLqaeo
uwYTJ2aNsdUfbv9X3U7VTnOsUnd6iMl1nATAgHVAxIc=
-----END RSA PRIVATE KEY-----
EOD;

        $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIBSovT8ooDGP6IA7CB/TMbBbT
CuKAHJ2PG3/sv74lR1/jhv3xmfiJkyV+yrUy4nkmsoiWQ4tww+2YHNpYncrPIC8X
HpwBLwiR2syEBpEr4GF71pgGAfxEWKKESR+fbSH5exrg1Ly7au7TL1NqpxKxu6rt
RpV3aCLFg5RQVtIdIwIDAQAB
-----END PUBLIC KEY-----
EOD;


        $token = array(
            'account' => 1,
            'email' => 'b.pawluczuk@companion.pl',
            'firstname' => '',
            'lastname' => '',
            'admin' => true,
            'expiration' => time(),
        );

        $jwt = JWT::encode($token, $privateKey, 'RS256');
        echo "Encode:\n" . print_r($jwt, true) . "\n";

        $decoded = JWT::decode($jwt, $publicKey, array('RS256'));

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

        $decoded_array = (array)$decoded;
        echo "Decode:\n" . print_r($decoded_array, true) . "\n";

        return new Response();
    }

    /**
     * @Route("/bp/test", name="bp_test")
     */
    public function index()
    {
        return $this->render('bp_test/index.html.twig', [
            'controller_name' => 'BpTestController',
        ]);
    }

    /**
     * @Route("/bp/get-hero", name="get-hero")
     * @TokenAuthentication
     * @param Request $request
     * @return JsonResponse
     */
    public function indexJson(Request $request)
    {
        $result = [
            [
                'id' => 1,
                'name' => 'Mr. Nice',
            ],
            [
                'id' => 2,
                'name' => 'Narco',
            ],
            [
                'id' => 3,
                'name' => $request->headers->get('Authorization'),
            ],
        ];
        $response = new JsonResponse($result);
        $response->headers->set('Cache-Control', 'private, no-cache');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/products/{code}", name="products")
     * @param Request $request
     * @return JsonResponse
     */
    public function productList(Request $request)
    {
        $result = [];

        $code = $request->get('code');

        $products = [
            [
                "code" => "001",
                "name" => "telewizor",
            ],
            [
                "code" => "002",
                "name" => "gitara",
            ],
            [
                "code" => "003",
                "name" => "komputer",
            ],
        ];

        $product = array_filter($products, function ($data) use ($code) {
            return $data['code'] == $code;
        });

        foreach ($product as $item) $result = $item;

        $response = new JsonResponse($result);
        $response->headers->set('Cache-Control', 'private, no-cache');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/prices/{code}", name="prices")
     * @param Request $request
     * @return JsonResponse
     */
    public function priceList(Request $request)
    {
        $result = [];

        $code = $request->get('code');

        $prices = [
            [
                "code" => "001",
                "price" => 6700,
            ],
            [
                "code" => "002",
                "price" => 8500,
            ],
            [
                "code" => "003",
                "price" => 3000,
            ],
        ];


        $price = array_filter($prices, function ($data) use ($code) {
            return $data['code'] == $code;
        });

        foreach ($price as $item) $result = $item;

        $response = new JsonResponse($result);
        $response->headers->set('Cache-Control', 'private, no-cache');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/products-rx", name="products-rx")
     * @return JsonResponse
     */
    public function rxTest()
    {
        $result = [];

        $products = Http::get('http://symfony-api.localhost/products/002');
        $prices = Http::get('http://symfony-api.localhost/prices/002');

        $products
            ->map(function ($response) {
                return json_decode($response, true);
            });

        $prices
            ->map(function ($response) {
                return json_decode($response, true);
            });

        $products
            ->zip([$prices], function ($item_1, $item_2) {
                $item_j1 = json_decode($item_1, true);
                $item_j2 = json_decode($item_2, true);
                return [
                    'code' => $item_j1['code'],
                    'name' => $item_j1['name'],
                    'price' => $item_j2['price'],
                ];
            })
            ->subscribe(function ($data) {
//                echo var_dump($data);
            });

        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository(Product::class);
        $prod = $repo->findAll();

        $stream = new Stream($prod);

        $result = $stream->map(function ($value) {
            return $value->getName();
        })->asArray();


        //return new Response();
        $response = new JsonResponse($result);
        $response->headers->set('Cache-Control', 'private, no-cache');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function httpGetAndZip()
    {
        $observable = Observable::create(function () {
        });

        return $observable->zip([
                Http::get('http://symfony-api.localhost/products'),
                Http::get('http://symfony-api.localhost/prices')
            ]
        );
    }
}
