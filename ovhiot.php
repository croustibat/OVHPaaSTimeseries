<?php

/**
 * send/read data from OVH Paas IOT plateform 
 *
 */

class OvhIOT {

	// singleton instance
	private static $_instance = false;
	
	// store cURL resource
	private static $_cURL;

	// OVH url where to put data
	const OVHIOT_URL_PUT = 'https://opentsdb.iot.runabove.io/api/put';

	// OVH url where to read data
	const OVHIOT_URL_QUERY = 'https://opentsdb.iot.runabove.io/api/query';

	private function __construct() 
	{
		self::$_cURL = curl_init();
	}

	/**
	 * instance
	 */
	public static function getInstance() 
	{
		if (self::$_instance === false)
			self::$_instance = new OvhIOT();
		return self::$_instance;
	}

	/**
	 * read datas
	 * @param $data	array 		array of data to send
	 * @param $read_token_id 	token id given by OVH plateform
	 * @param $read_token_key 	token key given by OVH plateform
	 * @return curl result	    
	 */
	public function read(array $data, $read_token_id, $read_token_key)
	{
		curl_setopt(self::$_cURL, CURLOPT_URL, self::OVHIOT_URL_QUERY);
		curl_setopt(self::$_cURL, CURLOPT_USERPWD, $read_token_id.":".$read_token_key);

		return self::doCall(json_encode($data));
	}

	/**
	 * write datas
	 * @param $data	array 		array of data to send
	 * @param $write_token_id 	token id given by OVH plateform
	 * @param $write_token_key 	token key given by OVH plateform
	 * @return curl result	    
	 */
	public function write(array $data, $write_token_id, $write_token_key)
	{
		curl_setopt(self::$_cURL, CURLOPT_URL, self::OVHIOT_URL_PUT);
		curl_setopt(self::$_cURL, CURLOPT_USERPWD, $write_token_id.":".$write_token_key);
		
		return self::doCall(json_encode($data));
	}

	/**
	 * exec curl call
	 * @param $data	string 		json string 
	 * @return curl result
	 */
	private static function doCall($data_string)
	{
		curl_setopt(self::$_cURL, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt(self::$_cURL, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt(self::$_cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt(self::$_cURL, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);

		return curl_exec(self::$_cURL);
	}
}
