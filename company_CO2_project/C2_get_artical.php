<?php
 require_once("include/db.inc.php");
 $pdo = connect();

 ?>
<form action="add_artical.php" method="post" enctype="multipart/form-data">
    <h2>Page toevoegen</h2>
    <label for="input_company_name">Page name:</label>
    <input type="text" name="input_company_name" placeholder="company name" id="input_company_name">
    <br>
    <label for="input_page_text">Page text:</label>
    <textarea name="input_page_text" placeholder="Page text" id="input_page_text" rows="4" cols="50"></textarea>
    <br>
    <label for="file">Choose an image:</label>
    <input type="file" name="image_input" id="image" accept=".png, .jpeg, .jpg">
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>