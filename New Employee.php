<?php
// define variables and sets error messages
$fnameErr = $lnameErr = $passErr = $pass_confirm_err = $dob_dayErr = $dob_monthErr =
$dob_yearErr = $emailErr = $phoneErr = $addrErr = $cityErr = $stateErr = $zipErr = "";
define("REQ"," is required");

//Sets the error message to something
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["fname"])){$fnameErr = "first name".REQ;}//Assigns "first name is required"
	if(empty($_POST["lname"])){$lnameErr = "last name".REQ;}
	if(empty($_POST["password"]) || empty($_POST["password_confirm"])){$passErr = "password".REQ;}
	if($_POST["password"] !== $_POST["password_confirm"]){$pass_confirm_err = "Passwords do not match!";}
	if(empty($_POST["dob-day"])){$dob_dayErr = "day".REQ;}
	if(empty($_POST["dob-month"])){$dob_monthErr = "day".REQ;}
	if(empty($_POST["dob-year"])){$dob_yearErr = "day".REQ;}
	if(empty($_POST["email"])){$emailErr = "email".REQ;}
	if(empty($_POST["phone"])){$phoneErr = "phone".REQ;}
	if(empty($_POST["address1"])){$addrErr = "address".REQ;}
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
<h2>New Employee</h2>
<p><span class="error">* required field.</span></p>
<label>First Name:</label>
<span class="error">* <?php echo $fnameErr;?></span>
<input class="input" name="fname" type="text" value"">
<label>Middle Name:</label>
<input class="input" name="mname" type="text" value"">
<label>Last Name:</label>
<span class="error">* <?php echo $lnameErr;?></span>
<input class="input" name="lname" type="text" value"">
<label>Password:</label>
<span class="error">* <?php echo $passErr;?></span>
<input class="input" name="password" type="password" value"">
<label>Confirm Password:</label>
<span class="error">* <?php echo $pass_confirm_err;?></span>
<input class="input" name="password_confirm" type="password" value"">
<label>Date of birth</label><br>
  <select name="dob-day" id="dob-day">
    <option value="">Day</option>
    <option value="">---</option>
    <option value="01">01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>
  </select>
<span class="error">* <?php echo $dob_dayErr;?></span>
  <select name="dob-month" id="dob-month">
    <option value="">Month</option>
    <option value="">-----</option>
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>
<span class="error">* <?php echo $dob_monthErr;?></span>
  <select name="dob-year" id="dob-year">
    <option value="">Year</option>
    <option value="">----</option>
    <option value="2012">2012</option>
    <option value="2011">2011</option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    <option value="2007">2007</option>
    <option value="2006">2006</option>
    <option value="2005">2005</option>
    <option value="2004">2004</option>
    <option value="2003">2003</option>
    <option value="2002">2002</option>
    <option value="2001">2001</option>
    <option value="2000">2000</option>
    <option value="1999">1999</option>
    <option value="1998">1998</option>
    <option value="1997">1997</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
  	<option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
    <option value="1904">1904</option>
    <option value="1903">1903</option>
		<option value="1900">1900</option>
    <option value="1901">1901</option>
</select>
<span class="error">* <?php echo $dob_yearErr;?></span><br>
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
</select>
<span class="error">* <?php echo $stateErr;?></span><br>
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

//Tries to connect to the account
$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//SQL code for creating a table called employees
$sql_create_table = "
	CREATE TABLE IF NOT EXISTS employees(
	emp_id int(10) NOT NULL AUTO_INCREMENT,
	emp_first_name varchar(255) NOT NULL,
	emp_middle_name varchar(255) NOT NULL,
	emp_last_name varchar(255) NOT NULL,
	emp_username varchar(255) NOT NULL,
	emp_password varchar(255) NOT NULL,
	emp_day_OB int(3) DEFAULT NULL,
	emp_month_OB int(3) DEFAULT NULL,
	emp_year_OB int(3) DEFAULT NULL,
	emp_email varchar(255) NOT NULL,
	emp_phone varchar(255) NOT NULL,
	emp_street_address1 varchar(255) NOT NULL,
	emp_street_address2 varchar(255) NOT NULL,
	emp_city varchar(255) NOT NULL,
	emp_state varchar(255) NOT NULL,
	emp_zip varchar(255) NOT NULL,
	PRIMARY KEY (emp_id)
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

	do{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	} while ($old_data !== $data);

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
	$first_name = test_input($_POST['fname']); //Assigns the form values to variables to use
	$middle_name = test_input($_POST['mname']);
	$last_name = test_input($_POST['lname']);
	$username = strtolower($first_name[0].$last_name);
	if(isset($_POST['dob-day']) && isset($_POST['dob-month']) && isset($_POST['dob-year'])){
		$birth_day = test_input($_POST['dob-day']); //Don't know why, but this prevent a php error from being thrown when a field is left blank
		$birth_month = test_input($_POST['dob-month']);
		$birth_year = test_input($_POST['dob-year']);
	}
	//hashes the password with salt Tested and it works, should consider converting to server-side hash
	$password = password_hash($_POST['password'] , PASSWORD_BCRYPT);
	$email = test_input($_POST['email']);
	$phone = test_input($_POST['phone']);
	$address_1 = test_input($_POST['address1']);
	$address_2 = test_input($_POST['address2']);
	$city = test_input($_POST['city']);
	if(isset($_POST['state'])){ //Don't know why, but this prevent a php error from being thrown when state is left blank
		$state = test_input($_POST['state']);
	}
	$zip = test_input($_POST['zip']);



	if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone) && !empty($address_1) && !empty($city) && !empty($zip)){
		$sql_insert = "INSERT INTO employees(emp_first_name, emp_middle_name, emp_last_name, emp_username, emp_password,
																				 emp_day_OB, emp_month_OB, emp_year_OB, emp_email, emp_phone, emp_street_address1,
																				 emp_street_address2, emp_city, emp_state, emp_zip)
									 VALUES ('$first_name', '$middle_name', '$last_name', '$username', '$password', '$birth_day', '$birth_month',
										 			 '$birth_year', '$email', '$phone', '$address_1', '$address_2', '$city', '$state', '$zip');";
		if(mysqli_query($conn , $sql_insert) == TRUE){
			//If successful, prints nothing, else, prints error
		}else{
			echo "Error inserting data: ";
			echo mysqli_errno($conn) . ": " . mysqli_error($conn). "<br>";
		}
	}else{
			echo empty($first_name);
	}
}

mysqli_close($conn); // Close Connection with Server
?>
