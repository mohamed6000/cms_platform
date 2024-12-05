<?php

require_once("../core/bootstrap.php");

$database = new Database();
$account = new Account($database);
$notification = new Notification($database);

$my_account = $account->get_single($_SESSION["account_id"]);
$my_account_picture = Utils::get_user_avatar_from_email($my_account["email"], 256, "robohash");

$notification_list = $notification->get_all($_SESSION["account_id"]);
$notification_count = $notification->get_non_visited_count($_SESSION["account_id"]);

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
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            <li class="nav-item lh-1 me-3 navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" title="Notifications">
                    <i class="tf-icons bx bx-bell"></i>

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
                        <a class="dropdown-item" href="<?php echo $row["corresponding_url"]; ?>" pt-post="../api/notification-visit.php?id=<?php echo $row["id"]; ?>">
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
                <div class="avatar avatar-online">
                    <img src="<?php echo $my_account_picture; ?>" alt class="w-px-40 h-auto rounded-circle" />
                </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="/tech/profile.php">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
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
                    <a class="dropdown-item" href="/tech/profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Mon Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="/pTicket/">
                    <span class="d-flex align-items-center align-middle">
                        <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                        <span class="flex-grow-1 align-middle">Tickets</span>
                        <?php if ($notification_count > 0) { ?>
                        <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20"><?php echo $notification_count; ?></span>
                        <?php } ?>
                    </span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <button class="dropdown-item" pt-post="../api/logout.php" pt-replace="outerHTML">
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
