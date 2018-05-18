<?php
    require("init.php");
    if ($pageTitle == "Forside") {
        $navbarBackground = "rgba(0,0,0,0)";
        $navbarPosition = "absolute";
    } else {
        $navbarBackground = "#5f7b93";
        $navbarPosition = "static";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="better seo xd">

    <title><?=$pageTitle?> | Bageriet</title>

    <!-- BOOTSTRAP & JQUERY -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- SCRIPTS -->
    <script type="text/javascript" src="/assets/js/livequery.js"></script>
    <script type="text/javascript" src="/assets/js/validate.js"></script>

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="/assets/css/master.css">
</head>
<header>
    <nav style="background-color: <?=$navbarBackground?> !important;position:<?=$navbarPosition?>" class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="material-icons burger-icon">menu</i>
        </button>
        
        <div class="collapse navbar-collapse mr-auto" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/">forside <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/product/list.php">produkter</a>
                </li>
                <a class="navbar-brand" href="/">bageriet</a>
                <li class="nav-item active">
                    <a class="nav-link" href="/contact.php">kontakt</a>
                </li>
                <?php if (!$auth->auth_user_id) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-toggle="modal" data-target="#loginModal">login</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=logout">log ud</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_GET['s'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/product/list.php">
                            <i id="search" style="font-size:18px;font-weight:400" class="material-icons">close</i>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <div class="nav-link" href="#">
                            <i id="search" style="font-size:18px;font-weight:400" class="material-icons">search</i>
                            <form id="search_form" class="search" method="get" action="/product/list.php?">
                                <input class="search-input" type="text" name="s">
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php if ($auth->auth_user_id) : ?>
            <ul class="navbar-nav navbar-user">
                <li class="nav-item">
                    <a class="nav-link" href="/user/profile.php"><i class="material-icons">person</i>  <?=$auth->auth_firstname?></a>
                </li>
            </ul>
        <?php endif; ?>
    </nav>
</header>
<body>
<?php {
    // Login Modal
    require_once(DOCROOT."/assets/incl/modals/loginModal.php");
}