<?php
ini_set("display_errors", "on");
require "class.php-prowl.php";
define("DEMO_EOL",isset($_SERVER['HTTP_USER_AGENT']) ? "<br />" : "\n");

// Get a token on behalf of a user and then exchange it for an API key
try {
	$prowl = new Prowl();
	$prowl->setDebug(true);
	$prowl->setProviderKey("3e116a8f549ea41964f9dc682007ca2fd8e5a478");

	if (empty($_GET["token"])) {		
		$token = $prowl->request_token();		
		if (!empty($token["token"])) {
			// First stage of auth, get a token and URL
			echo "Request Token: ".$token["token"].DEMO_EOL;
			echo "Request URL: ".$token["url"].DEMO_EOL;
			echo "<h1>Get Authorisation for User</h1>".DEMO_EOL;
			echo "<a href='".$token["url"]."'>".$token["url"]."</a>";
		}
	} elseif ($_GET["token"]) {
		// Second stage of auth, they've returned back to us, so safely
		// get an API key for this user
		$api_key = $prowl->retrieve_apikey($_GET["token"]);
		if ($api_key) {
			$prowl = new Prowl();
			$prowl->setApiKey($api_key);
           	$prowl->setProviderKey("3e116a8f549ea41964f9dc682007ca2fd8e5a478");
			$prowl->setDebug(true);
			
			$application = "Example Application";
			$event = "My Custom Event";
			$description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam luctus dolor, placerat pharetra est tincidunt eget.";
			$url = "http://google.com/";
			$priority = -1;
			
			$message = $prowl->add($application,$event,$priority,$description,$url);
			echo var_dump($message).DEMO_EOL;		
		}
	}
} Catch (Exception $message) {
	echo "Failed: ".$message->getMessage().DEMO_EOL;
}
?>