<?php

session_start();

$database = new Database();
$account  = new Account($database);
$site_settings = new SiteSettings($database);
$ticket = new Ticket($database);
$ticket_department = new TicketDepartment($database);

$infos = $site_settings->get_global_infos();

$my_id = false;
if (isset($_SESSION["tu_id"])) {
    $my_id = $_SESSION["tu_id"];
} else {
    if (isset($_SESSION["admin_id"])) {
        $my_id = $_SESSION["admin_id"];
        $_SESSION["tu_id"] = $my_id;
    } else if (isset($_SESSION["account_id"])) {
        $my_id = $_SESSION["account_id"];
        $_SESSION["tu_id"] = $my_id;
    }
}

if ($my_id) {
    $my_account = $account->get_single($my_id);
} else {
    header("Location: /");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    <?php
    if (isset($page_title)) {
        echo "Systéme Ticket | ".$page_title;
    } else {
        echo "Systéme Ticket";
    }
    ?>
    </title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/display.css">

    <script type="text/javascript" src="../pt.js"></script>
</head>
<body>
    <div class="top">
        <div class="top_content">
            <div class="float-left">
                <span class="h1">
                    <a href="/pTicket/">SupportSystem</a>
                    <small style="font-size: 13px;">Version: 1.0</small>
                </span>
            </div>
            <div class="float-right">
                <?php if ($my_id) { ?>
                <div class="toolbar">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group">
                            <button class="btn btn-danger btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                Bienvenue {<?php echo $my_account["user_name"]; ?>}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                if (isset($_SESSION["admin_id"]) || isset($_SESSION["account_id"])) {
                                    if ($my_id == $_SESSION["admin_id"]) {
                                        echo '<li><a href="/admin-dashboard/"><img src="assets/images/system.png"> Panneau d\'administration</a></li>';
                                        echo '<li><a href="/pTicket/department"><img src="assets/images/list_departments.gif"> Départements</a></li>';
                                    } else if ($my_id == $_SESSION["account_id"]) {
                                        if ($_SESSION["account_role"] == "technician") {
                                            echo '<li><a href="/tech/"><img src="assets/images/user.png"> Tableau de board</a></li>';
                                        } else if ($_SESSION["account_role"] == "client") {
                                            echo '<li><a href="/profile"><img src="assets/images/mine.gif"> Profil</a></li>';
                                        }
                                    }

                                    if (isset($_SESSION["admin_id"]) && isset($_SESSION["account_id"])) {
                                        if ($my_id == $_SESSION["admin_id"]) {
                                            echo '<hr><li><a href="#" pt-post="../api/ticket-switch-account.php?type=account"><img src="assets/images/teams.png"> Passer au compte '. Utils::get_account_role_string($_SESSION["account_role"]) .'</a></li>';
                                        } else if ($my_id == $_SESSION["account_id"]) {
                                            echo '<hr><li><a href="#" pt-post="../api/ticket-switch-account.php?type=admin"><img src="assets/images/teams.png"> Passer au compte administrateur</a></li>';
                                        }
                                    }
                                }
                                ?>
                                <li><a href="#" pt-post="../api/ticket-logout.php">Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <a href="/login" target="_blank">Se connecter</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="wrapper_content">

            <div class="quick_bar">
                <div class="float-left">
                    <a href="/pTicket/"class="btn btn-warning" title="Tableau de bord"><img src="assets/images/home.png"></a>
                    <a href="/pTicket/tickets" class="btn btn-info" title="Tickets"><img src="assets/images/open.gif"></a>
                </div>
                <div class="float-right">
                    <a href="/pTicket/new" class="btn btn-success" title="Ajouter Ticket"><img src="assets/images/new.png"></a>
                    <a href="/pTicket/closed" class="btn btn-danger" title="Closed"><img src="assets/images/closed.gif"></a>
                    <a href="/pTicket/search" class="btn btn-primary" title="Search"><img src="assets/images/ZoomHS.png"></a>
                </div>
            </div>


