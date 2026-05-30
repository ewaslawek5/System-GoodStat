<?php
if(file_exists('../config.php')){
//----------------------------------------------------------------------
	include('../config.php');
	include('../inc/baza_polacz.php');

//----------------------------------------------------------------------

$data_dodania = time();

//##### ZMIENNE SKRYPTU
// PHP 8.4: U¿ywamy operatora null coalescing (??), aby unikn¹æ Warning: Undefined array key
$ekran = $_GET['ekran'] ?? ''; 
$ekran = trim((string)$ekran); // rozdzielczosc
$color = $_GET['color'] ?? ''; 
$color = trim((string)$color); // rozdzielczosc
$przegladarka 			= $_GET['przegladarka']; $przegladarka = trim($przegladarka);
$system 				= $_GET['system']; $system = trim($system);
$jezyk_przegladarki 	= $_GET['jezyk_przegladarki']; $jezyk_przegladarki = trim($jezyk_przegladarki);
$podstrona 				= $_GET['podstrona'];	$podstrona = trim($podstrona);	$podstrona = str_replace("|","&",$_GET['podstrona']);
$idref 					= $_GET['idref'];							//przekliknjêto ze strony
$seo 					= $_GET['seo'];								//strona z historii
$ciaguser 				= $_GET['ciaguser'];						//ciag user agent

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $nr_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    // W przypadku X_FORWARDED_FOR mo¿e pojawiæ siê lista IP po przecinku
    $nr_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    // REMOTE_ADDR jest zawsze ustawione przez serwer, ale dla pewnoœci u¿ywamy operatora ??
    $nr_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'; 
}

if (str_contains($nr_ip, ',')) {
    $nr_ip = explode(',', $nr_ip)[0];
}

$nr_ip = trim((string)$nr_ip);

//##### FUNKCJE
	include('../funkcje/funkcje_zapisu.php');

//##### NR IP
// PHP 8.4: Kluczowe jest dodanie apostrofów wokó³ litery Y
$nazwa_tab = date('Y') . '_nr_ip'; 
$nazwa_tab = trim($nazwa_tab);

// PHP 8.4: U¿ywamy prepared statement i poprawiamy format daty
$dzien_roku = date('z'); // Dodanie apostrofów zapobiega b³êdowi "Undefined constant z"

$stmt = $db->prepare("SELECT * FROM `$nazwa_tab` WHERE `nr_ip` = :ip AND `dzien_roku` = :dzien LIMIT 1");
$stmt->execute([
    ':ip'    => $nr_ip, 
    ':dzien' => $dzien_roku
]);

if ($stmt->rowCount() == 0) {
    // dodanie nowego nr IP do tabeli
    // PHP 8.4: Poprawiamy formaty date i u¿ywamy bindowania parametrów
    $stmt = $db->prepare(
        "INSERT INTO `$nazwa_tab` (nr_ip, dzien_roku, dzien, miesiac, ods, data_utw)
        VALUES (:nr_ip, :dzien_roku, :dzien, :miesiac, '1', :data_utw)"
    );		
    $stmt->execute([
        ':nr_ip'      => $nr_ip,
        ':dzien_roku' => date('z'), // Poprawione: dodano apostrofy
        ':dzien'      => date('j'), // Poprawione: dodano apostrofy
        ':miesiac'    => date('n'), // Poprawione: dodano apostrofy
        ':data_utw'   => time()
    ]);

} else {
    // dodanie o jeden do nr ip
    // Nie wykonujemy ponownie $stmt->execute(), bo dane ju¿ pobraliœmy wczeœniej (fetch)
    // Jeœli w poprzednim kroku (SELECT) nie zrobi³eœ fetch, robimy to tutaj:
    
    // Zak³adamy, ¿e $stmt to wynik zapytania SELECT wykonanego wczeœniej
    while ($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ods = $wiersz['ods']; 
        $ods++;
        
        // U¿ywamy przygotowanego zapytania, aby unikn¹æ b³êdów z cudzys³owami
        $stm = $db->prepare("UPDATE `$nazwa_tab` SET `ods` = :ods, `data_utw` = :now WHERE `nr_ip` = :ip AND `dzien_roku` = :dzien_z LIMIT 1;");
        $stm->execute([
            ':ods'     => $ods,
            ':now'     => time(),
            ':ip'      => $nr_ip,
            ':dzien_z' => date('z') // Poprawione: dodano apostrofy
        ]);
    }
}

