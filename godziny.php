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
		<h1 class="h3 mb-0 text-gray-800">Godziny <small></small></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Zebrane Dane</h6>
		</div>
		<div class="card-body">
	
		<div class="mx-auto" style="width: 315px;">
		<div class="col-sm" style="margin-top: 5px; margin-bottom: 5px;">
			<form action="" class="form-inline" method="post">

					<div class="form-group row">
						<label for="inputWykres" class="col-sm-2 col-form-label text-muted">wykres</label>
						
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
						<div class="col-sm">
							<button type="submit" name="wyslij_wykres" class="btn btn-primary btn-sm">zmień wykres</button>
						</div>
					 </div>

			</form>
		</div>
		</div>

	
<?php
//--- dolaczenie plikow
	include('inc/odczyt-stat/godziny.php');
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
