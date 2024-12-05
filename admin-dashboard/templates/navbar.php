<?php

require_once("../core/bootstrap.php");

$database = new Database();
$account = new Account($database);
$notification = new Notification($database);

$my_account = $account->get_single($_SESSION["admin_id"]);
$my_account_picture = Utils::get_user_avatar_from_email($my_account["email"], 256, "robohash");

$notification_list = $notification->get_all_for_admin();
$notification_count = $notification->get_non_visited_count_for_admin();

?>

<!-- Navbar -->
<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center"></div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            <li class="nav-item lh-1 me-3">
                <a class="btn btn-primary" href="/" target="_blank" title="Voir Site Web">
                    <i class='bx bx-show'></i>
                </a>
            </li>

            <li class="nav-item lh-1 me-3 navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" title="Notifications">
                    <i class="tf-icons bx bx-bell"></i>
                    <!-- <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle"> -->
                    
                    <?php if ($notification_count > 0) { ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary px-2 py-1">
                        <!-- <span class="visually-hidden">New Notification</span> -->
                        <?php echo $notification_count; ?>
                    </span>
                    <?php } ?>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <?php foreach ($notification_list as $key => $row) { ?>
                    <li>
                        <a class="dropdown-item" href="#" pt-post="api/notification-visit.php?id=<?php echo $row["id"]; ?>" pt-include="#c_url">
                        <input type="text" value="<?php echo $row["corresponding_url"]; ?>" name="c_url" id="c_url" style="display:none;">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img src="<?php echo $row["corresponding_image"]; ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                            <div class="flex-grow-1">
                                <span class="<?php echo ($row["visited"] == 0) ? "fw-semibold" : ""; ?> d-block">
                                <?php echo $row["title"]; ?>
                                </span>
                                <small class="text-muted">
                                <?php echo $row["content"]; ?>
                                </small>
                                <div class="float-start">
                                    <small class="text-muted">
                                        <i class='bx bx-time'></i>
                                        <?php echo $row["date_created"]; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <!-- @note: avatar-online avatar-offline avatar-away avatar-busy -->
                <div class="avatar avatar-online">
                    <!-- <img src="/admin-dashboard/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" /> -->
                    <img src="<?php echo $my_account_picture; ?>" alt class="w-px-40 h-auto rounded-circle" />
                </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="profile.php">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <!-- <img src="/admin-dashboard/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" /> -->
                                <img src="<?php echo $my_account_picture; ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block">
                            <?php
                                if (!empty($my_account["first_name"]) && !empty($my_account["last_name"])) {
                                    echo $my_account["first_name"] . " " . $my_account["last_name"];
                                } else {
                                    echo $my_account["user_name"];
                                }
                            ?>
                            </span>
                            <small class="text-muted"><?php echo Utils::get_account_role_string($my_account["role"]); ?></small>
                        </div>
                    </div>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                
                <li>
                    <a class="dropdown-item" href="profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Mon Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="site-settings.php">
                    <i class="bx bx-cog me-2"></i>
                    <span class="align-middle">Paramères</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <button class="dropdown-item" pt-post="api/logout.php" pt-replace="outerHTML">
                        <i class="bx bx-power-off me-2"></i>
                        Se déconnecter
                    </button>
                </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->
