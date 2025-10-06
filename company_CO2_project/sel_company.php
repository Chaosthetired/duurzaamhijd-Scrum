<?php
include 'include/page_header.php';

$companyRows = $comobj->getAllCompanies();
?>
<body>
    <form action="story_tree.php" method="post">
    <label>Update Page</label>
    <br>
    <label for="Dropdown_Page">Select an option:</label>
    <select id="Dropdown_Page" name="Dropdown_Page">
        <?php foreach ($companyRows as $company) {
    echo "<option value=\"" . $Page['company_id'] . "\">" . $Page['company_name'] . "</option>";
} ?>
    </select>
    <button type="submit">select</button>
</form>