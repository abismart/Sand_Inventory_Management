<html>
<body>
<?php
// session_start();
// if(isset($_SESSION['username']))
// {

include("DBConnection.php"); 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
 $customer_name = $_POST["customer_name"];
 $date = $_POST["date"];
 $vehicle_no = $_POST["vehicle_no"];
 $bill_no = $_POST["bill_no"];
 $material = $_POST["material"];
 $unit = $_POST["unit"];
 $rate = $_POST["rate"];
 $location_no = $_POST["location_no"];
 $amount_paid_for_customer = $_POST["amount_paid_for_customer"];
 $driver_name = $_POST["driver_name"];
 $amount_paid_for_driver = $_POST["amount_paid_for_driver"];

 $stmt = $db->prepare("INSERT INTO records(customer_name,date,vehicle_no,bill_no,material,unit,rate,location_no,amount_paid_for_customer,driver_name,amount_paid_for_driver) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
 $stmt->bind_param("sssssssssss",$customer_name,$date,$vehicle_no,$bill_no,$material,$unit,$rate,$location_no,$amount_paid_for_customer,$driver_name,$amount_paid_for_driver); 
 $stmt->execute();
 $result = $stmt->affected_rows;
 $stmt -> close();
 $db -> close(); 
 
 if($result > 0)
 {
header('location:index.php?success=msg');
exit();
 }
 else
 {
echo $result;
// header('location:index.php?failure=msg');
 exit();
 }
}
else{
	header('location:index.php');
}
// }
// else{
// header('location:l.php?loginf=msg');
//  exit();
//  }
?>
</body> 
</html>