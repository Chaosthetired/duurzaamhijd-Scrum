<?php
 require_once("include/db.inc.php");
 require_once("classes/functions.php");
 $pdo = connect();
 $fctopj = new functions($pdo);

 $typeRows = $fctopj->getAllTypes();
 include "include/header.php";
 ?>
<form action="add_company.php" method="post" enctype="multipart/form-data">
    <h2>company toevoegen</h2>
    <label for="input_company_name">company name:</label>
    <input type="text" name="input_company_name" placeholder="company name" id="input_company_name">
    <br>
    <label for="input_emissions_text">emissions amount:</label>
    <input name="input_emissions_text" placeholder="emissions text" id="input_emissions_text"></input>
    <br>
    <label for="input_electricity_text">electricity use amount:</label>
    <input name="input_electricity_text" placeholder="electricity text" id="input_electricity_text"></input>
    <br>
    <select id="type_dropdown" name="type_dropdown">
        <?php foreach ($typeRows as $t) {
  echo '<option value="' . (int)$t['type_id'] . '">' . htmlspecialchars($t['type_name']) . '</option>';
} ?>
    </select>
    <br>
    <label for="input_source_text">source:</label>
    <input name="input_source_text" placeholder="source text" id="input_source_text"></input>
    <br>
    <label for="file">Choose an image:</label>
    <input type="file" name="image_input" id="image" accept=".png, .jpeg, .jpg">
    <br>
    <button type="submit">Add</button>
</form>
</body>
</html>
