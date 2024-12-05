<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["type"])) {
        session_start();

        if (isset($_SESSION["account_id"]) && isset($_SESSION["admin_id"])) {
            if ($_GET["type"] == "account") {
                $_SESSION["tu_id"] = $_SESSION["account_id"];
            } else if ($_GET["type"] == "admin") {
                $_SESSION["tu_id"] = $_SESSION["admin_id"];
            }
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>