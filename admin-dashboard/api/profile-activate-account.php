<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    $database = new Database();
    $account = new Account($database);

    // Utils::begin_session();
    session_start();
    
    $my_id = false;
    if (isset($_SESSION["admin_id"])) {
        $my_id = $_SESSION["admin_id"];
    }

    if ($my_id) {
        if ($account->activate($my_id)) {
            echo '<div class="mb-3 col-12 mb-0">
                    <div class="alert alert-warning">
                        <h6 class="alert-heading fw-bold mb-1">Êtes-vous sûr de vouloir supprimer votre compte ?</h6>
                        <p class="mb-0">Une fois votre compte supprimé, vous ne pourrez plus revenir en arrière. Soyez-en sûr, s\'il vous plaît.</p>
                    </div>
                  </div>
                    
                  <form pt-post="api/profile-deactivate-account.php" pt-target="#deactivation_result">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="account_activation" id="account_activation">
                            <label class="form-check-label" for="account_activation">Je confirme la désactivation de mon compte</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Désactiver le compte</button>
                  </form>';
        }
    }
}

?>