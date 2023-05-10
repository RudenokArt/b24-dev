https://oauth.yandex.ru/authorize?response_type=token&client_id=89b8381231c14356af3570dc55e5aab7
токен: y0_AgAAAABHHQGdAAna0QAAAADiYnYyH0pabVJYQMub2aCcx8Q34WY2IVk
Номер компании: 60165900
https://partner.market.yandex.ru/supplier/60165900/onboarding
<hr>
<?php

$data = file_get_contents('https://api.partner.market.yandex.ru/campaigns/y0_AgAAAABHHQGdAAnasQAAAADiYSwAqCIgcXI7QKyExE83ADRMgoIUJN4');
print_r($data);

?>