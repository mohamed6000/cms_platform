<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION["tu_id"]) && isset($_SESSION["admin_id"])) {
        if ($_SESSION["tu_id"] == $_SESSION["admin_id"]) {
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);
                if ($id) {
                    require_once("../core/bootstrap.php");
                    $database = new Database();
                    $ticket_reply = new TicketReply($database);
                    $ticket_reply->delete($id);
                }
            }
        }
    }
}

?>