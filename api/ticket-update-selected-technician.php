<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);

        if ($id) {
            session_start();

            if (isset($_SESSION["tu_id"])) {
                if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
                    require_once("../core/bootstrap.php");
                    $database = new Database();
                    $ticket = new Ticket($database);
                    $notification = new Notification($database);
                    $account = new Account($database);

                    $key = "assigned_to_ticket".$id;
                    if (isset($_POST[$key]) && !empty($_POST[$key])) {
                        $result = $ticket->assign_to_id($id, $_POST[$key]);
                        if ($result) {
                            $user_name = $account->get_username_by_id($_SESSION["tu_id"]);
                            $notification->push("Nouvelle attribution de ticket",
                                                "@".$user_name." vous a attribué un ticket",  
                                                "/pTicket/ticket?id=".$id, 
                                                "/pTicket/assets/images/kb_large_folder.png", $_POST[$key]);
                        }
                    }
                }
            } 
        }
    }
}

?>