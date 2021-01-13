<?php
    // Routes

    $tmpl   = 'inc/tmpl/';    // Template ROUTE
    $css    = 'layout/css/';  // CSS ROUTE
    $fun    = 'inc/func/';     // Function Route
    $js     = 'layout/js/';   // Js ROUTE
    $lang   = 'inc/lang/';
    $font   = 'layout/webfonts/';
    $img    = 'layout/img/';
    include "connect.php";
    include $fun  . 'functions.php';
    include $lang . 'en.php';
    include $tmpl . 'header.php';

    if(isset($navbar) && $navbar == 1){ include $tmpl . 'navbar.php'; }

?>
