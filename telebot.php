<?php
	include("Telegram.php");
	$bot_id = "botid";
	$yandtrankey = "yandtrankey";
	$openwethid = "openwethid";
	$telegram = new Telegram($bot_id);
	$text = $telegram->Text();
	$chat_id = $telegram->ChatID();
	$userna = $telegram->Username();
	$userid = $telegram->UserID();
	$randproc = rand(1, 100);
	
	// Просто старт
    if ($text == "/start") {
        $reply = "Working";
        $content = array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => '');
        $telegram->sendMessage($content);
	}
	// Помощь
	if ($text == "/help" OR $text == "/help@Turn_Bot") {
        $reply = " /help - список команд
		/bash - шуткануть с баша
		/cur - погрустить с курсом
		/news - 5 свежих новостей с медузы
		/tr - яндекс.переводчик. Жми команду для помощи.
		/we - погода. Жми команду для помощи.
		/advice - спросить совета (кд 1 мин)
		/cat - котик
		/romi - аналог @mi в RO
		/roii - аналог @ii в RO";
        $content = array('chat_id' => $chat_id, 'text' => $reply);
        $telegram->sendMessage($content);
	}
	// debug2
	//if ($text == "/debug" OR $text == "/debug@Turn_Bot") {
	//	$reply = $chat_id;
	//	$content = array('chat_id' => $chat_id, 'text' => $reply);
	//	$telegram->sendMessage($content);
	//}
	// Шутки с баша
	if ($text == "/bash" OR $text == "/bash@Turn_Bot") {
		$html = file_get_contents('http://bash.im/forweb/?u');
		$sim = array("document.write(borq);", "var borq='';", "borq +=", "&quot;", "<' + 'br>");
		$rep = array("", "", "", "'", "\n");
		$html =  explode(' ]', substr(strip_tags(str_replace($sim, $rep, $html), '\n'),4,-30));
        $content = array('chat_id' => $chat_id, 'text' => html_entity_decode($html[1]));
        $telegram->sendMessage($content);
	}
	//Курс валюты
	if ($text == "/cur" OR $text == "/cur@Turn_Bot") {
		$cur = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?");
		$usd = $cur->Valute[10]->Name ." ". $cur->Valute[10]->Value;
		$eur = $cur->Valute[11]->Name ." ". $cur->Valute[11]->Value;
		$pln = $cur->Valute[19]->Name ." ". $cur->Valute[19]->Value;
        $reply = $usd."\n".$eur."\n".$pln;
        $content = array('chat_id' => $chat_id, 'text' => $reply);
        $telegram->sendMessage($content);
	}
	//Новости
	if ($text == "/news" OR $text == "/news@Turn_Bot") {
		$rss = simplexml_load_file("https://meduza.io/rss/all");
		$rss0title = $rss->channel->item[0]->title;
		$rss0link = $rss->channel->item[0]->link;
		$rss0 = "1) [".trim($rss0title)."](".$rss0link.")\n";
		$rss1title = $rss->channel->item[1]->title;
		$rss1link = $rss->channel->item[1]->link;
		$rss1 = "2) [".trim($rss1title)."](".$rss1link.")\n";
		$rss2title = $rss->channel->item[2]->title;
		$rss2link = $rss->channel->item[2]->link;
		$rss2 = "3) [".trim($rss2title)."](".$rss2link.")\n";
		$rss3title = $rss->channel->item[3]->title;
		$rss3link = $rss->channel->item[3]->link;
		$rss3 = "4) [".trim($rss3title)."](".$rss3link.")\n";
		$rss4title = $rss->channel->item[4]->title;
		$rss4link = $rss->channel->item[4]->link;
		$rss4 = "5) [".trim($rss4title)."](".$rss4link.")\n";
        $reply = $rss0.$rss1.$rss2.$rss3.$rss4;
        $content = array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'Markdown', 'disable_web_page_preview' => 'true');
        $telegram->sendMessage($content);
	}
	//Гитлер и все, что к нему относится
	$texthitlers = mb_strtolower($text, 'utf-8');
	$findhitlers = array("гитлер", "рейх", "зига", "hitler", "1488", "рейх", "жечь евреев", "жги евреев", "холокост");
	foreach($findhitlers as $v){
		if(mb_stripos($texthitlers,$v) !== false){
			$findhitler = true;
			break;
		}
	}
	if ($findhitler === true) {
		$hitrand = rand(1,11);
		if($hitrand == 1) {
			$reply = "На всякий случай зиганул";
			$content = array('chat_id' => $chat_id, 'stiker' => "CAADAgADTAIAAiHtuwM0w5oWdrwUsAI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 2) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADPgIAAiHtuwPNMjQkRQEERwI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 3) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADMgIAAiHtuwO7d0YhJHL79AI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 4) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgAD1wMAAiHtuwOg8Q_qBaHrbAI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 5) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgAD5wMAAiHtuwN2AAFEAsKmcN4C");
			$telegram->sendSticker($content);
		}
		if($hitrand == 6) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADRAIAAiHtuwM4RQnJhcQXrwI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 7) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADBAADsAADcKvVBCcMLL-Z2FfrAg");
			$telegram->sendSticker($content);
		}
		if($hitrand == 8) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADLAIAAiHtuwPRAt2H7R4JbQI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 9) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADMAIAAiHtuwOdxr-cmmlPLwI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 10) {
			$content = array('chat_id' => $chat_id, 'sticker' => "BQADAgADSAIAAiHtuwO8cAJFZVDO6wI");
			$telegram->sendSticker($content);
		}
		if($hitrand == 11) {
			$content = array('chat_id' => $chat_id, 'text' => "хуитлер");
			$telegram->sendMessage($content);
		}
		
	}
	//Переводчик
	$trpos = mb_stripos($text,"/tr");
	if ($trpos !== false) {
		$pos1 = mb_stripos($text, ' ');
		$pos2 = mb_stripos($text, ' ', 4);
		$pos3 = $pos2 - $pos1;
		$lang = mb_strimwidth($text,$pos1+1, $pos3-1);
		$str = mb_substr($text, $pos2+1);
		
		$url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$yandtrankey."&text=".$str."&lang=".$lang;
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$qwe = json_decode($result);
		$reply = $qwe->text;
        $content = array('chat_id' => $chat_id, 'text' => $reply[0]);
        $telegram->sendMessage($content);
	}
	// Хелп по переводчику
	if ($text == "/tr" OR $text == "/tr@Turn_Bot"){
		$reply = "Помощь по переводчику.
		/tr [язык] [текст]
		Язык на вотороый хотим перевести, исходный определяется автоматически.
		Пример - /tr ru hello
		[Список языков](https://tech.yandex.ru/translate/doc/dg/concepts/api-overview-docpage/)";
        $content = array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'Markdown', 'disable_web_page_preview' => 'true');
        $telegram->sendMessage($content);
	}
	// Совуеты
	if ($text == "/advice" OR $text == "/advice@Turn_Bot"){
		if ($telegram->messageFromGroup()) {
			$file = 'advicetiming.txt';
			// Открываем файл для получения существующего содержимого
			$d = file_get_contents($file);
			// Пишем содержимое обратно в файл
			$now = time();
			if ($d + 60 < $now){
				$url = "http://fucking-great-advice.ru/api/random";
				//  Initiate curl
				$ch = curl_init();
				// Disable SSL verification
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
				//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// Will return the response, if false it print the response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// Set the url
				curl_setopt($ch, CURLOPT_URL,$url);
				// Execute
				$result=curl_exec($ch);
				// Closing
				curl_close($ch);
				$qwe = json_decode($result);
				$reply = $qwe->text;
				$content = array('chat_id' => $chat_id, 'text' => html_entity_decode($reply));
				$telegram->sendMessage($content);
				file_put_contents($file, $now);
			}
		}
		else {
			$url = "http://fucking-great-advice.ru/api/random";
			//  Initiate curl
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			$qwe = json_decode($result);
			$reply = $qwe->text;
			$content = array('chat_id' => $chat_id, 'text' => html_entity_decode($reply));
			$telegram->sendMessage($content);
		}
		
	}
	//Котик
	if ($text == "/cat" OR $text == "/cat@Turn_Bot"){
		$rss = simplexml_load_file("http://thecatapi.com/api/images/get?format=xml");
		$rssimg = $rss->data->images->image->url;		
		if(get_headers($rssimg) !== false){
			$reply = $rssimg;
		}
		if(get_headers($rssimg) == false){
			$reply = "Котик сдох. Попробуй еще раз.";
		}
		$content = array('chat_id' => $chat_id, 'text' => $reply);
        $telegram->sendMessage($content);
	}
	// Сиськи
	$textboobs = mb_strtolower($text, 'utf-8');
	$findboobs = array("сиськи", "сисек", "сисечки", "сисяндры", "сисюли", "/boobs", "/boobs@Turn_Bot", "🤔");
	foreach($findboobs as $v){
		if(mb_stripos($textboobs,$v) !== false){
			$findboob = true;
			break;
		}
	}
	if($findboob === true){ 
		if ($telegram->messageFromGroup()) {
			$weekday = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));
			if($weekday == 5){
				if ($userid == "25726868500000" && $randproc > 59){
					$file = 'boobstiming.txt';
					// Открываем файл для получения существующего содержимого
					$d = file_get_contents($file);
					// Пишем содержимое обратно в файл
					$now = time();
					if ($d + 60 < $now){
						$url = "http://api.oboobs.ru/boobs/1/1/random/";
						//  Initiate curl
						$ch = curl_init();
						// Disable SSL verification
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
						//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						// Set the url
						curl_setopt($ch, CURLOPT_URL,$url);
						// Execute
						$result=curl_exec($ch);
						// Closing
						curl_close($ch);
						$qwe = json_decode($result);
						$qwe2 = $qwe[0]->preview;
						$reply = "http://media.oboobs.ru/".$qwe2;
						
						$content = array('chat_id' => $chat_id, 'photo' => $reply);
						$telegram->sendPhoto($content);
						file_put_contents($file, $now);
					}
				}
				elseif ($userid == "25726868500000" && $randproc > 29 && $randproc < 60){
					$reply = "Алина, сиди работай!";						
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);			
				}
				elseif ($userid == "25726868500000" && $randproc < 30){
					$reply = "фиг тебе, а не сиськи";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
				}
				else {
					$file = 'boobstiming.txt';
					// Открываем файл для получения существующего содержимого
					$d = file_get_contents($file);
					// Пишем содержимое обратно в файл
					$now = time();
					if ($d + 60 < $now){
						$url = "http://api.oboobs.ru/boobs/1/1/random/";
						//  Initiate curl
						$ch = curl_init();
						// Disable SSL verification
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
						//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						// Set the url
						curl_setopt($ch, CURLOPT_URL,$url);
						// Execute
						$result=curl_exec($ch);
						// Closing
						curl_close($ch);
						$qwe = json_decode($result);
						$qwe2 = $qwe[0]->preview;
						$reply = "http://media.oboobs.ru/".$qwe2;
						
						$content = array('chat_id' => $chat_id, 'photo' => $reply);
						$telegram->sendPhoto($content);
						file_put_contents($file, $now);
					}
				}
			}
		}
		else {
			$url = "http://api.oboobs.ru/boobs/1/1/random/";
			//  Initiate curl
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			$qwe = json_decode($result);
			$qwe2 = $qwe[0]->preview;
			$reply = "http://media.oboobs.ru/".$qwe2;
			
			$content = array('chat_id' => $chat_id, 'photo' => $reply);
			$telegram->sendPhoto($content);
		}		
	}
	// Жопки
	$textbutts = mb_strtolower($text, 'utf-8');
	$findbutts = array("жопа", "попа", "попка", "жопка", "жопо");
	foreach($findbutts as $v){
		if(mb_stripos($textbutts,$v) !== false){
			$findbutts = true;
			break;
		}
	}
	if($findbutts === true){ 
		$weekday = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));
		if ($telegram->messageFromGroup()) {			
			if($weekday == 5){
				if ($userid == "25726868500000" && $randproc > 59){
					$file = 'assstiming.txt';
					// Открываем файл для получения существующего содержимого
					$d = file_get_contents($file);
					// Пишем содержимое обратно в файл
					$now = time();
					if ($d + 60 < $now){
						$url = "http://api.obutts.ru/butts/1/1/random/";
						//  Initiate curl
						$ch = curl_init();
						// Disable SSL verification
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
						//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						// Set the url
						curl_setopt($ch, CURLOPT_URL,$url);
						// Execute
						$result=curl_exec($ch);
						// Closing
						curl_close($ch);
						$qwe = json_decode($result);
						$qwe2 = $qwe[0]->preview;
						$reply = "http://media.obutts.ru/".$qwe2;
						
						$content = array('chat_id' => $chat_id, 'photo' => $reply);
						$telegram->sendPhoto($content);
						file_put_contents($file, $now);
					}
				}
				elseif ($userid == "25726868500000" && $randproc > 29 && $randproc < 60){
					$reply = "Алина, сиди работай!";						
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);			
				}
				elseif ($userid == "25726868500000" && $randproc < 30){
					$reply = "фиг тебе, а не жопки";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
				}
				else {
					$file = 'assstiming.txt';
					// Открываем файл для получения существующего содержимого
					$d = file_get_contents($file);
					// Пишем содержимое обратно в файл
					$now = time();
					if ($d + 60 < $now){
						$url = "http://api.obutts.ru/butts/1/1/random/";
						//  Initiate curl
						$ch = curl_init();
						// Disable SSL verification
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
						//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						// Set the url
						curl_setopt($ch, CURLOPT_URL,$url);
						// Execute
						$result=curl_exec($ch);
						// Closing
						curl_close($ch);
						$qwe = json_decode($result);
						$qwe2 = $qwe[0]->preview;
						$reply = "http://media.obutts.ru/".$qwe2;
						
						$content = array('chat_id' => $chat_id, 'photo' => $reply);
						$telegram->sendPhoto($content);
						file_put_contents($file, $now);
					}
				}
			}
		}
		else {
			$url = "http://api.obutts.ru/butts/1/1/random/";
			//  Initiate curl
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			$qwe = json_decode($result);
			$qwe2 = $qwe[0]->preview;
			$reply = "http://media.obutts.ru/".$qwe2;
			
			$content = array('chat_id' => $chat_id, 'photo' => $reply);
			$telegram->sendPhoto($content);
		}
		
	}
	
	//Погода
	$wepos = mb_stripos($text,"/we ");
	if ($wepos !== false) {
		$city = mb_strimwidth($text,4, 500);
		
		$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&lang=ru&units=metric&APPID=".$openwethid;
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$qwe = json_decode($result);
	$temp = $qwe->main->temp;
	$pressurehpa = $qwe->main->pressure;
	$pressure = $pressurehpa * 0.750064;
	$humidity = $qwe->main->humidity;
	$description = $qwe->weather[0]->description;
	$reply = $description."\n";
	$reply .= "Температура: ".$temp."°C\n";
	$reply .= "Давление: ".$pressure."рт/ст\n";
	$reply .= "Влажность: ".$humidity."%\n";
	$content = array('chat_id' => $chat_id, 'text' => $reply);
	$telegram->sendMessage($content);
	}
	// Хелп по погоде
	if ($text == "/we" OR $text == "/we@Turn_Bot"){
		$reply = "Для тех, кому лень идти до окна. 
		/we [город]
		Пример - /we Калининград";
		$content = array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'Markdown', 'disable_web_page_preview' => 'true');
		$telegram->sendMessage($content);
	}
	
	//ragnarok online monster info
	$romipos = mb_stripos($text,"/romi ");
	if ($romipos !== false) {
		$romonster = mb_strimwidth($text,6, 500);
		$reply = "Ты хотел инфу по монстру ". $romonster ." Увы, я только учусь. Попробуй через пару дней/недель/месяцев.";
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
	}
	//ragnarok online item info
	$romipos = mb_stripos($text,"/roii ");
	if ($romipos !== false) {
		$romonster = mb_strimwidth($text,6, 500);
		$reply = "Ты хотел инфу по вещи ". $romonster ." Увы, я только учусь. Попробуй через пару дней/недель/месяцев.";
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
	}
		
	//Albion Online Server Status
	if ($text == "/ao_status" OR $text == "/ao_status@Turn_Bot"){
		$url = "http://live.albiononline.com/status.txt";
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json")); 
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$qwe = json_decode($result);
		$temp = $qwe["status"];
		$temp2 = print_r($qwe);
		$content = array('chat_id' => $chat_id, 'text' => $result);
		$telegram->sendMessage($content);
	}
?>					