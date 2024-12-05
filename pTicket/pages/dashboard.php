<?php

include "includes/header.php";

$ticket_list = false;
if (isset($_SESSION["tu_id"])) {
    if (isset($_SESSION["account_id"]) && ($_SESSION["tu_id"] == $_SESSION["account_id"])) {
        if ($_SESSION["account_role"] == "client") {
            $result = $ticket->get_by_creator_id($_SESSION["tu_id"]);
            $ticket_list = $result["tickets"];
        } else if ($_SESSION["account_role"] == "technician") {
            $result = $ticket->get_by_assigned_to($_SESSION["tu_id"]);
            $ticket_list = $result["tickets"];
        }
    } else if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
        $result = $ticket->get_by_creator_id($_SESSION["tu_id"]);
        $ticket_list = $result["tickets"];
    }
}

?>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">Tableau de bord</span>
        <div class="block_middle_container">
            <?php
            if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) {
            ?>
            <h2><img src="assets/images/pages.gif"> Tickets</h2>
            <?php
            $result = $ticket->get_all();
            $last_tickets = $result["tickets"];
            if ($last_tickets) {
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Date</th>
                        <th>Sujet</th>
                        <th>Depuis</th>
                        <th>Priorité</th>
                        <th>Attribué à</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($last_tickets as $index => $t) { 
                            $user_name = $account->get_username_by_id($t["from_id"]);
                            if (!$user_name) $user_name = "unknown";
                    ?>
                    <tr>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><img src="assets/images/tix.png"> TID<?php echo $t["id"]; ?></a></td>
                        <td><?php echo $t["date_created"]; ?></td>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><?php echo $t["subject"]; ?></a></td>
                        <td>@<?php echo $user_name; ?></td>
                        <?php
                        if ($t["priority"] == 2) {
                            echo '<td class="danger">Haute</td>';
                        } else if ($t["priority"] == 1) {
                            echo '<td class="warning">Normale</td>';
                        } else if ($t["priority"] == 0) {
                            echo '<td class="active">Faible</td>';
                        }

                        if ($t["assigned_to"]) {
                            $assigned_to = $account->get_username_by_id($t["assigned_to"]);
                            echo '<td>@'.$assigned_to.'</td>';
                        } else {
                            echo '<td>None</td>';
                        }
                        ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>

            <?php } ?>

            <h2><img src="assets/images/mine.gif"> Mes tickets</h2>
            <?php if ($ticket_list) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Date</th>
                        <th>Sujet</th>
                        <th>Depuis</th>
                        <th>Priorité</th>
                        <th>Attribué à</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ticket_list as $index => $t) { 
                            $user_name = $account->get_username_by_id($t["from_id"]);
                            if (!$user_name) $user_name = "inconnu";
                    ?>
                    <tr>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><img src="assets/images/tix.png"> TID<?php echo $t["id"]; ?></a></td>
                        <td><?php echo $t["date_created"]; ?></td>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><?php echo $t["subject"]; ?></a></td>
                        <td>@<?php echo $user_name; ?></td>
                        <?php
                        if ($t["priority"] == 2) {
                            echo '<td class="danger">Haute</td>';
                        } else if ($t["priority"] == 1) {
                            echo '<td class="warning">Normale</td>';
                        } else if ($t["priority"] == 0) {
                            echo '<td class="active">Faible</td>';
                        }

                        if ($t["assigned_to"]) {
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
            <?php } else { ?>
            <p>You have no tickets.</p>
            <?php } ?>

            <?php if (isset($_SESSION["account_id"]) && ($_SESSION["account_role"] == "client") && ($_SESSION["tu_id"] == $_SESSION["account_id"])) {
                      $rts = $ticket->get_requested_by_creator_id($_SESSION["tu_id"]); ?>

            <h2>Mes demandes</h2>
            <?php if ($rts) { ?>
                <table class="table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Departement</th>
                        <th>From</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rts as $index => $rt) { 
                    $user_name = $account->get_username_by_id($t["from_id"]);
                    if (!$user_name) $user_name = "inconnu";
                    $dept = $ticket_department->get_by_id($rt["department"]);
                ?>
                <tr>
                    <td><a href="ticket?id=<?php echo $rt["id"]; ?>"><img src="assets/images/tix.png"> TID<?php echo $rt["id"]; ?></a></td>
                    <td><?php echo $rt["date_created"]; ?></td>
                    <td><a href="ticket?id=<?php echo $rt["id"]; ?>"><?php echo $rt["subject"]; ?></a></td>
                    <td><?php echo $dept["dep"]; ?></td>
                    <td>@<?php echo $user_name; ?></td>
                </tr> 
                <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
            <p>Vous n'avez pas de tickets demandés.</p>
            <?php }} ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>