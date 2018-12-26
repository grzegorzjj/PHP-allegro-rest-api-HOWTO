<?php

// below php modules comes from Wiatrogon'a php-allegro-res-api
// https://github.com/Wiatrogon/php-allegro-rest-api
// It were commented and slightly changed ( parameters for get() function )
// by me. But all the code is from and 99,9% of glory shoud go to Wiatrogon.

require_once 'Resource.php';	//classes
require_once 'Api.php';		//classes
require_once 'api_login.php';	//login and allegro conection tokens

$api = new Api($clientId, $clientSecret, $apiKey, $redirectUri.'/api/demo/ApiTest.php', null, null);
//  the 4-th parameter should point to Your auth file.php - in this example - this file.
//  on my server it's located in http://myserver.com/api/demo/ directory
//  and during the regirtration process I put [ http://myserver.com ] as a url.
//  if You put in smoewhere different directory You  shold edit added string
//  '/api/dem/ApiTest.php'  

$code = $_GET['code'];
//  parameter needed for authorisation - returned by Allegro while two-phase auth method

if(strlen($code)<3)
{  // run once - for authorization code passing to allegro
  $authUri=$api->getAuthorizationUri();

//echo $authUri."<br><br><br>"; 
//  IMPORTANT!!!!!
//  You may have to run it once manually - uncoment the above line, copy from browser output
//  paste & execute in browser being Loged in to allegro. It asks ( allegro web page ) You
//  if You agree to run program named [ name_given_while_registration_process ]. You should
//  probably agree  ;-)

  header("Location: $authUri");
  exit;
}

//  for my lazy character:
//  define ('RESTAPI' , 'https://allegroapi.io'); 

//  ### Getting new token ###
$response = $api->getNewAccessToken($code);
//  # response contains json with your access_token and refresh_token

//   Look how token looks like - just to see it, You might never know how it is....
echo "[============ Hi this is Your access token ==================]<br>";
echo $response;

echo "<br><br><br>";

//  If Your app is planned to work 24/7 ( exceed 12h after first run ) should refresh
//  token every 12 h or less
//$response = $api->refreshAccessToken();

echo "[============ This is a one selected category info ==================]<br>";
echo $api->categories(15703)->get();
//  Reprezents request:  RESTAPI/categories/15703
//  ... and get() function must be at the end each time You call GET resource.

echo "<br><br><br>";

echo "[============ All main categories  ==================]<br>";
echo $api->categories()->get();
//  Reprezents request:  RESTAPI/categories

echo "<br><br><br>";

//  Sometimes resouces needs additional parameters given
//  to prepare them You must create an array['parameter_name','parameter_value]
//  below there ia an array with 3 parameters 
$params=array('category.id' => '15703', 'limit' => 100, 'offset' => 0);
//  please take 100 auctions from 0 to 99 of 15703 category [ Yea! That's my favourite.... ]
//  to take 50 auctions from 200 to 249 it should look like:
//  $params=array('category.id' => '15703', 'limit' => 50, 'offset' => 200);

$response=$api->offers->listing()->get($params);
//  Reprezents request:  RESTAPI/offers/listing?category.id=15703&limit=100&offset=0
//  to get more than 100 You must do the loop ( do-while / while / for ) with 
//  $params['offset'] modification ( 0/100/200/300 ..... ) - always n x limit parameter


$response=json_decode($response,true);
//  The response is always in json format. Let's make a multi dimension array from it.

//  have a look for an array made from this response:
echo "[============ All the items selected and get from the server - OUR MAIN GOAL!! ==================]<br>";
echo print_r($response,true);
//  probably it's better to set the limit parameter to 10 - You will have smaller output....

//  all the output is divided now ( not wise , but we have no choice ) for two groups of items
//  promoted - that appears at the begining of Your search while browsing allegro.pl
//  regular - the rest of items/auctions
$num_promoted=count($response['items']['promoted']);
$num_regular=count($response['items']['regular']);
//  we may count them - as counting elements of an array.

echo "<br><br><br>";
echo "<br><br><br>";

//  .... and look at the end of an output
echo "[============ One selected auction - details  ==================]<br>";
echo print_r($response['items']['promoted'][0]['id'],true)." | ";
echo print_r($response['items']['promoted'][0]['name'],true)." | ";
echo print_r($response['items']['promoted'][0]['images'][0]['url'],true)." | ";
//  and this is the way we can access elements of our array of promoted group

echo "[============ Second one selected auction - details  ==================]<br>";
echo print_r($response['items']['regular'][0]['id'],true)." | ";
echo print_r($response['items']['regular'][0]['name'],true)." | ";
echo print_r($response['items']['regular'][0]['images'][0]['url'],true)." | ";
//  and this is the way we can access elements of our array of promoted group

// to acces items You of cours need some loop parametrisd by $f ( eg. for($f=0;$f<$num_regular;$f++)  )
//  $item_id=$response['items']['regular'][$f]['id'];
//  $item_name=$response['items']['regular'][$f]['name'];
//  $item_image=$response['items']['regular'][$f]['images'][0]['url'];




// And some more explanations:

// GET https://allegroapi.io/{resource}
// $api->{resource}->get();

// GET https://allegroapi.io/{resource}/{resource_id}
// $api->{resource}({resource_id})->get();

// PUT https://allegroapi.io/{resource}/{resource_id}/{command-name}-command/{uuid}
// $api->{resource}({resource_id})->commands()->{command_name}($data);

// PUT https://allegroapi.io/offers/12345/change-price-commands/84c16171-233a-42de-8115-1f1235c8bc0f
//$api->offers(12345)->commands()->change_price($data);
?>