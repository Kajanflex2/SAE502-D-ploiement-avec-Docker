<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

#$absolute_path = $_SERVER['DOCUMENT_ROOT'] . "/hefo/header.php";

require __DIR__ . '/../../hefo/header.php';


// check login status 
if(!isset($_SESSION['user-id'])){
    header('location: ' . $base_url . 'signin.php');
    die();
}

?>