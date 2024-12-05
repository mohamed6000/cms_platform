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

                    $key = "priority".$id;
                    if (isset($_POST[$key])) {
                        $result = $ticket->set_priority($id, $_POST[$key]);
                        if ($result) {

                            if ($_POST[$key] == "2") {
                                echo '<td id="priority_result'.$id.'" class="danger">';
                            } else if ($_POST[$key] == "1") {
                                echo '<td id="priority_result'.$id.'" class="warning">';
                            } else if ($_POST[$key] == "0") {
                                echo '<td id="priority_result'.$id.'" class="active">';
                            }
?>
                            <select name="priority<?php echo $id; ?>" style="padding: 0; border: none; background: none;"
                                    pt-post="../api/ticket-update-selected-priority.php?id=<?php echo $id; ?>"
                                    pt-target="#priority_result<?php echo $id; ?>"
                                    pt-replace="outerHTML" pt-include>
                                <option value="0" <?php echo ($_POST[$key] == "0") ? "selected" : ""; ?>>Faible</option>
                                <option value="1" <?php echo ($_POST[$key] == "1") ? "selected" : ""; ?>>Normale</option>
                                <option value="2" <?php echo ($_POST[$key] == "2") ? "selected" : ""; ?>>Haute</option>
                            </select>
                        </td>
<?php                      }
                    }
                }
            } 
        }
    }
}

?>