<?php

function generate_config_file($hostname, $dbname, $username, $password) {
    $config_file_path = "../../../core/config.php";
    $config_file = fopen($config_file_path, "w");

    $config_file_contents = '<?php

define("DB_HOST", "'.$hostname.'");

define("DB_NAME", "'.$dbname.'");

define("DB_USER", "'.$username.'");

define("DB_PASSWORD", "'.$password.'");
    
?>';
    fwrite($config_file, $config_file_contents);
    fclose($config_file);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = "";
    if (isset($_POST["db_hostname"]) && !empty($_POST["db_hostname"])) {
        if (isset($_POST["db_name"]) && !empty($_POST["db_name"])) {
            if (isset($_POST["db_username"]) && !empty($_POST["db_username"])) {
                // password can be empty, it's fine
                generate_config_file($_POST["db_hostname"], $_POST["db_name"], $_POST["db_username"], $_POST["db_password"]);
                echo "<meta http-equiv='refresh' content='0; setup-tables.php'>";
            } else {
                $error_message = "User name is empty";
            }
        } else {
            $error_message = "Database name is empty";
        }
    } else {
        $error_message = "Host name is empty";
    }

    if (!empty($error_message)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error_message</div>";
    }
}

?>