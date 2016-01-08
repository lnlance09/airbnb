<?php
	class AirBnB {    
		// Define the properties
		public $currency = 'USD';
		public $language = 'en';
		public $country = 'us';
		public $network = 'AT&T';
		public $apiKey = '915pw2pnf4h1aiguhph5gc5b2';
		public $adId = '911EBF1C-7C1D-46D5-A925-2F49ED064C92';
		public $deviceId = 'a382581f36f1635a78f3d688bf0f99d85ec7e21f';

		public function SendRequest($endpoint, $token, $post, $data, $cookies) {
			$headers = array(
						'Host: api.airbnb.com',
						'Accept: application/json',
						'Accept-Language: en-us',
						'Connection: keep-alive',
						'Content-Type: application/json',
						'Proxy-Connection: keep-alive',
						'X-Airbnb-Carrier-Country: '.$this->country,
						'X-Airbnb-Currency: '.$this->currency,
						'X-Airbnb-Locale: '.$this->language,
						'X-Airbnb-Carrier-Name: '.$this->network,
						'X-Airbnb-Network-Type: wifi',
						'X-Airbnb-API-Key: '.$this->apiKey,
						'X-Airbnb-Device-ID: '.$this->deviceId,
						'X-Airbnb-Advertising-ID: '.$this->adId,
						);

			// Add the new custom headers
			if($token) {
				$header = 'X-Airbnb-OAuth-Token: '.$token;
				array_push($headers, $header);
			}

			// Add the query string
			if(!$post && is_array($data)) {
				$endpoint .= '?'.http_build_query($data);
			}

		    $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.airbnb.com/'.$endpoint);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Airbnb/15.50 iPhone/9.2 Type/Phone');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			if($post) {
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			}
				
			if($cookies) {
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');			
			} else {
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
			}
				
			$response = curl_exec($ch);
			$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);	
			
			return array(
						'http' => $http,
						'response' => $response
						);
		}

		public function Authorize($username, $password) {
			$data = array(
						'username' => $username,
						'password' => $password,
						'prevent_account_creation' => TRUE,
						);
			$data = $this->SendRequest('v1/authorize', FALSE, TRUE, $data, FALSE);

			if($data['http'] == 200) {
				$json = @json_decode($data['response'], TRUE);
				return $json['access_token'];
			} else {
				return FALSE;
			}
		}

		public function SearchListings($data, $token) {
			// Send the request
			$data = $this->SendRequest('v2/search_results', $token, FALSE, $data, TRUE);
			return $data['response'];
			// return @json_decode($data['response'], TRUE);
		}

		public function CreateListing($data, $token) {
			// Send the request
			$data = SendRequest('v1/listings/create', $token, TRUE, $data, TRUE);
			return @json_decode($data['response'], TRUE);
		}

		public function UpdateListing($id, $data, $token) {
			// Send the request
			$data = SendRequest('v1/listings/'.$id.'/update', $token, TRUE, $data, TRUE);
			return @json_decode($data['response'], TRUE);
		}

		public function CreateWishlist($name, $private, $token) {
			$data = array(
						'name' => $name,
						'private' => $private,
						);

			// Send the request
			$data = SendRequest('v1/collections/create', $token, TRUE, $data, TRUE);
			return @json_decode($data['response'], TRUE);
		}

		public function GetWishlist($id, $token) {
			// Send the request
			$data = SendRequest('v1/collections/'.$id, $token, FALSE, NULL, TRUE);
			return @json_decode($data['response'], TRUE);
		}

		public function UpdateWishlist($name, $private, $token) {
			$data = array(
						'name' => $name,
						'private' => $private,
						);

			// Send the request
			$data = SendRequest('v1/collections/'.$id.'/update', $token, TRUE, $data, TRUE);
			return @json_decode($data['response'], TRUE);
		}

		public function UserListings($token) {
			$data = array(
						'include_host_standards' => TRUE,
						'include' => 'photography_status',
						'include_unavailable' => TRUE,
						'items_per_page' => 50,
						);

			// Send the request
			$data = SendRequest('v1/users/'.$userId.'/listings', $token, FALSE, $data, TRUE);
			return @json_decode($data['response'], TRUE);
		}
	}
?>