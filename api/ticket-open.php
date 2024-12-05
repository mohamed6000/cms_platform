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
            $id_to_open = intval($_GET["id"]);
            if ($id_to_open) {
                $result = $ticket->open($id_to_open);
                if (true == $result) {
                    echo '<div class="col-sm-3">
                              <img src="assets/images/ok.png"> Ouvert
                          </div>
                          <div class="col-sm-3">
                              <a href="edit?id='.$id_to_open.'" class="btn btn-default btn-sm" title="Modifier"><img src="assets/images/edit_ticket.png"></a>
                              <button pt-post="../api/ticket-delete.php?id='.$id_to_open.'" 
                                      pt-target="#ticket_action_result" class="btn btn-default btn-sm" 
                                      title="Supprimer" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                      <img src="assets/images/delete.png">
                              </button>
                              <button pt-post="../api/ticket-close.php?id='.$id_to_open.'" pt-target="#state_result" class="btn btn-default btn-sm" title="Fermer" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'><img src="assets/images/lock.png"></button>
                              <button pt-post="../api/ticket-abort.php?id='.$id_to_open.'" 
                                          pt-target="#state_result" class="btn btn-default btn-sm" 
                                          title="Avorter" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                          <img src="assets/images/cancel.png">
                                  </button>
                          </div>';
                }
            }
        }
    }
}

?>