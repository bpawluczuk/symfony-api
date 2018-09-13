<?php
/**
 * Created by PhpStorm.
 * User: Borys
 * Date: 2017-11-27
 * Time: 14:46
 */

namespace App\Authentication;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Token
 * @package App\Authentication
 * @author Borys Pawluczuk
 */
class Token
{
    private $request;

    /**
     * Token constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function instance(Request $request){
        return new Token($request);
    }

    public function getToken()
    {
        $accessToken = $this->request->headers->get('access-token');
        if (empty($accessToken))
            $accessToken = $this->request->query->get('access-token');
        $accessToken = str_replace(' ', '', $accessToken);
        $accessToken = str_replace('key=', '', $accessToken);
        return $accessToken;
    }

    public function getRefreshToken()
    {
        $refreshToken = $this->request->headers->get('refresh-token');
        if (empty($refreshToken))
            $refreshToken = $this->request->query->get('refresh-token');
        $refreshToken = str_replace(' ', '', $refreshToken);
        $refreshToken = str_replace('key=', '', $refreshToken);
        return $refreshToken;
    }

}