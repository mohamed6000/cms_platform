<?php 
$page_title = "Détails";
$use_pt = "";
include "header.php"; 

$id = false;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = intval($_GET["id"]);
} // } else {
//     echo '<script> location.replace("/"); </script>';
//     exit;
// }

$current = false;
if ($id) {
    $current = $store_product->get_single_display($id);
    if ($current)
        $related_posts = $store_product->get_related($current["id"], $current["title"], $current["brand"], $current["category"]);
}// } else {
//     echo '<script> location.replace("/"); </script>';
//     exit;
// }
?>

<?php if ($current) { ?>
    <script type="text/javascript">document.title = "<?php echo $current["title"]; ?> : : <?php echo $infos["site_name"]; ?>";</script>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i></a>
                    <a href="/shop">Boutique</a>
                    <span><?php echo $current["title"]; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__left product__thumb nice-scroll">
                        <a class="pt active" href="#product-1">
                            <img src="/uploads/<?php echo $current["image0"]; ?>" alt="<?php echo $current["title"]; ?>">
                        </a>
                        <a class="pt" href="#product-2">
                            <img src="/uploads/<?php echo $current["image1"]; ?>" alt="<?php echo $current["title"]; ?>">
                        </a>
                        <a class="pt" href="#product-3">
                            <img src="/uploads/<?php echo $current["image2"]; ?>" alt="<?php echo $current["title"]; ?>">
                        </a>
                        <a class="pt" href="#product-4">
                            <img src="/uploads/<?php echo $current["image3"]; ?>" alt="<?php echo $current["title"]; ?>">
                        </a>
                    </div>
                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-hash="product-1" class="product__big__img" src="/uploads/<?php echo $current["image0"]; ?>" alt="<?php echo $current["title"]; ?>">
                            <img data-hash="product-2" class="product__big__img" src="/uploads/<?php echo $current["image1"]; ?>" alt="<?php echo $current["title"]; ?>">
                            <img data-hash="product-3" class="product__big__img" src="/uploads/<?php echo $current["image2"]; ?>" alt="<?php echo $current["title"]; ?>">
                            <img data-hash="product-4" class="product__big__img" src="/uploads/<?php echo $current["image3"]; ?>" alt="<?php echo $current["title"]; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3><?php echo $current["title"]; ?> <span>Brand: <?php echo $current["brand"]; ?></span></h3>
                    <?php if (!empty($current["new_price"]) && ($current["new_price"] > 0)) { ?>
                    <div class="product__details__price">DT <?php echo $current["new_price"]; ?> <span>DT <?php echo $current["original_price"]; ?></span></div>
                    <?php } else { ?>
                    <div class="product__details__price">DT <?php echo $current["original_price"]; ?></div>
                    <?php } ?>

                    <p><?php echo $current["description"]; ?></p>

                    <div class="product__details__button">
                        <div id="add_to_cart_result_div"></div>
                        <form pt-post="api/store-add-to-cart.php?id=<?php echo $id; ?>" pt-target="#add_to_cart_result_div">
                        <div class="quantity">
                            <span>Quantité:</span>
                            <div class="pro-qty">
                                <input type="text" name="stock" value="1">
                            </div>
                        </div>
                        <button style="outline: none; border: none;" type="submit" class="cart-btn">
                            <span class="icon_bag_alt"></span> Ajouter au panier
                        </button>
                    </div>
                    <div class="product__details__widget">
                        <ul>
                            <li>
                                <span>Catégorie:</span>
                                <p>
                                <?php echo $current["category"]; ?>
                                </p>
                            </li>
                            
                            <?php if (!empty($current["new_price"]) && ($current["new_price"] > 0)) { ?>
                            <li>
                                <span>Remise:</span>
                                <p>
                                <?php echo number_format($current["original_price"] / $current["new_price"], 2) . "%"; ?>
                                </p>
                            </li>
                            <?php } else { ?>
                            <li>
                                <span>Prix:</span>
                                <p>
                                <?php echo "DT ".number_format($current["original_price"], 2); ?>
                                </p>
                            </li>
                            <?php } ?>

                            <li>
                                <span>Disponibilité:</span>
                                <p>
                                <?php
                                if ($current['stock'] > 0) {
                                    if ($current['stock'] == 1) {
                                        echo "<b><span style='color: #B12704;'>Il n'en reste que 1 en stock - commandez bientôt.</span></b>";
                                    } else {
                                        echo "<b><span style='color: green;'>En stock</span></b>";
                                    }
                                }
                                else {
                                    echo "<b><span style='color: red;'>En rupture de stock</span></b>";
                                }
                                ?>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Spécification</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>Description</h6>
                            <p><?php echo nl2br($current["description"]); ?></p>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <h6>Spécification</h6>
                            <p><?php echo nl2br($current["specification"]); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>PRODUITS CONNEXES</h5>
                </div>
            </div>

            <?php foreach ($related_posts as $index => $p) { ?>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="/uploads/<?php echo $p["picture"]; ?>">
                        <?php
                        $time = strtotime($p["date_created"]);
                        $current_time = time();
                        if (($current_time - $time) < 60*60*24*7*2) { // less than 2 weeks
                        ?>
                        <div class="label new">Nouveau</div>
                        <?php } ?>

                        <?php if ($p["stock"] <= 0) { ?>
                        <div class="label stockout">en rupture de stock</div>
                        <?php } ?>

                        <ul class="product__hover">
                            <li><a href="/uploads/<?php echo $p["picture"]; ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <!-- <li><a href="#"><span class="icon_heart_alt"></span></a></li> -->
                            <li>
                                <a href="javascript:void(0);" pt-post="api/store-add-product-to-cart.php?id=<?php echo $p["id"]; ?>" title="Ajouter au panier">
                                    <span class="icon_bag_alt"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="/product?id=<?php echo $p["id"]; ?>"><?php echo $p["title"]; ?></a></h6>
                        <div class="product__price">DT <?php echo $p["price"]; ?></div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</section>
<!-- Product Details Section End -->
<?php } else { ?>
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center">
                <h1>404:</h1> Page introuvable
            </div>
        </div>
    </div>
</section>
<?php } ?>

<?php include "footer.php"; ?>