//##### ODS£ONY
// PHP 8.4: Dodajemy apostrofy wokó³ litery Y, aby poprawnie odczytaæ format roku
$nazwa_tab = date('Y').'_wiz_ods'; 
$nazwa_tab = trim($nazwa_tab);

// PHP 8.4: Przygotowujemy wartoœci czasu w zmiennych z apostrofami
$godzina_kolumna = date('G') . 'ods'; // np. "14ods"
$dzien_roku_id = date('z');

// U¿ywamy grawisów dla nazw kolumn i tabel, bo mog¹ zaczynaæ siê od cyfr
$stmt = $db->prepare("SELECT id, ods, `$godzina_kolumna` FROM `$nazwa_tab` WHERE `id` = :id LIMIT 1");
$stmt->execute([':id' => $dzien_roku_id]);

// Nie u¿ywamy @$stmt->execute() w if, bo execute() wykonaliœmy wy¿ej
// Sprawdzamy, czy wiersz istnieje
while ($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ods = $wiersz['ods']; 
    $ods++;
    
    // Pobieramy wartoœæ dynamicznej kolumny (np. 14ods)
    $god_ods = $wiersz[$godzina_kolumna]; 
    $god_ods++;
    
    // UPDATE z zachowaniem Twoich nazw zmiennych
    $stm = $db->prepare("UPDATE `$nazwa_tab` SET `ods` = :ods, `$godzina_kolumna` = :god_ods WHERE `id` = :id LIMIT 1;");
    $stm->execute([
        ':ods'     => $ods,
        ':god_ods' => $god_ods,
        ':id'      => $dzien_roku_id
    ]);
}
	

//------------------------------------------------------------ start nowych wizyt ------------------------------------------------------------------------

//##### NUMERY IP dzis
$nazwa_tab = 'nr_ip_dzis'; 
$nazwa_tab = trim((string)$nazwa_tab);

//-- Odczytanie dnia dodania nr ip do tabeli
$stmt = $db->query("SELECT dzien FROM `$nazwa_tab` LIMIT 1");
$dzien_dodania = ''; 

if ($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dzien_dodania = $wiersz['dzien'];
}
	
// Kasowanie danych z tabeli, jeœli zacz¹³ siê nowy dzieñ
if($dzien_dodania !== '' && $dzien_dodania != date('j')){
    $db->query("DELETE FROM `$nazwa_tab`"); 
}
	
// Sprawdzamy czy IP istnieje
$stm = $db->prepare("SELECT wejscia FROM `$nazwa_tab` WHERE `nr_ip` = :nr_ip LIMIT 1");
$stm->execute([':nr_ip' => $nr_ip]);
$wiersz_ip = $stm->fetch(PDO::FETCH_ASSOC);
		
