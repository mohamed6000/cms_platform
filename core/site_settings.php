<?php

class SiteSettings {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function update_site_name($site_name) {
        if (isset($this->conn)) {
            $site_name = htmlspecialchars(strip_tags($site_name));
            if (isset($site_name) && !empty($site_name)) {
                try {
                    $sql = "update `site_settings` set `site_name` = '$site_name'";
                    $this->conn->exec($sql);
                }  catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
        }
    }

    public function set_internal_is_setup() {
        if (isset($this->conn)) {
            try {
                $sql = "update `site_settings` set `internal_is_setup` = '1'";
                $this->conn->exec($sql);
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function get_published_state() {
        if (isset($this->conn)) {
            try {
                $sql = "select `published` from `site_settings` limit 1";
                $stmt = $this->conn->query($sql);
                $site_settings = $stmt->fetch();
                    
                return $site_settings["published"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Internal error on get_published_state";
    }

    public function set_published_state($value) {
        if (isset($this->conn)) {
            try {
                $value = htmlspecialchars(strip_tags($value));

                $sql = "update `site_settings` set `published` = :value";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["value" => $value]);
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function get_global_infos() {
        if (isset($this->conn)) {
            try {
                $sql = "select * from `site_settings` limit 1";
                $stmt = $this->conn->query($sql);
                $site_settings = $stmt->fetch();
                    
                return $site_settings;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update($site_name, $base_url, $email, $phone, $timing, $address, $description, $keywords) {
        if (isset($this->conn)) {
            $site_name   = htmlspecialchars(strip_tags($site_name));
            $base_url    = htmlspecialchars(strip_tags($base_url));
            $email       = htmlspecialchars(strip_tags($email));
            $phone       = htmlspecialchars(strip_tags($phone));
            $timing      = htmlspecialchars(strip_tags($timing));
            $address     = htmlspecialchars(strip_tags($address));
            $description = htmlspecialchars(strip_tags($description));
            $keywords    = htmlspecialchars(strip_tags($keywords));

            try {
                $sql = "update `site_settings` set `site_name` = :site_name, `base_url` = :base_url, `email` = :email, `phone` = :phone, `timing` = :timing, `address` = :address, `description` = :description, `keywords` = :keywords";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "site_name" => $site_name,
                    "base_url" => $base_url,
                    "email" => $email,
                    "phone" => $phone,
                    "timing" => $timing,
                    "address" => $address,
                    "description" => $description,
                    "keywords" => $keywords
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_email_sender() {
        if (isset($this->conn)) {
            try {
                $sql = "select `email` from `site_settings` limit 1";
                $stmt = $this->conn->query($sql);
                $site_settings = $stmt->fetch();
                    
                return $site_settings["email"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_discount_infos() {
        if (isset($this->conn)) {
            try {
                $sql = "select show_store_discount, store_discount_percent, store_discount_event_name, store_discount_date_limit from `site_settings` limit 1";
                $stmt = $this->conn->query($sql);
                $infos = $stmt->fetch();
                    
                return $infos;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_socials($social_facebook, 
                                   $social_twitter, 
                                   $social_youtube, 
                                   $social_instagram,
                                   $social_pinterest) {
        if (isset($this->conn)) {
            $social_facebook = htmlspecialchars(strip_tags($social_facebook));
            $social_twitter = htmlspecialchars(strip_tags($social_twitter));
            $social_youtube = htmlspecialchars(strip_tags($social_youtube));
            $social_instagram = htmlspecialchars(strip_tags($social_instagram));
            $social_pinterest = htmlspecialchars(strip_tags($social_pinterest));

            try {
                $sql = "update `site_settings` set `social_facebook` = :social_facebook,
                                                   `social_twitter` = :social_twitter,
                                                   `social_youtube` = :social_youtube,
                                                   `social_instagram` = :social_instagram,
                                                   `social_pinterest` = :social_pinterest";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "social_facebook" => $social_facebook,
                    "social_twitter" => $social_twitter,
                    "social_youtube" => $social_youtube,
                    "social_instagram" => $social_instagram,
                    "social_pinterest" => $social_pinterest,
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_logo($target) {
        if (isset($this->conn)) {
            $target = htmlspecialchars(strip_tags($target));

            try {
                $sql = "update `site_settings` set `logo` = :logo";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "logo" => $target
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_store_discount_state() {
        if (isset($this->conn)) {
            try {
                $sql = "select show_store_discount from `site_settings` limit 1";
                $stmt = $this->conn->query($sql);
                $infos = $stmt->fetch();
                    
                return $infos["show_store_discount"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function set_store_discount_state($state) {
        if (isset($this->conn)) {
            $state = htmlspecialchars(strip_tags($state));

            try {
                $sql = "update `site_settings` set `show_store_discount` = :state";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["state" => $state]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_store_discount($store_discount_percent, 
                                          $store_discount_event_name,
                                          $store_discount_date_limit) {
        if (isset($this->conn)) {
            $store_discount_percent = htmlspecialchars(strip_tags($store_discount_percent));
            $store_discount_event_name = htmlspecialchars(strip_tags($store_discount_event_name));
            $store_discount_date_limit = htmlspecialchars(strip_tags($store_discount_date_limit));

            try {
                $sql = "update `site_settings` set `store_discount_percent` = :store_discount_percent, `store_discount_event_name` = :store_discount_event_name, `store_discount_date_limit` = :store_discount_date_limit";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "store_discount_percent" => $store_discount_percent,
                    "store_discount_event_name" => $store_discount_event_name,
                    "store_discount_date_limit" => $store_discount_date_limit
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
}

?>