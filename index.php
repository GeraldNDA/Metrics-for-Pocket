<?php 
  $access_token = "";
  $consumer_key = "41234-af2d9cbd339c7ac68ff46575";
  $pocketCount;
  function getAuth(){
    session_start();
    global $consumer_key;
    $fields_string = "";
    if (isset($_SESSION['code'])) {
    $code = $_SESSION['code'];
    }
    if(!array_key_exists("redirect",$_GET))
    {
    $parameters = array(
      "consumer_key" => $consumer_key,
      "redirect_uri" => "http://pocketmetrics.heroku.com/",
    );

    //set POST variables
    $url = "https://getpocket.com/v3/oauth/request";

    //url-ify the data for the POST
    foreach($parameters as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    $fields_string = rtrim($fields_string, '&');
    //open connection
    $ch = curl_init($url."?".$fields_string);

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8","X-Accept: application/json"));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    //execute post
    $result = curl_exec($ch);
    
    if(!curl_exec($ch)){
      //disabled error messaging
      //die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
    
    //close connection
    curl_close($ch);
    if(gettype($result) == "string")
    {
      $result = json_decode($result);
      
      $code = $result->code;
      $_SESSION['code'] = $code;
      
      header("Location: https://getpocket.com/auth/authorize?request_token=$code&redirect_uri=http://geraldnda.comlu.com?redirect=done");
      exit;
    }
    }
    //use code to get access token
    $url = "https://getpocket.com/v3/oauth/authorize";
    $parameters = array(
      "consumer_key" => $consumer_key,
      "code" => $code,
    );
    foreach($parameters as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    $fields_string = rtrim($fields_string, '&');
    //open connection
    $ch = curl_init($url."?".$fields_string);
    $parameters = array(
      "consumer_key" => $consumer_key,
      "redirect_uri" => "http://pocketmetrics.heroku.com/",
    );
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8","X-Accept: application/json"));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    //execute post
    $result = curl_exec($ch);
    $result = json_decode($result);
    if(gettype($result) == "object" )
    {
    global $access_token;
    $access_token = $result->access_token;
    global $username;
    $username = $result->username;
    }
    curl_close($ch);
  }
    
  function getCount() {
    global $consumer_key;
    global $access_token;
    global $pocketCount;

    $parameters = array(
      "consumer_key" => $consumer_key,
      "access_token" => $access_token,
      "detailType" => "simple",
    );
    
    //set POST variables
    $url = 'https://getpocket.com/v3/get';
    $fields_string = "";
    //url-ify the data for the POST
    foreach($parameters as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    $fields_string = rtrim($fields_string, '&');
    //open connection
    $ch = curl_init($url."?".$fields_string);

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8","X-Accept: application/x-www-form-urlencoded"));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    //execute post
    $result = curl_exec($ch);
    $result =json_decode($result);
	//echo var_dump($result);
    $pocketCount = count((array)($result->list));
    //$pocketCount = "6969";
    if(!curl_exec($ch)){
      die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
    //close connection
    curl_close($ch);
  }
  getAuth();
  if($access_token)
  {
    getCount();
  }
  else
  {
    $pocketCount = "undefined";
  }
?>

<!DOCTYPE html>
	<html>
		<head>
			<title> Metrics for Pocket</title>
			<script src = "http://code.jquery.com/jquery-2.1.4.min.js"></script>
      <script> var pocketCount = <?php echo $pocketCount ?>;</script>
      <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Ubuntu:400,300,300italic,500' rel='stylesheet' type='text/css'>
      <script src = "script.js" rel = "text/javascript"></script>
      <link href='style.css' rel='stylesheet' type='text/css'>
		</head>
    <body>
      <header>
        <div class="logo">
          <img src="ArticleCounterLogo.svg" alt = "Logo">
          <div class="title">
            <h1>Metrics</h1>
            <h2>for Pocket</h2>
          </div>
        </div>
        <a href="http://pocketmetrics.heroku.com/" class="refresh">
         <!--&#10227;-->
         &#10226;
  
        </a>
        <a href = "http://getpocket.com/a/queue/" class="more">
          <div class="pocketLogo"></div>
          <span><?php echo !empty($username)?$username:"You"; ?></span>
        </a>
      </header>
        <div class="countDisplay">
          <div class="pocketCount">
          You have ... <span id ="swag">0</span> Unread Articles 
          </div>
          <div class="check">
          Last updated <span>Unknown</span> ago ...
          </div>
        </div>
      <footer>
        made with <span class = "heart"> &#10084;</span> by Gerald Aryeetey
      </footer>

    </body>
	</html>

