<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION["admin_id"])) {
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            if ($id) {
                require_once("../../core/bootstrap.php");
                require_once("render-store-categories.php");
                $database = new Database();
                $store_category = new StoreCategory($database);

                $store_category->delete($id);

                $cats = $store_category->get_all();
                render_store_categories($cats);
            }
        }
    }
}

?>