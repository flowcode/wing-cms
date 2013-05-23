<?php

$setup = array(
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
