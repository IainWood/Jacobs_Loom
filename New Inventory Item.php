<?php
// define variables and sets error messages
$productTypeErr = $primaryColorErr = $secondaryColorErr = $typeErr = $quantityErr = $qualityErr = "";
define("REQ"," is required");

//Sets the error messages to something
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["productType"])){$productTypeErr = "product type".REQ;}
	if(empty($_POST["primaryColor"])){$primaryColorErr = "primary color".REQ;} //Assigns "primary color is required"
	if(empty($_POST["secondaryColor"])){$secondaryColorErr = "secondary color".REQ;}
	if(empty($_POST["type"])){$typeErr = "type".REQ;}
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
<form action="New Inventory Item.php" method="post">
<!-- Method can be set as POST for hiding values in URL-->
<h2>Submit Product to Inventory</h2>
<label>Product</label><br>
  <select name="productType" id="productType">
		<option selected="true" disabled="disabled">Product</option>
    <option value="Headband">Headband</option>
    <option value="Scarf">Scarf</option>
    <option value="Beanie">Beanie</option>
    <option value="Coffee Cozy">Coffee Cozy</option>
	</select>
<span class="error">* <?php echo $productTypeErr;?></span><br><br>

<label>Primary Color</label><br>
  <select name="primaryColor" id="primaryColor">
		<option selected="true" disabled="disabled">Primary Color</option>
    <option value="Honolulu Pink">Honolulu Pink</option>
    <option value="Fort Worth Blue">Fort Worth Blue</option>
    <option value="Green Bay Green">Green Bay Green</option>
    <option value="Tampa Spice">Tampa Spice</option>
    <option value="Chicago Charcoal">Chicago Charcoal</option>
    <option value="Dallas Grey">Dallas Grey</option>
    <option value="New York White">New York White</option>
		<option value="Oakland Black">Oakland Black</option>
		<option value="Cincinatti Red">Cincinatti Red</option>
		<option value="Misc">Misc</option>

		<option value="Real Teal">Real Teal</option>
    <option value="Dark Orchid">Dark Orchid</option>
    <option value="Coral">Coral</option>
    <option value="Buff">Buff</option>
    <option value="Royal">Royal</option>
    <option value="Heather Grey">Heather Grey</option>
    <option value="Charcoal">Charcoal</option>
		<option value="Medium Thyme">Medium Thyme</option>
		<option value="Warm Brown">Warm Brown</option>
		<option value="Shocking Pink">Shocking Pink</option>
		<option value="Delft Blue">Delft Blue</option>
		<option value="Gold">Gold</option>
		<option value="Carrott">Carrott</option>
		<option value="Orchid">Orchid</option>
	</select>
<span class="error">* <?php echo $primaryColorErr;?></span><br><br>

<label>Secondary Color</label><br>
  <select name="secondaryColor" id="secondaryColor">
		<option selected="true" disabled="disabled">Secondary Color</option>
		<option value="New York White">New York White</option>
		<option value="Dallas Grey">Dallas Grey</option>
		<option value="Tampa Spice">Tampa Spice</option>
    <option value="Detroit Blue">Detroit Blue</option>
    <option value="Portland Wine">Portland Wine</option>
    <option value="Pittsburgh Pumpkin">Pittsburgh Pumpkin</option>
    <option value="Las Vegas Gold">Las Vegas Gold</option>

		<option value="Gold">Gold</option>
		<option value="None">(No Color)</option>
	</select>
<span class="error">* <?php echo $secondaryColorErr;?></span><br><br>

<label>Type</label><br>
  <select name="type" id="type">
		<option selected="true" disabled="disabled">Type</option>
		<option value="Headband Retail">Headband Retail</option>
		<option value="Headband Wholesale Exclusive">Headband Wholesale Exclusive</option>
		<option value="Headband Misc">Headband Misc</option>
    <option value="Headband in Progress Misc">Headband in Progress Misc</option>
    <option value="Scarf Retail">Scarf Retail</option>
    <option value="Scarf Wholesale Exclusive">Scarf Wholesale Exclusive</option>
    <option value="Beanie Retail">Beanie Retail</option>
		<option value="Beanie Wholesale Exclusive">Beanie Wholesale Exclusive</option>
		<option value="Coffee Cozy Regular Label">Coffee Cozy Regular Label</option>
		<option value="Coffee Cozy Custom Label">Coffee Cozy Custom Label</option>
	</select>
