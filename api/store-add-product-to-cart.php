<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $client = false;
    if (isset($_SESSION["account_id"])) {
        $client = $_SESSION["account_id"];
    } else if (isset($_SESSION["admin_id"])) {
        $client = $_SESSION["admin_id"];
    }

    if ($client) {
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            if ($id) {
                require_once("../core/bootstrap.php");

                $database = new Database();
                $store_basket = new StoreBasket($database);
                $store_product = new StoreProduct($database);
                $p = $store_product->get_single($id);

                if ($p["stock"] >= 1)
                    $store_basket->create($id, $client, 1);
            }
        }
    }
}

?>