<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	if ( ! function_exists('sendWAMessage'))
	{
		function sendWAMessage($phone,$body)
		{
			$tokenwa = "674zbuhplpkkhyro";
			
			$data = array(
				'phone' => $phone,
				'body' => $body
			);
			
			$payload = json_encode($data);
			
			// Prepare new cURL resource
			$ch = curl_init("https://eu61.chat-api.com/instance75884/sendMessage?token=".$tokenwa);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			
			// Set HTTP Header for POST request
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($payload))
			);
			
			$result = curl_exec($ch);
			
			curl_close($ch);
			$hasil= json_decode($result, false);
			
			return $hasil->sent;
		}
		
	}
 
 
?>