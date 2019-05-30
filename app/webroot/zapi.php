<?php
	define("ZDAPIKEY", "hkO9V4UK78ITOYfH74Z8hSv7WlPWF7NQw5j1FB3n");
	define("ZDUSER", "soporteestadio@cdf.cl");
	define("ZDURL", "https://estadiocdf.zendesk.com/api/v2");
	/* Note: do not put a trailing slash at the end of v2 */
	function curlWrap($url, $json, $action)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_URL, ZDURL.$url);
		curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
		switch($action){
			case "POST":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				break;
			case "GET":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				break;
			case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				break;
			case "DELETE":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
			default:
				break;
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		$decoded = json_decode($output);
		return $decoded;
	}
	$data = curlWrap("/search.json?query=status<solved", null, "GET");
	print_r($data->count);
?>
<?php 
	/*$parametros = $_REQUEST;
	if(!empty($parametros)){
		curl
	}
	print_r($parametros["algo"]);*/
?>