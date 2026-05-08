<?php
//---- total_wiz
	$tabela = date('Y').'_wiz_ods';
	$res1 = $db->query("SELECT SUM(`wiz`) AS 'total_wiz' FROM `$tabela`");
	
	$row = $res1->fetch(PDO::FETCH_ASSOC);
	$total_wiz_ 	= $row['total_wiz'];
	$total_wiz = number_format(str_replace(',','.',$total_wiz_), 0, '.', ' ');
	
//---- total_ods
	$tabela = date('Y').'_wiz_ods';
	$res1 = $db->query("SELECT SUM(`ods`) AS 'total_ods' FROM `$tabela`");
	
	$row = $res1->fetch(PDO::FETCH_ASSOC);
	$total_ods_ 	= $row['total_ods'];
	$total_ods = number_format(str_replace(',','.',$total_ods_), 0, '.', ' ');
	
//---- sr_ods_na_wiz
if(($total_ods_ != 0) AND ($total_wiz_ != 0)){
	
	$sr_ods_na_wiz_ = $total_ods_ / $total_wiz_;
	$sr_ods_na_wiz = number_format(str_replace(',','.',$sr_ods_na_wiz_), 1, '.', ' ');
	
}else{
	$sr_ods_na_wiz = 0.0;
}

//###########################################################################
// WIZYTY WSZYSTKIE LATA

$stmt = $db->query("SELECT `lata` FROM `lata_kal` ORDER BY `lata` ASC");
$latatab = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (!empty($latatab)) {
    $queries = [];
    foreach ($latatab as $lata) {
        $queries[] = "SELECT SUM(`wiz`) as wiz_sum FROM `{$lata}_wiz_ods`";
    }
    
    // Łączymy wszystkie tabele w jedno potężne zapytanie
    $final_sql = "SELECT SUM(wiz_sum) as grand_total FROM (" . implode(" UNION ALL ", $queries) . ") as subquery";
    $total_wiz_wszy_lata_ = $db->query($final_sql)->fetchColumn();
}

$total_wiz_wszy_lata = number_format((float)$total_wiz_wszy_lata_, 0, '.', ' ');
		
// ODSŁONY WSZYSTKIE LATA
$stmt = $db->query("SELECT `lata` FROM `lata_kal` ORDER BY `lata` ASC");

$total_ods_wszy_lata_ = 0;

while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
    $lata = $wiersz['lata'];
    $tabela = $lata . '_wiz_ods';
    
    try {
        // Próba pobrania sumy
        $res1 = $db->query("SELECT SUM(`ods`) AS total FROM `$tabela` LIMIT 1");
        
        if ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
            // PHP 8.4: Bezpieczne sumowanie
            $total_ods_wszy_lata_ += (float)($row['total'] ?? 0);
        }
    } catch (PDOException $e) {
        // Jeśli tabela nie istnieje, pomijamy ten rok i idziemy dalej
        continue;
    }
}

// Wynik sformatowany do wyświetlenia
$total_ods_wszy_lata = number_format($total_ods_wszy_lata_, 0, '.', ' ');

//---- sr_ods_na_wiz_total
// Sprawdzamy czy mianownik nie jest zerem (dzielenie przez 0 wyrzuca błąd Fatal Error w nowym PHP)
if ($total_wiz_wszy_lata_ > 0) {
    
    // Wykonujemy dzielenie
    $sr_ods_na_wiz_total_ = $total_ods_wszy_lata_ / $total_wiz_wszy_lata_;
    
    // Formatujemy wynik: 1 miejsce po przecinku, spacja jako separator tysięcy
    // Usuwamy str_replace, bo operujemy na czystych liczbach (float/int)
    $sr_ods_na_wiz_total = number_format($sr_ods_na_wiz_total_, 1, '.', ' ');
    
} else {
    // Wartość domyślna, jeśli nie ma jeszcze żadnych wizyt
    $sr_ods_na_wiz_total = "0.0";
}

//###########################################################################
// BAZA DANYCH - Statystyki wielkości
// 1. Inicjalizacja zmiennych przed pętlą (wymagane w PHP 8.4)
$suma_rows = 0;
$suma_Avg_row_length = 0;
$suma_Data_length = 0;
$suma_Index_length = 0;
$suma_wielkosci = 0;

// Upewnij się, że stała NAZWA_BAZY jest zdefiniowana
$db_name = defined('NAZWA_BAZY') ? NAZWA_BAZY : '';

if (!empty($db_name)) {
    // 2. Pobieramy status tabel
    $stmt = $db->query("SHOW TABLE STATUS FROM `$db_name`");

    while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
        // 3. Sumowanie z użyciem rzutowania na int (dla bezpieczeństwa obliczeń)
        $rows         = (int)($wiersz['Rows'] ?? 0);
        $avg_len      = (int)($wiersz['Avg_row_length'] ?? 0);
        $data_len     = (int)($wiersz['Data_length'] ?? 0);
        $index_len    = (int)($wiersz['Index_length'] ?? 0);

        $suma_rows           += $rows;
        $suma_Avg_row_length += $avg_len;
        $suma_Data_length    += $data_len;
        $suma_Index_length   += $index_len;
        $suma_wielkosci      += ($data_len + $index_len);
    }
}

