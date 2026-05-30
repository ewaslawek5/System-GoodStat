<?php

//##### ekran
function ekran($nazwa_tab, $ekran)
{
    global $db;
    
    // PHP 8.4: Rzutujemy $ekran na string, aby unikn¹æ problemów z typem danych w prepare
    $ekran_val = (string)$ekran;
    
    // 1. Sprawdzamy, czy dana rozdzielczoœæ ju¿ istnieje
    // U¿ywamy grawisów wokó³ $nazwa_tab, bo nazwy tabel mog¹ zaczynaæ siê od cyfr (np. 2026_ekran)
    $stmt = $db->prepare("SELECT id, wejscia FROM `$nazwa_tab` WHERE `ekran` = :ekran LIMIT 1");
    $stmt->execute([':ekran' => $ekran_val]);
    $wiersz = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$wiersz) {
        // 2. Dodanie nowej rozdzielczoœci
        // PHP 8.4: Jawne przekazanie parametrów zapobiega b³êdom przy pustych danych
        $stmt = $db->prepare(
            "INSERT INTO `$nazwa_tab` (ekran, wejscia) 
             VALUES (:ekran, 1)"
        );        
        $stmt->execute([':ekran' => $ekran_val]); 
        
    } else {
        // 3. Aktualizacja istniej¹cego wpisu
        // PHP 8.4: Rzutujemy na (int), aby inkrementacja by³a w 100% bezpieczna typologicznie
        $wejscia = (int)($wiersz['wejscia'] ?? 0); 
        $wejscia++;
        $nr_ip_id = $wiersz['id'];
        
        // Wykonujemy UPDATE korzystaj¹c z ID
        $stmt = $db->prepare("UPDATE `$nazwa_tab` SET `wejscia` = :wejscia WHERE `id` = :id LIMIT 1");
        $stmt->execute([
            ':wejscia' => $wejscia,
            ':id'      => $nr_ip_id
        ]);
    }
}

//##### color
function color($nazwa_tab, $color)
{
			global $db;
			
			$stmt = $db->query("SELECT * FROM $nazwa_tab WHERE color='$color' LIMIT 1");
			
			if($stmt->rowCount() == 0){
			
					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, color, wejscia)
						VALUES ('0', '$color', '1')"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli
					
					global $db;
			}else{

					//wykonanie zapytania
					if(@$stmt->execute()){
						
						while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
							$wejscia = $wiersz['wejscia']; $wejscia++;
							$nr_ip_id = $wiersz['id'];
							
							$stmt = $db->prepare("UPDATE $nazwa_tab SET `wejscia` = '$wejscia' WHERE `id` = '".$nr_ip_id."' LIMIT 1;");
							$stmt->execute();	//WYKONANIE ZAPYTANIA	
						}// while
					}//if
					
					global $db;
				}
				
				global $db;
}

//##### przegladarki
function przegladarki($nazwa_tab, $przegladarki)
{
			global $db;
			
			$stmt = $db->query("SELECT * FROM $nazwa_tab WHERE przegladarki='$przegladarki' LIMIT 1");
			
			if($stmt->rowCount() == 0){
			
					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, przegladarki, wejscia)
						VALUES ('0', '$przegladarki', '1')"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli
					
					global $db;
			}else{

					//wykonanie zapytania
					if(@$stmt->execute()){
						
						while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
							$wejscia = $wiersz['wejscia']; $wejscia++;
							$nr_ip_id = $wiersz['id'];
							
							$stmt = $db->prepare("UPDATE $nazwa_tab SET `wejscia` = '$wejscia' WHERE `id` = '".$nr_ip_id."' LIMIT 1;");
							$stmt->execute();	//WYKONANIE ZAPYTANIA	
						}// while
					}//if
					
					global $db;
				}
				
				global $db;
}


//##### jezyk
function jezyk($nazwa_tab, $jezyk_przegladarki)
{
			global $db;
			
			$stmt = $db->query("SELECT * FROM $nazwa_tab WHERE jezyk='$jezyk_przegladarki' LIMIT 1");
			
			if($stmt->rowCount() == 0){
			
					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, jezyk, wejscia)
						VALUES ('0', '$jezyk_przegladarki', '1')"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli
					
					global $db;
			}else{

					//wykonanie zapytania
					if(@$stmt->execute()){
						
						while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
							$wejscia = $wiersz['wejscia']; $wejscia++;
							$nr_ip_id = $wiersz['id'];
							
							$stmt = $db->prepare("UPDATE $nazwa_tab SET `wejscia` = '$wejscia' WHERE `id` = '".$nr_ip_id."' LIMIT 1;");
							$stmt->execute();	//WYKONANIE ZAPYTANIA	
						}// while
					}//if
					
					global $db;
				}
				
				global $db;
}

//##### system
function system_op($nazwa_tab, $system)
{
			global $db;
			
			$stmt = $db->query("SELECT * FROM $nazwa_tab WHERE system='$system' LIMIT 1");
			
			if($stmt->rowCount() == 0){
			
					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, system, wejscia)
						VALUES ('0', '$system', '1')"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli
					
					global $db;
			}else{

					//wykonanie zapytania
					if(@$stmt->execute()){
						
						while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
							$wejscia = $wiersz['wejscia']; $wejscia++;
							$nr_ip_id = $wiersz['id'];
							
							$stmt = $db->prepare("UPDATE $nazwa_tab SET `wejscia` = '$wejscia' WHERE `id` = '".$nr_ip_id."' LIMIT 1;");
							$stmt->execute();	//WYKONANIE ZAPYTANIA	
						}// while
					}//if
					
					global $db;
				}
				
				global $db;
}

