<?php
include("Telegram.php");
$find_hitlers = array("гитлер","рейх","зига","hitler","1488","рейх","жечь евреев","жги евреев","холокост");
$find_boobs   = array("сиськи","сисек","сисечки","сисяндры","сисюли","/boobs","/boobs@Turn_Bot");
$find_butts   = array("жопа","попа","попка","жопка","жопо","жопунька","кардан","кардашьян","седло");
$find_cats    = array("кот","котейка","котюня","шерстяной","киса","кошко","котэ");
$find_meme    = array("мемас","баянчег","боян","баянист");
$bot_id       = "";
$yandtrankey  = "";
$openwethid   = "";
$telegram     = new Telegram($bot_id);
$text         = $telegram->Text();
$mb_text      = mb_strtolower($text, 'utf-8');
$chat_id      = $telegram->ChatID();

function checkArr($arr) {
    $check = array_filter($arr, function($k) {
        global $mb_text;
        return mb_stripos($mb_text, $k) !== false;
    });
    return count($check) > 0;
}
// Помощь
if ($text == "/help" OR $text == "/help@Turn_Bot") {
    $reply   = " /help - список команд
        /bash - шуткануть с баша
        /cur - погрустить с курсом
        /news - 5 свежих новостей с медузы
        /tr - яндекс.переводчик. Жми команду для помощи.
        /we - погода. Жми команду для помощи.
        /advice - спросить совета (кд 1 мин)
        /cat - котик";
    $content = array(
        'chat_id' => $chat_id,
        'text' => $reply
    );
    $telegram->sendMessage($content);
}
// Месасы
if ($text == "/mem" || $text == "/meme" || checkArr($find_meme) === true) {
    $opts    = array('http' => array('method' => "GET",'header' => "Cookie: beget=begetok;\r\n"));
    $context = stream_context_create($opts);
    $data    = file_get_contents("http://admem.ru/rndm", false, $context);
    preg_match_all("/\<img src=\"\/\/(admem\.ru.+)\" alt.+\>/", $data, $matches);
    $pic = $matches[1][array_rand($matches[1], 1)];
    $telegram->sendPhoto(array(
        'chat_id' => $chat_id,
        'photo' => "http://" . $pic
    ));
}
// Шутки с баша
if ($text == "/bash" OR $text == "/bash@Turn_Bot") {
    $html    = file_get_contents('http://bash.im/forweb/?u');
    $sim     = array("document.write(borq);","var borq='';","borq +=","&quot;","<' + 'br>");
    $rep     = array("","","","'","\n");
    $html    = explode(' ]', substr(strip_tags(str_replace($sim, $rep, $html), '\n'), 4, -30));
    $content = array(
        'chat_id' => $chat_id,
        'text' => html_entity_decode($html[1])
    );
    $telegram->sendMessage($content);
}
//Курс валюты
if ($text == "/cur" OR $text == "/cur@Turn_Bot") {
    $cur = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?");
    $usd = $cur->Valute[10]->Name . " " . $cur->Valute[10]->Value;
    $eur = $cur->Valute[11]->Name . " " . $cur->Valute[11]->Value;
    $pln = $cur->Valute[19]->Name . " " . $cur->Valute[19]->Value;
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $usd . "\n" . $eur . "\n" . $pln
    ));
}
//Новости
if ($text == "/news" OR $text == "/news@Turn_Bot") {
    $rss    = simplexml_load_file("https://meduza.io/rss/all");
    $result = '';
    for ($i = 0; $i < 6; $i++) {
        $title = $rss->channel->item[$i]->title;
        $link  = $rss->channel->item[$i]->link;
        $result .= $i . ") [" . trim($title) . "](" . $link . ")\n";
    }
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $result,
        'parse_mode' => 'Markdown',
        'disable_web_page_preview' => 'true'
    ));
}
//Гитлер и все, что к нему относится
$hitlers = array(
    'CAADAgADTAIAAiHtuwM0w5oWdrwUsAI',
    'BQADAgADPgIAAiHtuwPNMjQkRQEERwI',
    'BQADAgADMgIAAiHtuwO7d0YhJHL79AI',
    'BQADAgAD1wMAAiHtuwOg8Q_qBaHrbAI',
    'BQADAgAD5wMAAiHtuwN2AAFEAsKmcN4C',
    'BQADAgADRAIAAiHtuwM4RQnJhcQXrwI',
    'BQADBAADsAADcKvVBCcMLL-Z2FfrAg',
    'BQADAgADLAIAAiHtuwPRAt2H7R4JbQI',
    'BQADAgADMAIAAiHtuwOdxr-cmmlPLwI',
    'BQADAgADSAIAAiHtuwO8cAJFZVDO6wI',
    'CAADAgADLAIAAiHtuwPRAt2H7R4JbQI',
    'CAADAgADLgIAAiHtuwNdwzbZsxYrtAI',
    'CAADAgADMAIAAiHtuwOdxr-cmmlPLwI',
    'CAADAgADMgIAAiHtuwO7d0YhJHL79AI',
    'CAADAgADNAIAAiHtuwOrFz1Ys75vngI',
    'CAADAgADOAIAAiHtuwMs7mMiyp_LGQI',
    'CAADAgADPgIAAiHtuwPNMjQkRQEERwI',
    'CAADAgADQAIAAiHtuwPJ8ab-ioHcXQI',
    'CAADAgADRAIAAiHtuwM4RQnJhcQXrwI',
    'CAADAgADSAIAAiHtuwO8cAJFZVDO6wI',
    'CAADAgADTgIAAiHtuwPIk696OrWIhgI',
    'CAADAgADxQMAAiHtuwMNjB9tfln8QwI',
    'CAADAgADxwMAAiHtuwMfIaXCl3_ZSQI',
    'CAADAgADyQMAAiHtuwOUVmQX3cuc9wI',
    'CAADAgADzQMAAiHtuwMwC3wxDSKU3QI',
    'CAADAgADzwMAAiHtuwPIImB34jFF6wI',
    'CAADAgAD0wMAAiHtuwMjoZFV2xiQIwI',
    'CAADAgAD2QMAAiHtuwNSSISIiiunBgI',
    'CAADAgAD2wMAAiHtuwMMX7zpS7REfQI',
    'CAADAgAD3QMAAiHtuwPI0dsWzZZDEQI',
    'CAADAgAD3wMAAiHtuwMly8RQMXZLCgI',
    'CAADAgAD4QMAAiHtuwOb2b3uZxbBVgI',
    'CAADAgAD5wMAAiHtuwN2AAFEAsKmcN4C',
    'CAADAgAD6QMAAiHtuwP_7MG90BPVGwI'
);
if (checkArr($find_hitlers) === true) {
    $content = array(
        'chat_id' => $chat_id,
        'sticker' => $hitlers[rand(0, 33)]
    );
    $telegram->sendSticker($content);
}
//Переводчик
$trpos = mb_stripos($text, "/tr");
if ($trpos !== false) {
    $text = explode(' ', $text);
    $lang = $text[1];
    $text = urlencode(join(' ', array_slice($text, 2)));
    $url  = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=" . $yandtrankey . "&text=" . $text . "&lang=" . $lang;
    $data = json_decode(file_get_contents($url));
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $data->text[0]
    ));
}
// Хелп по переводчику
if ($text == "/tr" OR $text == "/tr@Turn_Bot") {
    $reply = "Помощь по переводчику.\n/tr [язык] [текст]\nЯзык на вотороый хотим перевести, исходный определяется автоматически.\n";
    $reply .= "Пример - /tr ru hello\n[Список языков](https://tech.yandex.ru/translate/doc/dg/concepts/api-overview-docpage/)";
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $reply,
        'parse_mode' => 'Markdown',
        'disable_web_page_preview' => 'true'
    ));
}
// Советы
if ($text == "/advice" OR $text == "/advice@Turn_Bot") {
    $data = json_decode(file_get_contents("http://fucking-great-advice.ru/api/random"));
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => html_entity_decode($data->text)
    ));
}
//Котик
if (checkArr($find_cats) === true) {
    $rss   = simplexml_load_file("http://thecatapi.com/api/images/get?format=xml");
    $reply = (get_headers($rss->data->images->image->url) !== false) ? $rss->data->images->image->url : "Котик сдох. Попробуй еще раз.";
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $reply
    ));
}
// Сиськи
if (checkArr($find_boobs) === true) {
    $data = json_decode(file_get_contents("http://api.oboobs.ru/boobs/1/1/random/"));
    $telegram->sendPhoto(array(
        'chat_id' => $chat_id,
        'photo' => "http://media.oboobs.ru/" . $data[0]->preview
    ));
}
// Жопки
if (checkArr($find_butts) === true) {
    $data = json_decode(file_get_contents("http://api.obutts.ru/butts/1/1/random/"));
    $telegram->sendPhoto(array(
        'chat_id' => $chat_id,
        'photo' => "http://media.obutts.ru/" . $data[0]->preview
    ));
}
//Погода
$wepos = mb_stripos($text, "/we ");
if ($wepos !== false) {
    $city     = mb_strimwidth($text, 4, 500);
    $url      = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=ru&units=metric&APPID=" . $openwethid;
    $data     = json_decode(file_get_contents($url));
    $pressure = $data->main->pressure * 0.750064;
    $reply    = $data->weather[0]->description . "\n";
    $reply .= "Температура: " . $data->main->temp . "°C\n";
    $reply .= "Давление: " . $pressure . "рт/ст\n";
    $reply .= "Влажность: " . $data->main->humidity . "%\n";
    $telegram->sendMessage(array(
        'chat_id' => $chat_id,
        'text' => $reply
    ));
}
// Хелп по погоде
if ($text == "/we" OR $text == "/we@Turn_Bot") {
    $reply   = "Для тех, кому лень идти до окна.\n/we [город]\nПример - /we Калининград";
    $content = array(
        'chat_id' => $chat_id,
        'text' => $reply,
        'parse_mode' => 'Markdown',
        'disable_web_page_preview' => 'true'
    );
    $telegram->sendMessage($content);
}
?>
