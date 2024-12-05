<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    session_start();

    $database = new Database();
    $store_product = new StoreProduct($database);

    if (isset($_SESSION["admin_id"])) {
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            if ($id) {
                $store_product->delete($id);
            }
        }
    }
}

?>