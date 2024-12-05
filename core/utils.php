<?php

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);

class Utils {
    public static function generate_random_password($length = 16) {
        $result = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $max_rand_val = strlen($chars) - 1;
        for ($index = 0; $index < $length; ++$index) {
            $cursor = mt_rand(0, $max_rand_val);
            $result .= $chars[$cursor];
        }

        return $result;
    }

    public static function prevent_non_logged_in_visits() {
        if (!isset($_SESSION["admin_id"])) {
            if (!isset($_SESSION["account_id"])) {
                header("location: /admin-dashboard/login.php");
                exit;
            }
        }
    }

    public static function prevent_client_visits() {
        if ((isset($_SESSION["account_id"]) && ($_SESSION["account_role"] == "client"))) {
            header("location: /");
            exit;
        }
    }

    public static function prevent_non_admin_visits() {
        // if (!isset($_SESSION["account_role"]) || ($_SESSION["account_role"] == "client") || ($_SESSION["account_role"] == "technician")) {
        if (!isset($_SESSION["admin_id"])) {
            header("location: /admin-dashboard/login.php");
            exit;
        }
    }

    public static function prevent_logged_in_admin_visit() {
        if ((isset($_SESSION["account_id"]) && ($_SESSION["account_role"] == "admin")) || isset($_SESSION["admin_id"])) {
            header("location: /admin-dashboard/");
            exit;
        }
    }

    public static function website_prevent_logged_in_visits() {
        if (isset($_SESSION["account_id"])) {
            echo '<script> location.replace("/"); </script>';
            exit;
        }
    }

    public static function website_prevent_non_logged_in_visits() {
        if (!isset($_SESSION["account_id"])) {
            echo '<script> location.replace("/"); </script>';
            exit;
        }
    }

    public static function get_account_role_string($role) {
        switch ($role) {
            case "admin":      return "admin";
            case "technician": return "technicien";
            case "client":     return "client";
            default:           return "<unknown>";
        }
    }

    public static function get_user_avatar_from_email($email, $size = 200, $default_type = "mp") {
        $email = trim($email);
        $email = strtolower($email);
        $email_hash = hash("sha256", $email);
        $result = "https://gravatar.com/avatar/" . $email_hash . ".jpg?s=" . $size . "&d=" . $default_type;
        return $result;
    }

    public static function send_mail($from, $to, $subject, $message) {
        // @todo: implement mail sending
    }

    public static function is_the_mime_image($mime) {
        return (($mime === "image/jpeg") || ($mime === "image/bmp") ||
                ($mime === "image/gif") || ($mime === "image/png") ||
                ($mime === "image/webp"));
    }

    public static function is_the_mime_video($mime) {
        return (($mime === "video/x-msvideo") || ($mime === "video/mp4") ||
                ($mime === "video/mpeg") || ($mime === "video/ogg") ||
                ($mime === "video/mp2t") || ($mime === "video/webm"));
    }

    public static function get_priority_string($priority) {
        if ($priority == 0) {
            return "Faible";
        } else if ($priority == 1) {
            return "Normale";
        } else if ($priority == 2) {
            return "Haute";
        }

        return "Normale";
    }
};

?>