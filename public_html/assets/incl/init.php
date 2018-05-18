<?php

    /* Define Document Root */
    define("DOCROOT", filter_input(INPUT_SERVER, "DOCUMENT_ROOT", FILTER_SANITIZE_STRING));
    /* Define Core Root */
    define("COREPATH", substr(DOCROOT, 0, strrpos(DOCROOT,"/")) . "/core/");

    define("CURRENT_URL", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

    require_once(COREPATH . "classes/autoloader.php");
    
    $db = new db_conf();
    $auth = new auth();
    $auth->auth_role = "guest";
    $auth->authenticate(false);
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        $auth->logout();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $commentsClass = new comments();
    $ingredientsClass = new ingredients();
    $productsClass = new products();
    $paginationClass = new pagination();
?>