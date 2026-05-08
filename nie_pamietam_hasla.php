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
		
		include('inc/index.php');

	}else{		
?>

<?php
if (!isset($haslo)){
?>


   <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

	<div class="jumbotron border">
		<div class="img-rounded postep_0">
			<p class="lead">Jeśli nie pamiętasz hasła do Systemu, nic się nie martw, podaj Swój Login, a system automatycznie wygeneruje Nowe Hasło, po zalogowaniu będzie można je zmienić na inne w dziale: <b>System/Zmiana Hasła</b>.</p>
		</div>
	</div>

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Nie pamiętam hasła</h1>
                  </div>

					<form action="nie_pamietam_hasla.php" method="post">
						<fieldset class="border p-2">
						
							<legend class="w-auto"><i class="fas fa-lock"></i> podaj swój login</legend>
						<div class="form-group">
							<label for="login"> Login</label>
							<input type="password" class="form-control" id="login" name="l" placeholder="podaj Swój Login" required>
						</div>

						<div class="checkbox">
							
						</div>
						</fieldset>
						
						<fieldset class="border tblFooters">
							<button type="submit" name="wyslij_5" class="btn btn-primary btn-block my-4">Wyślij</button>
						</fieldset>
					</form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

<?php
}else{
?>
	<div class="jumbotron border">
		<div class="img-rounded postep_0">
			<p class="lead">Nowe Hasło to: <strong><?php echo $haslo; ?></strong> po zalogowaniu będzie można je zmienić na inne w dziale: <b>System/Zmiana Hasła</b>.</p>
		</div>
	</div>
<?php
}
?>

<?php
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
