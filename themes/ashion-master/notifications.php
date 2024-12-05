<?php
$page_title = "Notifications";
$use_pt = "";
include "header.php";

Utils::website_prevent_non_logged_in_visits();

$all_notifications = $notification->get_everything($_SESSION["account_id"]);
?>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6">
                <ul>
                <?php foreach ($all_notifications as $key => $row) { ?>
                <li style="list-style: none; margin-top: 8px; margin-bottom: 8px;">
                    <a href="<?php echo $row["corresponding_url"]; ?>" pt-post="../api/notification-visit.php?id=<?php echo $row["id"]; ?>">
                        <div class="row">
                            <div class="col-sm-2">
                                <img width="100" src="<?php echo $row["corresponding_image"]; ?>" class="rounded-circle"/>
                            </div>
                            <div class="col-sm-8">
                                <span class="d-block" style="<?php echo ($row["visited"] == 0) ? "font-weight: 800;" : ""; ?>">
                                <?php echo $row["title"]; ?>
                                </span>
                                <small class="text-muted" style="<?php echo ($row["visited"] == 0) ? "font-weight: 800;" : ""; ?>">
                                <?php echo $row["content"]; ?>
                                </small>
                                <div class="float-start">
                                    <small class="text-muted" style="<?php echo ($row["visited"] == 0) ? "font-weight: 800;" : ""; ?>">
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
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->


<?php

include "footer.php";

?>