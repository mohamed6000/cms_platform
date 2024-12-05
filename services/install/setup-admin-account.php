<?php

$config_file_path = "../../core/config.php";

if (file_exists($config_file_path)) {
    require_once($config_file_path);
    require_once("../../core/database.php");

    $database = new Database();

    if ($database->check_site_is_setup()) {
        // prevent installation restart
        header("location: /");
    }
} else {
    // start installation
    header("location: setup.php");
}

require_once("../../core/utils.php");
$random_password = Utils::generate_random_password();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Compte administrateur</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/themes/ashion-master/img/favicon.ico" rel="icon">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/themes/ashion-master//css/bootstrap.min.css" rel="stylesheet">

    <!-- front-end library -->
    <script src="/pt.js"></script>
</head>
<body>
    
    <!-- Contact Start -->
    <div class="container-fluid bg-light overflow-hidden px-lg-0">
        <div class="container contact px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="p-lg-5 ps-lg-0">
                    <div class="section-title text-start">                        
                        <h4>Bienvenue</h4>
                        <p>
                            Bienvenue dans le processus d'installation! Il suffit de remplir les informations ci-dessous
                            et vous serez sur la bonne voie pour utiliser la plateforme.
                        </p>
                        <hr>

                        <h4>Informations requises</h4>
                        <p>
                            S'il vous plaît fournir les informations suivantes. Ne vous inquiétez pas, vous pourrez toujours modifier ces paramètres ultérieurement.
                        </p>

                        <form pt-post="api/setup-admin-account.php" pt-target="#message_section">
                            <div id="message_section"></div>
                            <div class="row g-3">
                            <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Nom du site">
                                        <label for="site_name">Nom du site</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Votre E-mail">
                                        <label for="email">Votre E-mail</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Nom d'utilisateur (administrateur)">
                                        <label for="username">Nom d'utilisateur (administrateur)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="password" id="password" placeholder="Mot de passe" value="<?php echo $random_password; ?>">
                                        <label for="password">Mot de passe</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-2 text-white" type="submit">Installer</button>
                                </div>
                            </div>
                        </form>
                        
                        <br>
                        <hr>
                        <p>
                            Si ce n'est pas votre première fois et que vous rencontrez un problème ou des erreurs, veuillez contacter <a href="mailto:support@company.org">l'équipe d'assistance</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <script>
    const password_field = document.getElementById("password");
    password_field.oninput = function(e) {
        if (e.target.type === "text") {
            e.target.type = "password";
        }
    };
    </script>
</body>
</html>