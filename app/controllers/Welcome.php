<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:54
 */

namespace controllers;

use core\Controller as Controller;

class Welcome extends Controller
{
    public function index()
    {
        $this->view->load('templates/header');
        $this->view->load('pages/index');
        $this->view->load('templates/footer');
    }
}