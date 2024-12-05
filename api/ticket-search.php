<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();

    if (isset($_SESSION["tu_id"])) {
        if (isset($_GET["ticket"]) && !empty($_GET["ticket"])) {
            require_once("../core/bootstrap.php");
            $database = new Database();
            $ticket = new Ticket($database);
            $account = new Account($database);
            $ticket_department = new TicketDepartment($database);

            $results = $ticket->search_by_criteria($_GET["ticket"]);
            if ($results) {
?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Date</th>
                        <th>Sujet</th>
                        <th>Depuis</th>
                        <th>Priorité</th>
                        <th>Departement</th>
                        <th>Attribué à</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $t) { 
                    $user_name = $account->get_username_by_id($t["from_id"]);
                    if (!$user_name) $user_name = "inconnu";
                    $dept = $ticket_department->get_by_id($t["department"]);
                ?>
                <tr>
                    <td><a href="ticket?id=<?php echo $t["id"]; ?>"><img src="assets/images/tix.png"> TID<?php echo $t["id"]; ?></a></td>
                    <td><?php echo $t["date_created"]; ?></td>
                    <td><a href="ticket?id=<?php echo $t["id"]; ?>"><?php echo $t["subject"]; ?></a></td>
                    <td>@<?php echo $user_name; ?></td>
                    <?php
                    if ($t["priority"] == "2") {
                        echo '<td class="danger">Haut</td>';
                    } else if ($t["priority"] == "1") {
                        echo '<td class="warning">Normale</td>';
                    } else if ($t["priority"] == "0") {
                        echo '<td class="active">Faible</td>';
                    }?>
                    <td><?php echo $dept["dep"]; ?></td>

                    <?php if ($t["assigned_to"]) {
                        $assigned_to = $account->get_username_by_id($t["assigned_to"]);
                        echo '<td>@'.$assigned_to.'</td>';
                    } else {
                        echo '<td>Aucun</td>';
                    }
                    ?>
                </tr>
                <?php } ?>
                </tbody>
            </table>

<?php       } else {
                echo '<div>Aucun résultat pour<b>'.$_GET["ticket"].'</b></div>';
            }
        }
    }
}

?>