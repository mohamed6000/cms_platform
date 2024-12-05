<?php
function render_store_categories($categories) {
if ($categories) { ?>
<table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Catégorie</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody class="table-border-bottom-0">
        <?php foreach ($categories as $index => $cat) { ?>
        <tr>
            <td>
              <input type="checkbox" name="cats_cb[]" value="<?php echo $cat["id"]; ?>">
            </td>
            <td>
              <input type="text" style="border: none; background: none; outline: none;"
                     value="<?php echo $cat["name"]; ?>" name="cat_name<?php echo $cat["id"]; ?>"
                     id="cat_name<?php echo $cat["id"]; ?>">
            </td>
            <td>
              <button class="btn btn-xs btn-success px-0" title="Enregistrer"
                      pt-post="api/store-category-update.php?id=<?php echo $cat["id"]; ?>"
                      pt-target="#result_div" pt-include="#cat_name<?php echo $cat["id"]; ?>">
                  <i class='bx bx-check'></i>
              </button>
              <button class="btn btn-xs btn-danger px-0" title="Supprimer"
                      pt-post="api/store-category-delete.php?id=<?php echo $cat["id"]; ?>"
                      pt-target="#categories">
                <i class='bx bx-x'></i>
              </button>
            </td>
        </tr>
        <?php } ?>
  </tbody>
</table>
<?php }
} ?>