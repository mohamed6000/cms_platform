<!-- Instagram Begin -->
<div class="instagram">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/feature.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-1.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-2.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-3.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-4.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="<?php echo $template; ?>img/about.jpg">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="<?php echo $infos["social_instagram"] ?>">@ shop</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Instagram End -->

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="/"><img src="<?php echo $infos["logo"]; ?>" alt=""></a>
                    </div>
                    <p><?php echo $infos["description"]; ?></p>
                    <div class="footer__payment">
                        <a href="#"><img src="<?php echo $template; ?>img/payment/payment-1.png" alt=""></a>
                        <a href="#"><img src="<?php echo $template; ?>img/payment/payment-2.png" alt=""></a>
                        <a href="#"><img src="<?php echo $template; ?>img/payment/payment-3.png" alt=""></a>
                        <a href="#"><img src="<?php echo $template; ?>img/payment/payment-4.png" alt=""></a>
                        <a href="#"><img src="<?php echo $template; ?>img/payment/payment-5.png" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    <h6>Liens rapides</h6>
                    <ul>
                        <li><a href="/">Acceuil</a></li>
                        <li><a href="/shop">Boutique</a></li>
                        <?php if (!isset($_SESSION["account_id"])) { ?>
                        <li><a href="/login">Connexion</a></li>
                        <li><a href="/register">Inscription</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION["account_id"])) { ?>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    <h6>Compte</h6>
                    <ul>
                        <li><a href="/profile">Mon compte</a></li>
                        <li><a href="/pTicket/">Tickets</a></li>
                        <li><a href="/basket">Panier</a></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6>Support Technique</h6>
                    <form action="#">
                        <a href="mailto:<?php echo $infos["email"]; ?>" class="site-btn">Contacter</a>
                    </form>
                    <div class="footer__social">
                        <?php if (!empty($infos["social_facebook"])) {
                            echo '<a href="'.$infos["social_facebook"].'"><i class="fa fa-facebook"></i></a>';
                        } ?>
                        <?php if (!empty($infos["social_twitter"])) {
                            echo '<a href="'.$infos["social_twitter"].'"><i class="fa fa-twitter"></i></a>';
                        } ?>
                        <?php if (!empty($infos["social_youtube"])) {
                            echo '<a href="'.$infos["social_youtube"].'"><i class="fa fa-youtube-play"></i></a>';
                        } ?>
                        <?php if (!empty($infos["social_instagram"])) {
                            echo '<a href="'.$infos["social_instagram"].'"><i class="fa fa-instagram"></i></a>';
                        } ?>
                        <?php if (!empty($infos["social_pinterest"])) {
                            echo '<a href="'.$infos["social_pinterest"].'"><i class="fa fa-pinterest"></i></a>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Copyright &copy; 2024 Tous droits réservés | Ce modèle est réalisé avec <i class="fa fa-heart" aria-hidden="true"></i> par <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="<?php echo $template; ?>js/jquery-3.3.1.min.js"></script>
<script src="<?php echo $template; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $template; ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo $template; ?>js/jquery-ui.min.js"></script>
<script src="<?php echo $template; ?>js/mixitup.min.js"></script>
<script src="<?php echo $template; ?>js/jquery.countdown.min.js"></script>
<script src="<?php echo $template; ?>js/jquery.slicknav.js"></script>
<script src="<?php echo $template; ?>js/owl.carousel.min.js"></script>
<script src="<?php echo $template; ?>js/jquery.nicescroll.min.js"></script>
<script src="<?php echo $template; ?>js/main.js"></script>
</body>

</html>