<?php 


$url = "https://api.partner.market.yandex.ru/campaigns/60165900/offer-prices/updates";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Authorization: Bearer y0_AgAAAABHHQGdAAna0QAAAADiYnYyH0pabVJYQMub2aCcx8Q34WY2IVk",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "offers": [
    {
      "price": {
        "value": 1010,
        "discountBase": 1120,
        "currencyId": "RUR",
        "vat": 6
      },
      "shopSku": "modular23"
    }
  ]
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);


?>