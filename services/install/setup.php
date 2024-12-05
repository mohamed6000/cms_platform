<?php
// prevent installation restart
if (file_exists("../../core/config.php")) {
    header("location: /");
}

session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bienvenue dans la configuration</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/themes/ashion-master/img/favicon.ico" rel="icon">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/themes/ashion-master/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <!-- Contact Start -->
    <div class="container-fluid bg-light overflow-hidden px-lg-0">
        <div class="container contact px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="p-lg-5 ps-lg-0">
                    <div class="section-title text-start">
                        <h1 class="display-5 mb-4">Installation</h1>
                        <hr>
                        <p>
                            <b>Bienvenue sur la page de configuration.</b>
                        </p>
                        <p>
                            Prenons quelques étapes pour configurer votre site Web et le préparer à fonctionner.
                        </p>
                        <p>
                            <a href="setup-config.php" class="btn btn-primary text-white w-10 py-2">Allons-y</a>
                        </p>
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
</body>
</html>