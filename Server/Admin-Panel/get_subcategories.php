<?php
include("./config/db.php"); 

if (isset($_POST['category_id'])) {
  $category_id = $_POST['category_id'];
  echo $category_id;

  $sql = "SELECT * FROM subcategories WHERE category_id = '$category_id'";
  $result = $conn->query($sql);
  

  echo '<option hidden>Select Subcategory</option>';

  while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
  }
}
?>

