<?php
include "const.php";
include "db.php";

if ($_POST['company_id'] <> 0) {
	$sql = "UPDATE company SET name = '$_POST['name']', address = '$_POST['address']' WHERE company_id = $_POST['company_id']";
	$result = mysql_query($sql);
}
elseif (!empty($_POST)) {
	$sql = "INSERT INTO company SET name = '$_POST['name']', address = '$_POST['address']'";
	$result = mysql_query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Company</title>
<meta name="description" content="This is an example of HTML5 header element. header element is the head of a new section." />
</head>
<body>
<?php
if (!empty($_GET['company_id']))
	echo "<h1>Edit your company</h1>";
else
	echo "<h1>Add your company</h1>";
?>
<form action="messy-code.php" action="post">
<?php

if ($_GET['company_id'] <> 0) {
	$sql = "SELECT * FROM company WHERE company_id = $_GET['company_id']";
	$result = mysql_query($sql);
}
?>
	<label>Name</label>
	<input type="text" name="name" value="<?php echo $result['name']?>" />
	<br />
	<label>Address</label>
	<input type="text" name="address" value="<?php echo $result['address']?>" />
	<br />
	<input type="submit" name="submit" value="submit" />
</form>
</body>
</html>