<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once("../../core/bootstrap.php");
    require_once("render-technician-row.php");

    // Utils::begin_session();
    session_start();

    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $account = new Account($database);

        if (isset($_GET["user_id"]) && !empty($_GET["user_id"])) {
            $users = $account->search_users_by_name_criteria($_GET["user_id"]);
            if ($users) {
?>
                <table class="table table-hover">
                    <thead>
                            <tr>
                              <th>#</th>
                              <th>Client</th>
                              <th>Nom</th>
                              <th>Email</th>
                              <th>Role</th>
                            </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    <?php foreach ($users as $index => $user) { ?>
                            <tr onclick="process_selection(this);">
                                <td>
                                    <input type="radio" name="id" value="<?php echo $user["id"]; ?>" hidden>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="<?php echo $user["user_name"]; ?>">
                                            <img src="<?php echo Utils::get_user_avatar_from_email($user["email"], 200, "robohash"); ?>" alt="Avatar" class="rounded-circle">
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <strong><?php echo $user["user_name"]; ?></strong>
                                </td>
                              
                                <td>
                                    <?php echo $user["first_name"]." ".$user["last_name"]; ?>
                                </td>

                                <td>
                                    <?php echo $user["email"]; ?>
                                </td>

                                <td>
                                    <?php echo Utils::get_account_role_string($user["role"]); ?>
                                </td>
                            </tr>

                    <?php } ?>
                    </tbody>
                </table>
<?php
            } else {
                echo "<div class='col'> ... </div>";
            }
        }
    }
}

?>