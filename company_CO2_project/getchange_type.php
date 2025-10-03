<?php
 require_once("include/db.inc.php");
 require_once("classes/functions.php");
 $pdo = connect();
 $fctopj = new functions($pdo);

$type_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if($type_id == null) {
    $type_id = isset($_POST['Dropdown_artist']) ? intval($_POST['Dropdown_artist']) : null;
}

$typeRow = $fctopj->getTypeById($type_id);

print_r($typeRow);
 ?>
<form action="addchange_type.php?id=<?php echo $type_id; ?>" method="post" enctype="multipart/form-data">
    <h2>Page toevoegen</h2>
    <label for="input_type_name">type name:</label>
    <input type="text" name="input_type_name" placeholder="type name" id="input_type_name" value='<?php echo $typeRow['type_name'] ?>'>
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>