// Opcjonalnie: Konwersja na megabajty dla czytelności w panelu GoodStat
$suma_wielkosci_mb = number_format($suma_wielkosci / 1024 / 1024, 2, '.', ' ') . ' MB';

//###########################################################################
// HISTORIA

//	$total_odsl_wszy_lata_ = 0;

// 1. Wykonujemy szybkie liczenie po stronie bazy danych (zamiast fetchAll)
$res1 = $db->query("SELECT COUNT(*) FROM `historia`");

// 2. Pobieramy tylko jedną liczbę bezpośrednio
$count = (int)$res1->fetchColumn();

// 3. Formatujemy wynik (PHP 8.4: operujemy na liczbie, nie potrzebujemy str_replace)
$hist = number_format($count, 0, '.', ' ');
			
//###########################################################################
// DZIENNIK SYSTEMU

// 1. Liczymy rekordy bezpośrednio w bazie danych (optymalne)
$res1 = $db->query("SELECT COUNT(*) FROM `hist_operacji`");

// 2. Pobieramy wynik jako pojedynczą liczbę (fetchColumn jest najszybszy)
$ilosc_wpisow = (int)$res1->fetchColumn();

// 3. Formatujemy liczbę do wyświetlenia
$dziennik_sys = number_format($ilosc_wpisow, 0, '.', ' ');
			
//###########################################################################
// PODSTRONY

// 1. Zapytanie liczące rekordy - baza danych wykonuje całą pracę
$res1 = $db->query("SELECT COUNT(*) FROM `podstrony`");

// 2. Pobranie tylko wyniku liczbowego (PHP 8.4)
$count_podstrony = (int)$res1->fetchColumn();

// 3. Formatowanie (bez zbędnego str_replace, bo operujemy na liczbie)
$podstrony = number_format($count_podstrony, 0, '.', ' ');
			
//###########################################################################
// roboty

// 1. Liczymy roboty bezpośrednio w bazie
$res1 = $db->query("SELECT COUNT(*) FROM `roboty`");

// 2. Pobieramy wynik (rzutowanie na int dla pewności typu)
$count_roboty = (int)$res1->fetchColumn();

// 3. Formatowanie wyniku do wyświetlenia
$roboty = number_format($count_roboty, 0, '.', ' ');

//###########################################################################
// zrodlo

// 1. Zapytanie COUNT(*) - baza danych zwraca tylko jedną liczbę
$res1 = $db->query("SELECT COUNT(*) FROM `klikzestr`");

// 2. Pobieramy wynik bezpośrednio jako liczbę całkowitą
$count_klik = (int)$res1->fetchColumn();

// 3. Formatujemy wynik (używając spacji jako separatora tysięcy)
$klikzestr = number_format($count_klik, 0, '.', ' ');
			
//###########################################################################
// AKTUALIZACJA - Pobieranie danych z serwera GoodStat

// 1. Pobieranie wersji (używamy file_get_contents z obsługą błędów)
// Operator @ tłumi błędy połączenia, a ?? zapewnia domyślną wartość
$wersja_new = @file_get_contents("http://goodstat.pl/!download-goodstat/aktualizacja.txt");
$wersja_new = $wersja_new !== false ? trim($wersja_new) : $wersja_uzyt;

// 2. Pobieranie wiadomości
$wiadomosc_raw = @file_get_contents("http://goodstat.pl/!download-goodstat/wiadomosc.txt");
$wiadomosc = $wiadomosc_raw !== false ? trim($wiadomosc_raw) : '';

// 3. Bezpieczne porównywanie wersji (standard PHP version_compare)
// Obsługuje formaty typu 1.0.1, 1.2, 2.0-beta itp.
if (version_compare($wersja_new, $wersja_uzyt, '>')) {
    // Jest nowa wersja
    $stan = 'nieaktualny';
    $klasa_alertu = 'alert-warning';
} else {
    // Masz aktualną wersję
    $stan = 'aktualny';
    $klasa_alertu = 'alert-success';
}
			
?>
			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0 text-gray-800">Główny Panel <small></small></h1>
			</div>

          <div class="card mb-4">
            <div class="card-body">
			
<?php
//###########################################################################
?>
			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Aktualizacje i Informacje <small>od Systemu GoodStat</small></h1>
			</div>
		<!-- Content Row -->
		<div class="row">
		
			<!-- aktualizacja -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1"><span class="text-muted small">STAN Systemu GoodStat</span></div>
<?php 
// PHP 8.4: Zabezpieczenie na wypadek, gdyby $stan nie został wcześniej zdefiniowany
$status_wersji = $stan ?? 'nieznany'; 
?>

<?php if ($status_wersji === 'aktualny'): ?>
    <div class="h2 mb-0 font-weight-bold text-success">
        <i class="fas fa-check-square"></i> aktualny
    </div>
