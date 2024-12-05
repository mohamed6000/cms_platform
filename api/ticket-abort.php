<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");
    $database = new Database();
    $ticket = new Ticket($database);

    if (isset($_SESSION["tu_id"]) && isset($_SESSION["admin_id"]) &&
        ($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
        // only the admin can abort tickets
        if (isset($_GET["id"])) {
            $id_to_abort = intval($_GET["id"]);
            if ($id_to_abort) {
                $result = $ticket->abort($id_to_abort);
                if (true == $result) {
                    echo '<div class="col-sm-3">
                              <img src="assets/images/error.png"> Avorté
                          </div>
                          <div class="col-sm-3">
                              <button pt-post="../api/ticket-open.php?id='.$id_to_abort.'" 
                                      pt-target="#state_result" class="btn btn-default btn-sm" 
                                      title="Ouvert" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                      <img src="assets/images/ok.png">
                              </button>
                              <a href="edit?id='.$id_to_abort.'" class="btn btn-default btn-sm" title="Modifier"><img src="assets/images/edit_ticket.png"></a>
                              <button pt-post="../api/ticket-delete.php?id='.$id_to_abort.'" 
                                      pt-target="#ticket_action_result" class="btn btn-default btn-sm" 
                                      title="Supprimer" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                      <img src="assets/images/delete.png">
                              </button>
                          </div>';
                }
            }
        }
    }
}

?>