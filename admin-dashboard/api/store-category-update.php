<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION["admin_id"])) {
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            if ($id) {
                require_once("../../core/bootstrap.php");
                $database = new Database();
                $store_category = new StoreCategory($database);

                $message = "";
                $key = "cat_name".$id;
                if (isset($_POST[$key]) && !empty($_POST[$key])) {
                    if ($store_category->update($_POST[$key], $id)) {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                Catégorie a été mis à jour.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                } else {
                    $message = "Nom de catégorie est vide.";
                }

                if (!empty($message)) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                            '.$message.'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                }
            }
        }
    }
}

?>