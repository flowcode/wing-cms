<?php

$setup = array(
    "homepage" => array(
        "permalink" => "home",
    ),
    "admin" => array(
        "controller" => "AdminHome",
    ),
    "post" => array(
        "controller" => "Post",
        "actions" => array(
            "*" => "post",
        ),
    ),
);
?>
