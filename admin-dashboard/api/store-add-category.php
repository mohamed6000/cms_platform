<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION["admin_id"])) {
        require_once("../../core/bootstrap.php");
        require_once("render-store-categories.php");

        $database = new Database();
        $store_category = new StoreCategory($database);

        $message = "";
        if (isset($_POST["cat_name"]) && !empty($_POST["cat_name"])) {
            $store_category->create($_POST["cat_name"]);
        } else {
            $message = "Nom de catégorie est vide.";
        }

        if (!empty($message)) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }

        $cats = $store_category->get_all();
        render_store_categories($cats);
    }
}

?>