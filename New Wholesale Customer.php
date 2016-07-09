<?php
// define variables and sets error messages
$nameErr = $passErr = $pass_confirm_err = $emailErr = $phoneErr = $addrErr = $cityErr = $stateErr = $zipErr = "";
define("REQ"," is required");
//Sets the error message to something
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["name"])){$nameErr = "name".REQ;}
	if(empty($_POST["password"]) || empty($_POST["password_confirm"])){$passErr = "pass".REQ;}
	if($_POST["password"] !== $_POST["password_confirm"]){$pass_confirm_err = "Passwords do not match!";}
	if(empty($_POST["email"])){$emailErr = "email".REQ;}
	if(empty($_POST["phone"])){$phoneErr = "phone".REQ;}
	if(empty($_POST["address_1"])){$addrErr = "address".REQ;}
	if(empty($_POST["city"])){$cityErr = "city".REQ;}
	if(empty($_POST["state"])){$stateErr = "state".REQ;}
	if(empty($_POST["zip"])){$zipErr = "zip code".REQ;}
}
?>

<html>
<head>
<title>New Employee Form</title>
<link href="CSS/insert.css" rel="stylesheet">
</head>
<body>
<div class="maindiv">
<!--HTML Form -->
<div class="form_div">
<div class="title"></div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
<!-- Method can be set as POST for hiding values in URL-->
<h2>New Wholesale Customer</h2>
<p><span class="error">* required field.</span></p>
<label>Name:</label>
<span class="error">* <?php echo $nameErr;?></span>
<input class="input" name="name" type="text" value"">
<label>Password:</label>
<span class="error">* <?php echo $passErr;?></span>
<input class="input" name="password" type="password" value"">
<label>Confirm Password:</label>
<span class="error">* <?php echo $pass_confirm_err;?></span>
<input class="input" name="password_confirm" type="password" value"">
<label>Email:</label>
<span class="error">* <?php echo $emailErr?></span>
<input class="input" name="email" type="text" value"">
<label>Phone Number:</label>
<span class="error">* <?php echo $phoneErr;?></span>
<input class="input" name="phone" type="text" value"">
<label>Street Address Line 1:</label>
<span class="error">* <?php echo $addrErr;?></span>
<input class="input" name="address1" type="text" value"">
<label>Street Address Line 2:</label>
<input class="input" name="address2" type="text" value"">
<label>City:</label>
<span class="error">* <?php echo $cityErr;?></span>
<input class="input" name="city" type="text" value"">
<select name="state" id="state" value""> <!--List of states including District of Columbia-->
  <option value=" " label="STATE" selected disabled>(State)</option>
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
<!--<labe>Employee Photo:</label>
<input type="file" name="fileToUpload" id="fileToUpload" value"">-->
<input class="submit" name="submit" type="submit" value="Submit">
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

//SQL code for creating a table called customers
$sql_create_table = "
	CREATE TABLE IF NOT EXISTS customers(
	cust_id int(10) NOT NULL AUTO_INCREMENT,
	cust_name varchar(255) NOT NULL,
	cust_email varchar(255) NOT NULL,
	cust_phone varchar(255) NOT NULL,
	cust_street_address1 varchar(255) NOT NULL,
	cust_street_address2 varchar(255) NOT NULL,
	cust_city varchar(255) NOT NULL,
	cust_state varchar(255) NOT NULL,
	cust_zip varchar(255) NOT NULL,
	PRIMARY KEY (cust_id)
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
//DEAD CODE FOR UPLOADING AN EMPLOYEE PHOTO
//Can't seem to correctly orientate the photo
//-----------------------------------------
/*//Don't store images on database(too much space)
//instead store path to the image and store image in folder
if(isset($_POST['submit']) && isset($_FILES['fileToUpload']['tmp_name'])){ // Fetching variables of the form which travels in URL
$target_dir = "uploads/";
$target_file = basename($_FILES['fileToUpload']['name']);
$uploadOk = 1;//1=Success 0=Failure
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//Check if file has an imagesize, i.e. could be a virus just with a .jpg extenstion
if(isset($_FILES['fileToUpload']['tmp_name'])){
$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
}

//Message if file is an image or not
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".<br>";
    $uploadOk = 1;
} else {
    echo "File is not an image.<br>";
    $uploadOk = 0;
}

//Limits the size of file
if ($_FILES['fileToUpload']['size'] > 5000000) {//5MB
    echo "File too large.<br>";
    $uploadOk = 0;
}

// Allow certain file formats: jpg, png, jpeg
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Error: Only .JPG, .JPEG, and .PNG file types are allowed.<br>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "File not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    } else {
        echo "Error uploading file.<br>";
    }
}*/

//Sets the form answers to the variables
if(isset($_POST['submit'])){ //Fetching variables of the form which travels in URL
	$name = test_input($_POST['name']); //Assigns the form values to variables to use
	$password = test_input($_POST['password']);
	$password_confirm = test_input($_POST['password_confirm']);
	$email = test_input($_POST['email']);
	$phone = test_input($_POST['phone']);
	$address_1 = test_input($_POST['address1']);
	$address_2 = test_input($_POST['address2']);
	$city = test_input($_POST['city']);
	if(isset($_POST['state'])){ //Don't know why, but this prevent a php error from being thrown when state is left blank
		$state = test_input($_POST['state']);
	$zip = test_input($_POST['zip']);

	if($password !== $password_confirm){
		$pass_confirm_err = "Passwords do not match!";
	}

	$sql_insert = "INSERT INTO employees(cust_name, cust_email, cust_phone,
																			 cust_street_address1, cust_street_address2,
																			 cust_city, cust_state, cust_zip)
								 VALUES ('$name', '$email', '$phone', '$address_1',
										  	 '$address_2', '$city', '$state', '$zip');";
	 }
	/*if(mysqli_query($conn , $sql_insert) == TRUE){
		//If successful, prints nothing, else, prints error
	}else{
		echo "Error inserting data: ";
		echo mysqli_errno($conn) . ": " . mysqli_error($conn). "<br>";
	}*/
}

mysqli_close($conn); // Close Connection with Server
?>
