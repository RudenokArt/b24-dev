<?php 

namespace Bitrix\Docbrown;
/**
 * 
 */
class TinkoffApi {
	
	function __construct($last_time) {
		$this->last_time = $last_time;
		$this->api_url = 'https://business.tinkoff.ru/openapi/api/v1/';
		// $this->token = 't.jKSRfYE-LT4zg1HE0fIedUtoZkphW5OTAzCQDOImEXF2sKpoyr5ckWipW3ZTFDvoR3rGGRmRL-tJLadgR11LPw';
		$this->token = 't.-Rc7QpMtFYtdxN7644SJGXTkflw33WFKgsoHtweRhRcn4JBso1MUVnz9kjuXWBK5QbIKJuVE5-Kus3998ezPlA';
		$this->company = $this->restApiRequest($this->api_url.'company/');
		$this->accounts = $this->restApiRequest($this->api_url.'bank-accounts/');
		foreach ($this->accounts as $key => $value) {
			$this->statements[] = $this->statement($key);
		}
	}

	function statement ($key) {
		$q_str = http_build_query([
			'accountNumber' => $this->accounts[$key]['accountNumber'],
			'from' => $this->last_time,
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