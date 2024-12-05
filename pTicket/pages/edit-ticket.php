<?php
$page_title = "Ticket Edit";
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
    if (($current["from_id"] != $_SESSION["tu_id"])) {
        // you didn't create this ticket
        header("Location: /pTicket/tickets");
    }
}

if ($current) $creator = $account->get_username_by_id($current["from_id"]);
$depts = $ticket_department->get_all();

$techs = $account->get_all_technicians();
?>

<script type="text/javascript" src="assets/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
      selector: 'textarea#default',  // change this value according to your HTML
      plugins: [
          'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
          'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
          'media', 'table', 'emoticons', 'help'
      ],
      toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
        'forecolor backcolor emoticons | help',
      menu: {
        favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
      },
      menubar: 'favs file edit view insert format tools table help',
      license_key: 'gpl',
      // a_plugin_option: true,
      // a_configuration_option: 400
    });
</script>

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
        content: 'Browse';
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

<div class="block_middle">
    <div class="block_content">
        <?php if ($current) { ?>
        <span class="block_title">
            <img src="assets/images/edit_ticket.png">
            TID<?php echo $current["id"]; ?>: "<?php echo $current["subject"]; ?>" (EDIT)
        </span>
        <div class="block_middle_container">
            <div id="ticket_action_result"></div>
            <div class="row">
                <div class="col-sm-3" title="Date created">
                        <img src="assets/images/date.png">
                        <?php echo $current["date_created"]; ?>
                </div>
                <div class="col-sm-3" title="Created by">
                        <img src="assets/images/user.png">
                        <?php echo $creator; ?>
                </div>

                <div id="state_result">
                    <div class="col-sm-3">
                            <?php
                            if ($current["state"] == "open") {
                                echo '<img src="assets/images/ok.png"> Open';
                            } else if ($current["state"] == "requested") {
                                echo '<img src="assets/images/alert.png"> Requested';
                            } else if ($current["state"] == "aborted") {
                                echo '<img src="assets/images/error.png"> Aborted';
                            } else if ($current["state"] == "closed") {
                                echo '<img src="assets/images/lock.png"> Closed';
                            }
                            ?>
                    </div>
                    <div class="col-sm-3">
                        <button pt-post="../api/ticket-delete.php?id=<?php echo $current["id"]; ?>" 
                                pt-target="#ticket_action_result" 
                                class="btn btn-default btn-sm" 
                                title="Delete" <?php echo (!isset($_SESSION["admin_id"]) || ($_SESSION["admin_id"] != $_SESSION["tu_id"])) ? "disabled" : ""; ?>>
                                <img src="assets/images/delete.png"> Delete Permanently
                        </button>
                    </div>
                </div>
            </div>

            <div id="edit_ticket_result"></div>
            <h2>Détails du ticket</h2>
            <form class="form" pt-post="../api/ticket-edit.php?id=<?php echo $tid; ?>" pt-target="#edit_ticket_result">
                <div class="form_group">
                    <label for="subject">Résumé du problème<code>*</code></label>
                    <input type="text" name="subject" id="subject" 
                           class="form-control input-text"
                           value="<?php echo $current["subject"]; ?>">
                </div>
                <div class="form_group">
                    <textarea id="default" name="content" rows="4" 
                              class="form-control input-text"><?php echo $current["content"]; ?></textarea>
                </div>

                <div class="form_group">
                    <label for="dept">Département</label>
                    <select id="dept" name="dept" class="form-control input-text">
                        <option value="">Choisir département</option>
                        <?php
                        foreach ($depts as $index => $dept) {
                            echo '<option value="'.$dept["id"].'" '.(($current["department"] == $dept["id"]) ? "selected" : "").'>'.$dept["dep"].'</option>';
                        }
                        ?>
                    </select>
                </div>

                <?php if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) { ?>
                <div class="form_group">
                    <label for="priority">Priorité</label>
                    <select id="priority" name="priority" class="form-control input-text">
                        <option value="low" <?php echo ($current["priority"] == "low") ? "selected" : ""; ?>>Low</option>
                        <option value="normal" <?php echo ($current["priority"] == "normal") ? "selected" : ""; ?>>Normal</option>
                        <option value="high" <?php echo ($current["priority"] == "high") ? "selected" : ""; ?>>High</option>
                    </select>
                </div>

                <div class="form_group">
                    <label for="assigned_to">Technicien</label>
                    <select id="assigned_to" name="assigned_to" class="form-control input-text">
                        <option value="">None</option>
                        <?php
                        foreach ($techs as $tech) {
                            if ($tech["id"] == $current["assigned_to"]) {
                                echo '<option value="'.$tech["id"].'" selected>'.$tech["user_name"].'</option>';
                            } else {
                                echo '<option value="'.$tech["id"].'">'.$tech["user_name"].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php } ?>

                <hr>
                <div class="form_group">
                    <b>Téléchargez des fichiers ici</b>

                    <!-- fileuploader view component -->
                    <div class="row" id="attachments_section">
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
                        if (!empty($current["attachment_video"])) {
                            echo '<div class="col-sm-12 text-center">
                                      <video class="thumbnail" width="200" controls>
                                          <source src="/uploads/'.$current["attachment_video"].'">
                                      </video>
                                  </div>';
                        }
                        ?>
                    </div>
                    <!-- ./fileuploader view component -->

                    <span class="control-fileupload">
                      <label for="attachments" class="text-left">Veuillez choisir un fichier sur votre ordinateur.</label>
                      <input type="file" id="attachments" name="attachments[]" multiple>
                    </span>
                </div>

                <hr>

                <div class="form_group">
                    <label for="user_id">ID de de compte</label>
                    <input type="text" id="user_id" class="form-control input-text" value="@<?php echo $creator; ?>" readonly>
                </div>

                <?php if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) { ?>
                <div class="form_group">
                    <label for="deadline">Date limite</label>
                    <input type="date" name="deadline" id="deadline" 
                           class="form-control input-text" value="<?php echo $current["deadline"]; ?>">
                </div>
                <?php } ?>

                <div class="form_group">
                    <label for="location">Localisation<code>*</code></label>
                    <select name="location" id="location" class="form-control input-text">
                         <option value="">Sélectionner le gouvernorat</option>
                         <option value="ARIANA" <?php echo ($current["location"] == "ARIANA") ?  "selected" : ""; ?>>ARIANA</option>
                         <option value="BEJA" <?php echo ($current["location"] == "BEJA") ?  "selected" : ""; ?>>BEJA</option>
                         <option value="BEN AROUS" <?php echo ($current["location"] == "BEN AROUS") ?  "selected" : ""; ?>>BEN AROUS</option>
                         <option value="BIZERTE" <?php echo ($current["location"] == "BIZERTE") ?  "selected" : ""; ?>>BIZERTE</option>
                         <option value="GABES" <?php echo ($current["location"] == "GABES") ?  "selected" : ""; ?>>GABES</option>
                         <option value="GAFSA" <?php echo ($current["location"] == "GAFSA") ?  "selected" : ""; ?>>GAFSA</option>
                         <option value="JENDOUBA" <?php echo ($current["location"] == "JENDOUBA") ?  "selected" : ""; ?>>JENDOUBA</option>
                         <option value="KAIROUAN" <?php echo ($current["location"] == "KAIROUAN") ?  "selected" : ""; ?>>KAIROUAN</option>
                         <option value="KASSERINE" <?php echo ($current["location"] == "KASSERINE") ?  "selected" : ""; ?>>KASSERINE</option>
                         <option value="KEBILI" <?php echo ($current["location"] == "KEBILI") ?  "selected" : ""; ?>>KEBILI</option>
                         <option value="KEF" <?php echo ($current["location"] == "KEF") ?  "selected" : ""; ?>>KEF</option>
                         <option value="MAHDIA" <?php echo ($current["location"] == "MAHDIA") ?  "selected" : ""; ?>>MAHDIA</option>
                         <option value="MANNOUBA" <?php echo ($current["location"] == "MANNOUBA") ?  "selected" : ""; ?>>MANNOUBA</option>
                         <option value="MEDENINE" <?php echo ($current["location"] == "MEDENINE") ?  "selected" : ""; ?>>MEDENINE</option>
                         <option value="MONASTIR" <?php echo ($current["location"] == "MONASTIR") ?  "selected" : ""; ?>>MONASTIR</option>
                         <option value="NABEUL" <?php echo ($current["location"] == "NABEUL") ?  "selected" : ""; ?>>NABEUL</option>
                         <option value="SFAX" <?php echo ($current["location"] == "SFAX") ?  "selected" : ""; ?>>SFAX</option>
                         <option value="SIDI BOUZID" <?php echo ($current["location"] == "SIDI BOUZID") ?  "selected" : ""; ?>>SIDI BOUZID</option>
                         <option value="SILIANA" <?php echo ($current["location"] == "SILIANA") ?  "selected" : ""; ?>>SILIANA</option>
                         <option value="SOUSSE" <?php echo ($current["location"] == "SOUSSE") ?  "selected" : ""; ?>>SOUSSE</option>
                         <option value="TATAOUINE" <?php echo ($current["location"] == "TATAOUINE") ?  "selected" : ""; ?>>TATAOUINE</option>
                         <option value="TOZEUR" <?php echo ($current["location"] == "TOZEUR") ?  "selected" : ""; ?>>TOZEUR</option>
                         <option value="TUNIS" <?php echo ($current["location"] == "TUNIS") ?  "selected" : ""; ?>>TUNIS</option>
                         <option value="ZAGHOUAN" <?php echo ($current["location"] == "ZAGHOUAN") ?  "selected" : ""; ?>>ZAGHOUAN</option>
                    </select>
                </div>

                <div class="form_group">
                    <label for="address">Adresse<code>*</code></label>
                    <input type="text" name="address" id="address" class="form-control input-text" value="<?php echo $current["address"]; ?>">
                </div>

                <div class="form_group">
                    <label for="phone">Tel<code>*</code></label>
                    <input type="text" name="phone" id="phone" class="form-control input-text" value="<?php echo $current["phone"]; ?>">
                </div>

                <hr>
                <div class="form_group text-center">
                    <button class="btn btn-danger">Enregistrer</button>
                    <button class="btn btn-default" type="reset">Réinitialiser</button>
                    <a href="/pTicket/ticket?id=<?php echo $tid; ?>" class="btn btn-default">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <span class="block_title">
        Error 404: Not found
    </span>
    <div class="block_middle_container">
        The requested ticket was not found.
    </div>
    <?php } ?>
</div>

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