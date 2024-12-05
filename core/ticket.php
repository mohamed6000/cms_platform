<?php

class TicketDepartment {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($dep) {
        if (isset($this->conn)) {
            $dep = htmlspecialchars(strip_tags($dep));

            try {
                $sql = "insert into `ticket_department` (dep) values ('$dep')";
                $this->conn->exec($sql);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_all() {
        if (isset($this->conn)) {
            try {
                $sql = "select * from `ticket_department`";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute();
                if ($result) {
                    $depts = $stmt->fetchAll();                    
                    return $depts;
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_by_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from `ticket_department` where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $dept = $stmt->fetch();                    
                    return $dept;
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            try {
                $sql = "delete from `ticket_department` where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);

                return $result;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update($dep, $id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $dep = htmlspecialchars(strip_tags($dep));
            try {
                $sql = "update `ticket_department` set dep = :dep where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["dep" => $dep, "id" => $id]);

                return $result;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

class Ticket {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($subject, $content, $deadline, 
                           $location, $address, $phone, $state,
                           $image0, $image1, $image2, $image3, $image4,
                           $video, 
                           $department, $from_id) {
        if (isset($this->conn)) {
            $subject = htmlspecialchars(strip_tags($subject));
            if ($deadline) $deadline = htmlspecialchars(strip_tags($deadline));
            $location = htmlspecialchars(strip_tags($location));
            $address = htmlspecialchars(strip_tags($address));
            $phone = htmlspecialchars(strip_tags($phone));
            $state = htmlspecialchars(strip_tags($state));
            $image0 = htmlspecialchars(strip_tags($image0));
            $image1 = htmlspecialchars(strip_tags($image1));
            $image2 = htmlspecialchars(strip_tags($image2));
            $image3 = htmlspecialchars(strip_tags($image3));
            $image4 = htmlspecialchars(strip_tags($image4));
            $video = htmlspecialchars(strip_tags($video));
            $department = htmlspecialchars(strip_tags($department));
            $from_id = htmlspecialchars(strip_tags($from_id));

            try {
                $sql = "insert into `ticket` (subject, content, deadline, 
                                              location, address, phone, state,
                                              attachment_image0, attachment_image1, attachment_image2, attachment_image3, attachment_image4,
                                              attachment_video, 
                                              department, from_id) values 
                                             ('$subject', '$content', '$deadline', 
                                              '$location', '$address', '$phone', '$state',
                                              '$image0', '$image1', '$image2', '$image3', '$image4',
                                              '$video', 
                                              '$department', '$from_id')";
                $this->conn->exec($sql);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_last_inserted_id() {
        if (isset($this->conn)) {
            
            return $this->conn->lastInsertId();
        }

        return 0;
    }

    public function get_by_creator_id($id, $sort_type = "date_created", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where from_id = :id and state != 'closed' order by $sort_type desc limit $first, $per_page";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $tickets = $stmt->fetchAll();                    
                    return ["tickets" => $tickets, "pages" => $pages];
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_closed_by_creator_id($id, $sort_type = "date_created", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where from_id = :id and state = 'closed' order by $sort_type desc limit $first, $per_page";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $tickets = $stmt->fetchAll();                    
                    return ["tickets" => $tickets, "pages" => $pages];
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_requested_by_creator_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from `ticket` where from_id = :id and state = 'requested' order by date_created desc";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $tickets = $stmt->fetchAll();                    
                    return $tickets;
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_by_assigned_to($id, $sort_type = "priority", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where assigned_to = :id and state != 'closed' order by :sort_type desc limit $first, $per_page";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id, "sort_type" => $sort_type]);
                if ($result) {
                    $tickets = $stmt->fetchAll();
                    return ["tickets" => $tickets, "pages" => $pages];
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_closed_by_assigned_to($id, $sort_type = "priority", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where assigned_to = :id and state = 'closed' order by :sort_type desc limit $first, $per_page";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id, "sort_type" => $sort_type]);
                if ($result) {
                    $tickets = $stmt->fetchAll();                    
                    return ["tickets" => $tickets, "pages" => $pages];
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_all($sort_type = "last_updated", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where state != 'closed' order by $sort_type desc limit $first, $per_page";
                $stmt = $this->conn->query($sql);
                $tickets = $stmt->fetchAll();
                return ["tickets" => $tickets, "pages" => $pages];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_all_closed($sort_type = "last_updated", $page = 1, $per_page = 10) {
        if (isset($this->conn)) {
            $sort_type = htmlspecialchars(strip_tags($sort_type));
            $page = htmlspecialchars(strip_tags($page));
            $per_page = htmlspecialchars(strip_tags($per_page));

            try {
                $sql = "select count(*) as tickets_count from `ticket`";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch();
                $tickets_count = (int)$result["tickets_count"];

                $pages = ceil($tickets_count / $per_page);

                $first = ($page * $per_page) - $per_page;

                $sql = "select * from `ticket` where state = 'closed' order by $sort_type desc limit $first, $per_page";
                $stmt = $this->conn->query($sql);
                $tickets = $stmt->fetchAll();                    
                return ["tickets" => $tickets, "pages" => $pages];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_single_by_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from `ticket` where id = :id limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $t = $stmt->fetch();   
                    return $t;
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "delete from `ticket` where id = :id limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function close($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `ticket` set `state` = 'closed' where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function open($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `ticket` set `state` = 'open' where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function abort($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `ticket` set `state` = 'aborted' where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_state($id, $state) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $state = htmlspecialchars(strip_tags($state));

            try {
                $sql = "update `ticket` set `state` = :state where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id, "state" => $state]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function search_by_criteria($criteria) {
        if (isset($this->conn)) {
            $criteria = htmlspecialchars(strip_tags($criteria));

            try {
                if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) {
                    // admin can see all the tickets
                    $sql = "select * from `ticket` where subject like '%".$criteria."%'";
                } else if (isset($_SESSION["account_id"]) && ($_SESSION["account_id"] == $_SESSION["tu_id"])) {
                    if ($_SESSION["account_role"] == "client") {
                        $sql = "select * from `ticket` where from_id = ".$_SESSION["tu_id"]." and subject like '%".$criteria."%'";
                    } else if ($_SESSION["account_role"] == "technician") {
                        $sql = "select * from `ticket` where assigned_to = ".$_SESSION["tu_id"]." and subject like '%".$criteria."%'";
                    }
                }
                $stmt = $this->conn->query($sql);
                $tickets = $stmt->fetchAll();                    
                return $tickets;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function assign_to_id($ticket_id, $tech_id) {
        if (isset($this->conn)) {
            $ticket_id = htmlspecialchars(strip_tags($ticket_id));
            $tech_id = htmlspecialchars(strip_tags($tech_id));

            try {
                $sql = "update `ticket` set `assigned_to` = :assigned_to where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["assigned_to" => $tech_id, "id" => $ticket_id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update($subject, $content, $dept,
                           $priority, $assigned_to,
                           $new_attachment0, $new_attachment1,
                           $new_attachment2, $new_attachment3,
                           $new_attachment4, $new_attachment_video,
                           $deadline,
                           $location, $address, $phone, 
                           $timestamp, $tid) {
        if (isset($this->conn)) {
            $subject              = htmlspecialchars(strip_tags($subject));
            $dept                 = htmlspecialchars(strip_tags($dept));
            $priority             = htmlspecialchars(strip_tags($priority));
            $assigned_to          = htmlspecialchars(strip_tags($assigned_to));
            $new_attachment0      = htmlspecialchars(strip_tags($new_attachment0));
            $new_attachment1      = htmlspecialchars(strip_tags($new_attachment1));
            $new_attachment2      = htmlspecialchars(strip_tags($new_attachment2));
            $new_attachment3      = htmlspecialchars(strip_tags($new_attachment3));
            $new_attachment4      = htmlspecialchars(strip_tags($new_attachment4));
            $new_attachment_video = htmlspecialchars(strip_tags($new_attachment_video));
            $deadline             = htmlspecialchars(strip_tags($deadline));
            $location             = htmlspecialchars(strip_tags($location));
            $address              = htmlspecialchars(strip_tags($address));
            $phone                = htmlspecialchars(strip_tags($phone));
            $timestamp            = htmlspecialchars(strip_tags($timestamp));
            $tid                  = htmlspecialchars(strip_tags($tid));

            try {
                $sql = "update `ticket` set subject = :subject, content = :content, department = :dept, 
                                            priority = :priority, assigned_to = :assigned_to, 
                                            attachment_image0 = :new_attachment0,
                                            attachment_image1 = :new_attachment1,
                                            attachment_image2 = :new_attachment2,
                                            attachment_image3 = :new_attachment3,
                                            attachment_image4 = :new_attachment4,
                                            attachment_video  = :new_attachment_video,
                                            deadline = :deadline, location = :location, address = :address,
                                            phone = :phone, last_updated = :timestamp where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([
                    "subject" => $subject,
                    "content" => $content,
                    "dept" => $dept,
                    "priority" => $priority,
                    "assigned_to" => $assigned_to,
                    "new_attachment0" => $new_attachment0,
                    "new_attachment1" => $new_attachment1,
                    "new_attachment2" => $new_attachment2,
                    "new_attachment3" => $new_attachment3,
                    "new_attachment4" => $new_attachment4,
                    "new_attachment_video" => $new_attachment_video,
                    "deadline" => $deadline,
                    "location" => $location,
                    "address" => $address,
                    "phone" => $phone,
                    "timestamp" => $timestamp,
                    "id" => $tid
                ]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function set_priority($id, $priority) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $priority = htmlspecialchars(strip_tags($priority));

            try {
                $sql = "update `ticket` set `priority` = :priority where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["priority" => $priority, "id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_date($id, $date) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $date = htmlspecialchars(strip_tags($date));

            try {
                $sql = "update `ticket` set `last_updated` = :date where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["date" => $date, "id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
}

class TicketReply {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($reply, $date_created, 
                           $attachment_image0,
                           $attachment_image1,
                           $attachment_image2,
                           $attachment_image3,
                           $attachment_image4,
                           $attachment_video,
                           $from_id, $ticket_id) {
        if (isset($this->conn)) {
            $reply = htmlspecialchars(strip_tags($reply));
            $date_created = htmlspecialchars(strip_tags($date_created));
            $attachment_image0 = htmlspecialchars(strip_tags($attachment_image0));
            $attachment_image1 = htmlspecialchars(strip_tags($attachment_image1));
            $attachment_image2 = htmlspecialchars(strip_tags($attachment_image2));
            $attachment_image3 = htmlspecialchars(strip_tags($attachment_image3));
            $attachment_image4 = htmlspecialchars(strip_tags($attachment_image4));
            $attachment_video = htmlspecialchars(strip_tags($attachment_video));
            $from_id = htmlspecialchars(strip_tags($from_id));
            $ticket_id = htmlspecialchars(strip_tags($ticket_id));

            try {
                $sql = "insert into `ticket_reply` (reply, date_created, 
                                              attachment_image0, attachment_image1, attachment_image2, attachment_image3, attachment_image4,
                                              attachment_video, 
                                              from_id, ticket_id) values 
                                             ('$reply', '$date_created', 
                                              '$attachment_image0', '$attachment_image1', '$attachment_image2', '$attachment_image3', '$attachment_image4',
                                              '$attachment_video', 
                                              '$from_id', '$ticket_id')";
                $this->conn->exec($sql);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_by_ticket_id($ticket_id) {
        if (isset($this->conn)) {
            $ticket_id = htmlspecialchars(strip_tags($ticket_id));

            try {
                $sql = "select * from `ticket_reply` where ticket_id = :ticket_id";
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute([":ticket_id" => $ticket_id])) {
                    $result = $stmt->fetchAll();
                    return $result;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "delete from `ticket_reply` where id = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute([":id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

?>