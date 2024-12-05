<?php

function render_technician_row($technician) {
    ?>
<tr 
  id="row_id_<?php echo $technician['id']; ?>"
  <?php echo ($technician["state"] == "deactivated") ? "class='table-danger'" : ""; ?>>
  <td>
    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="<?php echo (empty($technician["first_name"]) || empty($technician["last_name"])) ? $technician["user_name"] :  ($technician["first_name"] . " " . $technician["last_name"]); ?>">
        <img src="<?php echo Utils::get_user_avatar_from_email($technician["email"], 200, "robohash"); ?>" alt="Avatar" class="rounded-circle">
      </li>
      </ul>
  </td>
  <td><strong><?php echo $technician["user_name"]; ?></strong></td>  
  <td>
      <?php
      if ($technician["state"] == "pending") {
        echo '<span class="badge bg-label-warning me-1">En attente</span>';
      } else if ($technician["state"] == "activated") {
        echo '<span class="badge bg-label-primary me-1">Active</span>';
      } else if ($technician["state"] == "restricted") {
        echo '<span class="badge bg-label-danger me-1">limité</span>';
      } else if ($technician["state"] == "deactivated") {
        echo '<span class="badge bg-danger me-1">Désactivé</span>';
      }
      ?>
  </td>
  <td>
    <div class="btn-group" role="group" aria-label="First group">
      <a href="update-user.php?id=<?php echo $technician['id']; ?>" class="btn btn-outline-success px-2">
        <i class="tf-icons bx bx-edit"></i>
      </a>

      <?php if ($technician["state"] != "restricted") { ?>
      <button type="button" class="btn btn-outline-warning px-2" pt-post="api/restrict-user.php?id=<?php echo $technician['id']; ?>" pt-target="#row_id_<?php echo $technician['id']; ?>" pt-replace="outerHTML">
        <i class="tf-icons bx bx-user-minus"></i>
      </button>
      <?php } ?>
      
      <?php if ($technician["state"] != "deactivated") { ?>
      <button type="submit" class="btn btn-outline-danger px-2" pt-post="api/deactivate-user.php?id=<?php echo $technician['id']; ?>" pt-target="#row_id_<?php echo $technician['id']; ?>" pt-replace="outerHTML">
        <i class="tf-icons bx bx-trash"></i>
      </button>
      <?php } ?>

      <?php if ($technician["state"] != "activated") { ?>
      <button type="submit" class="btn btn-outline-primary px-2" pt-post="api/activate-user.php?id=<?php echo $technician['id']; ?>" pt-target="#row_id_<?php echo $technician['id']; ?>" pt-replace="outerHTML">
        <i class="tf-icons bx bx-user-check"></i>
      </button>
      <?php } ?>
    </div>
  </td>
</tr>
<?php
}

?>