

<pre><?php print_r(new TinkoffApi()); ?></pre>

<?php 

/**
 * 
 */
class TinkoffApi {
	
	function __construct() {
		$this->api_url = 'https://business.tinkoff.ru/openapi/sandbox/api/v1/';
		$this->token = 'TinkoffOpenApiSandboxSecretToken';
		$this->company = $this->restApiRequest($this->api_url.'company/');
		$this->accounts = $this->restApiRequest($this->api_url.'bank-accounts/');
		foreach ($this->accounts as $key => $value) {
			$this->statements[] = $this->statement($key);
		}
	}

	function statement ($key) {
		$q_str = http_build_query([
			'accountNumber' => $this->accounts[$key]['accountNumber'],
		]);
		return $this->restApiRequest($this->api_url.'bank-statement/?'.$q_str);
		$q_str = http_build_query([
			'accountNumber' => $this->accounts[$key]['accountNumber'],
			'from' => '2023-06-01T00:00:00Z',
		]);
		return $this->restApiRequest($this->api_url.'statement/?'.$q_str);
	}

	function restApiRequest ($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
			'Accept: application/json',
			'Authorization: Bearer '.$this->token,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp, true);
	}


}

?>