<?php
//--- dolaczenie plikow
if(file_exists('config.php')) {
	include('config.php');
	include('inc/baza_polacz.php');
}
	include('funkcje/funkcje.php');
	include('funkcje/funkcje_odczytu.php');
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
		<h1 class="h3 mb-0 text-gray-800">Wizyty <small><?php echo 'Rok: '.$_GET['rok']; ?></small></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Zebrane Dane</h6>
		</div>
		<div class="card-body">

<div class="row">
<div class="col-sm">
	<div class="btn-group" role="group" aria-label="...">

		<!-- lata -->
<div class="btn-group" role="group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php 
            // PHP 8.4: Bezpieczne pobranie roku do wyświetlenia w przycisku
            $wyswietl_rok = $_GET['rok'] ?? date('Y');
            echo 'Rok <b>' . htmlspecialchars((string)$wyswietl_rok) . '</b>'; 
        ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
<?php
    // Zapytanie do bazy pozostaje bez zmian
    $stmt = $db->query("SELECT * FROM `lata_kal` ORDER BY `lata_kal`.`lata` ASC");

    // PHP 8.4: Pobieramy rok do porównania w pętli
    $get_rok = $_GET['rok'] ?? '';

    while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rok = $wiersz['lata'];
        
        // Logika przypisania klasy 'active' pozostaje identyczna
        echo '<a href="wizyty.php?rok='.$rok.'" class="dropdown-item'; 
        if($rok == $get_rok){ echo ' active'; } 
        echo '">'.$rok.'</a>';
    }
?>
    </ul>
</div>
		
<!-- miesiace -->
<div class="btn-group" role="group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php 
            // PHP 8.4: Bezpieczne pobranie miesiąca. Jeśli brak w URL, wyświetli puste lub można dać date('n')
            $m_wyswietl = $_GET['m'] ?? '';
            echo 'Miesiąc <b>' . htmlspecialchars((string)$m_wyswietl) . '</b>'; 
        ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <?php
            // Przygotowujemy zmienne pomocnicze, aby kod był czytelniejszy i bezpieczny
            $get_rok = $_GET['rok'] ?? '';
            $get_m   = $_GET['m']   ?? '';

            // Funkcja pomocnicza do generowania linków (opcjonalnie, ale poniżej zostawiam Twój format)
            // Styczeń
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=1" class="dropdown-item'; if($get_m == 1){echo' active';} echo'">Styczeń</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=2" class="dropdown-item'; if($get_m == 2){echo' active';} echo'">Luty</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=3" class="dropdown-item'; if($get_m == 3){echo' active';} echo'">Marzec</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=4" class="dropdown-item'; if($get_m == 4){echo' active';} echo'">Kwiecień</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=5" class="dropdown-item'; if($get_m == 5){echo' active';} echo'">Maj</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=6" class="dropdown-item'; if($get_m == 6){echo' active';} echo'">Czerwiec</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=7" class="dropdown-item'; if($get_m == 7){echo' active';} echo'">Lipiec</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=8" class="dropdown-item'; if($get_m == 8){echo' active';} echo'">Sierpień</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=9" class="dropdown-item'; if($get_m == 9){echo' active';} echo'">Wrzesień</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=10" class="dropdown-item'; if($get_m == 10){echo' active';} echo'">Październik</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=11" class="dropdown-item'; if($get_m == 11){echo' active';} echo'">Listopad</a>';
            echo '<a href="wizyty.php?rok='.$get_rok.'&m=12" class="dropdown-item'; if($get_m == 12){echo' active';} echo'">Grudzień</a>';
        ?>
    </ul>
</div>

	</div>
</div>

	<div class="col-sm" style="margin-top: 5px; margin-bottom: 5px;">
		<form action="" class="form-inline" method="post">

				<div class="form-group row">
					<label for="inputWykres" class="col-sm-2 col-form-label text-muted">wykres</label>
					
					<div class="col-sm">
						<select name="rodz_wykresu" id="inputWykres" class="form-control form-control-sm">
							<?php
								// PHP 8.4: Pobieramy typ wykresu z sesji lub ustawiamy domyślny (np. 'bar')
								// Zapobiega to błędom "Undefined array key", gdy użytkownik nie jest zalogowany
								$aktualny_wykres = $_SESSION['sesja_uzyt']['wykres'] ?? 'bar';
							?>
							
							<option value="bar" <?php if($aktualny_wykres == 'bar'){echo 'selected';} ?>>Bar</option>
							<option value="line" <?php if($aktualny_wykres == 'line'){echo 'selected';} ?>>Line</option>
							<option value="radar" <?php if($aktualny_wykres == 'radar'){echo 'selected';} ?>>Radar</option>
							<option value="polarArea" <?php if($aktualny_wykres == 'polarArea'){echo 'selected';} ?>>Polar Area</option>
						</select>
					</div>
				</div>

				 <div class="form-group row">
					<div class="col-sm">
						<button type="submit" name="wyslij_wykres" class="btn btn-primary btn-sm">zmień wykres</button>
					</div>
				 </div>

		</form>
	</div>
</div><!-- /row -->
	
<?php
// PHP 8.4: Sprawdzamy, czy parametry 'm' (miesiąc) lub 't' (tydzień/tabela) istnieją.
// Używamy isset(), aby uniknąć błędów przy próbie odczytu nieistniejących kluczy.

if (!isset($_GET['m']) && !isset($_GET['t'])) {
    //---------------------------------------Pokazuje wykres ROKU (miesiące)
    // Ten widok ładuje się, gdy użytkownik wejdzie bezpośrednio w zestawienie
    
    if (file_exists('inc/odczyt-stat/wizyty-rok.php')) {
        include('inc/odczyt-stat/wizyty-rok.php');
    }

} else {
    //---------------------------------------Pokazuje wykres MIESIECZNY (dni)
    // Ten widok ładuje się, gdy w URL jest np. ?m=5
    
    if (file_exists('inc/odczyt-stat/wizyty-miesiac.php')) {
        include('inc/odczyt-stat/wizyty-miesiac.php');
    }
}
?>

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
