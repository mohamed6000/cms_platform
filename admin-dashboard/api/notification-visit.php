<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    // Utils::begin_session();
    session_start();

    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $account = new Account($database);
        $notification = new Notification($database);

        if (isset($_GET["id"])) {
            $my_id = intval($_GET["id"]);
            $notification->visit_at_id($my_id);

            $c_url = $_POST["c_url"];
            echo '<meta http-equiv="refresh" content="0; url=' . $c_url . '" />';
        }
    }
}

?>