<?php else: ?>
    <div class="h2 mb-0 font-weight-bold text-danger">
        <i class="fas fa-exclamation-triangle"></i> nieaktualny
    </div>
<?php endif; ?>
                    </div>

                    <div class="col-auto">
						<i class="fab fa-searchengin fa-2x text-gray-300"></i>
                    </div>
                  </div>
<hr />
<div class="small text-right" style="margin-top: 10px;">
    <?php if (($stan ?? '') === 'nieaktualny'): ?>
        <span class="text-danger">
            <i class="fas fa-exclamation-triangle"></i> 
            Czym prędzej przejdź do działu: 
            <a href="aktualizacja.php" class="font-weight-bold">Aktualizacja</a>
        </span>
    <?php else: ?>
        <span class="text-muted">
            <i class="fas fa-check-circle"></i> Posiadasz aktualną wersję
        </span>
    <?php endif; ?>
</div>
                </div>
              </div>
            </div>
			
            <div class="col-xl-8 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">INFORMACJE <span class="text-muted small">od GoodStat-u</span></div>
<?php
echo '<div class="small">'.$wiadomosc.'</div>';
?>					  

                    </div>
                    <div class="col-auto">
						<i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
		</div>












			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Wizyty i Odsłony <small>rok <?php echo date('Y'); ?></small></h1>
			</div>

		<!-- Content Row -->
		<div class="row">
		
			<!-- total_wiz -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">WIZYTY <span class="text-muted small">suma</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_wiz; ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz <a href="wizyty.php?rok=<?php echo date('Y'); ?>">Wizyty</a> w <?php echo date('Y'); ?> roku</p>
                </div>
              </div>
            </div>
			
			<!-- total_ods -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-success mb-1">ODSŁONY <span class="text-muted small">suma</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_ods; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz <a href="odslony.php?rok=<?php echo date('Y'); ?>">Odsłony</a> w <?php echo date('Y'); ?> roku</p>
                </div>
              </div>
            </div>
			
			<!-- sr_ods_na_wiz -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-warning mb-1">ŚREDNIO <span class="text-muted small">odsłon na 1 wizytę</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $sr_ods_na_wiz; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;"></p>
                </div>
              </div>
            </div>
		  

			
		</div>
		
<?php
//###########################################################################
?>
		
			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Wizyty i Odsłony <small>wszystkie lata</small></h1>
			</div>
		
		<!-- Content Row -->
		<div class="row">
		
			<!-- total_wiz_wszy_lata -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">WIZYTY <span class="text-muted small">suma całkowita</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_wiz_wszy_lata; ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;"></p>
                </div>
              </div>
            </div>
			
			<!-- total_ods -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-success mb-1">ODSŁONY <span class="text-muted small">suma całkowita</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_ods_wszy_lata; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;"></p>
                </div>
              </div>
            </div>
			
			<!-- sr_ods_na_wiz -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-warning mb-1">ŚREDNIO <span class="text-muted small">odsłon na 1 wizytę</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $sr_ods_na_wiz_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;"></p>
                </div>
              </div>
            </div>
		  

			
		</div>
		
<?php
//###########################################################################
?>
			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Baza Danych <small>dane i wielkości</small></h1>
			</div>		

		<!-- Content Row -->
		<div class="row">
		
			<!-- baza danych -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">BAZA DANYCH <span class="text-muted small">wielkość</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo formatSize($suma_wielkosci); ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-database fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz dane Bazy: <a href="baza_danych.php"><?php echo ''.NAZWA_BAZY.''; ?></a></p>
                </div>
              </div>
            </div>
			
			<!-- total_ods -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">HISTORIA <span class="text-muted small">ilość wierszy w tabeli</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $hist; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz: <a href="historia.php">Historię Wejść</a></p>
                </div>
              </div>
            </div>
			
			<!-- dziennik_systemu -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">DZIENNIK SYSTEMU <span class="text-muted small">ilość rekordów</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $dziennik_sys; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz: <a href="logi.php">Dziennik Systemu</a></p>
                </div>
              </div>
            </div>
		  

			
		</div>
		
<?php
//###########################################################################
?>
			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Inne <small>wybrane dane</small></h1>
			</div>
		<!-- Content Row -->
		<div class="row">
		
			<!-- inne -->
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">PODSTRONY <span class="text-muted small">ilość</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $podstrony; ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz: <a href="podstrony.php">Podstrony</a></p>
                </div>
              </div>
            </div>
			
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">ROBOTY <span class="text-muted small">ilość</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $roboty; ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz: <a href="roboty.php">Roboty</a></p>
                </div>
              </div>
            </div>
			
            <div class="col-xl-4 col-md-12 mb-4">
              <div class="card card_str_gl border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary mb-1">ŹRÓDŁO <span class="text-muted small">ilość</span></div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $klikzestr; ?></div>
                    </div>
                    <div class="col-auto">
						<i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
				  <hr />
				  <p class="small text-right" style="margin-bottom: 0px; margin-top: 10px;">zobacz: <a href="zrodlo.php">Źródło</a></p>
                </div>
              </div>
            </div>
			
			
		</div>



	</div>
</div>
