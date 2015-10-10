<?php
/**
 * Demo Code
 * PHP Wrapper for Flipkart API (unofficial)
 * GitHub: https://github.com/xaneem/flipkart-api-php
 * Demo: http://www.clusterdev.com/flipkart-api-demo
 * License: MIT License
 *
 * @author Saneem (@xaneem, xaneem@gmail.com)
 */
//This is basic example code, and is not intended to be used in production.
//Don't forget to use a valid Affiliate Id and Access Token.
//Include the class.
include "api.php";
//Replace <affiliate-id> and <access-token> with the correct values
$trackingId="yogendrad";
$tokenId="75be719547854aea82b22deac9af8cea";
$searchQuery='tops';
$resultCount=50;
$productId="MOBE6FT8DZXTBRZZ";
$flipkart = new \Flipkart($trackingId,$tokenId,"json");
$search_url = 'https://affiliate-api.flipkart.net/affiliate/search/json?query='.$searchQuery.'&'.'resultCount='.$resultCount;
$productFeeds_url='https://affiliate-api.flipkart.net/affiliate/api/'.$trackingId.'.json';
$dotd_url='https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
$searchProductId_url='https://affiliate-api.flipkart.net/affiliate/product/json?id='.$productId;
$topoffers_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/top/json';
$orderReport_url='https://affiliate-api.flipkart.net/affiliate/report/orders/detail/json?startDate=yyyy-MM-dd&endDate=yyyy-MM-dd&status=<status>&offset=0';
//If the control reaches here, the API directory view is shown.
//Query the API
$details = $flipkart->call_url($search_url);
if(!$details){
        echo 'Error: Could not retrieve products list.';
        exit();
    }
//var_dump($details);
//This was just a rough example created in limited time.
//Good luck with the API.
$details = json_decode($details, TRUE);

//Information of jason database
for($itr=0;$itr<$resultCount;$itr++)
{
$product_id = $details['productInfoList'][$itr]['productBaseInfo']['productIdentifier']['productId'];
$title = addslashes($details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['title']);
$productDescription = addslashes($details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['productDescription']);
$small = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['imageUrls']['100x100'];
$medium = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['imageUrls']['400x400'];	
$large = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['imageUrls']['700x700'];
$maximumRetailPrice = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
$sellingPrice = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
$productUrl = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['productUrl'];
$productBrand = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['productBrand'];
$size = $details['productInfoList'][$itr]['productBaseInfo']['productAttributes']['size'];


//database entry
$servername = "db4free.net:3306";
$username = "tori";
$password = "tori123";
$dbname="data01";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//sql query
$sql = "INSERT INTO data (product_id, title, product_description,image_url_01,image_url_02,image_url_03,maximum_retail_price,selling_price,product_url,product_brand,size)
VALUES ('$product_id','$title','$productDescription','$small','$medium','$large','$maximumRetailPrice','$sellingPrice','$productUrl','$productBrand','$size')";

if (mysqli_query($conn, $sql)) {
    echo "Record #".$itr."created successfully";
} else {
    echo "Error: " . $sql . "\r\n" . mysqli_error($conn);
}

echo "\r\n";
}
//print_r($details);