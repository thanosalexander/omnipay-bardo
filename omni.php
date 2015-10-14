<?php

 if (isset($_GET['CUSTOMER_FIRST_NAME'])){
 $fname = $_GET['CUSTOMER_FIRST_NAME'];
 $lname = $_GET['CUSTOMER_LAST_NAME'];
 $email = $_GET['CUSTOMER_EMAIL'];
 $phone = $_GET['CUSTOMER_PHONE'];
 $product = $_GET['PRODUCT_NAME'];
 $address = $_GET['CUSTOMER_ADDRESS'];
 $totalamtfull = $_GET['TRANSAC_AMOUNT'];
 $totalamt = $totalamtfull / 100;
 $city = $_GET['CUSTOMER_CITY'];
 $country = $_GET['CUSTOMER_COUNTRY'];
 $currency_code = $_GET['CURRENCY_CODE'];
 $ordernumber = $_GET['SHOP_NUMBER'];
 $state = $_GET['CUSTOMER_STATE'];
 $custip = $_GET['CUSTOMER_IP'];
 
 echo "<iframe src='http://bardo.com/pay/check.php?fname=$fname&lname=$lname&email=$email&phone=$phone&product=$product&address=$address&total_amount=$totalamt&city=$city&country=$country&currency_code=$currency_code&custip=$custip&custstate=$state&ordernumber=$ordernumber' width='100%' height='100%'  frameBorder='0' scrolling></iframe>";
 
 }
?>
<html>
<head></head>
<body>



</body>
</html>
