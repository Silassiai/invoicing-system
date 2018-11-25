<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:53
 */

namespace controllers;

use core\Controller as Controller;
use models\ModelUser as ModelUser;

class User extends Controller
{
    public function getUserById($userid = 0)
    {
        $user = new ModelUser();
        echo '<pre>';
        var_dump($user->getUser($userid));
    }
}