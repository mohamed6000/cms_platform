<?php
session_start();

$database       = new Database();
$site_settings  = new SiteSettings($database);
$account        = new Account($database);
$infos          = $site_settings->get_global_infos();
$notification   = new Notification($database);
$store_product  = new StoreProduct($database);
$store_category = new StoreCategory($database);
$store_basket   = new StoreBasket($database);
$order          = new Order($database);

if ($infos["published"] === 0) {
    include "under-maintenance.html";
    die();
}

if (isset($_SESSION["account_id"])) {
    $my_account         = $account->get_single($_SESSION["account_id"]);
    $notification_list  = $notification->get_all($_SESSION["account_id"]);
    $notification_count = $notification->get_non_visited_count($_SESSION["account_id"]);
    $basket_count       = $store_basket->get_count_by_client($_SESSION["account_id"]);
}

?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $infos["description"]; ?>">
    <meta name="keywords" content="<?php echo $infos["keywords"]; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
    <?php 
        if (isset($page_title) && !empty($page_title)) {
            echo $page_title ." : : ". $infos["site_name"];
        } else {
            echo $infos["site_name"];
        }
    ?>
    </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo $template; ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $template; ?>css/style.css" type="text/css">

    <?php

    if (isset($use_pt)) {
        echo '<!-- my frontend library -->';
        echo '<script src="/pt.js"></script>';
    }

    ?>
<style type="text/css">
    .me-3 {
        margin-right: 1rem !important;
    }
    .w-px-40 {
        width: 40px !important;
    }
    .float-start {
        float: left !important;
    }
</style>
</head>

<body>
    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
        <?php if (isset($_SESSION["account_id"])) { ?>
            <li>
                <a href="/basket">
                    <span class="icon_cart_alt"></span>
                    <?php if ($basket_count > 0) { ?>
                    <div class="tip"><?php echo $basket_count; ?></div>
                    <?php } ?>
                </a>
            </li>

            <li>
                <a href="/notifications">
                    <span class="icon_bag_alt"></span>
                    <?php if ($notification_count > 0) { ?>
                    <div class="tip"><?php echo $notification_count; ?></div>
                    <?php } ?>
                </a>
             </li>
        <?php } ?>
        </ul>
        <div class="offcanvas__logo">
            <a href="/"><img src="<?php echo $infos["logo"]; ?>" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <?php if (!isset($_SESSION["account_id"])) { ?>
        <div class="offcanvas__auth">
            <a href="/login">Connexion</a>
            <a href="/register">Inscription</a>
        </div>
        <?php } ?>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="/"><img src="<?php echo $infos["logo"]; ?>" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="/">Acceuil</a></li>
                            <li><a href="/shop">Boutique</a></li>
                            <?php if (isset($_SESSION["account_id"])) { ?>
                            <li><a href="#"><i class="fa fa-user"></i> <?php echo $my_account["user_name"]; ?></a>
                                <ul class="dropdown">
                                <?php if ($my_account["role"] == "client") { ?>
                                    <li><a href="/profile">Profil</a></li>
                                    <li><a href="/bills">Factures</a></li>
                                    <li><a href="/pTicket/">Tickets</a></li>
                                <?php } else if ($my_account["role"] == "technician") { ?>
                                    <li><a href="/tech/">Tableau de bord</a></li>
                                    <li><a href="/pTicket/">Tickets</a></li>
                                <?php } ?>
                                    <li><a href="#" pt-post="api/logout.php">
                                        <i class="fa fa-sign-out"></i> déconnecter
                                    </a></li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <?php if (!isset($_SESSION["account_id"])) { ?>
                        <div class="header__right__auth">
                            <a href="/login">Connexion</a>
                            <a href="/register">Inscription</a>
                        </div>
                        <?php } ?>
                        <ul class="header__right__widget">
                            <?php if (isset($_SESSION["account_id"])) { ?>
                            <li>
                                <a href="/basket">
                                    <span class="icon_cart_alt"></span>
                                    <?php if ($basket_count > 0) { ?>
                                    <div class="tip"><?php echo $basket_count; ?></div>
                                    <?php } ?>
                                </a>
                            </li>

                            <li>
                                <div class="dropdown show">
                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon_bag_alt"></span>
                                        <?php if ($notification_count > 0) { ?>
                                            <div class="tip"><?php echo $notification_count; ?></div>
                                        <?php } ?>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <?php foreach ($notification_list as $key => $row) { ?>
                                        <li>
                                           <a class="dropdown-item" 
                                           href="<?php echo $row["corresponding_url"]; ?>" 
                                           pt-post="../api/notification-visit.php?id=<?php echo $row["id"]; ?>">
                                            <div class="d-flex" style="font-size: 13px;">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="<?php echo $row["corresponding_image"]; ?>" alt class="w-px-40 h-auto rounded-circle" style="vertical-align: middle;" />
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="d-block" style="<?php echo ($row["visited"] == 0) ? "font-weight: 700;" : ""; ?>">
                                                    <?php echo $row["title"]; ?>
                                                    </span>
                                                    <small class="text-muted" style="<?php echo ($row["visited"] == 0) ? "font-weight: 700;" : ""; ?>">
                                                    <?php echo $row["content"]; ?>
                                                    </small>
                                                    <div class="float-start">
                                                        <small class="text-muted" style="<?php echo ($row["visited"] == 0) ? "font-weight: 700;" : ""; ?>">
                                                            <i class='bx bx-time'></i>
                                                            <?php echo $row["date_created"]; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        </li>
                                        <?php } ?>

                                        <a class="dropdown-item" style="font-size: 13px; font-weight: 700; text-align: center;" href="/notifications">Voir Tous</a>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->


