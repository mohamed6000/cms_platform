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
                $message = "";
                if (isset($_POST["title"]) && !empty($_POST["title"])) {
                    if (isset($_POST["brand"]) && !empty($_POST["brand"])) {
                        if (isset($_POST["original_price"]) && !empty($_POST["original_price"])) {
                            $target_dir = "../../uploads/";
                            $images = ["", "", "", ""];

                            if ((isset($_FILES["attachments"]["tmp_name"][0]) && !empty($_FILES["attachments"]["tmp_name"][0])) &&
                                (isset($_FILES["attachments"]["tmp_name"][1]) && !empty($_FILES["attachments"]["tmp_name"][1])) &&
                                (isset($_FILES["attachments"]["tmp_name"][2]) && !empty($_FILES["attachments"]["tmp_name"][2])) &&
                                (isset($_FILES["attachments"]["tmp_name"][3]) && !empty($_FILES["attachments"]["tmp_name"][3]))) {

                                for ($i = 0; $i < 4; ++$i) {
                                    if (Utils::is_the_mime_image($_FILES["attachments"]["type"][$i])) {
                                        $check = getimagesize($_FILES["attachments"]["tmp_name"][$i]);
                                        if ($check != false) {
                                            $ext = pathinfo($_FILES["attachments"]["name"][$i], PATHINFO_EXTENSION);
                                            $timestamp = time();
                                            $target_image_name = "img_".$timestamp."_".rand(1000, 6000).".".$ext;
                                            $images[$i] = $target_image_name;
                                        }
                                    }
                                }
                            }

                            if (!empty($images[0]) && !empty($images[1]) && !empty($images[2]) && !empty($images[3])) {
                                $added = $store_product->update($_POST["title"], $_POST["brand"],
                                                            $_POST["original_price"], $_POST["new_price"],
                                                            $_POST["description"], $_POST["specification"],
                                                            $_POST["stock"], $images[0], $images[1], $images[2], $images[3], $_POST["category"], $id);
                                move_uploaded_file($_FILES["attachments"]["tmp_name"][0], $target_dir.$images[0]);
                                move_uploaded_file($_FILES["attachments"]["tmp_name"][1], $target_dir.$images[1]);
                                move_uploaded_file($_FILES["attachments"]["tmp_name"][2], $target_dir.$images[2]);
                                move_uploaded_file($_FILES["attachments"]["tmp_name"][3], $target_dir.$images[3]);
                            } else {
                                $old_product = $store_product->get_single($id);
                                $added = $store_product->update($_POST["title"], $_POST["brand"],
                                                                $_POST["original_price"], $_POST["new_price"],
                                                                $_POST["description"], $_POST["specification"],
                                                                $_POST["stock"], 
                                                                $old_product["image0"], $old_product["image1"], 
                                                                $old_product["image2"], $old_product["image3"], $_POST["category"], $id);
                            }
                            
                            if ($added === true) {
                                echo '<div class="alert alert-success alert-dismissible" role="alert">
                                        Le produit a été mise à jour.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                            } else {
                                $message = $added;
                            }
                        } else {
                            $message = "Prix invalid invalid";
                        }
                    } else {
                        $message = "Nom du brand invalid";
                    }
                } else {
                    $message = "Nom du produit invalid";
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