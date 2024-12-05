<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION["account_id"])) {
        require_once("../core/bootstrap.php");

        $message = "";
        if (isset($_POST["first_name"]) && !empty($_POST["first_name"])) {
            if (isset($_POST["last_name"]) && !empty($_POST["last_name"])) {
                if (isset($_POST["address"]) && !empty($_POST["address"])) {
                    if (isset($_POST["phone"]) && !empty($_POST["phone"])) {
                        if (isset($_POST["email"]) && !empty($_POST["email"])) {
                            if (isset($_POST["pay"]) && !empty($_POST["pay"])) {
                                $database = new Database();
                                $store_basket = new StoreBasket($database);
                                
                                $my_products = $store_basket->get_products_by_client($_SESSION["account_id"]);

                                $order = new Order($database);
                                if ($order->add($_POST["first_name"], $_POST["last_name"], $_POST["address"], $_POST["phone"], $_POST["email"], $_POST["pay"], $_SESSION["account_id"])) {
                                    echo '<div class="alert alert-success">Votre facture a été créée</div>';
                                }
                            } else {
                                $message = "Choisir une methode de payment.";
                            }
                        } else {
                            $message = "E-mail vide";
                        }
                    } else {
                        $message = "Téléphone vide";
                    }
                } else {
                    $message = "Adresse vide";
                }
            } else {
                $message = "Nom de famille vide";
            }
        } else {
            $message = "Prénom vide";
        }

        if (!empty($message)) {
            echo '<div class="alert alert-danger">
                      <strong>Erreur:</strong>
                      '.$message.'
                  </div>';
        }
    }
}

?>