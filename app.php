<?php

$allowed = array();
$allowed[] = "127.0.0.1";
$ip = $_SERVER['REMOTE_ADDR'];

if (!in_array($ip, $allowed)) {
    echo die("You are not allowed.");
    exit;
}

$kernel_dir = __DIR__ . '/src/flowcode/wing/mvc/Kernel.php';

require_once $kernel_dir;

use flowcode\wing\mvc\Kernel;

$kernel = new Kernel();
$kernel->init("prod");

$kernel->handleRequest($_SERVER['REQUEST_URI']);
?>
