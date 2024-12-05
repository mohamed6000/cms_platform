<?php 
$page_title = "Boutique";
$use_pt = "";
include "header.php"; 

$cats = $store_category->get_all();

if (isset($_GET["page"]) && !empty($_GET["page"])) {
  $current_page = (int)strip_tags($_GET["page"]);
} else {
  $current_page = 1;
}

$category = false;
if (isset($_GET["category"]) && !empty($_GET["category"])) {
    $category = $_GET["category"];
}

$min_price = false;
$max_price = false;
if (isset($_GET["min_price"]) && !empty($_GET["min_price"])) {
    $min_price = $_GET["min_price"];
}
if (isset($_GET["max_price"]) && !empty($_GET["max_price"])) {
    $max_price = $_GET["max_price"];
}

$result = $store_product->get_all($category, $min_price, $max_price, $current_page, 10);
$products = $result["products"];
$pages = $result["pages"];

?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i></a>
                    <span>Boutique</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<div id="basket_res"></div>

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>Catégories</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading active">
                                        <a data-toggle="collapse" data-target="#collapseOne">Tous</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <ul>
                                                <?php foreach ($cats as $cat) { ?>
                                                <li><a href="?category=<?php echo $cat["name"]; ?>"><?php echo $cat["name"]; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar__filter">
                        <div class="section-title">
                            <h4>Magasiner par prix</h4>
                        </div>
                        <div class="filter-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                            data-min="10" data-max="100"></div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <p>Prix:</p>
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                        <a href="#" id="filter_btn">Filtrer</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <?php foreach ($products as $p) { ?>
                    <div class="col-lg-4 col-md-6">
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
                                        <a href="javascript:void(0);" pt-post="api/store-add-product-to-cart.php?id=<?php echo $p["id"]; ?>" pt-target="#basket_res" title="Ajouter au panier">
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
                    
                    <div class="col-lg-12 text-center">
                        <div class="pagination__option">
                            <?php 
                            if ($current_page > 1) {
                                $url_params = "";
                                $previous = $current_page - 1;
                                if ($category) {
                                    $url_params = "category=$category&page=$previous";
                                } else {
                                    $url_params = "page=$previous";
                                }
                                echo '<a href="/shop?'.$url_params.'"><i class="fa fa-angle-left"></i></a>';
                            }

                            for ($i = 1; $i <= $pages; ++$i) {
                                $url_params = "";
                                if ($category) {
                                    $url_params = "category=$category&page=$i";
                                } else {
                                    $url_params = "page=$i";
                                }

                                $selected = "";
                                if ($i == $current_page) $selected = "disabled";

                                echo '<a href="/shop?'.$url_params.'" '.$selected.'>'.$i.'</a>';
                            }

                            if ($current_page < $pages) {
                                $url_params = "";
                                $next = $current_page + 1;
                                if ($category) {
                                    $url_params = "category=$category&page=$next";
                                } else {
                                    $url_params = "page=$next";
                                }
                                echo '<a href="/shop?'.$url_params.'"><i class="fa fa-angle-right"></i></a>';
                            } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

<?php 
$url_params = "";
if ($category) {
    $url_params .= "category=$category";
    if ($current_page) $url_params .= "&page=$current_page";
} else {
    if ($current_page) $url_params .= "page=$current_page";
}
?>

<script type="text/javascript">
    const btn = document.getElementById("filter_btn");
    btn.href = "/shop?<?php echo $url_params; ?>";

    const min_btn = document.getElementById("minamount");
    const max_btn = document.getElementById("maxamount");

    btn.onclick = function () {
        btn.href += "&min_price=" + min_btn.value;
        btn.href += "&max_price=" + max_btn.value;
    };
</script>

<?php include "footer.php"; ?>
