<html>
<head>
<title>Orders</title>
<meta content="noindex, nofollow" name="robots">
<link href="CSS/pull.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
<div class="divA">
<div class="title">
<h2>Display Order</h2>
</div>
<div class="divB">
<div class="divD">
	<p>Click on an order to view details</p>

<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="J@c0bsl0om";
$dbname="new_schema";

$conn = new mysqli($host , $user , $password , $dbname , $port , $socket);

$query = mysqli_query($conn , "SELECT * FROM orders");
if (!$query) {
	printf("Error1: %s\n", mysqli_error($conn));
	exit();
}

	while($row = mysqli_fetch_array($query)){
		echo "<b><a href=\"Fetch orders.php?id={$row['order_id']}\">{$row['order_id']}</a></b>";
		echo "<br />";
	}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query1 = mysqli_query($conn , "SELECT * FROM orders WHERE order_id=$id");
	if (!$query1) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
	}
	while ($row1  = mysqli_fetch_array($query1)) {
		?>
		</div>
		<div class="form">
			<h2>---Details---</h2>
			<!-- Displaying Data Read From Database -->
			<span>Order Title:</span> <?php echo "Shipping " + $row1['order_product'] , " to " , $row1['order_name'] , "<br>" ?>
			<span>Quantity:</span> <?php echo $row1['order_amount'] , "<br>";?>
			<span>Shipping Address:</span> <?php echo $row1['order_street_address1'] , "<br>";
																if($row1['order_street_address2'] !='') {
                                  echo "     " , $row1['order_street_address2'] , " <br>";
																}
                                  echo $row1['order_city'],", ",$row1['order_state']," ", $row1['order_zip']," ","<br>";?>
			<span>Phone Number:</span> <?php echo $row1['order_phone']; echo "<br>"; ?>
			<span>Email:</span> <?php echo $row1['order_email']; echo "<br>"; ?>
		</div>
		<?php
	}
}

mysqli_close($conn); // Closing Connection with Server
?>


<div class="clear"></div>
</div>
<div class="clear"></div>
</div><!--divA-->
</div><!--maindiv-->
</body>
</html>
