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

                $store_basket->delete_one_from_client_by_id($id, $_SESSION["account_id"]);
            }
        }
    }
}

?>