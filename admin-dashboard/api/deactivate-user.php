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
            $my_id = intval($_GET["id"]);
            if ($account->deactivate($my_id)) {
                $technician = $account->get_single($my_id);
                render_technician_row($technician);
            } else {
                echo "Internal problem";
            }
        }
    }
}

?>