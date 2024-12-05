<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    
    // Utils::begin_session();
    session_start();

    $database = new Database();
    $account = new Account($database);

    $account->admin_logout();
    echo "<meta http-equiv='refresh' content='0; /admin-dashboard/login.php'>";
}

?>