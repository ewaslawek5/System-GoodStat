<?php
//--- dolaczenie plikow
if(file_exists('config.php')) {
	include('config.php');
	include('inc/baza_polacz.php');
}
	include('funkcje/funkcje.php');
	include("inc/sesje.php");
?>
<!DOCTYPE html>
<html lang="pl">

<head>

<?php	
//--- dolaczenie plikow
	include('inc/head.php');
?>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

<?php
if(file_exists('config.php')) {
//--- dolaczenie plikow
	include('inc/menu_lewe.php');
}
?>


	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">
<?php
if(file_exists('config.php')) {
    //zainstalowany
?>
		<!-- Main Content -->
		<div id="content">

<?php
//--- dolaczenie plikow
	include('inc/menu_gora.php');
?>

<!-- ######## Begin Page Content -->
		<div class="container-fluid">
<?php
//--- dolaczenie plikow
	include('operacje/!_spis.php');
	include('inc/pole_alerts.php');
?>
<?php
	if(isset($_SESSION['sesja_uzyt']['zalogowany'])){
// #############################################################################################
?>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Aktualizacja</h1>
	</div>

          <div class="card shadow mb-4">

            <div class="card-body">
			
			
			
			
			
		<div class="row justify-content-md-center my-1">
			<div class="col-xl-5 col-lg-6 col-md-6">
<?php
// 1. Obsługa formularza sprawdzania aktualizacji
if (isset($_POST['wyslij_aktualizacje'])) {

    // Pobieramy wersję z serwera za pomocą bezpieczniejszej metody
    $wersja_new_raw = @file_get_contents("https://goodstat.pl/!download-goodstat/aktualizacja.txt");
    $wersja_new = $wersja_new_raw !== false ? trim($wersja_new_raw) : $wersja_uzyt;

    // Używamy version_compare zamiast prostego porównania >
    if (version_compare($wersja_new, $wersja_uzyt, '>')) {
        ?>
        <div class="card border-success shadow-sm mb-4">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-download"></i> <strong>JEST NOWA WERSJA!</strong> (v. <?php echo htmlspecialchars($wersja_new); ?>)
                </div>
                
                <a class="btn btn-success btn-lg btn-block my-4 py-3" 
                   href="https://goodstat.pl/index.php?file=goodstat_<?php echo urlencode($wersja_new); ?>.zip">
                   <i class="fas fa-cloud-download-alt"></i> Pobierz aktualizację
                </a>

                <h4 class="mt-4"><i class="fas fa-info-circle"></i> Instrukcja aktualizacji</h4>
                <ol class="list-group list-group-flush list-group-numbered">
                    <li class="list-group-item">Pobierz i rozpakuj paczkę <strong>.zip</strong> na swoim komputerze.</li>
                    <li class="list-group-item">Wykasuj pliki starej wersji z serwera.</li>
                    <li class="list-group-item">Wgraj nowe pliki w to samo miejsce.</li>
                    <li class="list-group-item">Uruchom system w przeglądarce i postępuj zgodnie z komunikatami instalatora.</li>
                </ol>
            </div>
        </div>
        <?php
    } else {

// 1. Konfiguracja kontekstu z limitem czasu (timeout)
// Zapobiega to zawieszeniu panelu, gdyby strona goodstat.pl wolno działała
$stream_options = [
    'http' => [
        'timeout' => 2, // 2 sekundy to optymalny czas na pobranie małego pliku txt
        'ignore_errors' => true
    ]
];
$context = stream_context_create($stream_options);

// 2. Pobieranie surowych danych
// @ wycisza ewentualne błędy połączenia (np. brak DNS)
$wiadomosc_raw = @file_get_contents("https://goodstat.pl/!download-goodstat/wiadomosc.txt", false, $context);

// 3. Logika przypisania komunikatu
// Sprawdzamy czy pobieranie się udało I czy treść nie jest pusta po usunięciu spacji
if ($wiadomosc_raw !== false && trim($wiadomosc_raw) !== '') {
    $wiadomosc = trim($wiadomosc_raw);
} else {
    $wiadomosc = 'Brak nowych komunikatów.';
}

// 4. Wyświetlanie w interfejsie
// Warunek: pokazujemy boks tylko, jeśli faktycznie jest jakaś nowa wiadomość
if ($wiadomosc !== 'Brak nowych komunikatów.'): ?>
    <div class="p-3 bg-light border rounded mt-3 shadow-sm">
        <h6 class="text-muted mb-2">
            <i class="fas fa-info-circle"></i> Komunikat techniczny:
        </h6>
        <div class="small text-dark">
            <?php 
                // htmlspecialchars chroni przed XSS, nl2br zamienia entery na <br>
                echo nl2br($wiadomosc); 
            ?>
        </div>
    </div>
<?php endif;
    }

} else {
    // 2. Widok początkowy (przycisk sprawdzenia)
    ?>
    <form action="aktualizacja.php" method="post" class="mt-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fab fa-searchengin fa-4x text-primary"></i>
                </div>
                <h5>Sprawdź czy jest nowa wersja GoodStat-u</h5>
                <p class="text-muted small">System połączy się z serwerem goodstat.pl w celu weryfikacji wersji.</p>
                
                <button type="submit" name="wyslij_aktualizacje" class="btn btn-primary btn-lg btn-block mt-3">
                    <i class="fas fa-sync-alt"></i> Sprawdź teraz
                </button>
            </div>
        </div>
    </form>
    <?php
}
?>
			</div>
		</div>
			
			
			
			
			
			</div>
		  </div>
















<?php
// #############################################################################################
	}else{		
		include('inc/form_logowania.php');
	}
?>

		</div>
<!-- ######## end container-fluid -->

	</div>
	<!-- End of Main Content -->

<?php
}else{
    //instalacja
	include('instalacja/index.php');
}
?>
<?php
if(file_exists('config.php')) {
//--- dolaczenie plikow
	include('inc/stopka.php');
}
?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php
//--- dolaczenie plikow
	include('inc/stopka_bootstrap.php');
?>

</body>

</html>
