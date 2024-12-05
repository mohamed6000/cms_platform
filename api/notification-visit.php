<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../core/bootstrap.php");

    // Utils::begin_session();
    session_start();

    if (isset($_SESSION["account_id"])) {
        $database = new Database();
        $account = new Account($database);
        $notification = new Notification($database);

        if (isset($_GET["id"])) {
            $my_id = intval($_GET["id"]);
            if ($my_id) {
                $notification->visit_at_id($my_id);
            }
        }
    }
}

?>