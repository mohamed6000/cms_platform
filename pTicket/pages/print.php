<?php

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    if ($id) {
        require_once("../core/bootstrap.php");
        $database = new Database();
        $ticket = new Ticket($database);
        $ticket_department = new TicketDepartment($database);
        $site_settings = new SiteSettings($database);
        $account = new Account($database);

        $current = $ticket->get_single_by_id($id);
        $infos = $site_settings->get_global_infos();
        if ($current) {
            $creator = $account->get_single($current["from_id"]);
            $dept = $ticket_department->get_by_id($current["department"]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $current["subject"] ." | ". $infos["site_name"]; ?></title>
</head>
<body onload="window.print();">
    <table border="0" style="width: 800px; margin: 0 auto;">
        <tr>
            <td>Nom: <b><?php echo $creator["last_name"]; ?></b></td>
            <td>Prénom: <b><?php echo $creator["first_name"]; ?></b></td>
        </tr>
        
        <tr>
            <td>Adresse: <b><?php echo $current["address"]; ?>, <?php echo $current["location"]; ?></b></td>
            <td>Tel: <b><?php echo $current["phone"]; ?></b></td>
        </tr>

        <tr>
            <td>Département: <b><?php echo $dept["dep"]; ?></b></td>
            <td>Priorité: <b><?php echo Utils::get_priority_string($current["priority"]); ?></b></td>
        </tr>

        <tr>
            <td colspan="2">Date: <b><?php echo $current["date_created"]; ?></b></td>
        </tr>

        <tr>
            <td colspan="2">Sujet: <b><?php echo $current["subject"]; ?></b></td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $current["content"]; ?>
            </td>
        </tr>
    </table>
</body>
</html>

<?php
        }
    }
}
?>