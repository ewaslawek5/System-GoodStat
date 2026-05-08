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
		<h1 class="h3 mb-0 text-gray-800">Sekcja <small>Head</small></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-body">



<?php

	$result = getUrlData(ADRES_STR);
?>
<div class="row">
	<div class="col-sm-6">
		<div class="card mb-3">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">title</h6>
			</div>
			<div class="card-body">
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><?php echo $result['title'].' <small class="text-muted">- ilość znaków: '; if((strlen($result['title']) > 10) AND (strlen($result['title']) < 70)){ echo ''.strlen($result['title']).' - </small> <span class="badge badge-success">OK</span>'; }else{ echo ''.strlen($result['title']).' - </small> <span class="badge badge-danger">NIE OK!</span>'; } ?></li>
					<li class="list-group-item"><small class="text-muted">Optymalna ilość znaków dla TITLE wraz ze spacjami powinna wynosić od 10 do 70 znaków.</small></li>
				</ul>
			</div>
		</div>
	</div>

<?php
	foreach ( $result['metaTags'] as $zmienne_head => $zmi_head )
	{
		echo '<div class="col-sm-6">';
		echo '<div class="card mb-3">';
		echo '<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">' . $zmienne_head . '</h6></div>';
		echo '<div class="card-body">';
		echo '<ul class="list-group list-group-flush">';

			echo '<li class="list-group-item">' . $result['metaTags'][$zmienne_head]['value']; if($zmienne_head == 'description'){ echo'<small class="text-muted">- ilość znaków: '; if((strlen($result['metaTags']['description']['value']) > 70) AND (strlen($result['metaTags']['description']['value']) < 320)){ echo ''.strlen($result['metaTags']['description']['value']).' - </small> <span class="badge badge-success">OK</span>'; }else{ echo ''.strlen($result['metaTags']['description']['value']).' - </small><span class="badge badge-danger">NIE OK!</span>'; } } echo'</li>';
			
			if($zmienne_head == 'description'){ echo'<li class="list-group-item"><small class="text-muted">Optymalna ilość znaków dla DESCRIPTION wraz ze spacjami powinna wynosić od 70 do 320 znaków.</small></li>'; }
		
		echo'</ul>';
		
		echo'</div>';
		echo'</div>';
		echo'</div>';
	}
?>
</div>

	<hr />
<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> O sekcji HEAD
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Sekcja HEAD, to sekcja nagłówkowa dokumentu, chociaż niewidoczna na stronie, pełni bardzo ważną funkcję informacyjną dla wyszukiwarek, ma też ważne znaczenie dla pozycjonowania strony, jest nagłówkiem w dokumencie HTML lub XHTML. Pomiędzy otwierającym i zamykającym znacznikiem HEAD znajduje się prolog dokumentu. Zwykle jest to kilka znaczników, przede wszystkim tytuł strony, informacje o autorze strony, kodowaniu i instrukcje dla przeglądarki oraz wyszukiwarek.
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
