<?php

session_start();
if (isset($_SESSION["account_id"])) {
    require_once("../core/bootstrap.php");
    $database = new Database();
    $account = new Account($database);
    $my_account = $account->get_single($_SESSION["account_id"]);
} else die();

?>

<div class="row">
        <div class="col-md-6">
            <label>Nom d'utilisateur</label>
        </div>
        <div class="col-md-6">
            <p>@<?php echo $my_account["user_name"]; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>E-mail</label>
        </div>
        <div class="col-md-6">
            <p><?php echo $my_account["email"]; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Prénom & Nom</label>
        </div>
        <div class="col-md-6">
            <p><?php echo $my_account["first_name"]." ".$my_account["last_name"]; ?></p>
        </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Tel</label>
            </div>
            <div class="col-md-6">
                <p><?php echo $my_account["phone"]; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Adresse</label>
            </div>
            <div class="col-md-6">
                <p><?php echo $my_account["address"]; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Sexe</label>
            </div>
            <div class="col-md-6">
                <p><?php echo ($my_account["gender"] == "male") ? "Homme" : "Femme"; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Date de naissance</label>
            </div>
            <div class="col-md-6">
                <p><?php echo $my_account["birth_date"]; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Date d'inscription</label>
            </div>
            <div class="col-md-6">
                <p><?php echo $my_account["register_date"]; ?></p>
            </div>
        </div>