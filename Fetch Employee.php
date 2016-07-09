<!DOCTYPE html>
<html>
<head>
<title>Employee List</title>
<meta content="noindex, nofollow" name="robots">
<link href="CSS/pull.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
<div class="divA">
<div class="title">
</div>
<div class="divB">
<div class="divD">
	<p>Click on an Employee to Show More Information</p>
	<?php

	$host="localhost";
	$port=3306;
	$socket="";
	$user="root";
	$password="J@c0bsl0om";
	$dbname="new_schema";

	$conn = new mysqli($host , $user , $password , $dbname , $port , $socket);//Connect to server

	$query = mysqli_query($conn , "SELECT * FROM employees");
	if (!$query) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
	}

		while($row = mysqli_fetch_array($query)){
			$full_name = $row['emp_first_name']." ".$row['emp_last_name'];
			echo "<b><a href=\"Fetch Employee.php?id={$row['emp_id']}\">{$full_name}</a></b>";
			echo "<br />";
		}
	?><!--end of php script-->
</div>
<?php
if (isset($_GET['id'])) {//test_input not necessary because input is controlled
	$id = test_input($_GET['id']);
	$query1 = mysqli_query($conn , "SELECT * FROM employees WHERE emp_id=$id");//
	if (!$query1) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
//$image_path = 'C:\\xampp\\htdocs\\test\\test_insert\\' . $row1['emp_image_path'];
	while ($row1 = mysqli_fetch_array($query1)) {
		//$file_to_grab = "http://localhost/test/test_insert/".$row1['emp_image_path'];
?>
		<div class="form">
			<h2>---Details---</h2>
			<!-- Displaying Data Read From Database -->
			<!--<span>Photo:</span> <img src="<?php// echo $file_to_grab ?>" width="175px" height="200px"/> <?php// echo "<br>";?>-->
			<?php echo "<h1>" , $row1['emp_first_name'] , " " , $row1['emp_last_name'] , "</h1>" , "<br>"; ?>
			<span>E-mail:</span> <?php echo $row1['emp_email'] , "<br>"; ?>
      <span>Phone:</span> <?php echo $row1['emp_phone'] , "<br>"; ?>
			<span>Birthdate:</span> <?php echo $row1['emp_birthdate'] , "<br>"; ?>
			<span>Address:</span> <?php echo $row1['emp_street_address1'] , "<br>";
																	if($row1['emp_street_address2'] !='') {
                                  		echo $row1['emp_street_address2'] , "<br>";
																	}
                                  echo $row1['emp_city']," ",$row1['emp_state']," ",$row1['emp_zip']," ","<br>";?>
		</div>
		<?php
	}
}
?>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div><!--divA-->
</div><!--maindiv-->
<?php
mysqli_close($conn); // Closing Connection with Server
?>
</body>
</html>
