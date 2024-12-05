<?php

class Database {

    public function __construct() {
        if (!isset($this->conn)) {
            try {
                $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn = $db;
            } catch (PDOException $e) {
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }

    public function close_connection() {
        $this->conn = null;
    }

    public function get_connection() {
        return $this->conn;
    }

    private function table_exists($table) {
        try {
            $result = $this->conn->query("select 1 from {$table} limit 1");
        } catch (Exception $e) {
            return false;
        }

        return $result !== false;
    }

    // setup utils
    public function setup_create_site_settings_table() {
        if (isset($this->conn)) {
            try {
                $sql = "create table `site_settings` (
                    `site_name` varchar(255),
                    `base_url` varchar(255),
                    `description` varchar(255),
                    `keywords` varchar(255),
                    `address` varchar(255),
                    `email` varchar(255),
                    `phone` varchar(255),
                    `timing` varchar(255),
                    `published` boolean default true,

                    `logo` varchar(255),

                    `show_store_discount` boolean default false,
                    `store_discount_percent` int default 0,
                    `store_discount_event_name` varchar(255),
                    `store_discount_date_limit` date NULL,

                    `social_facebook` varchar(255),
                    `social_twitter` varchar(255),
                    `social_youtube` varchar(255),
                    `social_instagram` varchar(255),
                    `social_pinterest` varchar(255),
                    
                    `internal_is_setup` boolean default false
                )";
                $this->conn->exec($sql);

                $sql = "insert into `site_settings` (`site_name`, `base_url`, `description`, `keywords`, `address`, `email`, `phone`, `timing`) values ('Hello Sailor', '', '', '', '', '', '', '')";
                $this->conn->exec($sql);
                return true;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_account_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("account");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `account` (
                        `id` int unsigned auto_increment primary key,
                        `first_name` varchar(255),
                        `last_name` varchar(255),
                        `user_name` varchar(255) unique,
                        `email` varchar(255),
                        `password` varchar(255),
                        `address` varchar(255),
                        `phone` varchar(20),
                        `gender` enum('male', 'female') default 'male',
                        `register_date` timestamp default current_timestamp,
                        `birth_date` date NULL,
                        `role` enum('client', 'technician', 'admin') default 'client',
                        `state` enum('pending', 'activated', 'restricted', 'deactivated') default 'pending'
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_notification_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("notification");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `notification` (
                        `id` int unsigned auto_increment primary key,
                        `title` varchar(255),
                        `content` varchar(255),
                        `corresponding_url` varchar(255),
                        `corresponding_image` varchar(255),
                        `date_created` timestamp default current_timestamp,
                        `visited` BOOLEAN NOT NULL DEFAULT FALSE,
                        `concerns` int default 0
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_ticket_department_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("ticket_department");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `ticket_department` (
                        `id` int unsigned auto_increment primary key,
                        `dep` varchar(255) unique
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_ticket_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("ticket");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `ticket` (
                        `id` int unsigned auto_increment primary key,
                        `subject` varchar(255),
                        `content` varchar(300),
                        `priority` tinyint default 1,
                        `date_created` timestamp default current_timestamp,
                        `last_updated` timestamp NULL,
                        `deadline` date,
                        `location` varchar(255),
                        `address` varchar(255),
                        `phone` varchar(20),
                        `state` enum('requested', 'open', 'closed', 'aborted', 'verified') default 'requested',

                        `attachment_image0` varchar(255),
                        `attachment_image1` varchar(255),
                        `attachment_image2` varchar(255),
                        `attachment_image3` varchar(255),
                        `attachment_image4` varchar(255),
                        `attachment_video` varchar(255),
                        
                        `department` int,
                        `from_id` int,
                        `assigned_to` int
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_ticket_reply_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("ticket_reply");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `ticket_reply` (
                        `id` int unsigned auto_increment primary key,
                        `reply` varchar(300),
                        `date_created` timestamp,

                        `attachment_image0` varchar(255),
                        `attachment_image1` varchar(255),
                        `attachment_image2` varchar(255),
                        `attachment_image3` varchar(255),
                        `attachment_image4` varchar(255),
                        `attachment_video` varchar(255),
                        
                        `from_id` int,
                        `ticket_id` int
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_store_product_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("store_product");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `store_product` (
                        `id` int unsigned auto_increment primary key,
                        `title` varchar(255) not null,
                        `brand` varchar(255) not null,
                        `original_price` decimal(10,3),
                        `new_price` decimal(10,3),
                        `description` text not null,
                        `specification` text not null,
                        `stock` int default 0,
                        `image0` varchar(255),
                        `image1` varchar(255),
                        `image2` varchar(255),
                        `image3` varchar(255),
                        `date_created` timestamp default current_timestamp,

                        `category` int,
                        `creator` int
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_store_product_category_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("store_product_category");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `store_product_category` (
                        `id` int unsigned auto_increment primary key,
                        `name` varchar(255) not null unique
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_store_basket_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("store_basket");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "create table `store_basket` (
                        `id` int unsigned auto_increment primary key,

                        `product` int,
                        `client` int,
                        `quantity` int,
                        `history` int
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function setup_create_store_order_table() {
        if (isset($this->conn)) {
            try {
                $table_exists = $this->table_exists("store_order");
                if ($table_exists) {
                    return false;
                } else {
                    $sql = "CREATE TABLE `store_order` (
                        `id` int unsigned auto_increment primary key,
                        `client_id` INT(10) NOT NULL DEFAULT '0',
                        `first_name` VARCHAR(255) NULL DEFAULT NULL,
                        `last_name` VARCHAR(255) NULL DEFAULT NULL,
                        `address` VARCHAR(255) NULL DEFAULT NULL,
                        `phone` VARCHAR(8) NULL DEFAULT NULL,
                        `email` VARCHAR(255) NULL DEFAULT NULL,
                        `content` TEXT NULL DEFAULT NULL,
                        `total` DECIMAL(20,2) NULL DEFAULT NULL,
                        `pay` ENUM('pod','cc') NULL DEFAULT 'pod',
                        `order_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
                    )";
                    $this->conn->exec($sql);
                    return true;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }

    public function check_site_is_setup() {
        if (isset($this->conn)) {
            try {
                // check if table exists first
                $table_exists = $this->table_exists("site_settings");
                if ($table_exists) {
                    $sql = "select `internal_is_setup` from `site_settings` limit 1";
                    $stmt = $this->conn->query($sql);
                    $site_settings = $stmt->fetch();
                    
                    return ($site_settings["internal_is_setup"] === 1);
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return false;
    }
}

?>