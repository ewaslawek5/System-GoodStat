<?php
//###################### Z JAKIEJ KLIKNIETO STRONY
$adres_www = ADRES_STR; 
// Usuwamy protoko³y i ewentualny "www.", aby porównanie by³o rygorystyczne
$moje_www = str_replace(["http://", "https://", "www."], "", strtolower($adres_www));

// Parsowanie adresu przychodz¹cego
$idref_val = (string)($idref ?? '');
$idref_parse = parse_url($idref_val);

// Pobieramy host i równie¿ czyœcimy go z "www." do porównania
$ze_str_raw = strtolower(trim($idref_parse['host'] ?? ''));
$ze_str_clean = str_replace("www.", "", $ze_str_raw);

// WARUNEK: Zapisuj tylko jeœli:
// 1. $ze_str_raw nie jest puste
// 2. $ze_str_clean nie jest Twoj¹ domen¹ ($moje_www)
if ($ze_str_raw !== '' && $ze_str_clean !== $moje_www) {

    $nazwa_tab = 'klikzestr';
    
    // U¿ywamy oryginalnego hosta do zapisu w bazie, ale po przefiltrowaniu Twojej domeny
    $ze_str = $ze_str_raw;

    // 1. Sprawdzamy czy strona istnieje
    $stmt = $db->prepare("SELECT id, wejscia FROM `$nazwa_tab` WHERE strona = :strona LIMIT 1");
    $stmt->execute([':strona' => $ze_str]);
    $wiersz = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$wiersz) {
        // 2. Dodanie nowej strony (klikniêcie z zewn¹trz)
        $stmt_ins = $db->prepare(
            "INSERT INTO `$nazwa_tab` (strona, wejscia, data) 
             VALUES (:strona, 1, :data)"
        );        
        $stmt_ins->execute([
            ':strona' => $ze_str,
            ':data'   => time()
        ]);

    } else {            
        // 3. Aktualizacja istniej¹cej strony
        $wej_k = (int)$wiersz['wejscia'] + 1;
        $id_k  = $wiersz['id'];

        $stmt_upd = $db->prepare("UPDATE `$nazwa_tab` SET `wejscia` = :wej, `data` = :data WHERE `id` = :id LIMIT 1");
        $stmt_upd->execute([
            ':wej'  => $wej_k,
            ':data' => time(),
            ':id'   => $id_k
        ]);
    }   
}

//###################### roboty internetowe (boty)
	$nazwa_robota = jakiRobot();	
	$nazwa_robota = trim($nazwa_robota);
	
/**/
if ($nazwa_robota !== '') {
    $nazwa_tab = 'roboty';
    
    // 1. Sprawdzamy czy robot ju¿ istnieje (u¿ywaj¹c bindowania)
    $stmt = $db->prepare("SELECT id, wejscia FROM `$nazwa_tab` WHERE roboty = :nazwa LIMIT 1");
    $stmt->execute([':nazwa' => $nazwa_robota]);
    $wiersz = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$wiersz) {
        // 2. Dodanie nowego robota (tylko jeden INSERT!)
        // PHP 8.4: U¿ywamy bindowania dla bezpieczeñstwa i czytelnoœci
        $stmt_ins = $db->prepare(
            "INSERT INTO `$nazwa_tab` (roboty, wejscia, data, ua) 
             VALUES (:roboty, 1, :data, :ua)"
        );        
        $stmt_ins->execute([
            ':roboty' => $nazwa_robota,
            ':data'   => time(),
            ':ua'     => (string)($ciaguser ?? '')
        ]);

    } else {    
        // 3. Aktualizacja istniej¹cego robota
        $wej_r = (int)$wiersz['wejscia'] + 1;
        $id_r  = $wiersz['id'];

        // U¿ywamy innej nazwy zmiennej ($stmt_upd), aby nie uszkodziæ pêtli/obiektu
        $stmt_upd = $db->prepare("UPDATE `$nazwa_tab` SET `wejscia` = :wej, `data` = :data WHERE `id` = :id LIMIT 1");
        $stmt_upd->execute([
            ':wej'  => $wej_r,
            ':data' => time(),
            ':id'   => $id_r
        ]);
    }
}


?>