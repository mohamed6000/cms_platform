<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    require_once("render-technician-row.php");

    // Utils::begin_session();
    session_start();

    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $account = new Account($database);

        if (isset($_GET["id"])) {
            if ($account->activate($_GET["id"])) {
                $technician = $account->get_single($_GET["id"]);
                render_technician_row($technician);
            } else {
                echo "Internal problem";
            }
        }
    }
}

?>