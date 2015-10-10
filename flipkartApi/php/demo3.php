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
$categoryForSearch="womens_clothing";
//api call
$flipkart = new \Flipkart($trackingId,$tokenId,"json");
$search_url = 'https://affiliate-api.flipkart.net/affiliate/search/json?query='.$searchQuery.'&'.'resultCount='.$resultCount;
$productFeeds_url='https://affiliate-api.flipkart.net/affiliate/api/'.$trackingId.'.json';
$dotd_url='https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
$searchProductId_url='https://affiliate-api.flipkart.net/affiliate/product/json?id='.$productId;
$topoffers_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/top/json';
$orderReport_url='https://affiliate-api.flipkart.net/affiliate/report/orders/detail/json?startDate=yyyy-MM-dd&endDate=yyyy-MM-dd&status=<status>&offset=0';
//If the control reaches here, the API directory view is shown.

//First make call to product feeds url to get list of api's which we can access
$api_lists = $flipkart->call_url($productFeeds_url);
if(!$api_lists){
        echo 'Error: Could not retrieve api listings';
        exit();
    }
$api_lists = json_decode($api_lists, TRUE);
// url of category search
$url_call = $api_lists['apiGroups']['affiliate']['apiListings'][$categoryForSearch]['availableVariants']['v0.1.0']['get'];
echo $url_call;
//Loop1
$iter2=0;
$totalProductsSearched=0;
while($iter2<=50)
{
	$product_lists = $flipkart->call_url($url_call);
	if(!$product_lists){
	        echo 'Error: Could not retrieve api listings';
	        exit();
	    }
	echo "\r\n";
	$product_lists = json_decode($product_lists, TRUE);
	$totalSize = sizeof($product_lists['productInfoList']);   
	//Loop2
	for ($iter1 = 0; $iter1 <= $totalSize-1; $iter1++) {
		$title=$product_lists['productInfoList'][$iter1]['productBaseInfo']['productIdentifier']['categoryPaths']['categoryPath'][0][0]['title'];
		if(preg_match("/Tops/",$title))
		{
			echo $title."\r\n";
		}
	    else 
	    {
	    	continue;
	    }
	}

	//Loop2
	echo $totalSize;
	echo "\r\n";
	$next_url_call = $product_lists['nextUrl'];   
	$url_call = $next_url_call;
	echo $next_url_call;
	echo "\r\n";
	$iter2++;
	$totalProductsSearched=$totalProductsSearched+$totalSize;
	echo "Iteration No >> ".$iter2."\r\n";

}	
echo "totalsearched >> :".$totalProductsSearched."\r\n";
//Loop1