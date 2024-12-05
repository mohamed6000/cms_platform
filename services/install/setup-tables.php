<?php

$config_file_path = "../../core/config.php";

if (file_exists($config_file_path)) {

    require_once($config_file_path);
    require_once("../../core/database.php");

    $database = new Database();
    if ($database->check_site_is_setup()) {
        // prevent installation restart
        header("location: /");
    } else {
        if ($database->setup_create_account_table()) {
            if ($database->setup_create_site_settings_table()) {
                if ($database->setup_create_notification_table()) {
                    if ($database->setup_create_ticket_department_table()) {
                        if ($database->setup_create_ticket_table()) {
                            if ($database->setup_create_ticket_reply_table()) {
                                if ($database->setup_create_store_product_table()) {
                                    if ($database->setup_create_store_product_category_table()) {
                                        if ($database->setup_create_store_basket_table()) {
                                            if ($database->setup_create_store_order_table()) {
                                                header("location: setup-admin-account.php");
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    // start installation
    header("location: setup.php");
}

?>