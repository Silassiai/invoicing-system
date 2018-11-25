<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 22:36
 */

function dd($obj){
    echo '<pre>';
    var_dump($obj);
    echo '</pre>'; exit;
}

function site_url($uri = ''){
    return BASE_URL . $uri;
}