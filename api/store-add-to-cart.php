<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        if ($id) {
            session_start();

            if (isset($_SESSION["account_id"])) {
                require_once("../core/bootstrap.php");

                $database = new Database();
                $store_basket = new StoreBasket($database);

                $store_product = new StoreProduct($database);
                $p = $store_product->get_single($id);

                if (isset($_POST["stock"]) && !empty($_POST["stock"])) {
                    $q = (int)$_POST["stock"];
                    if ((int)$p["stock"] < $q) {
                        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                              La quantité requise n\'est pas en stock.
                              <button type="button" class="close btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                          </div>';
                    } else {
                        $store_basket->create($id, $_SESSION["account_id"], $q);
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                Le produit a été ajouté à votre panier..
                                <button type="button" class="close btn-close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                }
            }
        }
    }
}

?>