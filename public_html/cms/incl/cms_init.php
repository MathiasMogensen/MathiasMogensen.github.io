<?php

/* - DEFINE DOCUMENT ROOT - */
define("DOCROOT", filter_input(INPUT_SERVER, "DOCUMENT_ROOT", FILTER_SANITIZE_STRING) . "/");

/* - DEFINE CORE ROOT - */
define("COREPATH", substr(DOCROOT, 0, strrpos(DOCROOT, "/", -2)) . "/core/");

/* - CLASS AUTOLOADER - */
require_once COREPATH . 'classes/autoloader.php';
/* - INITIALIZE DATABASE - */
$db = new db_conf();
$auth = new auth();
$auth->authenticate(true);
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $auth->logout();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if (isset($_GET['action']) && $_GET['action'] == 'register') {
    $auth->register_form();
}
