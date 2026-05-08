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
		<h1 class="h3 mb-0 text-gray-800">Zestawienie <small><?php echo 'Rok: '.$_GET['rok']; ?></small></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Wykresy Wizyt i Odsłon</h6>
		</div>
		<div class="card-body">

		
		
		
<div class="btn-group" role="group" aria-label="...">

	<div class="btn-group" role="group">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?php echo 'Rok <b>'.$_GET['rok'].'</b>'; ?>
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
<?php
// Pobieramy lata - ograniczamy SELECT do potrzebnej kolumny
$stmt = $db->query("SELECT `lata` FROM `lata_kal` ORDER BY `lata` ASC");

// PHP 8.4: Bezpieczne pobranie roku z adresu URL (zapobiega Undefined array key)
$wybrany_rok = isset($_GET['rok']) ? $_GET['rok'] : null;

while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
    $rok = $wiersz['lata'];
    
    // Sprawdzamy, czy ten rok jest obecnie przeglądany
    $aktywny = ($rok == $wybrany_rok) ? ' active' : '';
    
    // Wyświetlamy link
    echo '<a href="zestawienie.php?rok=' . $rok . '" class="dropdown-item' . $aktywny . '">' . $rok . '</a>';
}
?>
		</ul>
		
	</div>
	
	
	<div class="btn-group" role="group">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php 
// PHP 8.4: Sprawdzamy czy parametr istnieje, aby uniknąć Warning
$m_param = $_GET['m'] ?? ''; 

// Zabezpieczamy wyświetlanie przed atakiem XSS (używamy htmlspecialchars)
echo 'Miesiąc <b>' . htmlspecialchars((string)$m_param, ENT_QUOTES, 'UTF-8') . '</b>'; 
?>
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
<?php				
$get_rok = $_GET['rok'] ?? '';
$get_m   = $_GET['m']   ?? 0;

// Budujemy klasę CSS
$active_class = ($get_m == 1) ? ' active' : '';
$active_class = ($get_m == 2) ? ' active' : '';
$active_class = ($get_m == 3) ? ' active' : '';
$active_class = ($get_m == 4) ? ' active' : '';
$active_class = ($get_m == 5) ? ' active' : '';
$active_class = ($get_m == 6) ? ' active' : '';
$active_class = ($get_m == 7) ? ' active' : '';
$active_class = ($get_m == 8) ? ' active' : '';
$active_class = ($get_m == 9) ? ' active' : '';
$active_class = ($get_m == 10) ? ' active' : '';
$active_class = ($get_m == 11) ? ' active' : '';

// Wyświetlamy link (używając htmlspecialchars dla bezpieczeństwa URL)
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=1" class="dropdown-item' . $active_class . '">Styczeń</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=2" class="dropdown-item' . $active_class . '">Luty</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=3" class="dropdown-item' . $active_class . '">Marzec</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=4" class="dropdown-item' . $active_class . '">Kwiecień</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=5" class="dropdown-item' . $active_class . '">Maj</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=6" class="dropdown-item' . $active_class . '">Czerwiec</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=7" class="dropdown-item' . $active_class . '">Lipiec</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=8" class="dropdown-item' . $active_class . '">Sierpień</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=9" class="dropdown-item' . $active_class . '">Wrzesień</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=10" class="dropdown-item' . $active_class . '">Pazdziernik</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=11" class="dropdown-item' . $active_class . '">Listopad</a>';
echo '<a href="zestawienie.php?rok=' . htmlspecialchars((string)$get_rok) . '&m=12" class="dropdown-item' . $active_class . '">Grudzień</a>';
?>
		</ul>
		
	</div>
	
</div>


			
			
<?php
$miesiace = [
    1 => 'Styczeń', 2 => 'Luty', 3 => 'Marzec', 4 => 'Kwiecień',
    5 => 'Maj', 6 => 'Czerwiec', 7 => 'Lipiec', 8 => 'Sierpień',
    9 => 'Wrzesień', 10 => 'Październik', 11 => 'Listopad', 12 => 'Grudzień'
];

// PHP 8.4: Bezpieczne pobranie numeru miesiąca z adresu URL
$nr_miesiaca = isset($_GET['m']) ? (int)$_GET['m'] : 0;

// Przypisanie nazwy lub domyślny tekst, jeśli parametr jest błędny
$miesiac = $miesiace[$nr_miesiaca] ?? 'Nieokreślony';

if(!isset($_GET['m']) AND !isset($_GET['t'])){
//---------------------------------------Pokazuje wykres ROKU (miesiące)

	include('inc/odczyt-stat/zestawienie-rok.php');
	
}else{
//---------------------------------------Pokazuje wykres MIESIECZNY (dni)

	include('inc/odczyt-stat/zestawienie-miesiac.php');
}
?>

	<hr />
	
<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Co znaczą te dane ?
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Dane zawarte w powyższej tabeli wskazują ilość Wizyt i Odsłon w wybranym roku i w miesiącu. Dane ilości Wizyt i Odsłon przedstawiono w jednej tabeli, ponieważ z takiego zestawienia można szybciej wyciągnąć wnioski.
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
