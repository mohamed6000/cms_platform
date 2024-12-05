<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");
    require_once("../core/utils.php");

    $database = new Database();
    $ticket = new Ticket($database);

    if (isset($_GET["id"])) {
        $tid = intval($_GET["id"]);
        if ($tid) {
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
                                    // everything is good, let's upload and continue

                                    if ($should_add_ticket) {
                                        $old_ticket = $ticket->get_single_by_id($tid);
                                        $state = $old_ticket["state"];

                                        $deadline = "";
                                        if (isset($_POST["deadline"])) $deadline = $_POST["deadline"];

                                        $new_attachment0 = $old_ticket["attachment_image0"];
                                        if (!empty($target_attachments_names[0])) $new_attachment0 = $target_attachments_names[0];
                                        $new_attachment1 = $old_ticket["attachment_image1"];
                                        if (!empty($target_attachments_names[1])) $new_attachment1 = $target_attachments_names[1];
                                        $new_attachment2 = $old_ticket["attachment_image2"];
                                        if (!empty($target_attachments_names[2])) $new_attachment2 = $target_attachments_names[2];
                                        $new_attachment3 = $old_ticket["attachment_image3"];
                                        if (!empty($target_attachments_names[3])) $new_attachment3 = $target_attachments_names[3];
                                        $new_attachment4 = $old_ticket["attachment_image4"];
                                        if (!empty($target_attachments_names[4])) $new_attachment4 = $target_attachments_names[4];
                                        $new_attachment_video = $old_ticket["attachment_video"];
                                        if (!empty($target_video_name)) $new_attachment_video = $target_video_name;

                                        $priority = $old_ticket["priority"];
                                        if (isset($_POST["priority"])) $priority = $_POST["priority"];

                                        $assigned_to = $old_ticket["assigned_to"];
                                        if (isset($_POST["assigned_to"])) $assigned_to = $_POST["assigned_to"];

                                        $timestamp = date('Y-m-d H:i:s');

                                        $result = $ticket->update($_POST["subject"], $_POST["content"], $_POST["dept"],
                                                                 $priority, $assigned_to,
                                                                 $new_attachment0, $new_attachment1,
                                                                 $new_attachment2, $new_attachment3,
                                                                 $new_attachment4, $new_attachment_video,
                                                                 $deadline,
                                                                 $_POST["location"], $_POST["address"], $_POST["phone"], 
                                                                 $timestamp, $tid);
                                       if ($result) {
                                            echo '<div class="alert alert-success">
                                                      <strong>Ticket</strong> a été mis à jour.
                                                  </div>';
                                       } else {
                                           $message = "Échec de la mise à jour du ticket, réessayez plus tard...";
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
    }
}

?>