<?php
$page_title = "Ticket Thread";
include "includes/header.php";

$tid = false;
if (isset($_GET["id"])) {
    $tid = intval($_GET["id"]);
    if (!$tid) {
        header("Location: /pTicket/tickets");
    }
} else {
    header("Location: /pTicket/tickets");
}

$current = $ticket->get_single_by_id($tid);

if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) {
    // you can see the ticket
} else {
    if (($current["from_id"] != $_SESSION["tu_id"]) && ($current["assigned_to"] != $_SESSION["tu_id"])) {
        // you didn't create this ticket and you are not assigned to it either
        header("Location: /pTicket/tickets");
    }
}

if ($current) $creator = $account->get_username_by_id($current["from_id"]);

$ticket_reply = new TicketReply($database);
$thread_replies = $ticket_reply->get_by_ticket_id($tid);
?>

<?php if ($current) { ?>

<?php if (($current["state"] == "open") || (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"]))) { ?>
<div class="quick_bar">
    <a href="/pTicket/reply?id=<?php echo $tid; ?>" class="btn btn-primary">
        <img src="assets/images/email_templates.gif">
        Répondre
    </a>

    <a href="/pTicket/print?id=<?php echo $tid; ?>" class="btn btn-default" title="Imprimer" target="_blank">
        <img src="assets/images/printer.gif">
    </a>
</div>
<?php } ?>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">
            <img src="assets/images/thread.gif">
            TID<?php echo $current["id"]; ?>: "<?php echo $current["subject"]; ?>"
        </span>
        <div class="block_middle_container">
            <div id="ticket_action_result"></div>
            <div class="row">
                <div class="col-sm-3" title="Date de création">
                    <img src="assets/images/date.png">
                    <?php echo $current["date_created"]; ?>
                </div>
                <div class="col-sm-3" title="Crée par">
                    <img src="assets/images/user.png">
                    <?php echo $creator; ?>
                </div>

                <div id="state_result">
                    <div class="col-sm-3">
                            <?php
                            if ($current["state"] == "open") {
                                echo '<img src="assets/images/ok.png"> Ouvert';
                            } else if ($current["state"] == "requested") {
                                echo '<img src="assets/images/alert.png"> Demande';
                            } else if ($current["state"] == "aborted") {
                                echo '<img src="assets/images/error.png"> Refusé';
                            } else if ($current["state"] == "closed") {
                                echo '<img src="assets/images/lock.png"> Fermé';
                            }
                            ?>
                    </div>
                    <div class="col-sm-3">
                        <?php
                        if ($current["state"] != "open") {
                            echo '<button pt-post="../api/ticket-open.php?id='.$current["id"].'" pt-target="#state_result" class="btn btn-default btn-sm" title="Ouvert" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'><img src="assets/images/ok.png"></button>';
                        }
                        ?>
                        <a href="edit?id=<?php echo $current["id"]; ?>" class="btn btn-default btn-sm" title="Modifier"><img src="assets/images/edit_ticket.png"></a>
                        <button pt-post="../api/ticket-delete.php?id=<?php echo $current["id"]; ?>" 
                                pt-target="#ticket_action_result" 
                                class="btn btn-default btn-sm" 
                                title="Supprimer" <?php echo (!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : ""; ?>>
                                <img src="assets/images/delete.png">
                        </button>
                        <?php
                        if (($current["state"] != "closed") && ($current["state"] != "aborted")) {
                            echo '<button pt-post="../api/ticket-close.php?id='.$current["id"].'" 
                                          pt-target="#state_result" class="btn btn-default btn-sm" 
                                          title="Fermer" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                          <img src="assets/images/lock.png">
                                  </button>
                                  <button pt-post="../api/ticket-abort.php?id='.$current["id"].'" 
                                          pt-target="#state_result" class="btn btn-default btn-sm" 
                                          title="Refuser" '.((!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : "") .'>
                                          <img src="assets/images/cancel.png">
                                  </button>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12">
                    <?php echo $current["content"]; ?>          
                </div>
            </div>

            <br>
            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <img src="assets/images/articles.png">
                    Adresse: <b><?php echo $current["address"]; ?></b>, <b><?php echo $current["location"]; ?></b>

                    <?php if (isset($current["deadline"]) && !empty($current["deadline"]) && ($current["deadline"] != "0000-00-00")) { ?>
                    <img src="assets/images/date.png"> Date limite: <b><?php echo $current["deadline"]; ?></b>
                    <?php } ?>
                </div>
                
                <div class="col-sm-12">
                    <img src="assets/images/ticket_source_phone.gif"> Tel: <b><?php echo $current["phone"]; ?></b>
                </div>

                <div class="col-sm-4">
                    <img src="assets/images/list_departments.gif"> Departement: 
                    <b>
                    <?php $dept = $ticket_department->get_by_id($current["department"]);
                          echo $dept["dep"];
                     ?>
                    </b>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/note.gif"> Priorité: <b><?php echo Utils::get_priority_string($current["priority"]); ?></b>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/list_users.gif"> Tech: 
                    <b>
                    <?php 
                        if ($current["assigned_to"]) {
                            $tech_username = $account->get_username_by_id($current["assigned_to"]);
                            echo $tech_username;
                        } else {
                            echo "Aucun";
                        }
                    ?>
                    </b>
                </div>
            </div>

            <hr>
            <b><img src="assets/images/attachment.gif"> Attachements:</b>
            <div class="row">
                <?php
                for ($i = 0; $i < 5; ++$i) {
                    $key = "attachment_image".$i;
                    if (!empty($current[$key])) {
                        echo '<div class="col-sm-2">
                                  <a href="/uploads/'.$current[$key].'" target="_blank">
                                      <img class="thumbnail" width="100" src="/uploads/'.$current[$key].'">
                                  </a>
                              </div>';
                    }
                }
                ?>
            </div>
            <?php
            if (!empty($current["attachment_video"])) {
                echo '<div class="row">
                          <div class="col-sm-12 text-center">
                              <video class="thumbnail" width="100%" controls>
                                  <source src="/uploads/'.$current["attachment_video"].'">
                              </video>
                          </div>
                      </div>';
            }
            ?>
        </div>
    </div>
</div>

<?php 
if ($thread_replies) { 
    foreach ($thread_replies as $index => $reply) {
?>

<div id="reply_n<?php echo $reply["id"]; ?>" class="block_middle" style="margin-top: 8px;">
    <div class="block_content">
        <span class="block_title">
            <img src="assets/images/thread.gif"> Réponse Ticket n°<?php echo ($index + 1); ?>

            <?php if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) { ?>
            <div class="float-right">
                <button class="btn btn-danger btn-xs"
                        pt-post="../api/ticket-reply-remove.php?id=<?php echo $reply["id"]; ?>"
                        pt-target="#reply_n<?php echo $reply["id"]; ?>"
                        pt-replace="outerHTML">&#10006;</button>
            </div>
            <?php } ?>
        </span>
        <div class="block_middle_container">
            <div class="row">
                <div class="col-sm-3" title="Date de création">
                    <img src="assets/images/date.png">
                    <?php echo $reply["date_created"]; ?>
                </div>

                <div class="col-sm-3" title="Réponse par">
                    <img src="assets/images/user.png">
                    <?php echo $account->get_username_by_id($reply["from_id"]); ?>
                </div>
            </div>

            <br>
            <?php echo $reply["reply"]; ?>

            <hr>
            <b><img src="assets/images/attachment.gif"> Attachements:</b>
            <div class="row">
                <?php
                for ($i = 0; $i < 5; ++$i) {
                    $key = "attachment_image".$i;
                    if (!empty($reply[$key])) {
                        echo '<div class="col-sm-2">
                                  <a href="/uploads/'.$reply[$key].'" target="_blank">
                                      <img class="thumbnail" width="100" src="/uploads/'.$reply[$key].'">
                                  </a>
                              </div>';
                    }
                }
                ?>
            </div>
            <?php
            if (!empty($reply["attachment_video"])) {
                echo '<div class="row">
                          <div class="col-sm-12 text-center">
                              <video class="thumbnail" width="100%" controls>
                                  <source src="/uploads/'.$reply["attachment_video"].'">
                              </video>
                          </div>
                      </div>';
            }
            ?>
        </div>
    </div>
</div>

<?php 
    }
}
?>

<?php } else { ?>
<div class="block_middle">
    <div class="block_content">
        <span class="block_title">
            Erreur 404 : introuvable
        </span>
        <div class="block_middle_container">
            Le ticket demandé n'a pas été trouvé.
        </div>
    </div>
</div>
<?php } ?>

<?php include "includes/footer.php" ?>