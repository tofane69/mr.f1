<?php
define('BOT_TOKEN', '308262213:AAGPSWoYU4Sal-tvF8YYTDjC45g0-co4oLY');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init(API_URL);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}
function processMessage($message) {
  // process incoming message
  $boolean = file_get_contents('booleans.txt');
  $booleans= explode("\n",$boolean);
  $admin = 102718646;
  $message_id = $message['message_id'];
  $rpto = $message['reply_to_message']['forward_from']['id'];
  $chat_id = $message['chat']['id'];
  $txxxtt = file_get_contents('msgs.txt');
  $pmembersiddd= explode("-!-@-#-$",$txxxtt);
  if (isset($message['photo'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
    $photo = $message['photo'];
    $photoid = json_encode($photo, JSON_PRETTY_PRINT);
    $photoidd = json_encode($photoid, JSON_PRETTY_PRINT); 
    $photoidd = str_replace('"[\n    {\n        \"file_id\": \"','',$photoidd);
    $pos = strpos($photoidd, '",\n');
    //$pphoto = strrpos($photoid,'",\n        \"file_size\": ',1);
    $pos = $pos -1;
    $substtr = substr($photoidd, 0, $pos);
    $caption = $message['caption'];
    if($caption != "")
    {
    apiRequest("sendphoto", array('chat_id' => $rpto, "photo" => $substtr,"caption" =>$caption));
    }
    else{
        apiRequest("sendphoto", array('chat_id' => $rpto, "photo" => $substtr));
    }
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. " ,"parse_mode" =>"HTML"));
    
}  else if ($chat_id == $admin && $booleans[0] == "true") {
    
    $photo = $message['photo'];
    $photoid = json_encode($photo, JSON_PRETTY_PRINT);
    $photoidd = json_encode($photoid, JSON_PRETTY_PRINT); 
    $photoidd = str_replace('"[\n    {\n        \"file_id\": \"','',$photoidd);
    $pos = strpos($photoidd, '",\n');
    //$pphoto = strrpos($photoid,'",\n        \"file_size\": ',1);
    $pos = $pos -1;
    $substtr = substr($photoidd, 0, $pos);
    $caption = $message['caption'];
    
    
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			if($caption != "")
    {
    apiRequest("sendphoto", array('chat_id' => $membersidd[$y], "photo" => $substtr,"caption" =>$caption));
    }
    else{
        apiRequest("sendphoto", array('chat_id' => $membersidd[$y], "photo" => $substtr));
    }
			
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
    }
  }
    if (isset($message['video'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1],"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $video = $message['video']['file_id'];
    $caption = $message['caption'];
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $video ,"parse_mode" =>"HTML"));
    if($caption != "")
    {
    apiRequest("sendvideo", array('chat_id' => $rpto, "video" => $video,"caption" =>$caption));
    }
    else{
        apiRequest("sendvideo", array('chat_id' => $rpto, "video" => $video));
    }
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. ","parse_mode" =>"HTML"));
    
}
else if ($chat_id == $admin && $booleans[0] == "true") {
    $video = $message['video']['file_id'];
    $caption = $message['caption'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			if($caption != "")
    {
    apiRequest("sendvideo", array('chat_id' => $membersidd[$y], "video" => $video,"caption" =>$caption));
    }
    else{
        apiRequest("sendvideo", array('chat_id' => $membersidd[$y], "video" => $video));
    }
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
    }
  }
   if (isset($message['sticker'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $sticker = $message['sticker']['file_id'];
   
    apiRequest("sendsticker", array('chat_id' => $rpto, "sticker" => $sticker));
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. " ,"parse_mode" =>"HTML"));
    
}

 else if ($chat_id == $admin && $booleans[0] == "true") {
       $sticker = $message['sticker']['file_id'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			//apiRequest("sendMessage", array('chat_id' => $membersidd[$y], "text" => $texttoall,"parse_mode" =>"HTML"));
			
			    apiRequest("sendsticker", array('chat_id' => $membersidd[$y], "sticker" => $sticker));

			
			
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
}
  }
  
  
  
  if (isset($message['document'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1],"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $video = $message['document']['file_id'];
    $caption = $message['caption'];
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $video ,"parse_mode" =>"HTML"));
    if($caption != "")
    {
    apiRequest("sendDocument", array('chat_id' => $rpto, "document" => $video,"caption" =>$caption));
    }
    else{
        apiRequest("sendDocument", array('chat_id' => $rpto, "document" => $video));
    }
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. " ,"parse_mode" =>"HTML"));
    
}
 else if ($chat_id == $admin && $booleans[0] == "true") {
    $video = $message['document']['file_id'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){

    apiRequest("sendDocument", array('chat_id' => $membersidd[$y], "document" => $video));
    
			
			
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
}
  }
  if (isset($message['voice'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $video = $message['voice']['file_id'];
    $caption = $message['caption'];
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $video ,"parse_mode" =>"HTML"));
    if($caption != "")
    {
    apiRequest("sendVoice", array('chat_id' => $rpto, "voice" => $video,"caption" =>$caption));
    }
    else{
        apiRequest("sendVoice", array('chat_id' => $rpto, "voice" => $video));
    }
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. ","parse_mode" =>"HTML"));
    
}
 else if ($chat_id == $admin && $booleans[0] == "true") {
    $video = $message['voice']['file_id'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){

        apiRequest("sendVoice", array('chat_id' => $membersidd[$y], "voice" => $video));
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
}
  }
  if (isset($message['audio'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $video = $message['audio']['file_id'];
    $caption = $message['caption'];
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $video ,"parse_mode" =>"HTML"));
    if($caption != "")
    {
    apiRequest("sendaudio", array('chat_id' => $rpto, "audio" => $video,"caption" =>$caption));
    }
    else{
        apiRequest("sendaudio", array('chat_id' => $rpto, "audio" => $video));
    }
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. " ,"parse_mode" =>"HTML"));
    
}
 else if ($chat_id == $admin && $booleans[0] == "true") {
    $video = $message['audio']['file_id'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){

                apiRequest("sendaudio", array('chat_id' => $membersidd[$y], "audio" => $video));

		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
}
  }
  if (isset($message['contact'])) {
      
      if ( $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	
}else{
  
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	

}
    }
    else if($rpto !="" && $chat_id==$admin){
   $phone = $message['contact']['phone_number'];
    $first = $message['contact']['first_name'];
    
    $last = $message['contact']['last_name'];
    
    //apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $video ,"parse_mode" =>"HTML"));
    
    apiRequest("sendcontact", array('chat_id' => $rpto, "phone_number" => $phone,"Last_name" =>$last,"first_name"=> $first));
    
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. ","parse_mode" =>"HTML"));
    
}
else if ($chat_id == $admin && $booleans[0] == "true") {
     $phone = $message['contact']['phone_number'];
    $first = $message['contact']['first_name'];
    
    $last = $message['contact']['last_name'];
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){

    apiRequest("sendcontact", array('chat_id' => $membersidd[$y], "phone_number" => $phone,"Last_name" =>$last,"first_name"=> $first));

		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
}
  }
  
  
  
  
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];
    $matches = explode(" ", $text); 
    if ($text=="/start") {
        
        
        
      if($chat_id!=$admin){
      apiRequest("sendMessage", array('chat_id' => $chat_id,"text"=>$pmembersiddd[0] ,"parse_mode"=>"HTML"));

$txxt = file_get_contents('pmembers.txt');
$pmembersid= explode("\n",$txxt);
	if (!in_array($chat_id,$pmembersid)) {
		$aaddd = file_get_contents('pmembers.txt');
		$aaddd .= $chat_id."
";
    	file_put_contents('pmembers.txt',$aaddd);
}

}
if($chat_id==$admin){
  apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => ' ط³ظ„ط§ظ… ظ‚ط±ط¨ط§ظ† ط­ظˆط´ ط¢ظ…ط¯غŒط¯ًںک‰
ط¨ط±ط§غŒ ظ¾ط§ط³ط® ط±ظˆغŒ ظ¾غŒط§ظ… ظ…ظˆط±ط¯ ظ†ط¸ط± ط±غŒظ¾ظ„ط§غŒ ع©ظ†غŒط¯ ظˆ ظ…طھظ† ط®ظˆط¯ ط±ط§ ط¨ظ†ظˆغŒط³غŒط¯ ًںکژ
ط¨ط±ط§غŒ ط¢ط´ظ†ط§غŒغŒ ط¯ع©ظ…ظ‡ غŒ âڑ“ï¸ڈ Helpï¸ڈ ط±ط§ ط¨ط²ظ†غŒط¯ ًں‘Œًںکƒ
.',"parse_mode"=>"MARKDOWN", 'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
}

    } else if ($matches[0] == "/setstart" && $chat_id == $admin) {

    $starttext = str_replace("/setstart","",$text);
            
    file_put_contents('msgs.txt',$starttext."

-!-@-#-$"."
".$pmembersiddd[1]);
apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں“‌ظ¾غŒط§ظ… ط®ظˆط´ ط¢ظ…ط¯ ع¯ظˆغŒغŒ ط¨ظ‡ ًں‘‡

".$starttext.""."

ًں‘†طھط؛غŒغŒط± غŒط§ظپطھ
."));
    
    
    
    
    }
    else if ($matches[0] == "/setdone" && $chat_id == $admin) {
        
    $starttext = str_replace("/setdone","",$text);
            
    file_put_contents('msgs.txt',$pmembersiddd[0]."

-!-@-#-$"."
".$starttext);
apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" =>"ًں“‌ظ¾غŒط§ظ… ظ¾غŒط´ ظپط±ط¶ ط´ظ…ط§ ط¨ظ‡ ًں‘‡

".$starttext.""."

ًں‘†طھط؛غŒغŒط± غŒط§ظپطھ
."));
    
    
    
    
    }
    else if ($text != "" && $chat_id != $admin) {
    	
    	$txt = file_get_contents('banlist.txt');
$membersid= explode("\n",$txt);

$substr = substr($text, 0, 28);
	if (!in_array($chat_id,$membersid)) {
		apiRequest("forwardMessage", array('chat_id' => $admin,  "from_chat_id"=> $chat_id ,"message_id" => $message_id));
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>$pmembersiddd[1] ,"parse_mode" =>"HTML"));	
	
}else{
  if($substr !="thisisnarimanfrombeatbotteam"){
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "<b>You Are Banned</b>ًںڑ«
Get Out Of Here Idiotًں–•
--------------------------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±غŒط¯ ًںڑ«
ظ„ط·ظپط§ ظ¾غŒط§ظ… ظ†ط¯ظ‡غŒط¯ًں–•" ,"parse_mode" =>"HTML"));	
}
else{
  $textfa =str_replace("thisisnarimanfrombeatbotteam","ًں–•",$text);;
apiRequest("sendMessage", array('chat_id' => $admin, "text" =>  $textfa,"parse_mode" =>"HTML"));	
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $pmembersiddd[1] ,"parse_mode" =>"HTML"));	

}
}
    	
    
    }else if ($text == "Settings âڑ™" && $chat_id==$admin) {
    		
    		
    		 apiRequestJson("sendMessage", array('chat_id' => $chat_id,"parse_mode"=>"HTML", "text" => '
غŒع©غŒ ط§ط² ع¯ط²غŒظ†ظ‡ ظ‡ط§ ط±ط§ ط§ظ†طھط®ط§ط¨ ع©ظ†غŒط¯
â€”---------------------------------------------
ًں”¶ًں”¸ Clean Members
ًں”¶ًں”¸ظ¾ط§ع© ع©ط±ط¯ظ† ظ„غŒط³طھ ظ…ط®ط§ط·ط¨غŒظ†

ًں”·ًں”¹Clean Block List
ًں”·ًں”¹ظ¾ط§ع© ع©ط±ط¯ظ† ظ„غŒط³طھ ط³غŒط§ظ‡

ط¯ط± طµظˆط±طھ ط§ظ†طµط±ط§ظپ Back ط±ط§ ط¨ط²ظ†غŒط¯
.', 'reply_markup' => array(
        'keyboard' => array(array('â‌Œ Clean Members ','â‌Œ Clean Block List '),array('ًں”™ Back')),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
    		
    		
    		
    }else if ($text == "âڑ“ï¸ڈ Help" && $chat_id==$admin) {
      
    		apiRequest("sendMessage", array('chat_id' => $admin, "text" => "`ط¨ط±ط§غŒ ظ¾ط§ط³ط® ظ¾غŒط§ظ… ظ…ظˆط±ط¯ ظ†ط¸ط± ط±ط§ ط±غŒظ¾ظ„ط§غŒ ع©ظ†غŒط¯`
ًں”· ظ„غŒط³طھ ع©ط§ظ…ظ†طھ ظ‡ط§غŒ ظ…ظˆط¬ظˆط¯ :

ًں”¹`1.` */ban*
 ظ‚ط±ط§ط± ط¯ط§ط¯ظ† ظ…ط®ط§ط·ط¨ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡(ط¨ط§ ط±غŒظ¾ظ„ط§غŒ) 
â€”------------------------------
ًں”¹`2. `*/unban *
 ظ¾ط§ع© ع©ط±ط¯ظ† ظ…ط®ط§ط·ط¨ ط§ط² ظ„غŒط³طھ ط³غŒط§ظ‡(ط¨ط§ ط±غŒظ¾ظ„ط§غŒ)
â€”------------------------------
ًں”¹`3. `*/setstart *
ط§ع¯ط± ط´ط®طµغŒ ظˆط§ط±ط¯ ط±ط¨ط§طھ ط´ظ…ط§ ط´ظˆط¯ ظˆ */start* ط¨ط²ظ†ط¯ ط§غŒظ† ظ¾غŒط§ظ…  ط¨ط±ط§غŒ ط§ظˆ ط§ط±ط³ط§ظ„ ظ…غŒط´ظˆط¯           */setstart* ط¨ط²ظ†غŒط¯ ظˆ ط¯ط± ط§ط¯ط§ظ…ظ‡ غŒ ط¢ظ† ظ…طھظ† ظ…ظˆط±ط¯ ظ†ط¸ط± ط®ظˆط¯ ط±ط§ ط¨ظ†ظˆغŒط³غŒط¯.
ظ…ط«ط§ظ„ :
*/setstart* ط³ظ„ط§ظ… ع†ط·ظˆط±غŒطں ط§ع¯ظ‡ ظ¾غŒط§ظ…غŒ ط¯ط§ط±غŒ ظˆط§ط³ظ‡ ظ…ظ† ظ‡ظ…غŒظ†ط¬ط§ ط¨ظپط±ط³طھًںکƒ
â€”------------------------------
ًں”¹`4. `*/setdone *
ط§ع¯ط± ط´ط®طµغŒ ط¯ط± ط±ط¨ط§طھ ط¨ط±ط§غŒ ط´ظ…ط§ ظ¾غŒط§ظ…غŒ ط¨ظپط±ط³طھط¯ ط§غŒظ† ظ¾غŒط§ظ… ط¨ط±ط§غŒ ط§ظˆ ط§ط±ط³ط§ظ„ ظ…غŒط´ظˆط¯.
ظ…ط«ط§ظ„ :
*/setdone* ظ¾غŒط§ظ…طھ ط±ط³غŒط¯ طµط¨ط± ع©ظ† طھط§ ط¬ظˆط§ط¨ ط¨ط¯ظ…

â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–
ًں”¶ ظ„غŒط³طھ ط¯ع©ظ…ظ‡  ظ‡ط§غŒ ظ…ظˆط¬ظˆط¯ :

ًں”¸`1.`*Send To All*
ط§ط±ط³ط§ظ„ ظ¾غŒط§ظ… ظ…طھظ†غŒ ط¨ظ‡ ظ‡ظ…ظ‡ غŒ ع©ط§ط±ط¨ط±ط§ظ†
â€”------------------------------
ًں”¸`2.`*Members*
طھط¹ط¯ط§ط¯ ع©ط§ط±ط¨ط±ط§ظ†
â€”------------------------------
ًں”¸`3.`*Blocked Users*
طھط¹ط¯ط§ط¯ ع©ط§ط±ط¨ط±ط§ظ† ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡
â€”-------------------------------
ًں”¸`4.`*Settings*
طھظ†ط¸غŒظ…ط§ظ† ط±ط¨ط§طھ

.","parse_mode" =>"MARKDOWN",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
    		
    }else if ($text == "â‌Œ Clean Members" && $chat_id==$admin) {
    		
    		
    		$txxt = file_get_contents('pmembers.txt');
        $pmembersid= explode("\n",$txxt);
    		file_put_contents('pmembers.txt',"");
    		apiRequestJson("sendMessage", array('chat_id' => $chat_id,"parse_mode"=>"HTML", "text" => 'ظ„غŒط³طھ ظ…ط®ط§ط·ط¨غŒظ† ظ¾ط§ع© ط´ط¯ âœ”ï¸ڈ
.', 'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
    }
    else if ($text == "â‌Œ Clean Block List" && $chat_id==$admin) {
    		
    		
    		$txxt = file_get_contents('banlist.txt');
        $pmembersid= explode("\n",$txxt);
    		file_put_contents('banlist.txt',"");
    		apiRequestJson("sendMessage", array('chat_id' => $chat_id,"parse_mode"=>"HTML", "text" => 'ظ„غŒط³طھ ط³غŒط§ظ‡ ظ¾ط§ع© ط´ط¯ âœ” ', 'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
    }
    else if ($text == "ًں”™ Back" && $chat_id==$admin) {
    		apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => 'ط³ظ„ط§ظ… ظ‚ط±ط¨ط§ظ† ط­ظˆط´ ط¢ظ…ط¯غŒط¯ًںک‰
ط¨ط±ط§غŒ ظ¾ط§ط³ط® ط±ظˆغŒ ظ¾غŒط§ظ… ظ…ظˆط±ط¯ ظ†ط¸ط± ط±غŒظ¾ظ„ط§غŒ ع©ظ†غŒط¯ ظˆ ظ…طھظ† ط®ظˆط¯ ط±ط§ ط¨ظ†ظˆغŒط³غŒط¯ ًںکژ
ط¨ط±ط§غŒ ط¢ط´ظ†ط§غŒغŒ ط¯ع©ظ…ظ‡ غŒ âڑ“ï¸ڈ Helpï¸ڈ ط±ط§ ط¨ط²ظ†غŒط¯ ًں‘Œًںکƒ
.', 'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
        
        
        
    }
    else if ($text =="ًں—£ Send To All"  && $chat_id == $admin && $booleans[0]=="false") {
          apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط®ظˆط¯ ط±ط§ ط§ط±ط³ط§ظ„ ع©ظ†غŒط¯ ." ,"parse_mode" =>"HTML"));
      $boolean = file_get_contents('booleans.txt');
		  $booleans= explode("\n",$boolean);
	  	$addd = file_get_contents('banlist.txt');
	  	$addd = "true";
    	file_put_contents('booleans.txt',$addd);
    	
    }
      else if ($chat_id == $admin && $booleans[0] == "true") {
    $texttoall =$text;
		$ttxtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$ttxtt);
		for($y=0;$y<count($membersidd);$y++){
			apiRequest("sendMessage", array('chat_id' => $membersidd[$y], "text" => $texttoall,"parse_mode" =>"HTML"));
		}
		$memcout = count($membersidd)-1;
	 	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں“¦ ظ¾غŒط§ظ… ط´ظ…ط§ ط¨ظ‡  ".$memcout." ظ…ط®ط§ط·ط¨ ط§ط²ط³ط§ظ„ ط´ط¯.
.","parse_mode" =>"HTML",'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
         $addd = "false";
    	file_put_contents('booleans.txt',$addd); 
    }else if($text == "ًں‘¥ Members" && $chat_id == $admin ){
		$txtt = file_get_contents('pmembers.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
		 apiRequestJson("sendMessage", array('chat_id' => $chat_id,"parse_mode" =>"HTML", "text" => "âœ… طھط¹ط¯ط§ط¯ ع©ظ„ ظ…ط®ط§ط·ط¨ط§ظ† : ".$mmemcount,'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
		
		
	}else if($text == "â‌Œ Blocked Users" && $chat_id == $admin ){
		$txtt = file_get_contents('banlist.txt');
		$membersidd= explode("\n",$txtt);
		$mmemcount = count($membersidd) -1;
		 apiRequestJson("sendMessage", array('chat_id' => $chat_id,"parse_mode" =>"HTML", "text" => "ًںڑ« طھط¹ط¯ط§ط¯ ع©ظ„ ط§ظپط±ط§ط¯غŒ ع©ظ‡ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ط¯ط§ط±ظ†ط¯ : ".$mmemcount,'reply_markup' => array(
        'keyboard' => array(array('ًں—£ Send To All'),array('âڑ“ï¸ڈ Help','ًں‘¥ Members','â‌Œ Blocked Users'),array("Settings âڑ™")),
        'one_time_keyboard' => true,
        'selective' => true,
        'resize_keyboard' => true)));
		
		
	}
    else if($rpto != "" && $chat_id == $admin){
    	if($text != "/ban" && $text != "/unban")
    	{
	apiRequest("sendMessage", array('chat_id' => $rpto, "text" => $text ,"parse_mode" =>"HTML"));
	apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "ًں—£ظ¾غŒط§ظ… ط´ظ…ط§ ط§ط±ط³ط§ظ„ ط´ط¯. " ,"parse_mode" =>"HTML"));
    	}
    	else
    	{
    		if($text == "/ban"){
    	$txtt = file_get_contents('banlist.txt');
		$banid= explode("\n",$txtt);
	if (!in_array($rpto,$banid)) {
		$addd = file_get_contents('banlist.txt');
		$addd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $addd);
		$addd .= $rpto."
";

    	file_put_contents('banlist.txt',$addd);
    	apiRequest("sendMessage", array('chat_id' => $rpto, "text" => "<b>You Are Bannedًںڑ«,</b>
-----------------
ط´ظ…ط§ ط¯ط± ظ„غŒط³طھ ط³غŒط§ظ‡ ظ‚ط±ط§ط± ع¯ط±ظپطھغŒط¯ًںڑ«." ,"parse_mode" =>"HTML"));
}
		apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Banned
â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–â‍–
ط¨ظ‡ ظ„غŒط³طھ ط³غŒط§ظ‡ ط§ظپط²ظˆط¯ظ‡ ط´ط¯." ,"parse_mode" =>"HTML"));
    		}
    	if($text == "/unban"){
    	$txttt = file_get_contents('banlist.txt');
		$banidd= explode("\n",$txttt);
	if (in_array($rpto,$banidd)) {
		$adddd = file_get_contents('banlist.txt');
		$adddd = str_replace($rpto,"",$adddd);
		$adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);
    $adddd .="
";


		$banid= explode("\n",$adddd);
    if($banid[1]=="")
      $adddd = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $adddd);

    	file_put_contents('banlist.txt',$adddd);
}
		apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "UnBanned
------------------
ط§ط² ظ„غŒط³طھ ط³غŒط§ظ‡ ظ¾ط§ع© ط´ط¯." ,"parse_mode" =>"HTML"));
		apiRequest("sendMessage", array('chat_id' => $rpto, "text" => "<b>You Have Been UnBannedâڑ™,</b>
-----------------
ط´ظ…ط§ ط§ط² ظ„غŒط³طھ ط³غŒط§ظ‡ ظ¾ط§ع© ط´ط¯غŒط¯ âڑ™." ,"parse_mode" =>"HTML"));
    		}
    	}
	}
  } else {
    
  }
}


define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  exit;
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"]);
}
