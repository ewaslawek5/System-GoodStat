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
		<h1 class="h3 mb-0 text-gray-800">Kod Java-Script <small>do wklejenia</small></h1>
	</div>

<?php
define("SERVER_PROTOCOL",$_SERVER["SERVER_PROTOCOL"]);
define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"]);
define("HOST",$_SERVER['HTTP_HOST']);
define("SELF", '/'.implode(
    '/',
    array_slice(
        explode('/', trim($_SERVER['REQUEST_URI'])),1)
    )
);

function site_protocol() {
    if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	{	return $protocol = 'https://';	}else{	return $protocol = 'http://';	}
}

$protocol = site_protocol();
?>
<?php
//======== do kodu JAVASCRIPT
	$do_kodu_java = $_SERVER['SERVER_NAME'].''.str_replace("kod_javascript.php","zapis",$_SERVER['SCRIPT_NAME']);
	$do_kodu_java = $protocol.''.$do_kodu_java;
//======== do kodu JAVASCRIPT
?>

	<script type="text/javascript">
		function selectText_txt1() {
			var oTextbox1 = document.getElementById("txt1");
			oTextbox1.focus();
			oTextbox1.select();
		}
	</script>


          <div class="card shadow mb-4">

            <div class="card-body">


	<!-- Content Row -->
	<div class="row">
		  
		<div class="col-lg-6">

			<!--  -->
             <div class="card mb-3">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Ten kod skopiuj i wklej na stronę monitorowaną</h6>
                </div>
                <div class="card-body">
<?php
echo"
<pre>
<textarea rows='11' cols='30' id='txt1' class='form-control small'>
<!-- start System GoodStat -->
<script language='javascript'>
<!--
var ipath='$do_kodu_java'
document.write('<SCR' + 'IPT LANGUAGE=\"JavaScript\" SRC=\"'+ ipath +'/stat.js\"><\/SCR' + 'IPT>');
//-->
</script>
<!-- stop System GoodStat -->
</textarea>
</pre>
";
?>	
                </div>
			</div>
			  
		</div>

		<div class="col-lg-6">

			<!--  -->
             <div class="card mb-3">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">O kodzie JavaScript</h6>
                </div>
                <div class="card-body">
				
					<ul>
						<li>Kod JavaScript na Twojej stronie jest niezbędny, ponieważ za jego pomocą System GoodStat zlicza i zapisuje statystyki. Bez tego kodu, nie będą zliczane statystyki wejść Twojej strony internetowej.</li>
						<li><span class='glyphicon glyphicon-hand-left'></span> Zaznacz dokładnie cały kod JavaScript aby go skopiować i wklej na każdą podstronę którą chcesz monitorować, kod wklej na początku sekcji <strong>&lt;BODY&gt;</strong>.</li>
						<li>Pierwsze analizy z monitoringu Twojej strony internetowej, widoczne będą natychmiast po wklejeniu kodu JavaScript.</li>						
					</ul>
					<hr />
					<input type='button' class='btn btn-primary js-textareacopybtn' value='Zaznacz żeby skopiować kod JavaScript' onclick='selectText_txt1()' />
					<br /><br />
				
                </div>
			</div>
			  
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
