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

$assign = mysqli_query($conn , "SELECT * FROM employees");
if (!$assign) {
	printf("Error: %s\n", mysqli_error($conn));
	exit();
}

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

/*while($row = mysqli_fetch_array($query)){
	$username = $row['emp_username'];
	$password = $row['emp_password'];
	//echo "<b><a href=\"Fetch Employee.php?id={$row['emp_id']}\">{$full_name}</a></b>";
	//echo "<br />";
}*/

$incorrectInfo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['login'])) {//test_input not necessary because input is controlled

		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);

		$query = mysqli_query($conn , "SELECT * FROM employees WHERE emp_username='$username'");

		//Error message
		if (!$query) {
			printf("Error: %s\n", mysqli_error($conn));
	    exit;
		}

		$row = mysqli_fetch_array($query);

		if(password_verify($password , $row['emp_password'])){ //Checks if passwords match, (using hashed password does not work. this is good.)
			header("Location: http://localhost/test/test_insert/test.html");
			exit;
		} else {
			$incorrectInfo = "Username and/or password incorrect<br>"; //Sets the error message to something
		}
	} else {
		$incorrectInfo = "Username and/or password incorrect<br>"; //Sets the error message to something
	}
}
?>

<html>
<head>
<title>Login</title>
<link href="CSS/login.css" rel="stylesheet">
</head>
<body>
<div class="centered">
<div class="maindiv">
<div class="form_div">
<div class="title"></div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
<h2>Login</h2>
<label>Username:</label>
<input class="input" name="username" type="text" value"">
<label>Password:</label>
<input class="input" name="password" type="password" value""><br>
<span class="error"><?php echo $incorrectInfo;?></span>
<a href="http://localhost/test/test_insert/New%20Employee.php">Sign Up</a>
<input class="submit" name="login" type="submit" value="LOGIN">
</form>
</div>
</div>
</div>
</body>
</html>
