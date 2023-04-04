<?
//подключаем автозагрузчик
include_once 'autoload.inc.php';

use Dompdf\Dompdf;
//создаемэкземпляр класса
$d=new Dompdf();
//обрабатываем данные с помощью библиотеки DOMPDF
$d->loadHtml($html);
//устанавливаем ориентацию листа portrait || landscape
$d->setPaper('A4','portrait');
//отображаем готовый PDF
$d->render();
//записываем PDF в файл
file_put_contents(__DIR__."/report.pdf", $d->output());

//можно отправить ответ после AJAX Запроса с ссылкой на файл
//echo '<div onclick="window.open(\''."/pdf/{$name}".'\')"><i class="oi-cloud-download"></i> Скачать файл</div>';