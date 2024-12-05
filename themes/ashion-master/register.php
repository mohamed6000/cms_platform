<?php
$page_title = "Inscription";
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
                        <h5>S'inscrire</h5>
                            <form pt-post="api/register-client.php" pt-target="#conn_res">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div id="conn_res"></div>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control border-0" placeholder="Prénom" name="first_name" style="height: 55px;">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control border-0" placeholder="Nom" name="last_name" style="height: 55px;">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control border-0" placeholder="Votre Email" name="email" style="height: 55px;">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control border-0" placeholder="Nom d'utilisateur" name="user_name" style="height: 55px;">
                                </div>
                                <div class="col-6">
                                    <input type="password" class="form-control border-0" placeholder="Votre Mot de passe" name="password" style="height: 55px;">
                                </div>
                                <div class="col-6">
                                    <input type="password" class="form-control border-0" placeholder="Confirmer Mot de passe" name="password2" style="height: 55px;">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">S'inscrire</button>
                                </div>
                            </div>
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