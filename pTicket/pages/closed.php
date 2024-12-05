<?php
$page_title = "Closed Tickets";
include "includes/header.php";

$sort_type = "last_updated";
if (isset($_GET["sort"])) {
    $sort_type = $_GET["sort"];
}

if (isset($_GET["page"]) && !empty($_GET["page"])) {
    $current_page = (int)strip_tags($_GET["page"]);
} else {
    $current_page = 1;
}

$pages = 1;
if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) {
    $result = $ticket->get_all_closed($sort_type, $current_page);
    $ticket_list = $result["tickets"];
    $pages = $result["pages"];
} else if (isset($_SESSION["account_id"]) && ($_SESSION["account_id"] == $_SESSION["tu_id"])) {
    if ($_SESSION["account_role"] == "client") {
        $result = $ticket->get_closed_by_creator_id($_SESSION["tu_id"], $sort_type, $current_page);
        $ticket_list = $result["tickets"];
        $pages = $result["pages"];
    } else if ($_SESSION["account_role"] == "technician") {
        $result = $ticket->get_closed_by_assigned_to($_SESSION["tu_id"], $sort_type, $current_page);
        $ticket_list = $result["tickets"];
        $pages = $result["pages"];
    }
}
?>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">Tickets</span>
        <div class="block_middle_container">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th><a href="closed?sort=id&page=<?php echo $current_page; ?>">Ticket</a></th>
                        <th><a href="closed?sort=last_updated&page=<?php echo $current_page; ?>">Dernière mise à jour</a></th>
                        <th><a href="closed?sort=subject&page=<?php echo $current_page; ?>">Sujet</a></th>
                        <th><a href="closed?sort=from_id&page=<?php echo $current_page; ?>">Depuis</a></th>
                        <th><a href="closed?sort=priority&page=<?php echo $current_page; ?>">Priorité</a></th>
                        <th><a href="closed?sort=department&page=<?php echo $current_page; ?>">Département</a></th>
                        <th><a href="closed?sort=assigned_to&page=<?php echo $current_page; ?>">Attribué à</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ticket_list as $index => $t) { 
                            $user_name = $account->get_username_by_id($t["from_id"]);
                            if (!$user_name) $user_name = "unknown";
                            $dept = $ticket_department->get_by_id($t["department"]);
                    ?>
                    <tr>
                        <td><input type="checkbox" name="ticket_cb[]" value="<?php echo $t["id"]; ?>"></td>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><img src="assets/images/tix.png"> TID<?php echo $t["id"]; ?></a></td>
                        <td><?php echo $t["last_updated"]; ?></td>
                        <td><a href="ticket?id=<?php echo $t["id"]; ?>"><?php echo $t["subject"]; ?></a></td>
                        <td>@<?php echo $user_name; ?></td>
                        <?php
                        if ($t["priority"] == "2") {
                            echo '<td class="danger">Haute</td>';
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
                    <tr>
                        <td colspan="8" style="text-align: left;">
                            <b>Sélectionner:</b>
                            <button class="btn btn-default" onclick="select_all();">Tous</button>
                            <button class="btn btn-default" onclick="unselect_all();">Aucun</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: left;">
                            Page: 
                            <?php
                            for ($i = 1; $i <= $pages; ++$i) {
                                if ($i == $current_page) {
                                    echo "<b>[$i]</b>";
                                } else {
                                    echo "<b><a href='/pTicket/tickets?sort='.$sort_type.'&page=$i'>$i</a></b>";
                                }
                                echo " ";
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr>
            <div class="text-center">
                <button class="btn btn-success" <?php echo (!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : ""; ?>
                        onclick="open_selected_tickets();">
                    Ouvrir
                </button>
                <button class="btn btn-danger"  <?php echo (!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : ""; ?>
                        onclick="delete_selected_tickets();">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function select_all() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; ++i) {
            checkboxes[i].checked = true;
        }
    }

    function unselect_all() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; ++i) {
            checkboxes[i].checked = false;
        }
    }

    function send_http_post_request(uri, data) {
        const xhr = new XMLHttpRequest();

        if (xhr) {
            xhr.open("POST", uri, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            data = new URLSearchParams(data);

            xhr.onreadystatechange = function(e) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    //console.log(xhr.readyState, xhr.responseText);
                }
            };
            xhr.send(data);
        }
    }

    function open_selected_tickets() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

        for (var i = 0; i < checkboxes.length; ++i) {
            send_http_post_request("../api/ticket-open.php?id=" + checkboxes[i].value, null);
            checkboxes[i].parentNode.parentNode.style.display = "none";
        }
    }

    function delete_selected_tickets() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

        for (var i = 0; i < checkboxes.length; ++i) {
            send_http_post_request("../api/ticket-delete.php?id=" + checkboxes[i].value, null);
            checkboxes[i].parentNode.parentNode.style.display = "none";
        }
    }
</script>

<?php include "includes/footer.php" ?>