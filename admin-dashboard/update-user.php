<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$account = new Account($database);

$my_id = false;
if (isset($_GET["id"])) {
  $my_id = intval($_GET["id"]);
}

if (empty($my_id)) {
  header("Location: /admin-dashboard/");
}

$user_account = $account->get_single($my_id);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>
    Administration | <?php echo (empty($user_account["first_name"]) || empty($user_account["last_name"])) ? $user_account["user_name"] : ($user_account["first_name"] . " " . $user_account["last_name"]) ?>
    </title>

    <!-- my frontend library -->
    <script src="/pt.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php include "templates/menu.php"; ?>

        <!-- Layout container -->
        <div class="layout-page">
          <?php include "templates/navbar.php"; ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">
                  <span class="text-muted fw-light">
                  <?php echo (empty($user_account["first_name"]) || empty($user_account["last_name"])) ? $user_account["user_name"] : ($user_account["first_name"] . " " . $user_account["last_name"]) ?>
                  /</span> Mettre à jour</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="add-user.php"><i class="bx bx-user-plus me-1"></i> Ajouter un compte</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="user.php?id=<?php echo $user_account["id"]; ?>">
                        <i class="bx bxs-user-pin me-1"></i> Voir Profil
                      </a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header"><?php echo (empty($user_account["first_name"]) || empty($user_account["last_name"])) ? $user_account["user_name"] : ($user_account["first_name"] . " " . $user_account["last_name"]) ?></h5>
                    <hr class="my-0">
                    
                    <div class="card-body">
                      <form id="formAccountSettings" pt-post="api/update-user.php?id=<?php echo $user_account["id"]; ?>" pt-target="#result">
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <div id="result"></div>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email" placeholder="john.doe@example.com" value="<?php echo $user_account["email"]; ?>" autofocus="">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="user_name" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_account["user_name"]; ?>">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="***********">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="password2" class="form-label">Confirme mot de passe</label>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="***********">
                          </div>
                        
                          <div class="mb-3 col-md-6">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $user_account["first_name"]; ?>">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="last_name" class="form-label">Nom</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $user_account["last_name"]; ?>">
                          </div>
                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phone">Numéro de téléphone</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">TN (+216)</span>
                              <input type="text" id="phone" name="phone" class="form-control" placeholder="20 255 501" value="<?php echo $user_account["phone"]; ?>">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $user_account["address"]; ?>">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="gender" class="form-label">Sexe</label>
                            <select id="gender" name="gender" class="select2 form-select">
                                <option value="">Sélectionnez le sexe</option>
                                <option value="male" <?php echo $user_account["gender"] == "male" ? "selected" : ""; ?>>Homme</option>
                                <option value="female" <?php echo $user_account["gender"] == "female" ? "selected" : ""; ?>>Femme</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="birth_date" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Date de naissance" value="<?php echo $user_account["birth_date"]; ?>">
                          </div>

                          <div class="mb-3 col-md-6">
                              <label for="state" class="form-label">État de compte</label>
                              <select id="state" name="state" class="select2 form-select">
                                <option value="">Sélectionnez</option>
                                <option value="pending" <?php echo $user_account["state"] == "pending" ? "selected" : ""; ?>>En attente</option>
                                <option value="activated" <?php echo $user_account["state"] == "activated" ? "selected" : ""; ?>>Active</option>
                                <option value="restricted" <?php echo $user_account["state"] == "restricted" ? "selected" : ""; ?>>Limité</option>
                                <option value="deactivated" <?php echo $user_account["state"] == "deactivated" ? "selected" : ""; ?>>Desactivé</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                              <label for="role" class="form-label">Role</label>
                              <select id="role" name="role" class="select2 form-select">
                                <option value="">Sélectionnez</option>
                                <option value="admin" <?php echo $user_account["role"] == "admin" ? "selected" : ""; ?>>Admin</option>
                                <option value="technician" <?php echo $user_account["role"] == "technician" ? "selected" : ""; ?>>Technicien</option>
                                <option value="client" <?php echo $user_account["role"] == "client" ? "selected" : ""; ?>>Client</option>
                            </select>
                          </div>
                          
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
                          <button type="reset" class="btn btn-outline-secondary">Annuler</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <?php include "templates/common_libs.php"; ?>
    <!-- Page JS -->
</body>
</html>
