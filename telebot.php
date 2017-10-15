<?php
include("Telegram.php");

$app = new turnBot(array(
        'bot_id' => '',
        'yandex_translate_key' => '',
        'open_wheather_key' => ''
    )
);

class turnBot {
    private $find_types   = array(
        'hitler' => array("гитлер","рейх","зига","hitler","1488","рейх","жечь евреев","жги евреев","холокост"),
        'boobs'  => array("сиськи","сисек","сисечки","сисяндры","сисюли","/boobs","/boobs@Turn_Bot"),
        'butts'  => array("жопа","попа","попка","жопка","жопо","жопунька","кардан","кардашьян","седло"),
        'cats'   => array("кот","котейка","котюня","шерстяной","киса","кошко","котэ"),
        'meme'   => array("мемас","баянчег","боян","баянист")
    );
    private $hitlers = array(
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
    private $s_timer      = 10;
    private $s_timers     = array('boobs' => 0, 'butts' => 0, 'cats' => 0, 'meme' => 0);
    private $telegram, $bot_id, $yandtrankey, $openwethid, $chat_id, $text, $mb_text;
    
    function __construct($opts)
    {
        $this->telegram    = new Telegram($opts['bot_id']);
        $this->text        = $this->telegram->Text();
        $this->mb_text     = mb_strtolower($this->text, 'utf-8');
        $this->chat_id     = $this->telegram->ChatID();
        $this->yandtrankey = $opts['yandex_translate_key'];
        $this->openwethid  = $opts['open_wheather_key'];
        $this->s_timers    = file_exists("timers.txt") ? json_decode(file_get_contents("timers.txt")) : (object)$this->s_timers;
        $this->proceedText();
    }
    
    function _checkTimer($type)
    {
        if($this->s_timers->$type + $this->s_timer < time())
        {
            $this->s_timers->$type = time();
            file_put_contents("timers.txt", json_encode($this->s_timers));
            return true;
        }
        return false;
    }
    
    function _checkArr($type)
    {
        $check = array_filter($this->find_types[$type], array($this, '_arrFilter'));
        return count($check) > 0;
    }

    function _arrFilter($k)
    {
        return mb_stripos($this->mb_text, $k) !== false;
    }
    
    function _sendText($text, $opts = array())
    {
        $content = array(
            'chat_id' => $this->chat_id,
            'text' => $text
        );
        if(count($opts) > 0)
        {
              $content = array_merge($content, $opts);  
        }
        $this->telegram->sendMessage($content);
    }
    
    function _sendPhoto($url)
    {
        $this->telegram->sendPhoto(array(
            'chat_id' => $this->chat_id,
            'photo' => $url
        ));
    }
    
    function _sendSticker($sticker)
    {
        $content = array(
            'chat_id' => $chat_id,
            'sticker' => $sticker
        );
        $this->telegram->sendSticker($content);
    }
    
    function proceedText()
    {
        switch(trim($this->text))
        {
            case "/help":
            case "/help@Turn_Bot":
                return $this->helpMessage();
                break;
            case "/mem":
            case "/meme":
                return $this->memeMessage();
                break;
            case "/bash":
            case "/bash@Turn_Bot":
                return $this->bashMessage();
                break;
            case "/cur":
            case "/cur@Turn_Bot":
                return $this->curMessage();
                break;
            case "/news":
            case "/news@Turn_Bot":
                return $this->newsMessage();
                break;
            case "/tr":
            case "/tr@Turn_Bot":
                return $this->trHelpMessage();
                break;
            case "/advice":
            case "/advice@Turn_Bot":
                return $this->adviceMessage();
                break;
            case "/we":
            case "/we@Turn_Bot":
                return $this->weHelpMessage();
                break;
            default:
                return $this->checkNonStandart();
        }
    }
    
    function checkNonStandart()
    {
        foreach(array('hitler', 'boobs', 'butts', 'cats', 'meme') as $type)
        {
            if($this->_checkArr($type))
                $this->proceedNonStandart($type);
        }
        $arr_text = explode(' ', $this->text);
        if(count($arr_text) < 1)
            return false;
        switch($arr_text[0])
        {
            case "/tr":
                return $this->trMessage($arr_text);
            case "/we":
                return $this->weMessage();
        }
    }
    
    function proceedNonStandart($type)
    {
        switch($type)
        {
            case "hitler":
                return $this->hitlerMessage();
            case "boobs":
                 return $this->boobsMessage();
            case "butts":
                 return $this->buttsMessage();
            case "cats":
                 return $this->catsMessage();
            case "meme":
                return $this->memeMessage();
        }
    }
    
    function trMessage($arr_text)
    {
        $text = urlencode(join(' ', array_slice($arr_text, 2)));
        $url  = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=" . $this->yandtrankey . "&text=" . $text . "&lang=" . $arr_text[1];
        $data = json_decode(file_get_contents($url));
        $this->sendMessage($data->text[0]);
    }
    
    function weMessage()
    {
        $city     = mb_strimwidth($this->text, 4, 500);
        $url      = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=ru&units=metric&APPID=" . $thisa->openwethid;
        $data     = json_decode(file_get_contents($url));
        $pressure = $data->main->pressure * 0.750064;
        $reply    = $data->weather[0]->description . "\n";
        $reply .= "Температура: " . $data->main->temp . "°C\n";
        $reply .= "Давление: " . $pressure . "рт/ст\n";
        $reply .= "Влажность: " . $data->main->humidity . "%\n";
        $this->sendMessage($reply);
    }
    
    function hitlerMessage()
    {
        $this->sendSticker($this->hitlers[rand(0, (count($this->hitlers) - 1))]);
    }
    
    function boobsMessage()
    {
        if(!$this->_checkTimer('boobs'))
            return false;
        $data = json_decode(file_get_contents("http://api.oboobs.ru/boobs/1/1/random/"));
        $this->sendPhoto("http://media.oboobs.ru/" . $data[0]->preview);
    }
    
    function buttsMessage()
    {
        if(!$this->_checkTimer('butts'))
            return false;
        $data = json_decode(file_get_contents("http://api.obutts.ru/butts/1/1/random/"));
        $this->sendPhoto("http://media.obutts.ru/" . $data[0]->preview);
    }
    
    function catsMessage()
    {
        if(!$this->_checkTimer('cats'))
            return false;
        $rss   = simplexml_load_file("http://thecatapi.com/api/images/get?format=xml");
        $reply = (get_headers($rss->data->images->image->url) !== false) ? $rss->data->images->image->url : "Котик сдох. Попробуй еще раз.";
        $this->sendMessage($reply);
    }
    
    function helpMessage()
    {
        $helps = array(
            '/help - список команд',
            '/bash - шуткануть с баша',
            '/cur - погрустить с курсом',
            '/news - 5 свежих новостей с медузы',
            '/tr - яндекс.переводчик. Жми команду для помощи',
            '/we - погода. Жми команду для помощи',
            '/advice - спросить совета',
            '/cat - котик',
            '/mem - мемас'
        );
        $this->sendMessage(join("\n", $helps));
    }
    
    function memeMessage()
    {
        if(!$this->_checkTimer('meme'))
            return false;
        $opts    = array('http' => array('method' => "GET",'header' => "Cookie: beget=begetok;\r\n"));
        $context = stream_context_create($opts);
        $data    = file_get_contents("http://admem.ru/rndm", false, $context);
        preg_match_all("/\<img src=\"\/\/(admem\.ru.+)\" alt.+\>/", $data, $matches);
        $pic = $matches[1][array_rand($matches[1], 1)];
        $this->sendPhoto('http://'.$pic);
    }
    
    function bashMessage()
    {
        $html    = file_get_contents('http://bash.im/forweb/?u');
        $sim     = array("document.write(borq);","var borq='';","borq +=","&quot;","<' + 'br>");
        $rep     = array("","","","'","\n");
        $html    = explode(' ]', substr(strip_tags(str_replace($sim, $rep, $html), '\n'), 4, -30));
        $this->sendMessage(html_entity_decode($html[1]));
    }
    
    function curMessage()
    {
        $cur = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?");
        $usd = $cur->Valute[10]->Name . " " . $cur->Valute[10]->Value;
        $eur = $cur->Valute[11]->Name . " " . $cur->Valute[11]->Value;
        $pln = $cur->Valute[19]->Name . " " . $cur->Valute[19]->Value;
        $this->sendMessage($usd . "\n" . $eur . "\n" . $pln);
    }
    
    function newsMessage()
    {
        $rss    = simplexml_load_file("https://meduza.io/rss/all");
        $result = '';
        for ($i = 0; $i < 6; $i++) {
            $title = $rss->channel->item[$i]->title;
            $link  = $rss->channel->item[$i]->link;
            $result .= $i . ") [" . trim($title) . "](" . $link . ")\n";
        }
        $this->sendMessage($result, array(
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => 'true'
        ));
    }
    
    function trHelpMessage()
    {
        $helps = array(
            'Помощь по переводчику.',
            '/tr [язык] [текст]',
            'Язык на который хотим перевести, исходный определяется автоматически.',
            'Пример - /tr ru hello',
            '[Список языков](https://tech.yandex.ru/translate/doc/dg/concepts/api-overview-docpage/)'
        );
        $this->sendMessage(join("\n", $helps), array(
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => 'true'
        ));
    }
    
    function adviceMessage()
    {
        $data = json_decode(file_get_contents("http://fucking-great-advice.ru/api/random"));
        $this->sendMessage(html_entity_decode($data->text));
    }
    
    function weHelpMessage()
    {
        $helps = array(
            'Для тех, кому лень идти до окна.',
            '/we [город]',
            'Пример - /we Калининград'
        );
        $this->sendMessage(join("\n", $helps), array(
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => 'true'
        ));
    }
}
?>
