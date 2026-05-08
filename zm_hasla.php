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
		<h1 class="h3 mb-0 text-gray-800">Zmiana Hasła</h1>
	</div>
		
          <div class="card shadow mb-4">
            <div class="card-body">
		
		<div class="row justify-content-md-center my-1">
			<div class="col-md-4">
				
				<form action="zm_hasla.php" method="post">
					<fieldset class="border p-2">
					
						<legend class="w-auto">formularz zmiany hasła</legend>
					<div class="form-group">
						<label for="login">Login</label>
						<?php echo '<span class="text-success">'.$_SESSION['sesja_uzyt']['zalogowany'].'</span>'; ?>
					</div>
					<div class="form-group">
						<label for="stare_haslo">stare hasło</label>
						<input type="password" class="form-control" id="stare_haslo" name="stare_haslo" placeholder="stare hasło" required>
					</div>
					<div class="form-group">
						<label for="nowe_haslo">nowe hasło</label>
						<input type="password" class="form-control" id="nowe_haslo" name="nowe_haslo" placeholder="nowe hasło" required>
					</div>
					<div class="form-group">
						<label for="nowe_haslo2">powtórz hasło</label>
						<input type="password" class="form-control" id="nowe_haslo2" name="nowe_haslo2" placeholder="powtórz hasło" required>
					</div>

					</fieldset>
					
					<fieldset class="border tblFooters">
						<button type="submit" name="wyslij_1" class="btn btn-primary btn-lg btn-block my-4">Wyślij</button>
					</fieldset>
					
				</form>
				
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
