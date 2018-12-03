<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:54
 */

namespace core;

class Controller
{
    protected $model = null;
    public $view = null;

    public function __construct()
    {
        $this->view = new View($this);
    }
    
    /**
     * getCSRFToken
     * get or set CSRF token used for ajax calls
     * @param bool $new
     * @return mixed
     */
    public function getCSRFToken($new = true)
    {
        if ($new === true) {
            // create new token
            Application::sessionSet('token', bin2hex(openssl_random_pseudo_bytes(32)));

        }
        return Application::sessionGet('token');
    }

    /**
     * returns an ajax error
     * @param $msg
     */
    public static function badRequest($msg)
    {
        header('HTTP/1.1 400 ' . $msg);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($msg);
        exit;
    }

    public function notFound()
    {
        http_response_code(404);
        echo '404 page';
    }
}
