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
		<h1 class="h3 mb-0 text-gray-800">Odsłony <small><?php echo 'Rok: '.$_GET['rok']; ?></small></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Zebrane Dane</h6>
		</div>
		<div class="card-body">

<div class="row">
<div class="col-sm">
	<div class="btn-group" role="group" aria-label="...">

		<div class="btn-group" role="group">
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php 
					// PHP 8.4: Bezpieczne pobranie roku z GET lub ustawienie bieżącego
					$wybrany_rok = $_GET['rok'] ?? date('Y');
					echo 'Rok <b>' . htmlspecialchars((string)$wybrany_rok) . '</b>'; 
				?>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<?php
					// Pobieramy listę lat z bazy danych
					$stmt = $db->query("SELECT * FROM `lata_kal` ORDER BY `lata_kal`.`lata` ASC");

					if ($stmt) {
						while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
							$rok_z_bazy = $wiersz['lata'];
							
							// PHP 8.4: Sprawdzamy aktywność roku bez generowania Warning
							$czy_aktywny = ($rok_z_bazy == $wybrany_rok) ? ' active' : '';
							
							echo '<a href="odslony.php?rok=' . $rok_z_bazy . '" class="dropdown-item' . $czy_aktywny . '">' . $rok_z_bazy . '</a>';
						}
					}
				?>
			</ul>
		</div>
				
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php 
					// PHP 8.4: Bezpieczne pobranie parametrów z GET
					$m_get = $_GET['m'] ?? date('n');
					$rok_get = $_GET['rok'] ?? date('Y');
					
					// Tablica pomocnicza do wyświetlenia nazwy w przycisku
					$miesiace_nazwy = [
						1 => 'Styczeń', 2 => 'Luty', 3 => 'Marzec', 4 => 'Kwiecień',
						5 => 'Maj', 6 => 'Czerwiec', 7 => 'Lipiec', 8 => 'Sierpień',
						9 => 'Wrzesień', 10 => 'Październik', 11 => 'Listopad', 12 => 'Grudzień'
					];
					
					$nazwa_aktualna = $miesiace_nazwy[(int)$m_get] ?? 'Wybierz';
					echo 'Miesiąc <b>' . htmlspecialchars($nazwa_aktualna) . '</b>'; 
				?>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<?php
					// PHP 8.4: Generowanie linków w pętli - czyściej i bezpieczniej
					foreach ($miesiace_nazwy as $nr => $nazwa) {
						// Sprawdzamy czy dany miesiąc jest aktualnie wybrany
						$active = ($m_get == $nr) ? ' active' : '';
						
						// Budujemy link używając bezpiecznych zmiennych
						echo '<a href="odslony.php?rok=' . htmlspecialchars((string)$rok_get) . '&m=' . $nr . '" class="dropdown-item' . $active . '">' . $nazwa . '</a>';
					}
				?>
			</ul>
		</div>
		
	</div>
</div>	
	
	<div class="col-sm" style="margin-top: 5px; margin-bottom: 5px;">
		<form action="" class="form-inline" method="post">

				<div class="form-group row">
					<label for="inputWykres" class="col-sm col-form-label d-none d-md-block text-muted">wykres</label>
					
					<div class="col-sm">
						<select name="rodz_wykresu" id="inputWykres" class="form-control form-control-sm">
							<option value="bar" <?php if($_SESSION['sesja_uzyt']['wykres'] == 'bar'){echo 'selected';} ?>>Bar</option>
							<option value="line" <?php if($_SESSION['sesja_uzyt']['wykres'] == 'line'){echo 'selected';} ?>>Line</option>
							<option value="radar" <?php if($_SESSION['sesja_uzyt']['wykres'] == 'radar'){echo 'selected';} ?>>Radar</option>
							<option value="polarArea" <?php if($_SESSION['sesja_uzyt']['wykres'] == 'polarArea'){echo 'selected';} ?>>Polar Area</option>
						</select>
					</div>
				</div>

				 <div class="form-group row">
					<div class="col-sm" style="margin-left: 5px; margin-right: 5px;">
						<button type="submit" name="wyslij_wykres" class="btn btn-primary btn-sm">zmień wykres</button>
					</div>
				 </div>

		</form>
	</div>
</div><!-- /row -->
	
<?php
if(!isset($_GET['m']) AND !isset($_GET['t'])){
//---------------------------------------Pokazuje wykres ROKU (miesiące)

	include('inc/odczyt-stat/odslony-rok.php');
	
}else{
//---------------------------------------Pokazuje wykres MIESIECZNY (dni)

	include('inc/odczyt-stat/odslony-miesiac.php');
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
