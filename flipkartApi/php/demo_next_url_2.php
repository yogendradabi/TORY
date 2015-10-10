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
function insertData($details,$resultArrayCount)
{

	//database connection
	//$servername = "db4free.net:3306";
	//$username = "tori";
	//$password = "tori123";
	//$dbname="data01";
	$servername = "localhost:3306";
	$username = "root";
	$password = "";
	$dbname="data01";
	$category_01="womens_clothing_Suits";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

    // To keep only 400 data per category for demo
    if($resultArrayCount>400)
    {
    	$resultArrayCount=400;
    }
	//Information of jason database
	for($itr=0;$itr<$resultArrayCount;$itr++)
	{
		$product_id = $details['product_id'][$itr];
		$title = $details['title'][$itr];
		$productDescription = $details['productDescription'][$itr];
		$small = $details['small'][$itr];
		$medium = $details['medium'][$itr];	
		$large = $details['large'][$itr];
		$sellingPrice= $details['sellingPrice'][$itr];
		$maximumRetailPrice = $details['maximumRetailPrice'][$itr];
		$productUrl = $details['productUrl'][$itr];
		$productBrand = $details['productBrand'][$itr];
		$size = $details['size'][$itr];
//	    echo "product_id: ".$product_id."title: ".$title."productDescription: ".$productDescription."url: ".$small;
		//sql query
		$sql = "INSERT INTO data (product_id, title, product_description,image_url_01,image_url_02,image_url_03,maximum_retail_price,selling_price,product_url,product_brand,size,category_01)
		VALUES ('$product_id','$title','$productDescription','$small','$medium','$large','$maximumRetailPrice','$sellingPrice','$productUrl','$productBrand','$size','$category_01')";

		if (mysqli_query($conn, $sql)) {
		    echo "Record #".$itr."created successfully"."\r\n";
		} else {
		    echo "Error: " . $sql . mysqli_error($conn)."\r\n";
		}
	
	}
	echo "\r\n";	
	
}
//Replace <affiliate-id> and <access-token> with the correct values
$trackingId="yogendrad";
$tokenId="75be719547854aea82b22deac9af8cea";
$searchQuery='tops';
$resultCount=50;
$productId="MOBE6FT8DZXTBRZZ";
$categoryForSearch="womens_clothing";
$filterString="/Suits/";
//api call
$flipkart = new \Flipkart($trackingId,$tokenId,"json");
$search_url = 'https://affiliate-api.flipkart.net/affiliate/search/json?query='.$searchQuery.'&'.'resultCount='.$resultCount;
$productFeeds_url='https://affiliate-api.flipkart.net/affiliate/api/'.$trackingId.'.json';
$dotd_url='https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
$searchProductId_url='https://affiliate-api.flipkart.net/affiliate/product/json?id='.$productId;
$topoffers_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/top/json';
$orderReport_url='https://affiliate-api.flipkart.net/affiliate/report/orders/detail/json?startDate=yyyy-MM-dd&endDate=yyyy-MM-dd&status=<status>&offset=0';
// url of category search
//
$url_call ='https://affiliate-api.flipkart.net/affiliate/feeds/yogendrada/category/2oq-c1r/55abefaa73a4773ffb9e7a46.json?expiresAt=1441491712256&sig=13e8b8bdb58bd2d2cd1b5aef4f64b0ab';
echo $url_call;
//Loop1
//For outer loop
$iter2=0;
//For total product searched
$totalProductsSearched=0;
//For total resultant array count
$resultArrayCount=0;
// For resultant array
$resultArrayDataEntry=array();
while($iter2<=150)
{
	$product_lists = $flipkart->call_url($url_call);
	if(!$product_lists){
	        echo 'Error: Could not retrieve api listings 2'."\r\n";
	        $flipkart = new \Flipkart($trackingId,$tokenId,"json");
	        $product_lists=$flipkart->call_url($url_call);
	    }  
	echo "\r\n";
	$product_lists = json_decode($product_lists, TRUE);
	$totalSize = sizeof($product_lists['productInfoList']);   
    $exitLoop=1;  
	//Loop2
	for ($iter1 = 0; $iter1 <= $totalSize-1; $iter1++) {
		$title=$product_lists['productInfoList'][$iter1]['productBaseInfo']['productIdentifier']['categoryPaths']['categoryPath'][0][0]['title'];
		if($iter1 == 0){
         echo $title."\r\n";
		}  
		if(preg_match($filterString,$title))
		{
			echo $title."\r\n";
			$resultArrayDataEntry['product_id'][$resultArrayCount] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productIdentifier']['productId'];
			$resultArrayDataEntry['title'][$resultArrayCount]  = addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['title']);
			$resultArrayDataEntry['productDescription'][$resultArrayCount] = addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productDescription']);
			$resultArrayDataEntry['small'][$resultArrayCount]= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['100x100'];
			$resultArrayDataEntry['medium'][$resultArrayCount]= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['400x400'];	
			$resultArrayDataEntry['large'][$resultArrayCount]= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['700x700'];
			$resultArrayDataEntry['maximumRetailPrice'][$resultArrayCount] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
			$resultArrayDataEntry['sellingPrice'][$resultArrayCount] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
			$resultArrayDataEntry['productUrl'][$resultArrayCount] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productUrl'];
			$resultArrayDataEntry['productBrand'][$resultArrayCount] = addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productBrand']);
			$resultArrayDataEntry['size'][$resultArrayCount] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['size'];	
			$resultArrayCount++;
			$exitLoop=0;		

		}
		if($exitLoop==1)
		{
			$iter1=$iter1+99;
		}
	}

	//Loop2
	echo "Total Size >> ".$totalSize."\r\n";
	$next_url_call = $product_lists['nextUrl'];   
	$url_call = $next_url_call;
	echo "Next Url >> ".$next_url_call."\r\n";
	$iter2++;
	$totalProductsSearched=$totalProductsSearched+$totalSize;
	echo "Iteration No >> ".$iter2."\r\n";

}
echo "totalsearched >> :".$totalProductsSearched."\r\n";
echo "totalDataEntered >> :".$resultArrayCount."\r\n";
insertData($resultArrayDataEntry,$resultArrayCount);	

//Loop1