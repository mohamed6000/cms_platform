<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");
    require_once("../api/ticket-render-departments.php");

    $database = new Database();
    $ticket_department = new TicketDepartment($database);

    if (isset($_SESSION["tu_id"]) && isset($_SESSION["admin_id"])) {
        if ($_SESSION["tu_id"] == $_SESSION["admin_id"]) {
            $message = "";

            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);
                if ($id) {
                    $ticket_department->delete($id);
                }
            }

            if (!empty($message)) {
                echo '<div class="alert alert-danger">
                        <strong>Erreur</strong>
                        '.$message.'
                    </div>';
            }
        }
    }

    $depts = $ticket_department->get_all();
    render_departments($depts);
}

?>