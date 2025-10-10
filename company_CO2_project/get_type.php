<?php
 require_once("include/db.inc.php");
 require_once("include/auth_check_admin.php");
 $pdo = connect();
include "include/header.php";
 ?>
<form action="add_type.php" method="post" enctype="multipart/form-data">
    <h2>Page toevoegen</h2>
    <label for="input_type_name">type name:</label>
    <input type="text" name="input_type_name" placeholder="type name" id="input_type_name">
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>