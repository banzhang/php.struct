
<?php

 $RTMurl = $_POST["url"]; //Get the RTM server url to post the xml.
 $RTM_farm = $_POST["farm"]; //Get the Farm. ex:dm14
 $RTM_username = $_POST["username"]; //Get the DM login name
 $RTM_password = $_POST["password"]; //Get the DM login password
 $rtm_body = $_POST["rtm_body"]; //Get the XML details to be posted to the RTM server

 $rtm_body = str_replace('\"','"',$rtm_body); //Replace all the special character " to \" in the string to avoid the errors.

 
 //echo $rtm_sub; //Output the subject line

 //The test XML string to post to RTM server

//construct the authority Http header to RTM 
 
 $headers = array(  
            "Content-type: text/xml;charset=\"utf-8\"", 
            "Accept: text/xml", 
            "Content-length: ".strlen($rtm_body),
			"ServerName:".$RTM_farm,
			"UserName:".$RTM_username,
			"Password:".$RTM_password		
        ); 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$RTMurl); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 

// Apply the XML to our curl call 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $rtm_body); 

$data = curl_exec($ch); 

if (curl_errno($ch)) { 
	print "Error: " . curl_error($ch); 
} else { 
	// Show me the result 	
	var_dump($data); 
	curl_close($ch); 
} 
 

?>