<span class="error">* <?php echo $typeErr;?></span><br><br>

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
	inv_id int(10) NOT NULL AUTO_INCREMENT,
  inv_product_code varchar(255) NOT NULL,
  inv_identifier varchar(255) NOT NULL,
  inv_primaryColor varchar(255) NOT NULL,
  inv_secondaryColor varchar(255) NOT NULL,
  inv_type varchar(255) NOT NULL,
  inv_quantity varchar(255) NOT NULL,
  inv_assurance_id varchar(255) NOT NULL,
	PRIMARY KEY(inv_id)
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
	$product = test_input($_POST['productType']);
	$primaryColorNUM = $primaryColor = test_input($_POST['primaryColor']);
	$secondaryColorNUM = $secondaryColor = test_input($_POST['secondaryColor']);
	$type = test_input($_POST['type']);
	$quantity = test_input($_POST['quantity']);
	$assuranceID = test_input($_POST['assuranceID']);
	$primaryColorNUM = $secondaryColorNUM = $typeNUM = "";

	if($product === "Headband"){

		switch($primaryColor){
			  case "Honolulu Pink":
			      $primaryColorNUM = "08";
						break;
			  case "Fort Worth Blue":
			      $primaryColorNUM = "05";
						break;
			  case "Green Bay Green":
			      $primaryColorNUM = "07";
						break;
			  case "Tampa Spice":
			      $primaryColorNUM = "19";
						break;
			  case "Chicago Charcoal":
			      $primaryColorNUM = "01";
						break;
			  case "Dallas Grey":
			      $primaryColorNUM = "03";
						break;
			  case "New York White":
			      $primaryColorNUM = "13";
						break;
			  case "Oakland Black":
			      $primaryColorNUM = "14";
						break;
			  case "Cincinatti Red":
			      $primaryColorNUM = "02";
						break;
			  case "Detroit Blue":
			      $primaryColorNUM = "04";
						break;
			  case "Portland Wine":
			      $primaryColorNUM = "16";
						break;
			  case "Pittsburgh Pumpkin":
			      $primaryColorNUM = "17";
						break;
			  case "Las Vegas Gold":
			      $primaryColorNUM = "10";
						break;
			  case "Misc":
			      $primaryColorNUM = "00";
						break;
			  default:
			      $primaryColorNUM = "00";
		} //end switch

		switch($secondaryColor){
			  case "Honolulu Pink":
			      $secondaryColorNUM = "08";
						break;
			  case "Fort Worth Blue":
			      $secondaryColorNUM = "05";
						break;
			  case "Green Bay Green":
			      $secondaryColorNUM = "07";
						break;
			  case "Tampa Spice":
			      $secondaryColorNUM = "19";
						break;
			  case "Chicago Charcoal":
			      $secondaryColorNUM = "01";
						break;
			  case "Dallas Grey":
			      $secondaryColorNUM = "03";
						break;
			  case "New York White":
			      $secondaryColorNUM = "13";
						break;
			  case "Oakland Black":
			      $secondaryColorNUM = "14";
						break;
			  case "Cincinatti Red":
			      $secondaryColorNUM = "02";
						break;
			  case "Detroit Blue":
			      $secondaryColorNUM = "04";
						break;
			  case "Portland Wine":
			      $secondaryColorNUM = "16";
						break;
			  case "Pittsburgh Pumpkin":
			      $secondaryColorNUM = "17";
						break;
			  case "Las Vegas Gold":
			      $secondaryColorNUM = "10";
						break;
			  case "Misc":
			      $secondaryColorNUM = "00";
						break;
			  default:
			      $secondaryColorNUM = "00";
		} //end switch

	} else {

		switch($primaryColor){
			  case "Real Teal":
			      $primaryColorNUM = "11";
						break;
			  case "Dark Orchid":
			      $primaryColorNUM = "05";
						break;
			  case "Coral":
			      $primaryColorNUM = "07";
						break;
			  case "Buff":
			      $primaryColorNUM = "19";
						break;
			  case "Royal":
			      $primaryColorNUM = "01";
						break;
			  case "Heather Grey":
			      $primaryColorNUM = "03";
						break;
			  case "Charcoal":
			      $primaryColorNUM = "13";
						break;
			  case "Medium Thyme":
			      $primaryColorNUM = "14";
						break;
			  case "Warm Brown":
			      $primaryColorNUM = "02";
						break;
			  case "Shocking Pink":
			      $primaryColorNUM = "04";
						break;
			  case "Delft Blue":
			      $primaryColorNUM = "16";
						break;
			  case "Gold":
			      $primaryColorNUM = "17";
						break;
			  case "Carrot":
			      $primaryColorNUM = "10";
						break;
			  case "Orchid":
			      $primaryColorNUM = "00";
						break;
			  default:
			      $primaryColorNUM = "00";
		} //end switch

		switch($secondaryColor){
					case "Gold":
						  $secondaryColorNUM = "08";
							break;
					default:
						  $secondaryColorNUM = "00";
		} //end switch

	} //end if

	switch($type){
		case "Headband Retail":
			$typeNUM = "001";
			break;
		case "Headband Wholesale Exclusive":
			$typeNUM = "002";
			break;
		case "Headband Misc":
			$typeNUM = "003";
			break;
		case "Headband in Progress Misc":
			$typeNUM = "004";
			break;
		case "Scarf Retail":
			$typeNUM = "005";
			break;
		case "Scarf Wholesale Exclusive":
			$typeNUM = "006";
			break;
		case "Beanie Retail":
			$typeNUM = "007";
			break;
		case "Beanie Wholesale Exclusive":
			$typeNUM = "008";
			break;
		case "Coffee Cozy Regular Label":
			$typeNUM = "009";
			break;
		case "Coffee Cozy Custom Label":
			$typeNUM = "010";
			break;
		default:
			$typeNUM = "000";
	}

	$productCode = "003".$primaryColorNUM.$secondaryColorNUM.$typeNUM;

	if(!empty($product) && !empty($quantity) && !empty($assuranceID)){ //makes sure not to insert empty values
		$sql_insert = "INSERT INTO inventory(inv_product_code, inv_identifier, inv_primaryColor, inv_secondaryColor, inv_type, inv_quantity, inv_assurance_id)
		 							 VALUES ('003', '$productCode', '$primaryColor', '$secondaryColor', '$type', '$quantity', '$assuranceID');";


		if(mysqli_query($conn , $sql_insert) == TRUE){
			?>
			<script type="text/javascript">
				alert("Product successfully inserted!");
			</script>
			<?php
			header("Location: http://localhost/test/test_insert/test.html");
			exit;
		}else{
			?>
			<script type="text/javascript">
				alert("ERROR: Product NOT successfully inserted! Please try again");
			</script>
			<?php
		}
	}
}

mysqli_close($conn); // Closing Connection with Server
?>
