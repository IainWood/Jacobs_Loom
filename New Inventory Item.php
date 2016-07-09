<?php
// define variables and sets error messages
$productErr = $quantityErr = $qualityErr = "";
define("REQ"," is required");

//Sets the error message to something
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["product"])){$productErr = "product".REQ;}//Assigns "first name is required"
	if(empty($_POST["quantity"])){$quantityErr = "quantity".REQ;}
	if(empty($_POST["assuranceID"])){$qualityErr = "quality assurance".REQ;}
}
?>

<html>
<head>
<title>Inventory Form</title>
<link href="CSS/insert.css" rel="stylesheet">
</head>
<body>
<div class="maindiv">
<!--HTML Form -->
<div class="form_div">
<div class="title">
</div>
<form action="inventory submit form.php" method="post">
<!-- Method can be set as POST for hiding values in URL-->
<h2>Submit Product to Inventory</h2>
<label>Product Recieved:</label>
<span class="error">* <?php echo $productErr;?></span>
<input class="input" name="product" type="text" value"">
<label>Quantity Recieved:</label>
<span class="error">* <?php echo $quantityErr;?></span>
<input class="input" name="quantity" type="text" value"">
<label>Quality Assurance ID:</label>
<span class="error">* <?php echo $qualityErr;?></span>
<input class="input" name="assuranceID" type="text" value"">
<input class="submit" name="submit" type="submit" value="Insert">
</form>
</div>
</div>
</body>

<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="J@c0bsl0om";
$dbname="new_schema";

//Tries to connect to the account
$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//SQL code for creating a table called inventory
$sql_create_table = "
	CREATE TABLE IF NOT EXISTS inventory(
	inventory_id int(10) NOT NULL AUTO_INCREMENT,
	inventory_product varchar(255) NOT NULL,
	inventory_quantity_recieved varchar(255) NOT NULL,
	inventory_assurance_id varchar(255) NOT NULL,
	PRIMARY KEY(inventory_id)
)";

//Attempts to create the table above
if(mysqli_query($conn , $sql_create_table) == TRUE){
	//If successful, prints nothing, else, prints error
}else{
	echo "Error creating table<br>";
	echo mysqli_errno($conn) . ": " . mysqli_error($conn). "<br>";
}

//prevents XSS by trimming special characters
//that could introduce third party code
function test_input($data){
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	// we are done...
	return $data;
}

//Sets the form answers to the variables
if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
	$product = test_input($_POST['product']);
	$quantity = test_input($_POST['quantity']);
	$assuranceID = test_input($_POST['assuranceID']);

	if(!empty($product) && !empty($quantity) && !empty($assuranceID)){ //makes sure not to insert empty values
		$sql_insert = "INSERT INTO inventory(inventory_product, inventory_quantity_recieved, inventory_assurance_id)
		 							 VALUES ('$product', '$quantity', '$assuranceID');";
		if(mysqli_query($conn , $sql_insert) == TRUE){
			//If successful, prints nothing, else, prints error
		}else{
			echo "Error inserting data<br>";
			echo mysqli_errno($conn) . ": " . mysqli_error($conn). "<br>";
		}
	}
}

mysqli_close($conn); // Closing Connection with Server
?>
