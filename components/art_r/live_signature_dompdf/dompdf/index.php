<?
//подключаем автозагрузчик
include_once 'autoload.inc.php';

use Dompdf\Dompdf;
//создаемэкземпляр класса
$d=new Dompdf();
//создаем переменную
$html='<table border="1">
<tbody>
<tr>
<td><strong>Услуги</strong></td>
<td><strong>Цены</strong></td>
</tr>
<tr>
<td>Создание сайта-визитки</td>
<td>от 2&nbsp;499 UAH, от 5 999 RUR (сайт-одностраничник)</td>
</tr>
<tr>
<td>Создание простого сайта</td>
<td>от 3&nbsp;499 UAH, от 7&nbsp;999 RUR<br>(наполнение до 10 страниц без оплаты)</td>
</tr>
<tr>
<td>Создание интернет-магазина</td>
<td>от 5&nbsp;499 UAH, от 11&nbsp;999 RUR<br>(наполнение до 50 товаров – без оплаты)</td>
</tr>
<tr>
<td>Дополнительные услуги</td>
<td>по&nbsp;согласованию с заказчиком</td>
</tr>
<tr>
<td>Продление доменного имени и хостинга</td>
<td>599 RUR+цена хостинга+цена домена</td>
</tr>
<tr>
<td>Написание уникальных статей<br>(не входящих в пакет услуг создания&nbsp;сайта)</td>
<td>от 29&nbsp;UAH, 69 RUR / 1000 символов без пробелов</td>
</tr>
<tr>
<td>Поддержка сайта первые 14 дней</td>
<td>без оплаты</td>
</tr>
<tr>
<td>Поддержка сайта после&nbsp;14 дней</td>
<td>749 UAH, 1599 RUR / 30&nbsp;дней<br>(если производились действия)</td>
</tr>
<tr>
<td><span style="text-decoration: underline;">Минимальная</span> стоимость хостинга</td>
<td>329&nbsp;UAH, 719 RUR /&nbsp;365 дней<br>[расположение: RU, DE, UA]</td>
</tr>
<tr>
<td><span style="text-decoration: underline;">Минимальная</span> стоимость доменного имени</td>
<td>169&nbsp;UAH, 399 RUR /&nbsp;365 дней</td>
</tr>
<tr>
<td>Подбор доменного имени</td>
<td>даром</td>
</tr>
</tbody>
</table>';

//обрабатываем данные с помощью библиотеки DOMPDF
$d->loadHtml($html);
//устанавливаем ориентацию листа portrait || landscape
$d->setPaper('A4','portrait');
//отображаем готовый PDF
$d->render();
//записываем PDF в файл
file_put_contents(getenv('DOCUMENT_ROOT')."/test.pdf", $d->output());

//можно отправить ответ после AJAX Запроса с ссылкой на файл
//echo '<div onclick="window.open(\''."/pdf/{$name}".'\')"><i class="oi-cloud-download"></i> Скачать файл</div>';