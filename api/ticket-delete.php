<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");
    $database = new Database();
    $ticket = new Ticket($database);

    if (isset($_SESSION["tu_id"]) && isset($_SESSION["admin_id"]) &&
        ($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
        // only the admin can delete tickets
        if (isset($_GET["id"])) {
            $id_to_delete = intval($_GET["id"]);
            if ($id_to_delete) {
                $result = $ticket->delete($id_to_delete);
                if (true == $result) {
                    echo '<meta http-equiv="refresh" content="0; url=/pTicket/">';
                }
            }
        }
    }
}

?>