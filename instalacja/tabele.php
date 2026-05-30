<?php

//##### KLIENT	
// U¿ywamy operatora ?? aby unikn¹æ Warningu w PHP 8.4, jeœli nazwa_bazy nie dotar³a w POST
$baza = $_POST['nazwa_bazy'] ?? '';
$nazwa_tab = $baza . '.klient_stat'; 

if (!empty($baza)) {
    // 1. Najpierw usuwamy star¹ tabelê, jeœli istnieje (zamiast TRUNCATE)
    // To najbezpieczniejszy sposób przy nowej instalacji
    $sql_drop = "DROP TABLE IF EXISTS $nazwa_tab";
    $db->exec($sql_drop);

    // 2. Tworzymy tabelê od nowa
    $sql_create = "CREATE TABLE $nazwa_tab (
            `id` int(11) NOT NULL AUTO_INCREMENT,		
            `mail` varchar(100) NOT NULL DEFAULT '-',
            `wersja` varchar(20) NOT NULL DEFAULT '-',
            `data_inst` int(15) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $db->exec($sql_create);
} else {
    die("B³¹d: Nie podano nazwy bazy danych.");
}

	$h = $_POST['haslo1'];
	$haslo1 = sha1($h); $haslo_zakodowane = cleanText($haslo1);

	$stmt = $db->prepare( 
		"INSERT INTO $nazwa_tab (id, mail, wersja, data_inst)
		VALUES (0, '{$_POST['email']}', '2.1', ".time().")"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

//##### UZYTKOWNICY	
$baza = $_POST['nazwa_bazy'] ?? '';
$nazwa_tab = $baza . '.uzyt_stat';

if (!empty($baza)) {
    // 1. Usuwamy tabelê jeœli istnieje, zamiast TRUNCATE (rozwi¹zuje b³¹d Fatal Error)
    $db->exec("DROP TABLE IF EXISTS $nazwa_tab");

    // 2. Tworzymy strukturê tabeli
    $sql_create = "CREATE TABLE $nazwa_tab (
            `id` int NOT NULL AUTO_INCREMENT,
            `login` varchar(100) NOT NULL DEFAULT '-',
            `haslo` varchar(200) NOT NULL DEFAULT '-',
            `mail` varchar(100) NOT NULL DEFAULT '-',
            `data_utw` int(15) NOT NULL,	
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $db->exec($sql_create);

    // 3. Bezpieczne dodawanie u¿ytkownika (Prepared Statements)
    // PHP 8.4 wymaga pe³nego bezpieczeñstwa - nie wk³adamy $_POST bezpoœrednio do SQL!
    $stmt = $db->prepare("INSERT INTO $nazwa_tab (login, haslo, mail, data_utw) VALUES (:login, :haslo, :mail, :data)");
    
    $stmt->execute([
        'login' => $_POST['login'] ?? '',
        'haslo' => $haslo1, // Zak³adam, ¿e has³o jest ju¿ zahashowane wczeœniej
        'mail'  => $_POST['email'] ?? '',
        'data'  => time()
    ]);
}

//##### HISTORIA OPERACJI SYSTEMU GOODSTAT
$baza = $_POST['nazwa_bazy'] ?? '';
$nazwa_tab = $baza . '.hist_operacji'; 

if (!empty($baza)) {
    // 1. Bezpieczne usuwanie tabeli przed jej utworzeniem (unikasz b³êdu "Table already exists")
    $db->exec("DROP TABLE IF EXISTS $nazwa_tab");

    // 2. Tworzenie tabeli
    $sql_create = "CREATE TABLE $nazwa_tab (
            `id` int NOT NULL AUTO_INCREMENT,
            `opis` varchar(500) NOT NULL DEFAULT '-',
            `data_utw` int(15) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($sql_create);
        
    // 3. Dodanie pierwszego wpisu (zmienione na bezpieczne Prepared Statement)
    $stmt = $db->prepare("INSERT INTO $nazwa_tab (opis, data_utw) VALUES (:opis, :data)");
    
    $stmt->execute([
        'opis' => 'Instalacja systemu GoodStat na serwerze',
        'data' => time()
    ]);
}
	
//#####				#####
//#####	STATYSTYKI	#####
//#####				#####
	
//##### WIZYTY i ODS£ONY	
$rok_tworzenia = date('Y');
		
for ($rok_wys = $rok_tworzenia; $rok_wys <= $rok_tworzenia + 10; $rok_wys++) {

//##### WIZYTY i ODS£ONY	
$nazwa_tab = $_POST['nazwa_bazy'].'.'.$rok_wys.'_wiz_ods'; 


$sql = "CREATE TABLE $nazwa_tab (
	  `id` int NOT NULL default '0',	
	  
	  `wiz` int NOT NULL default '0',  
	  `ods` int NOT NULL default '0',
		
	  `0wiz` int NOT NULL default '0',
	  `1wiz` int NOT NULL default '0',
	  `2wiz` int NOT NULL default '0',
	  `3wiz` int NOT NULL default '0',
	  `4wiz` int NOT NULL default '0',
	  `5wiz` int NOT NULL default '0',
	  `6wiz` int NOT NULL default '0',
	  `7wiz` int NOT NULL default '0',
	  `8wiz` int NOT NULL default '0',
	  `9wiz` int NOT NULL default '0',
	  `10wiz` int NOT NULL default '0',
	  `11wiz` int NOT NULL default '0',
	  `12wiz` int NOT NULL default '0',
	  `13wiz` int NOT NULL default '0',
	  `14wiz` int NOT NULL default '0',
	  `15wiz` int NOT NULL default '0',
	  `16wiz` int NOT NULL default '0',
	  `17wiz` int NOT NULL default '0',
	  `18wiz` int NOT NULL default '0',
	  `19wiz` int NOT NULL default '0',
	  `20wiz` int NOT NULL default '0',
	  `21wiz` int NOT NULL default '0',
	  `22wiz` int NOT NULL default '0',
	  `23wiz` int NOT NULL default '0',

	  `0ods` int NOT NULL default '0',
	  `1ods` int NOT NULL default '0',
	  `2ods` int NOT NULL default '0',
	  `3ods` int NOT NULL default '0',
	  `4ods` int NOT NULL default '0',
	  `5ods` int NOT NULL default '0',
	  `6ods` int NOT NULL default '0',
	  `7ods` int NOT NULL default '0',
	  `8ods` int NOT NULL default '0',
	  `9ods` int NOT NULL default '0',
	  `10ods` int NOT NULL default '0',
	  `11ods` int NOT NULL default '0',
	  `12ods` int NOT NULL default '0',
	  `13ods` int NOT NULL default '0',
	  `14ods` int NOT NULL default '0',
	  `15ods` int NOT NULL default '0',
	  `16ods` int NOT NULL default '0',
	  `17ods` int NOT NULL default '0',
	  `18ods` int NOT NULL default '0',
	  `19ods` int NOT NULL default '0',
	  `20ods` int NOT NULL default '0',
	  `21ods` int NOT NULL default '0',
	  `22ods` int NOT NULL default '0',
	  `23ods` int NOT NULL default '0',
	  
	  `nr_tyg` int NOT NULL default '0',		  
	  `dni_tyg` int NOT NULL default '0',
	  
	  `data_unix` int(13) NOT NULL,
	  
	   PRIMARY KEY  (`id`),
	   KEY `nr_tyg` (`nr_tyg`)				
	)";
	
	$db->exec($sql);

}//end for


