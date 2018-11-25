<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25-11-2018
 * Time: 0:12
 */

namespace controllers;

use core\Controller as Controller;
use models\ModelInvoice;

class Invoice extends Controller
{
    public function index(){
        $this->model = new ModelInvoice();
        $data['invoices'] = $this->model->getInvoices();
        dd($data['invoices']);
        $this->view('templates/header');
        $this->view('pages/invoices/index', $data);
        $this->view('templates/footer');
    }
}