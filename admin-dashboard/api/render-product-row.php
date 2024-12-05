<?php
function render_product_row($index, $p, $creator) {
?>

<tr id="row_id_<?php echo $p['id']; ?>">
  <td>
    <input type="checkbox" name="product_cb" value="<?php echo $p['id']; ?>">
  </td>
  <td><strong><a href="/product?id=<?php echo $p['id']; ?>"><?php echo $p["title"]; ?></a></strong></td>  
  <td>
      <?php echo $p["date_created"]; ?>
  </td>
  <td>
      @<?php echo $creator; ?>
  </td>
  <td>
    <div class="btn-group" role="group" aria-label="First group">
      <a href="edit-product.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-success px-2">
        <i class="tf-icons bx bx-edit"></i>
      </a>
      <button class="btn btn-outline-danger px-2" 
              pt-post="api/store-product-delete.php?id=<?php echo $p["id"]; ?>"
              pt-target="#row_id_<?php echo $p["id"]; ?>" pt-replace="outerHTML">
          <i class="tf-icons bx bx-trash"></i>
      </button>
    </div>
  </td>
</tr>

<?php
}
?>