//##### PODSTRONY
$nazwa_tab = $_POST['nazwa_bazy'].'.podstrony'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`podstrony` varchar(300) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `podstrony` (`podstrony`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### EKRAN
$nazwa_tab = $_POST['nazwa_bazy'].'.ekran'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`ekran` varchar(200) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `ekran` (`ekran`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### COLOR
$nazwa_tab = $_POST['nazwa_bazy'].'.color'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`color` varchar(200) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `color` (`color`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### PRZEGLADARKI
$nazwa_tab = $_POST['nazwa_bazy'].'.przegladarki'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`przegladarki` varchar(200) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `przegladarki` (`przegladarki`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### JEZYK
$nazwa_tab = $_POST['nazwa_bazy'].'.jezyk'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`jezyk` varchar(200) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `jezyk` (`jezyk`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### SYSTEM
$nazwa_tab = $_POST['nazwa_bazy'].'.system'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`system` varchar(200) NOT NULL default '',
	`wejscia` int NOT NULL,
  
	PRIMARY KEY  (`id`),
	KEY `system` (`system`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### HISTORIA
$nazwa_tab = $_POST['nazwa_bazy'].'.historia'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`data_utw` int(15) NOT NULL,
	`ip` varchar(50) NOT NULL default '',
	`podstrona` varchar(200) NOT NULL default '',
	`system` varchar(20) NOT NULL default '',
	`przegladarki` varchar(50) NOT NULL default '',
	`color` varchar(10) NOT NULL default '',
	`ekran` varchar(20) NOT NULL default '',
	`jezyk` varchar(20) NOT NULL default '',
	`ciaguser` varchar(150) NOT NULL default '',
	  
	PRIMARY KEY  (`id`)
	)";
	
	$db->exec($sql);

//##### ROBOTY
$nazwa_tab = $_POST['nazwa_bazy'].'.roboty'; 

$sql = "CREATE TABLE $nazwa_tab (
	`id` int NOT NULL auto_increment,
	`roboty` varchar(50) NOT NULL default '',
	`wejscia` int NOT NULL,
	`data` int(15) NOT NULL,
	`ua` varchar(200) NOT NULL default '',
  
	PRIMARY KEY  (`id`),
	KEY `roboty` (`roboty`),
	KEY `wejscia` (`wejscia`)
	)";
	
	$db->exec($sql);

//##### NR IP
$rok_tworzenia = date('Y');
		
for ($rok_wys = $rok_tworzenia; $rok_wys <= $rok_tworzenia + 10; $rok_wys++) {

$nazwa_tab = $_POST['nazwa_bazy'].'.'.$rok_wys.'_nr_ip'; 

$sql = "CREATE TABLE $nazwa_tab (
  `nr_ip` varchar(50) default '0',
  `dzien_roku` int NOT NULL,
  `dzien` int NOT NULL,
  `miesiac` int NOT NULL,
  `ods` int NOT NULL,
  `data_utw` int(15) NOT NULL,

  KEY `nr_ip` (`nr_ip`),
  KEY `dzien_roku` (`dzien_roku`),
  KEY `dzien` (`dzien`),
  KEY `miesiac` (`miesiac`)
	)";
	
	$db->exec($sql);

}//end for

$rok_tworzenia = date('Y');
		
for ($rok_wys = $rok_tworzenia; $rok_wys <= $rok_tworzenia + 10; $rok_wys++) {

//##### WIZYTY i ODS£ONY	
$nazwa_tab = $_POST['nazwa_bazy'].'.'.$rok_wys.'_wiz_ods'; 
	for ($miesiac = 1; $miesiac <= 12; $miesiac++) {//tworzenie miesiecy, obieg 12 razy	
	
		$dni_w_miesiacu = new DateTime($rok_wys.'-'.$miesiac.'-01');
		$ilosc_dni = $dni_w_miesiacu->format("t");	//iloœæ dni w miesi¹cu
		
		for ($dzien = 1; $dzien <= $ilosc_dni; $dzien++) {
		
			$dni_w_tygodniu 	= new DateTime($rok_wys.'-'.$miesiac.'-'.$dzien.'');
			$dzien_tyg 			= $dni_w_tygodniu->format("w");	//dzien tygodnia jako cyfra 0 to niedziela
			$data_unix 			= $dni_w_tygodniu->format("U");	//Sekundy liczone od ery UNIX-a
			$dzien_roku 		= $dni_w_tygodniu->format("z");	//Dzieñ roku (Zaczynaj¹c od 0) 0 a¿ do 365
			$nr_tyg 			= $dni_w_tygodniu->format("W");	//Numer tygodnia w roku, zgodny z norm¹ ISO-8601, Tygodnie rozpoczynaj¹ Poniedzia³ki. Przyk³ad: 42

				$stmt = $db->prepare( 
					"INSERT INTO $nazwa_tab (id, nr_tyg, dni_tyg, data_unix)
					VALUES ($dzien_roku, $nr_tyg, $dzien_tyg, $data_unix)"
				); if(@$stmt->execute()){}//dodanie danych do tabeli

			}
			
		}
}

//##### LATA KALENDARZA	
$nazwa_tab = $_POST['nazwa_bazy'].'.'.'lata_kal';

$sql = "CREATE TABLE $nazwa_tab (
  `lata` int NOT NULL,
  
  PRIMARY KEY  (`lata`)			
	)";
	
	$db->exec($sql);

$rok_tworzenia = date('Y');
		
for ($rok_wys = $rok_tworzenia; $rok_wys <= $rok_tworzenia + 10; $rok_wys++) {
				$stmt = $db->prepare(
					"INSERT INTO $nazwa_tab (lata)
					VALUES ($rok_wys)"
				); if(@$stmt->execute()){}//dodanie danych do tabeli
}

//##### NUMERY IP	
$nazwa_tab = $_POST['nazwa_bazy'].'.'.'nr_ip_dzis';

$sql = "CREATE TABLE $nazwa_tab (
  `nr_ip` varchar(50) default '0',
  `wejscia` int NOT NULL,
  `dzien` int NOT NULL,
  
  PRIMARY KEY  (`nr_ip`),
  		
  KEY `dzien` (`dzien`)				
	)";
	
	$db->exec($sql);

//##### WIZYTY DNI TYGODNIA
$nazwa_tab = $_POST['nazwa_bazy'].'.'.'dni_tyg';

$sql = "CREATE TABLE $nazwa_tab (
	`dzien` int NOT NULL,
	`wejscia` int NOT NULL,
 
	PRIMARY KEY  (`dzien`)			
	)";
	
	$db->exec($sql);

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('0', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('1', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('2', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('3', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('4', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('5', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (dzien, wejscia)
		VALUES ('6', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli


//##### WIZYTY GODZIN
$nazwa_tab = $_POST['nazwa_bazy'].'.'.'god';

$sql = "CREATE TABLE $nazwa_tab (
	`god` int NOT NULL,
	`wejscia` int NOT NULL,
 
	PRIMARY KEY  (`god`)			
	)";
	
	$db->exec($sql);

	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('0', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('1', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('2', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('3', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('4', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('5', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('6', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('7', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('8', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('9', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('10', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('11', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('12', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('13', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('14', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('15', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('16', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('17', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('18', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('19', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('20', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('21', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('22', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	
	$stmt = $db->prepare(
		"INSERT INTO $nazwa_tab (god, wejscia)
		VALUES ('23', '0')"
	); if(@$stmt->execute()){}//dodanie danych do tabeli
	

//##### KLIKZESTR	
$nazwa_tab = $_POST['nazwa_bazy'].'.'.'klikzestr';

$sql = "CREATE TABLE $nazwa_tab (
  `id` int NOT NULL auto_increment,
  `strona` varchar(200) default '0',
  `wejscia` int NOT NULL,
  `data` int NOT NULL,
  
  PRIMARY KEY  (`id`),
  		
  KEY `strona` (`strona`)				
	)";
	
	$db->exec($sql);
