<?php
$page_title = "Rechercher";
include "includes/header.php";

?>

<div class="block_middle">
    <div class="block_content">
        <span class="block_title">
            <img src="assets/images/ZoomHS.png">
            Recherche Tickets
        </span>
        <div class="block_middle_container">
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-text" 
                           name="ticket" placeholder="Tapez ici.."
                           pt-get="../api/ticket-search.php" pt-target="#search_result"
                           pt-event="input" pt-include>
                </div>
            </div>
            <div id="search_result"></div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>