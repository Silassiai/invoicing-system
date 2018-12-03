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
use lib\CsvHelper;

class Invoice extends Controller
{
    public function index()
    {
        $this->model = new ModelInvoice();
        $data['invoices'] = $this->view->paginate($this->model->getInvoices());

        $this->view->load('templates/header');
        $this->view->load('pages/invoices/index', $data);
        $this->view->load('templates/footer');
    }

    public function exportCsv()
    {
        $this->model = new ModelInvoice();

        $invoices = $this->model->getInvoices();

        $csv = new CsvHelper();
        $csv->arrayToCsv($invoices);

        $this->index();
    }
}