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
	$fp = fopen('flipkart.json', 'w');
	//$items['items']=$details;
	fwrite($fp, json_encode($details));
	fclose($fp);	
	echo "File created \r\n";
}
//Replace <affiliate-id> and <access-token> with the correct values
$trackingId="yogendrad";
$tokenId="75be719547854aea82b22deac9af8cea";
$searchQuery='tops';
$resultCount=50;
$productId="MOBE6FT8DZXTBRZZ";
$categoryForSearch="womens_clothing";
//
$filterStringArray=array("/Lingerie/","/shawls/","/Skirts/","/Salwars/","/Churidars/","/Kurtis/",
	"/Jackets/","/HaremPants/","/Dresses/","/Shorts/","/Jeans/","/Saris/","/Blouses/",
	"/Leggings/","/tops/","/Socks/");
$categoryStringArray=array("womens_clothing_lingerie","womens_clothing_shawls","womens_clothing_skirts","womens_clothing_salwars",
	"womens_clothing_churidars","womens_clothing_kurtis","womens_clothing_jackets","womens_clothing_haremPants",
	"womens_clothing_dresses","womens_clothing_shorts","womens_clothing_jeans","womens_clothing_sarees","womens_clothing_blouses",
	"womens_clothing_leggings","womens_clothing_tops");
//api call
$flipkart = new \Flipkart($trackingId,$tokenId,"json");
$search_url = 'https://affiliate-api.flipkart.net/affiliate/search/json?query='.$searchQuery.'&'.'resultCount='.$resultCount;
$productFeeds_url='https://affiliate-api.flipkart.net/affiliate/api/'.$trackingId.'.json';
$dotd_url='https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
$searchProductId_url='https://affiliate-api.flipkart.net/affiliate/product/json?id='.$productId;
$topoffers_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/top/json';
$orderReport_url='https://affiliate-api.flipkart.net/affiliate/report/orders/detail/json?startDate=yyyy-MM-dd&endDate=yyyy-MM-dd&status=<status>&offset=0';
//
//First make call to product feeds url to get list of api's which we can access
$api_lists = $flipkart->call_url($productFeeds_url);
if(!$api_lists){
        echo 'Error: Could not retrieve api listings';
        exit();
    }
$api_lists = json_decode($api_lists, TRUE);
// url of category search
$url_call = $api_lists['apiGroups']['affiliate']['apiListings'][$categoryForSearch]['availableVariants']['v0.1.0']['get'];
$initial_url =$url_call;
echo $url_call."\r\n";
// url of category search
//
//$url_call ='https://affiliate-api.flipkart.net/affiliate/feeds/yogendrada/category/2oq-c1r/55abefaa73a4773ffb9e7a46.json?expiresAt=1441491712256&sig=13e8b8bdb58bd2d2cd1b5aef4f64b0ab';
//echo $url_call;
//Loop1
//For outer loop
// For total product searched
$totalProductsSearched=0;
// For total resultant array count
$resultArrayCount=0;
// For resultant array
$resultArrayDataEntry=array();

// For loop for filter string
//sizeof($filterStringArray)
for($iter=0;$iter<1;$iter++)
{
	$filterString=$filterStringArray[$iter];
	$categoryString=$categoryStringArray[$iter];
	echo "Iteration: ".$iter."\r\n";
    $url_call=$initial_url;
    $iter2=0;
    $resultArrayCountTemp=0;
	while($iter2<=1)
	{
		$product_lists = $flipkart->call_url($url_call);
		sleep(120);
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
		//		echo $title."\r\n";
				$resultArrayDataEntry[$resultArrayCount]['product_id']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productIdentifier']['productId'];
				$resultArrayDataEntry[$resultArrayCount]['title'] = addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['title']);
				$resultArrayDataEntry[$resultArrayCount]['productDescription']= addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productDescription']);
				$resultArrayDataEntry[$resultArrayCount]['small']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['100x100'];
				$resultArrayDataEntry[$resultArrayCount]['medium']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['400x400'];	
				$resultArrayDataEntry[$resultArrayCount]['large']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['imageUrls']['700x700'];
				$resultArrayDataEntry[$resultArrayCount]['maximumRetailPrice']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
				$resultArrayDataEntry[$resultArrayCount]['sellingPrice'] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
				$resultArrayDataEntry[$resultArrayCount]['productUrl'] = $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productUrl'];
				$resultArrayDataEntry[$resultArrayCount]['productBrand']= addslashes($product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['productBrand']);
				$resultArrayDataEntry[$resultArrayCount]['size']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['size'];	
				$resultArrayDataEntry[$resultArrayCount]['color']= $product_lists['productInfoList'][$iter1]['productBaseInfo']['productAttributes']['color'];
				$resultArrayDataEntry[$resultArrayCount]['category_01']= $categoryString;
				$resultArrayCount++;
				$resultArrayCountTemp++;	

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
		if($resultArrayCountTemp > 400)
		{
			break;
		}

	}
  echo "category added >> : ".$categoryString."\r\n";
}
echo "totalsearched >> :".$totalProductsSearched."\r\n";
echo "totalDataEntered >> :".$resultArrayCount."\r\n";
insertData($resultArrayDataEntry,$resultArrayCount);	

//Loop1