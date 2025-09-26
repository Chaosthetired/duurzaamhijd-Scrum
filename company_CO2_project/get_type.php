<?php
 require_once("include/db.inc.php");
 $pdo = connect();

 ?>
<form action="add_type.php" method="post" enctype="multipart/form-data">
    <h2>Page toevoegen</h2>
    <label for="input_type_name">Page name:</label>
    <input type="text" name="input_type_name" placeholder="type name" id="input_type_name">
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>