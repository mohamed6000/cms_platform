<?php

session_start();
if (isset($_SESSION["account_id"])) {
    require_once("../core/bootstrap.php");
    $database = new Database();
    $account = new Account($database);
    $my_account = $account->get_single($_SESSION["account_id"]);
} else die();

?>

<form pt-post="api/update-profile.php" pt-target="#form_res">
    <div class="row">
        <div class="col-md-12">
            <div id="form_res"></div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="user_name">Nom d'utilisateur</label>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="user_name" placeholder="Nom d'utilisateur" value="@<?php echo $my_account["user_name"]; ?>" disabled>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="email">E-mail</label>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $my_account["email"]; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="first_name">Prénom</label>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Prénom" value="<?php echo $my_account["first_name"]; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="last_name">Nom</label>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nom" value="<?php echo $my_account["last_name"]; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="phone">Tel</label>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Tel" value="<?php echo $my_account["phone"]; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="address">Adresse</label>
        </div>
        <div class="col-md-6">
            <textarea class="form-control" id="address" name="address" placeholder="Adresse"><?php echo $my_account["address"]; ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="gender">Sexe</label>
        </div>
        <div class="col-md-6">
            <select class="form-control" id="gender" name="gender">
                <option value="">Sélectionner</option>
                <option value="male" <?php echo ($my_account["gender"] == "male") ? "selected" : ""; ?>>Homme</option>
                <option value="female" <?php echo ($my_account["gender"] == "female") ? "selected" : ""; ?>>Femme</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="birth_date">Date de naissance</label>
        </div>
        <div class="col-md-6">
            <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Date de naissance" value="<?php echo $my_account["birth_date"]; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </div>
    </div>
</form>