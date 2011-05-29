<?php
require "class.php-prowl.php";

$prowl = new Prowl();
$prowl->setApiKey("3d6d41d6a5fb531a51ed40b3f3342deb97b6e86d");

$application = "Example Application";
$event = "My Custom Event";
$text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam luctus dolor, placerat pharetra est tincidunt eget.";
$url = "http://google.com/";
$priority = -1;

$message = $prowl->push($application, $event, $text, $url, $priority);

echo var_dump($message);
?>