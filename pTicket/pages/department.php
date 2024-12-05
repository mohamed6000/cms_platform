<?php
$page_title = "Départements";
include "includes/header.php";

if (isset($_SESSION["admin_id"]) && ($_SESSION["admin_id"] == $_SESSION["tu_id"])) {
    // you can see departments
} else {
    header("Location: /pTicket/tickets");
}

require_once("../api/ticket-render-departments.php");
$depts = $ticket_department->get_all();
?>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">
            <img src="assets/images/list_departments.gif"> Départements
        </span>
        <div class="block_middle_container">
            <div id="result_div"></div>
            <div id="depratments">
                <?php render_departments($depts); ?>
            </div>
            <div>
                <h2>Ajouter un nouveau département</h2>
                <form class="form" pt-post="../api/ticket-department-add.php"
                                   pt-target="#depratments">
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="text" name="dep" placeholder="Département.." class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success" type="submit">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>