//##### goodStatSeo
function goodStatSeo($refer) {

		$refer = str_replace('#', '&', $refer);

		$sr[] = array('interia', 'q', 'Interia.pl');
        $sr[] = array('google', 'q', 'Google');
        $sr[] = array('google', 'as_q', 'Google');
		$sr[] = array('wp', 'q', 'Wirtualna Polska');
		$sr[] = array('yahoo', 'p', 'Yahoo');
		$sr[] = array('onet', 'qt', 'Onet.pl');
		$sr[] = array('bing', 'q', 'Bing.com');
		$sr[] = array('baidu', 'wd', 'Baidu.com');

        $seach = '';

        // parsuj url'a
        $url = parse_url($refer);

        // twórz zmienne z zapytania url'a
        parse_str($url['query']);

        // liczba znanych wyszukiwarek
        $ile = count($sr);

        // zidentyfikuj wyszukiwarke
        for($n=0; $n<$ile; $n++)
		{
                if(@eregi($sr[$n][0], $refer) && isset($$sr[$n][1]))
				{
                        $search = $sr[$n][2];					
                        break;
                }
        }

        // slowa kluczowe
        if(!empty($search)) {
                $srq = $$sr[$n][1];
                $srq = strtolower($srq);
                $sign = array('%22', '%23', '%24', '%25', '%26', '%27', '%2a', '%2b', '%2c', '%5c');
                while(list($keysign, $valuesign) = each($sign)) $srq = str_replace($valuesign, '', $srq);
                $srq = str_replace('+', ' ', $srq);
                $srq = stripslashes($srq);
                $srq = rawurldecode($srq);
                $ret[1] = strtolower($srq);
                $ret[0] = $search;
        }
		global $wyszu, $slowa;
		
		$wyszu = $ret[0]; $wyszu = trim($wyszu);
		$slowa = $ret[1]; $slowa = trim($slowa);
	
        return $ret;
}


//##### slowa
function slowa($nazwa_tab, $slowa, $wyszu, $data_dodania)
{
	global $nazwa_tab, $slowa, $wyszu, $data_dodania;

	//dodanie nowej godziny do tabeli
	$zapytanie = "INSERT INTO $nazwa_tab (id, slowa, wyszu, data)
		VALUES ('0', '$slowa', '$wyszu', '$data_dodania')";		
			if (@mysql_query ($zapytanie)){	}//dodanie nr ip do tabeli
}

//##### roboty
function jakiRobot() 
{
    // PHP 8.x: Korzystamy z globalnych zmiennych zgodnie z Twoj¹ struktur¹
    global $ciaguser, $db;
    
    // Zabezpieczenie przed brakiem indeksu i rzutowanie na string (standard PHP 8)
    $agent = (string)($ciaguser ?? $_SERVER['HTTP_USER_AGENT'] ?? '');
    
    $nazwa_robota = '';

    // Jeœli agent jest pusty, od razu zwracamy pusty wynik lub oznaczamy jako nieznany
    if ($agent === '') {
        return '';
    }

    // U¿ywamy match() lub ulepszonego bloku if z uwzglêdnieniem nowoczesnych botów
    // Kolejnoœæ ma znaczenie - bardziej specyficzne boty powinny byæ wy¿ej
    
    if (preg_match('/(GPTBot|ChatGPT-User|OpenAI)/i', $agent)) {
        $nazwa_robota = 'ChatGPT Bot';
    }
    elseif (preg_match('/(ClaudeBot|Anthropic)/i', $agent)) {
        $nazwa_robota = 'Claude Bot';
    }
    elseif (preg_match('/(Googlebot|Google-InspectionTool|Google)/i', $agent)) {
        $nazwa_robota = 'Googlebot';
    }
    elseif (preg_match('/(Bingbot|BingPreview|Bing)/i', $agent)) {
        $nazwa_robota = 'BingBot';
    }
    elseif (preg_match('/(DuckDuckBot|DuckDuckGo)/i', $agent)) {
        $nazwa_robota = 'DuckDuckGo Bot';
    }
    elseif (preg_match('/(Yandex|YandexBot)/i', $agent)) {
        $nazwa_robota = 'Yandex Bot';
    }
    elseif (preg_match('/Baidu/i', $agent)) {
        $nazwa_robota = 'Baidu Spider';
    }
    elseif (preg_match('/facebookexternalhit|facebook/i', $agent)) {
        $nazwa_robota = 'Facebook External Hit';
    }
    elseif (preg_match('/(AhrefsBot|SemrushBot|DotBot|MJ12bot)/i', $agent)) {
        $nazwa_robota = 'SEO Spider';
    }
    elseif (preg_match('/Applebot/i', $agent)) {
        $nazwa_robota = 'AppleBot';
    }
    elseif (preg_match('/Twitterbot|XBot/i', $agent)) {
        $nazwa_robota = 'X/Twitter Bot';
    }
    elseif (preg_match('/(Soso|Sogou|msnbot)/i', $agent)) {
        $nazwa_robota = 'Inne Wyszukiwarki';
    }
    elseif (preg_match('/WordPress/i', $agent)) {
        $nazwa_robota = 'FeedWordPress Bot';
    }
    elseif (preg_match('/curl/i', $agent)) {
        $nazwa_robota = 'Curl';
    }
    
    return $nazwa_robota;
}
/**/
?>