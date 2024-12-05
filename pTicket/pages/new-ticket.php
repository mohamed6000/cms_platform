<?php
$page_title = "Ajouter Ticket";
include "includes/header.php";

$ticket_department = new TicketDepartment($database);
$depts = $ticket_department->get_all();

if (isset($_SESSION["tu_id"]) && isset($_SESSION["account_id"])) {
    if ($_SESSION["tu_id"] == $_SESSION["account_id"]) {
        if ($_SESSION["account_role"] == "technician") {
            header("Location: /pTicket/");
        }
    }
}

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

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">Ticket</span>
        <div class="block_middle_container">
            <h2>Détails du ticket</h2>
            <p>S'il vous plaît décrivez le problème</p>
            <form class="form" pt-post="../api/ticket-new.php" pt-target="#new_ticket_result">
                <div id="new_ticket_result"></div>
                <div class="form_group">
                    <label for="subject">Résumé du problème<code>*</code></label>
                    <input type="text" name="subject" id="subject" class="form-control input-text">
                </div>
                <div style="clear: both;"></div>
                
                <div class="form_group">
                    <textarea id="default" name="content" rows="4" class="form-control input-text"></textarea>
                </div>

                <div class="form_group">
                    <label for="dept">Département</label>
                    <select id="dept" name="dept" class="form-control input-text">
                        <option value="">Choisir département</option>
                        <?php
                        foreach ($depts as $index => $dept) {
                            echo '<option value="'.$dept["id"].'">'.$dept["dep"].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <hr>
                <div class="form_group">
                    <b>Téléchargez des fichiers ici</b>

                    <!-- fileuploader view component -->
                    <div class="row"></div>
                    <!-- ./fileuploader view component -->

                    <span class="control-fileupload">
                      <label for="attachments" class="text-left">Veuillez choisir un fichier sur votre ordinateur.</label>
                      <input type="file" id="attachments" name="attachments[]" multiple>
                    </span>
                </div>

                <hr>

                <div class="form_group">
                    <label for="user_id">ID de de compte</label>
                    <input type="text" id="user_id" class="form-control input-text" value="@<?php echo $my_account["user_name"]; ?>" readonly>
                </div>

                <?php if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) { ?>
                <div class="form_group">
                    <label for="deadline">Date limite</label>
                    <input type="date" name="deadline" id="deadline" class="form-control input-text">
                </div>
                <?php } ?>

                <div class="form_group">
                    <label for="location">Localisation<code>*</code></label>
                    <select name="location" id="location" class="form-control input-text">
                         <option value="">Sélectionner le gouvernorat</option>
                         <option value="ARIANA">ARIANA</option>
                         <option value="BEJA">BEJA</option>
                         <option value="BEN AROUS">BEN AROUS</option>
                         <option value="BIZERTE">BIZERTE</option>
                         <option value="GABES">GABES</option>
                         <option value="GAFSA">GAFSA</option>
                         <option value="JENDOUBA">JENDOUBA</option>
                         <option value="KAIROUAN">KAIROUAN</option>
                         <option value="KASSERINE">KASSERINE</option>
                         <option value="KEBILI">KEBILI</option>
                         <option value="KEF">KEF</option>
                         <option value="MAHDIA">MAHDIA</option>
                         <option value="MANNOUBA">MANNOUBA</option>
                         <option value="MEDENINE">MEDENINE</option>
                         <option value="MONASTIR">MONASTIR</option>
                         <option value="NABEUL">NABEUL</option>
                         <option value="SFAX">SFAX</option>
                         <option value="SIDI BOUZID">SIDI BOUZID</option>
                         <option value="SILIANA">SILIANA</option>
                         <option value="SOUSSE">SOUSSE</option>
                         <option value="TATAOUINE">TATAOUINE</option>
                         <option value="TOZEUR">TOZEUR</option>
                         <option value="TUNIS">TUNIS</option>
                         <option value="ZAGHOUAN">ZAGHOUAN</option>
                    </select>
                </div>

                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="address">Adresse<code>*</code></label>
                    <input type="text" name="address" id="address" class="form-control input-text" value="<?php echo $my_account["address"]; ?>">
                </div>
                <div style="clear: both;"></div>

                <div class="form_group">
                    <label for="phone">Tel<code>*</code></label>
                    <input type="text" name="phone" id="phone" class="form-control input-text" value="<?php echo $my_account["phone"]; ?>">
                </div>

                <hr>
                <div class="form_group text-center">
                    <button class="btn btn-danger">Ajouter</button>
                    <button class="btn btn-default" type="reset">Réinitialiser</button>
                    <a href="/pTicket/" class="btn btn-default">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function(){
        const MAX_ATTACHEMENT_COUNT = 6; // 5 images + 1 video
        var video_has_been_uploaded_once = false;
        var read_url = function(input) {
            if (input.files && (input.files.length <= MAX_ATTACHEMENT_COUNT)) {
                document.querySelector(".row").innerHTML = "";

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
                        
                        document.querySelector(".row").append(col);
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