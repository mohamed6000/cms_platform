<?php

function render_departments($depts) {
?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Département</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($depts as $index => $dept) { ?>
            <tr>
                <td><?php echo ($index + 1); ?></td>
                <td id="dep<?php echo $dept["id"]; ?>">
                    <input type="text" style="border: none; background: none; outline: none;"
                           name="dep_input<?php echo $dept["id"]; ?>" id="dep_input<?php echo $dept["id"]; ?>"
                           value="<?php echo $dept["dep"]; ?>">
                </td>
                <td>
                    <button type="submit" class="btn btn-xs" title="Enregistrer"
                            pt-post="../api/ticket-department-update.php?id=<?php echo $dept["id"]; ?>"
                            pt-target="#result_div" pt-include="#dep_input<?php echo $dept["id"]; ?>">
                        <img src="assets/images/ok.png">
                    </button>
                    <button type="button" class="btn btn-xs" title="Supprimer"
                            pt-post="../api/ticket-department-delete.php?id=<?php echo $dept["id"]; ?>"
                            pt-target="#depratments">
                        <img src="assets/images/delete.png">
                    </button>
                </td>
            </tr>

            <?php } ?>
        </tbody>
    </table>
<?php 
}
?>