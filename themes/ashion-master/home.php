<?php 
$use_pt = "";
include "header.php";

$cats = $store_category->get_all();
$products = $store_product->get_latest(8);
?>


<!-- Categories Section Begin -->
<section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                    data-setbg="<?php echo $template; ?>img/carousel-1.jpg">
                    <div class="categories__text">
                        <h1>Support</h1>
                        <!-- <a href="/shop">Achetez maintenant</a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="<?php echo $template; ?>img/carousel-2.jpg">
                            <div class="categories__text">
                                <h4>Maison intelligente</h4>
                                <a href="/shop">Achetez maintenant</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="<?php echo $template; ?>img/carousel-3.jpg">
                            <div class="categories__text">
                                <h4>Vidéosurveillance</h4>
                                <a href="/shop">Achetez maintenant</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-4.jpg">
                            <div class="categories__text">
                                <h4>Sécurité</h4>
                                <a href="/shop">Achetez maintenant</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="<?php echo $template; ?>img/portfolio-5.jpg">
                            <div class="categories__text">
                                <h4>Accessoires</h4>
                                <a href="/shop">Achetez maintenant</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Nouveau produit</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Tous</li>
                    <?php
                    foreach ($cats as $cat) {
                        echo '<li data-filter=".filte_cl'.$cat["id"].'">'.$cat["name"].'</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            <?php foreach ($products as $p) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo "filte_cl".$p["category"]; ?>">
                <div class="product__item <?php echo (!empty($p["new_price"]) && ($p["new_price"] > 0)) ? "sale" : ""; ?>">
                    <div style="background-size: contain; background-position: center center;" class="product__item__pic set-bg" data-setbg="/uploads/<?php echo $p["image1"]; ?>">
                        
                        <?php if (!empty($p["new_price"]) && ($p["new_price"] > 0)) { ?>
                            <div class="label">Vente</div>
                        <?php } else { 
                            $time = strtotime($p["date_created"]);
                            $current_time = time();
                            if (($current_time - $time) < 60*60*24*7*2) { // less than 2 weeks
                            ?>
                                <div class="label new">Nouveau</div>
                            <?php }
                        } ?>

                        <?php if ($p["stock"] <= 0) { ?>
                        <div class="label stockout stockblue">en rupture de stock</div>
                        <?php } ?>

                        <ul class="product__hover">
                            <li><a href="/uploads/<?php echo $p["image1"]; ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li>
                                <a href="javascript:void(0);" pt-post="api/store-add-product-to-cart.php?id=<?php echo $p["id"]; ?>" title="Ajouter au panier">
                                    <span class="icon_bag_alt"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="/product?id=<?php echo $p["id"]; ?>"><?php echo $p["title"]; ?></a></h6>
                        <?php if (!empty($p["new_price"]) && ($p["new_price"] > 0)) { ?>
                        <div class="product__price">DT <?php echo number_format($p["new_price"], 2); ?> <span>DT <?php echo number_format($p["original_price"], 2); ?></span></div>
                        <?php } else { ?>
                        <div class="product__price">DT <?php echo number_format($p["original_price"], 2); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>    
            <?php } ?>
        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="<?php echo $template; ?>img/post-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>Meilleure solution de vidéosurveillance et de sécurité pour vous</span>
                            <h1>Vidéosurveillance</h1>
                            <a href="/shop">Acheter maintenant</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>Solution de sécurité intelligente pour toutes les entreprises</span>
                            <h1>Sécurité</h1>
                            <a href="/shop">Acheter maintenant</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>Solution innovante pour le système de sécurité</span>
                            <h1>Innovation</h1>
                            <a href="/shop">Acheter maintenant</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Trend Section Begin -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Tendance chaude</h4>
                    </div>
                    <?php
                    $hots = $store_product->get_latest(3);
                    foreach ($hots as $hot) { ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img height="90" width="90" src="/uploads/<?php echo $hot["image1"]; ?>" alt="">
                        </div>
                        <div class="trend__item__text">
                            <h6><a href="/product?id=<?php echo $hot["id"]; ?>"><?php echo $hot["title"]; ?></a></h6>
                            <div class="product__price">DT 
                            <?php echo ($hot["new_price"] > 0) ? $hot["new_price"] : $hot["original_price"]; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Nouveautés</h4>
                    </div>
                    <?php
                    $hots = $store_product->get_latest(3);
                    foreach ($hots as $hot) { ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img height="90" width="90" src="/uploads/<?php echo $hot["image1"]; ?>" alt="">
                        </div>
                        <div class="trend__item__text">
                            <h6><a href="/product?id=<?php echo $hot["id"]; ?>"><?php echo $hot["title"]; ?></a></h6>
                            <div class="product__price">DT 
                            <?php echo ($hot["new_price"] > 0) ? $hot["new_price"] : $hot["original_price"]; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>En vedette</h4>
                    </div>
                    <?php
                    $featured = $store_product->get_featured(3);
                    foreach ($featured as $f) { ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img height="90" width="90" src="/uploads/<?php echo $f["image1"]; ?>" alt="">
                        </div>
                        <div class="trend__item__text">
                            <h6><?php echo $f["title"]; ?></h6>
                            <div class="product__price">DT 
                            <?php echo ($f["new_price"] > 0) ? $f["new_price"] : $f["original_price"]; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trend Section End -->

<!-- Discount Section Begin -->
<?php
$discount_infos = $site_settings->get_discount_infos();
if ($discount_infos["show_store_discount"] == 1) {
?>
<section class="discount">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="discount__pic">
                    <img src="<?php echo $template; ?>img/discount.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="discount__text">
                    <div class="discount__text__title">
                        <span>Remise</span>
                        <h2><?php echo $discount_infos["store_discount_event_name"]; ?></h2>
                        <h5><span>Vente</span> <?php echo $discount_infos["store_discount_percent"]; ?>%</h5>
                    </div>
                    <div class="discount__countdown" id="countdown-time" data-countdown-date="<?php echo $discount_infos["store_discount_date_limit"]; ?>">
                        <div class="countdown__item">
                            <span>22</span>
                            <p>Jour</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>Heure</p>
                        </div>
                        <div class="countdown__item">
                            <span>46</span>
                            <p>Min</p>
                        </div>
                        <div class="countdown__item">
                            <span>05</span>
                            <p>Sec</p>
                        </div>
                    </div>
                    <a href="/shop">Acheter maintenant</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<!-- Discount Section End -->

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Livraison gratuite</h6>
                    <p>Pour toute commande supérieure à 99 DT</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Garantie de remboursement</h6>
                    <p>Si les marchandises ont des problèmes</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Assistance en ligne 24h/24 et 7j/7</h6>
                    <p>Un support dédié</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Paiement Sécurisé</h6>
                    <p>Paiement 100% sécurisé</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->


<?php include "footer.php"; ?>