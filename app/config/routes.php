<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:50
 */

$route = [];
$route['user/get'] = ['User', 'getUserById', ['int', 'string']];
$route['invoices'] = ['Invoice', '', ['int', 'string']];
$route['invoices/export'] = ['Invoice', 'exportCsv', ['int', 'string']];