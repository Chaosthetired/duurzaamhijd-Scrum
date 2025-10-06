<?php
 require_once("include/db.inc.php");
 require_once("include/auth_check_super.php");
include "include/header.php";

 $pdo = connect();

 ?>
<form action="add_Admin.php" method="post" enctype="multipart/form-data">
    <h2>admin toevoegen</h2>
    <label for="Admin_username">admin username:</label>
    <input type="text" name="Admin_username" placeholder="admin username" id="Admin_username">
    <br>
    <br>
    <label for="Admin_password">admin password:</label>
    <input name="Admin_password" placeholder="admin password" id="Admin_password"></textarea>
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>