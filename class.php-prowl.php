<?php
/**
 * php-prowl
 *
 * This class provides a simple mechanism for interacting with the prowlapp.com
 * API service for pushing notifications to iOS devices.
 * @author Scott Wilcox <scott@dor.ky>
 * @version 0.1
 * @package php-prowl
 */
class Prowl
{
	private $api_root = "https://prowl.weks.net/publicapi/add";
	private $user_agent = "php-prowl <http://dor.ky>";
	private $api_key = null;

	public function setApiKey($key)
	{
		$this->api_key = $key;
	}

	public function push($applicaton, $event, $description, $url, $priority)
	{
		// This is our payload for this alert
		$fields = array(
			'application' => $applicaton,
			'event' => $event,
			'description' => $description,
			'url' => $url,
			'priority' => $priority
		);

		// Encode all values in our payload with UTF8
		foreach ($fields as $key => $value)
		{
			$fields[$key] = utf8_encode($value);
		}

		// Push the request out to the API
		$s = curl_init();
		curl_setopt($s, CURLOPT_URL, $this->api_root."?apikey=".$this->api_key);
		curl_setopt($s, CURLOPT_POST, true);
		curl_setopt($s, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($s, CURLOPT_HEADER, false);
		curl_setopt($s, CURLOPT_USERAGENT, $this->user_agent);
		$response_xml = simplexml_load_string(curl_exec($s));
		$response_code = curl_getinfo($s, CURLINFO_HTTP_CODE);
		curl_close($s);
		return $response_xml;
	}
}
?>