if(!$wiersz_ip){
    // --- START: NOWA WIZYTA (IP NIE ISTNIEJE) ---
    
    // 1. Dodanie nowego nr IP
    $stmt_ins = $db->prepare("INSERT INTO `$nazwa_tab` (nr_ip, wejscia, dzien) VALUES (:nr_ip, '1', :dzien)");		
    $stmt_ins->execute([
        ':nr_ip' => $nr_ip,
        ':dzien' => date('j')
    ]);

    // 2. WIZYTY (Roczne/Godzinowe)
    $nazwa_tab_wiz = date('Y').'_wiz_ods'; 
    $godzina_klucz = date('G').'wiz'; 
    $dzien_id = date('z');

    $stmt_wiz = $db->prepare("SELECT wiz, `$godzina_klucz` FROM `$nazwa_tab_wiz` WHERE id = :id LIMIT 1");
    $stmt_wiz->execute([':id' => $dzien_id]);

    if ($wiersz_wiz = $stmt_wiz->fetch(PDO::FETCH_ASSOC)) {
        $wiz = (int)$wiersz_wiz['wiz'] + 1;
        $god_wiz = (int)$wiersz_wiz[$godzina_klucz] + 1;

        $stm_upd = $db->prepare("UPDATE `$nazwa_tab_wiz` SET `wiz` = :wiz, `$godzina_klucz` = :god_wiz WHERE `id` = :id LIMIT 1");
        $stm_upd->execute([
            ':wiz' => $wiz,
            ':god_wiz' => $god_wiz,
            ':id' => $dzien_id
        ]);
    }
				
    // 3. WIZYTY DNI TYG
    $stmt_dt = $db->prepare("SELECT wejscia FROM dni_tyg WHERE dzien = :dzien LIMIT 1");
    $stmt_dt->execute([':dzien' => date('w')]);
    if ($wiersz_dt = $stmt_dt->fetch(PDO::FETCH_ASSOC)) {
        $wej_dt = (int)$wiersz_dt['wejscia'] + 1;
        $upd_dt = $db->prepare("UPDATE dni_tyg SET `wejscia` = :wej WHERE `dzien` = :dzien LIMIT 1");
        $upd_dt->execute([':wej' => $wej_dt, ':dzien' => date('w')]);
    }
				
    // 4. WIZYTY GODZIN
    $stmt_gh = $db->prepare("SELECT wejscia FROM god WHERE god = :god LIMIT 1");
    $stmt_gh->execute([':god' => date('G')]);
    if ($wiersz_gh = $stmt_gh->fetch(PDO::FETCH_ASSOC)) {
        $wej_gh = (int)$wiersz_gh['wejscia'] + 1;
        $upd_gh = $db->prepare("UPDATE god SET `wejscia` = :wej WHERE `god` = :god LIMIT 1");
        $upd_gh->execute([':wej' => $wej_gh, ':god' => date('G')]);
    }
				
    // 5. WIZYTY TECHNICZNE (Rozpoznawanie danych)
    include("../inc/wizyty_tech.php");
    
    // --- KONIEC: NOWA WIZYTA ---
} else {
    // --- START: POWRÓT (IP JU¯ ISTNIEJE) ---
    $wejscia_ip = (int)$wiersz_ip['wejscia'] + 1;
    $stm_ip_upd = $db->prepare("UPDATE `$nazwa_tab` SET `wejscia` = :wej WHERE `nr_ip` = :nr_ip LIMIT 1");
    $stm_ip_upd->execute([
        ':wej' => $wejscia_ip,
        ':nr_ip' => $nr_ip
    ]);
    // --- KONIEC: POWRÓT ---
}
		 
//------------------------------------------------------------ koniec nowych wizyt ------------------------------------------------------------------------


//##### PODSTRONY
			$nazwa_tab =  'podstrony'; $nazwa_tab = trim($nazwa_tab);
			$stmt = $db->query("SELECT * FROM $nazwa_tab WHERE podstrony='$podstrona' LIMIT 1");
			
			if($stmt->rowCount() == 0){
			
					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, podstrony, wejscia)
						VALUES (0, '".$podstrona."', 1)"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli
			
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

				}
			
//##### HISTORIA
$nazwa_tab = 'historia'; $nazwa_tab = trim($nazwa_tab);

					//dodanie nowej przegladarki do tabeli
					$stmt = $db->prepare(
						"INSERT INTO $nazwa_tab (id, data_utw, ip, podstrona, system, przegladarki, color, ekran, jezyk, ciaguser)
						VALUES (0, '".time()."', '$nr_ip', '".$podstrona."', '".$_GET['system']."', '".$_GET['przegladarka']."', '".$_GET['color']."', '".$_GET['ekran']."', '".$_GET['jezyk_przegladarki']."', '".$_GET['ciaguser']."')"
					);		
					$stmt->execute(); //dodanie nr ip do tabeli			
			
//##### SEO
			include("../inc/seo.php");	
	
//----------------------------------------------------------------------
}//### if file_exists







/**/


