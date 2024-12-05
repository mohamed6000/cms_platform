<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");
    require_once("../core/utils.php");

    $database = new Database();
    $ticket = new Ticket($database);
    $notification = new Notification($database);

    if (isset($_SESSION["admin_id"]) || isset($_SESSION["account_id"])) {
        $message = "";

        $attachment_video = null;
        $number_of_uploaded_images = 0;
        $target_dir = "../uploads/"; // http://localhost:8080/uploads/
        $target_video_name = "";
        $target_attachments_names = ["", "", "", "", ""]; // must be 5 items length

        $should_add_ticket = true;

        if (isset($_POST["subject"]) && !empty($_POST["subject"])) {
            if (isset($_POST["dept"]) && !empty($_POST["dept"])) {
                if (isset($_FILES["attachments"])) {
                    foreach ($_FILES["attachments"]["tmp_name"] as $key => $tmp_name) {
                        if (!empty($_FILES["attachments"]["tmp_name"][$key])) {
                            if ($_FILES["attachments"]["error"][$key] > 0) {
                                $message = $_FILES["attachments"]["error"][$key];
                                goto error_section;
                            } else {
                                if (Utils::is_the_mime_image($_FILES["attachments"]["type"][$key])) {
                                    $check = getimagesize($_FILES["attachments"]["tmp_name"][$key]); // check if image is fake
                                    if ($check !== false) {
                                        $number_of_uploaded_images++;
                                        if ($number_of_uploaded_images > 5) {
                                            $message = "Vous ne pouvez télécharger que jusqu'à 5 images";
                                            goto error_section;
                                        }
                                        if ($_FILES["attachments"]["size"][$key] > 2*MB) {
                                            $message = "La taille de l'image est trop grande (maximum : 2 Mo)";
                                            goto error_section;
                                        }

                                        $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                                        $timestamp = time();
                                        $target_image_name = "img_".$timestamp."_".rand(1000, 6000).".".$ext;
                                        $target_attachments_names[$number_of_uploaded_images-1] = $target_image_name;

                                        if (!move_uploaded_file($_FILES["attachments"]["tmp_name"][$key], $target_dir.$target_image_name))
                                            $should_add_ticket = false;
                                    }
                                } else if (Utils::is_the_mime_video($_FILES["attachments"]["type"][$key])) {
                                    if ($_FILES["attachments"]["size"][$key] > 10*MB) {
                                        $message = "La taille du fichier vidéo est trop grande (maximum : 10 Mo)";
                                        goto error_section;
                                    } else {
                                        if (!$attachment_video) {
                                            $attachment_video = $_FILES["attachments"]["tmp_name"][$key];
                                            
                                            $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                                            $timestamp = time();
                                            $target_video_name = "vid_".$timestamp.$timestamp.".".$ext;

                                            if (!move_uploaded_file($_FILES["attachments"]["tmp_name"][$key], $target_dir.$target_video_name))
                                                $should_add_ticket = false;
                                        } else {
                                            $message = "Vous ne pouvez télécharger qu'une seule vidéo";
                                            goto error_section;
                                        }
                                    }
                                } else {
                                    $message = "Format de fichier inconnu";
                                    goto error_section;
                                }
                            }
                        }
                    }
                }

                if (isset($_POST["location"]) && !empty($_POST["location"])) {
                    if (isset($_POST["address"]) && !empty($_POST["address"])) {
                        if (isset($_POST["phone"]) && !empty($_POST["phone"]) && (strlen($_POST["phone"]) == 8)) {
                            // everything is good, let's upload and
                            // continue

                            if ($should_add_ticket) {
                                $state = "requested";
                                if (isset($_SESSION["admin_id"]) && ($_SESSION["tu_id"] == $_SESSION["admin_id"])) {
                                    $state = "open";
                                }
                                $deadline = "";
                                if (isset($_POST["deadline"])) $deadline = $_POST["deadline"];

                                $result = $ticket->create($_POST["subject"], $_POST["content"], $deadline,
                                                         $_POST["location"], $_POST["address"], $_POST["phone"], $state,
                                                         $target_attachments_names[0], $target_attachments_names[1],
                                                         $target_attachments_names[2], $target_attachments_names[3],
                                                         $target_attachments_names[4], $target_video_name,
                                                         $_POST["dept"], $_SESSION["tu_id"]);
                               if ($result) {
                                    if ($state == "requested") {
                                        $inserted_id = $ticket->get_last_inserted_id();
                                        require_once("../core/bootstrap.php");
                                        $account = new Account($database);
                                        $my_account = $account->get_single($_SESSION["tu_id"]);
                                        $notification->push("Nouvelle demande de ticket", 
                                                            "Une demande de ticket d'assistance a été créée par @".$my_account["user_name"], 
                                                            "/pTicket/ticket?id=".$inserted_id, 
                                                            "/pTicket/assets/images/tix.png", 0);
                                    }
                                    echo '<meta http-equiv="refresh" content="0; url=/pTicket/">';
                               } else {
                                   $message = "Échec de la création du ticket, réessayez plus tard...";
                                   goto error_section;
                               }
                            } else {
                                $message = "Une erreur s'est produite (Not_Ready_To_Add_Ticket)<br>Réessayez plus tard..";
                                goto error_section;
                            }
                        } else {
                            $message = "Tel est invalide";
                        }
                    } else {
                        $message = "L'adresse est vide";
                    }
                } else {
                    $message = "Localisation est vide";
                }
            } else {
                $message = "Département est vide";
            }
        } else {
            $message = "Résumé du problème est vide";
        }

error_section:
        if (!empty($message)) {
            echo '<div class="alert alert-danger">
                      <strong>Erreur:</strong>
                      '.$message.'
                  </div>';
        }
    }
}

?>