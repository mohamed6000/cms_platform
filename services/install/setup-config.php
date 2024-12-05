<?php
// prevent installation restart
if (file_exists("../../core/config.php")) {
    header("location: /");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Configuration de la base de données</title>
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
                        <h1 class="display-5 mb-4">Installation</h1>
                        <hr>
                        <p>
                            <b>Commençons par configurer votre connexion à la base de données :</b>
                            <br>
                            Ci-dessous, vous devez saisir les détails de connexion à votre base de données. Si vous n'en êtes pas sûr, contactez votre hôte.
                        </p>

                        <form pt-post="api/setup-config.php" pt-target="#message_section">
                            <div id="message_section"></div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <label for="db_hostname">Hôte de base de données (mysql)</label>
                                        <input type="text" class="form-control" name="db_hostname" id="db_hostname" placeholder="Hôte de base de données (mysql)">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <label for="db_name">Nom de la base de données</label>
                                        <input type="text" class="form-control" name="db_name" id="db_name" placeholder="Nom de la base de données">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <label for="db_username">Nom d'utilisateur</label>
                                        <input type="text" class="form-control" name="db_username" id="db_username" placeholder="Nom d'utilisateur">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <label for="db_password">Mot de passe (facultatif)</label>
                                        <input type="password" class="form-control" name="db_password" id="db_password" placeholder="Mot de passe (facultatif)">
                                    </div>
                                </div>

                                <br>

                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary w-100 py-2 text-white" type="submit">Soumettre</button>
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
</body>
</html>