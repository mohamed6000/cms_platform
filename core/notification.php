<?php

class Notification {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function push($title, $content, $corresponding_url, $corresponding_image, $concerns = 0) {
        if (isset($this->conn)) {
            $title = htmlspecialchars(strip_tags($title));
            $content = htmlspecialchars(strip_tags($content));
            $corresponding_url = htmlspecialchars(strip_tags($corresponding_url));
            $corresponding_image = htmlspecialchars(strip_tags($corresponding_image));
            $concerns = htmlspecialchars(strip_tags($concerns));

            try {
                $sql = "insert into notification (title, content, corresponding_url, corresponding_image, concerns) values ('$title', '$content', '$corresponding_url', '$corresponding_image', '$concerns')";
                $this->conn->exec($sql);
                        
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_all_for_admin($per_display = 5, $offset = 0) {
        if (isset($this->conn)) {
            $per_display = htmlspecialchars(strip_tags($per_display));
            $offset = htmlspecialchars(strip_tags($offset));

            try {
                $sql = "select * from `notification` where concerns = 0 order by date_created desc limit $offset, $per_display";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();

                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function get_all($id, $per_display = 5, $offset = 0) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $per_display = htmlspecialchars(strip_tags($per_display));
            $offset = htmlspecialchars(strip_tags($offset));

            try {
                $sql = "select * from `notification` where concerns = $id order by date_created desc limit $offset, $per_display";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();

                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function get_everything($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from `notification` where concerns = $id order by date_created desc";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();

                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function get_non_visited_count_for_admin($per_display = 5, $offset = 0) {
        if (isset($this->conn)) {
            $per_display = htmlspecialchars(strip_tags($per_display));
            $offset = htmlspecialchars(strip_tags($offset));

            try {
                $sql = "select count(id) as total, visited from `notification` where concerns = 0 and visited = 0 limit $offset, $per_display";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();

                return $result["total"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return 0;
    }

    public function get_non_visited_count($id, $per_display = 5, $offset = 0) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));
            $per_display = htmlspecialchars(strip_tags($per_display));
            $offset = htmlspecialchars(strip_tags($offset));

            try {
                $sql = "select count(id) as total, visited from `notification` where concerns = $id and visited = 0 limit $offset, $per_display";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();

                return $result["total"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return 0;
    }

    public function visit_at_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `notification` set visited = 1 where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
};

?> 