<?php
$page_title = "Ticket Réponse";
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
    if ($current["state"] != "open") {
        header("Location: /pTicket/tickets");
    }
}

if ($current) $creator = $account->get_username_by_id($_SESSION["tu_id"]);
?>

<?php if ($current) { ?>

<style>
    .margin-bottom-20 {
        margin-top: 20px;
    }
    .margin-top-20 {
        margin-top: 20px;
    }
    .box-center {
        margin: 20px auto;
    }
    input[type=file] {
/*        display: block !important;*/
        right: 1px;
        top: 1px;
        height: 34px;
        opacity: 0;
      width: 100%;
        background: none;
        position: absolute;
      overflow: hidden;
      z-index: 2;
    }
    .control-fileupload {
        display: block;
        border: 1px solid #d6d7d6;
        background: #FFF;
        border-radius: 4px;
        width: 100%;
        height: 36px;
        line-height: 36px;
        padding: 0px 10px 2px 10px;
      overflow: hidden;
      position: relative;
      
      &:before, input, label {
        cursor: pointer !important;
      }
      /* File upload button */
      &:before {
        /* inherit from boostrap btn styles */
        padding: 4px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 20px;
        color: #333333;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
        vertical-align: middle;
        cursor: pointer;
        background-color: #f5f5f5;
        background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
        background-repeat: repeat-x;
        border: 1px solid #cccccc;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        border-bottom-color: #b3b3b3;
        border-radius: 4px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: color 0.2s ease;

        /* add more custom styles*/
        content: 'Parcourir';
        display: block;
        position: absolute;
        z-index: 1;
        top: 2px;
        right: 2px;
        line-height: 20px;
        text-align: center;
      }
      &:hover, &:focus {
        &:before {
          color: #333333;
          background-color: #e6e6e6;
          color: #333333;
          text-decoration: none;
          background-position: 0 -15px;
          transition: background-position 0.2s ease-out;
        }
      }
        label {
        line-height: 24px;
        color: #999999;
        font-size: 14px;
        font-weight: normal;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        z-index: 1;
        margin-right: 90px;
        margin-bottom: 0px;
        cursor: text;
      }
    }

    .hidden_input {display: none !important;}
</style>

<form pt-post="../api/ticket-reply.php?id=<?php echo $tid; ?>" pt-target="#reply_result">
<div class="quick_bar">
    <div class="float-left">
        <button class="btn btn-default">
            <img src="assets/images/add.png">
            Publier
        </button>
        <a href="/pTicket/ticket?id=<?php echo $tid; ?>" class="btn btn-primary">
            Annuler
        </a>
    </div>

    <?php if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) { ?>
    <div class="float-right">
        <img src="assets/images/status.png"> Ticket
        <select name="ticket_status" 
                style="display: inline-block; width: auto;" class="form-control">
            <option value="open" <?php echo ($current["state"] == "open") ? "selected" : ""; ?>>Ouvert</option>
            <option value="requested" <?php echo ($current["state"] == "requested") ? "selected" : ""; ?>>En attente</option>
            <option value="aborted" <?php echo ($current["state"] == "aborted") ? "selected" : ""; ?>>Annulé</option>
            <option value="closed" <?php echo ($current["state"] == "closed") ? "selected" : ""; ?>>Fermé</option>
        </select>
    </div>
    <?php } ?>
</div>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">
            <img src="assets/images/thread.gif">
            Répondre à TID<?php echo $current["id"]; ?>: "<?php echo $current["subject"]; ?>"
        </span>
        <div class="block_middle_container">
            <div id="ticket_action_result"></div>
            <div class="row">
                <div class="col-sm-3" title="Date de réponse">
                    <img src="assets/images/date.png">
                    <?php echo date("Y-m-d H:i:s"); ?>
                </div>
                <div class="col-sm-3" title="Créer par">
                    <img src="assets/images/user.png">
                    <?php echo $creator; ?>
                </div>
            </div>

            <br>
            <div id="reply_result"></div>

            <textarea name="reply" class="form-control" rows="5"></textarea>

            <hr>
            <b><img src="assets/images/attachment.gif"> Attachements:</b>
            <div class="form_group">
                <i>Téléchargez des fichiers ici</i>

                <!-- fileuploader view component -->
                <div class="row" id="attachments_section">
                </div>
                <!-- ./fileuploader view component -->

                <span class="control-fileupload">
                  <label for="attachments" class="text-left">Veuillez choisir un fichier sur votre ordinateur.</label>
                  <input type="file" id="attachments" name="attachments[]" multiple>
                </span>
            </div>
        </div>
    </div>
</div>
</form>

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

<script type="text/javascript">
    (function(){
        const MAX_ATTACHEMENT_COUNT = 6; // 5 images + 1 video
        var video_has_been_uploaded_once = false;
        var read_url = function(input) {
            if (input.files && (input.files.length <= MAX_ATTACHEMENT_COUNT)) {
                document.querySelector("#attachments_section").innerHTML = "";

                for (var i = 0; i < input.files.length; ++i) {
                    if (i == 0 && video_has_been_uploaded_once) video_has_been_uploaded_once = false;

                    var reader = new FileReader();
                    const current = input.files[i];

                    reader.onload = function (e) {
                        const col = document.createElement("div");
                        col.className = "col-sm-4";
                        
                        if ((current.type === "image/jpeg") || (current.type === "image/bmp") ||
                            (current.type === "image/gif") || (current.type === "image/png") ||
                            (current.type === "image/webp")) {
                            var new_el = document.createElement("img"); 
                            new_el.className = "thumbnail";
                            new_el.width = "200";
                            new_el.src = e.target.result;
                            col.append(new_el);
                        } else if ((current.type === "video/x-msvideo") || (current.type === "video/mp4") ||
                                   (current.type === "video/mpeg") || (current.type === "video/ogg") ||
                                   (current.type === "video/mp2t") || (current.type === "video/webm")) {
                            if (!video_has_been_uploaded_once) {
                                var new_el = document.createElement("video"); 
                                new_el.className = "thumbnail";
                                new_el.width = "200";
                                
                                var new_el_src = document.createElement("source");
                                new_el_src.src = URL.createObjectURL(current);
                                new_el_src.type = current.type;
                                new_el.append(new_el_src);

                                col.append(new_el);
                                new_el.load();
                                video_has_been_uploaded_once = true;
                            }
                        }
                        
                        document.querySelector("#attachments_section").append(col);
                    }

                    reader.readAsDataURL(current);
                }
            }
        };

        document.querySelector("input[type=file]").onchange = function() {
            var label_text = "Files : ";
            for (var i = 0; i < this.files.length; ++i) {
                var t = this.files[i].name;
                label_text += t + ", ";
            }

            this.parentNode.children[0].innerHTML = label_text;
            read_url(this);
        };
    })();
</script>

<?php include "includes/footer.php" ?>