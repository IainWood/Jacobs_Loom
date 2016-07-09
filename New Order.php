<?php
// define variables and sets error messages
$quantityErr = $productErr = $nameErr = $addrErr = $cityErr = $stateErr = $zipErr = $phoneErr = $emailErr = "";
define("REQ"," is required");

//Sets the error message to something
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["amount"])){$quantityErr = "quantity".REQ;}
	if(empty($_POST["product"])){$productErr = "product".REQ;}
	if(empty($_POST["name"])){$nameErr = "name".REQ;}
	if(empty($_POST["address1"])){$addrErr = "address".REQ;}
	if(empty($_POST["city"])){$cityErr = "city".REQ;}
	if(empty($_POST["state"])){$stateErr = "state".REQ;}
	if(empty($_POST["zip"])){$zipErr = "zip code".REQ;}
	if(empty($_POST["phone"])){$phoneErr = "phone".REQ;}
	if(empty($_POST["email"])){$emailErr = "email".REQ;}
}
?>

<html>
<head>
<title>Order Form</title>
<link href="CSS/insert.css" rel="stylesheet">
</head>
<body>
<div class="maindiv">
<!--HTML Form -->
<div class="form_div">
<div class="title">
<h2>Insert Data In Database Using PHP.</h2>
</div>
<form action="New Order form.php" method="post">
<!-- Method can be set as POST for hiding values in URL-->
<h2>Order Form</h2>
<label>Quantity:</label>
<span class="error">* <?php echo $quantityErr;?></span>
<input class="input" name="amount" type="number" value"">
<label>Product:</label>
<span class="error">* <?php echo $productErr;?></span>
<input class="input" name="product" type="text" value"">
<label>Name:</label>
<span class="error">* <?php echo $nameErr;?></span>
<input class="input" name="name" type="text" value"">
<label>Street Address Line 1:</label>
<span class="error">* <?php echo $addrErr;?></span>
<input class="input" name="address1" type="text" value"">
<label>Street Address Line 2:</label>
<input class="input" name="address2" type="text" value"">
<label>City:</label>
<span class="error">* <?php echo $cityErr;?></span>
<input class="input" name="city" type="text" value"">
<select name="state" id="state"><!--List of states including District of Columbia-->
  <option label="STATE" selected>(State)</option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
	</select><span class="error">* <?php echo $stateErr;?></span><br>
<label>Zip/Postal Code:</label>
<span class="error">* <?php echo $zipErr;?></span>
<input class="input" name="zip" type="text" value"">
<label>Phone Number:</label>
<span class="error">* <?php echo $phoneErr;?></span>
<input class="input" name="phone" type="text" value"">
<label>Email:</label>
<span class="error">* <?php echo $emailErr;?></span>
<input class="input" name="email" type="text" value"">
<input class="submit" name="submit" type="submit" value="Insert">
</form>
</div>
</div>
</body>
</html>


<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="J@c0bsl0om";
$dbname="new_schema";

//Tries to connect to the server
$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//SQL code for creating a table called orders
$sql_create_table = "
	CREATE TABLE IF NOT EXISTS orders(
	order_id int(10) NOT NULL AUTO_INCREMENT,
	order_amount int(10),
	order_product varchar(225) NOT NULL,
	order_name varchar(255) NOT NULL,
	order_street_address1 varchar(255) NOT NULL,
	order_street_address2 varchar(255) NOT NULL,
	order_city varchar(255) NOT NULL,
	order_state varchar(255) NOT NULL,
	order_zip varchar(255) NOT NULL,
	order_phone varchar(255) NOT NULL,
	order_email varchar(255) NOT NULL,
	PRIMARY KEY (order_id)
)";

//Attempts to create the table above
if(mysqli_query($conn , $sql_create_table) == TRUE){
	//If successful, prints nothing, else, prints error
}else{
	echo "Error creating table";
	echo mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
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
if(isset($_POST['submit'])){ //Fetching variables of the form which travels in URL
	$amount = test_input($_POST['amount']); //Assigns the form values to variables to use
	$product = test_input($_POST['product']);
	$name = test_input($_POST['name']);
	$address_1 = test_input($_POST['address1']);
	$address_2 = test_input($_POST['address2']);
	$city = test_input($_POST['city']);
	if(isset($_POST['state'])){ //Don't know why, but this prevent a php error from being thrown when state is left blank
		$state = test_input($_POST['state']);
	}
	$zip = test_input($_POST['zip']);
	$phone = test_input($_POST['phone']);
	$email = test_input($_POST['email']);

	if(!empty($amount) && !empty($product) && !empty($name) && !empty($address_1) && !empty($city) && !empty($zip) && !empty($phone) && !empty($email)){
	$sql_insert = "INSERT INTO orders (order_id, order_amount, order_product, order_name, order_street_address1,
		 																order_street_address2, order_city, order_state, order_zip,
																		order_phone, order_email)
								 VALUES (NULL, '$amount', '$product', '$name', '$address_1', '$address_2',
									 			 '$city', '$state', '$zip', '$phone', '$email');";
		if(mysqli_query($conn , $sql_insert) == TRUE){
			//If successful, prints nothing, else, prints error
		}else{
			echo "Error inserting data:<br>";
			echo mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
			?>
			<html>
			<p><h3>Redirecting...</h3><br></p>
			<meta http-equiv="refresh" content="2;url=http://localhost/test/test_insert/New%20Order%20form.html"><!--//Redirects back to the form--->
			</html>
			<?php
		}
	}
}

mysqli_close($conn); // Closing Connection with Server
?>
