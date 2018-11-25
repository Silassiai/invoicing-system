<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 21:18
 */
$hook = [];

$hook['pre_controller'][] = [
    'class' => 'Authenticate',
    'method' => 'checkAuth',
];