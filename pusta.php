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

<!-- start System GoodStat -->
<script language='javascript'>
<!--
var ipath='http://localhost/www/statystyki_goodstat_com_pl/goodstat_2/zapis'
document.write('<SCR' + 'IPT LANGUAGE="JavaScript" SRC="'+ ipath +'/stat.js"><\/SCR' + 'IPT>');
//-->
</script>
<!-- stop System GoodStat -->



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
		<h1 class="h3 mb-0 text-gray-800">Strona Testowa</h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Tytuł_Okienka</h6>
		</div>
		<div class="card-body">

		

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
