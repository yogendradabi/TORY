<?php
if (preg_match("/Shirts/", "[[{nodeId=20001, nodeName=FLIPKART_TREE}, {nodeId=21667, nodeName=Apparels}, {nodeId=22266, nodeName=Women}, {nodeId=26100, nodeName=Western Wear}, {nodeId=22268, nodeName=Shirts, Tops & Tunics}, {nodeId=22285, nodeName=Tops}]]"
)) {
  echo "Match was found <br />";
}
else
{
	echo "Not matched";
}
/*$arrayName = array();
$arrayName['a'][0]=0;
$arrayName['a'][1]=1;
echo sizeof($arrayName['a']);
echo sizeof($arrayName);

//database connection
$servername = "db4free.net:3306";
$username = "tori";
$password = "tori123";
$dbname="data01";
// Create connection
$conn = mysql_pconnect($servername, $username, $password);
// Check connection
if (!$conn) {
    die('Not connected : ' . mysql_error());
}
$db_selected = mysql_select_db($dbname, $conn);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

$sql = "INSERT INTO data (product_id, title, product_description,image_url_01,image_url_02,image_url_03,maximum_retail_price,selling_price,product_url,product_brand,size)
VALUES ('$product_id','$title','$productDescription','$small','$medium','$large','$maximumRetailPrice','$sellingPrice','$productUrl','$productBrand','$size')";

if (mysql_query($sql)) {
    echo "Record created successfully";
} else {
    echo "Error: " . $sql . "\r\n" . mysql_error();
}
*/

?>