<?php
function render_bill_row($index, $id, $name, $date, $phone, $total) {
?>

<tr>
  <td>
    <?php echo ($index + 1); ?>
  </td>
  <td><strong><a href="bill.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></strong></td>  
  <td>
      <?php echo $date; ?>
  </td>
  <td>
      <?php echo $phone; ?>
  </td>
  <td>
      <?php echo $total; ?> DT
  </td>
</tr>

<?php
}
?>