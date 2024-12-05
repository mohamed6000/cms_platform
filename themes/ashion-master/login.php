<?php
$page_title = "Connexion";
$use_pt = "";
include "header.php";

Utils::website_prevent_logged_in_visits();
?>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6">
                <div class="contact__content">
                    <div class="contact__form text-center">
                        <h5>CONNEXION</h5>
                            <form pt-post="api/login-user.php" pt-target="#conn_res">
                                <div id="conn_res"></div>
                                <input type="text" placeholder="Nom d'utilisateur" name="user_name">
                                <input type="password" placeholder="Mot de passe" name="password">
                                <p>Vous n'avez pas de compte ? <a href="/register">S'inscrire maintenant</a>.</p>
                                <button type="submit" class="site-btn">Se connecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->


<?php

include "footer.php";

?>