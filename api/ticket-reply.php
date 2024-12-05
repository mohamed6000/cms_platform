<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../core/bootstrap.php");

    $database = new Database();
    $ticket = new Ticket($database);
    $notification = new Notification($database);
    $account = new Account($database);
    $ticket_reply = new TicketReply($database);

    if (isset($_SESSION["tu_id"])) {
        if (isset($_SESSION["admin_id"]) || isset($_SESSION["account_id"])) {
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);
                if ($id) {
                    $message = "";
                    $attachment_video = null;
                    $number_of_uploaded_images = 0;
                    $target_dir = "../uploads/"; // http://localhost:8080/uploads/
                    $target_video_name = "";
                    $target_attachments_names = ["", "", "", "", ""]; // must be 5 items length

                    $should_reply = true;

                    if (isset($_POST["reply"]) && !empty($_POST["reply"])) {
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
                                                    $message = "La taille de l'image est trop grande (maximum: 2 Mo)";
                                                    goto error_section;
                                                }

                                                $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                                                $timestamp = time();
                                                $target_image_name = "img_".$timestamp."_".rand(1000, 6000).".".$ext;
                                                $target_attachments_names[$number_of_uploaded_images-1] = $target_image_name;

                                                if (!move_uploaded_file($_FILES["attachments"]["tmp_name"][$key], $target_dir.$target_image_name))
                                                    $should_reply = false;
                                            }
                                        } else if (Utils::is_the_mime_video($_FILES["attachments"]["type"][$key])) {
                                            if ($_FILES["attachments"]["size"][$key] > 10*MB) {
                                                $message = "La taille du fichier vidéo est trop grande (maximum: 10 Mo)";
                                                goto error_section;
                                            } else {
                                                if (!$attachment_video) {
                                                    $attachment_video = $_FILES["attachments"]["tmp_name"][$key];
                                                    
                                                    $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                                                    $timestamp = time();
                                                    $target_video_name = "vid_".$timestamp.$timestamp.".".$ext;

                                                    if (!move_uploaded_file($_FILES["attachments"]["tmp_name"][$key], $target_dir.$target_video_name))
                                                        $should_reply = false;
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

                        ///
                        if ($should_reply) {
                            $timestamp = date("Y-m-d H:i:s");
                            $result = $ticket_reply->create($_POST["reply"], $timestamp, 
                                                            $target_attachments_names[0],
                                                            $target_attachments_names[1],
                                                            $target_attachments_names[2],
                                                            $target_attachments_names[3],
                                                            $target_attachments_names[4],
                                                            $target_video_name,
                                                            $_SESSION["tu_id"], $id);
                            if ($result) {
                                $reply_user = $account->get_single($_SESSION["tu_id"]);
                                $my_ticket = $ticket->get_single_by_id($id);
                                $ticket->update_date($id, $timestamp);

                                if ($_SESSION["tu_id"] != $my_ticket["from_id"]) {
                                    $notification->push("Vous avez reçu une nouvelle réponse",
                                                        "@".$reply_user["user_name"]." a répondu à votre ticket",
                                                        "/pTicket/ticket?id=".$id, 
                                                        Utils::get_user_avatar_from_email($reply_user["email"], 200, "robohash"), $my_ticket["from_id"]);
                                }

                                if ($_SESSION["tu_id"] != $my_ticket["assigned_to"]) {
                                    $notification->push("Vous avez reçu une nouvelle réponse",
                                                        "@".$reply_user["user_name"]." a répondu à une ticket qui vous est attribué",
                                                        "/pTicket/ticket?id=".$id, 
                                                        Utils::get_user_avatar_from_email($reply_user["email"], 200, "robohash"), $my_ticket["assigned_to"]);
                                }

                                if (isset($_POST["ticket_status"]) && !empty($_POST["ticket_status"])) {
                                    $ticket->update_state($id, $_POST["ticket_status"]);
                                }

                                echo '<meta http-equiv="refresh" content="0; url=/pTicket/ticket?id='.$id.'">';
                            } else {
                                $message = "Échec de la réponse au ticket, réessayez plus tard...";
                               goto error_section;
                            }
                        } else {
                            $message = "Une erreur s'est produite (Not_Ready_To_Add_Ticket)<br>Réessayez plus tard..";
                            goto error_section;
                        }
                    } else {
                        $message = "Réponse vide";
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
}

?>