<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../core/bootstrap.php");
    
    session_start();

    $database = new Database();
    $account = new Account($database);

    if (isset($_SESSION["tu_id"])) {
        if (isset($_SESSION["admin_id"]) &&($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
            unset($_SESSION["admin_id"]);
        } else if (isset($_SESSION["account_id"]) &&($_SESSION["tu_id"] == $_SESSION["account_id"])) {
            unset($_SESSION["account_id"]);
            unset($_SESSION["account_role"]);
        }
        unset($_SESSION["tu_id"]);
    }
    echo "<meta http-equiv='refresh' content='0; /pTicket/'>";
}

?>