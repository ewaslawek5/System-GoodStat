<?php
//--- dolaczenie plikow
	include('funkcje/funkcje.php');
	include("inc/sesje.php");
	include('class/Mailer_GoodStat.class.php');
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

	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">


		<!-- Main Content -->
		<div id="content">

<?php
//--- dolaczenie plikow
	include('inc/menu_gora.php');
?>

		</div>












<div class="container tresc">

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h1 mb-0 text-gray-800"><img src="images/favicon/android-icon-72x72.png" /> Instalacja Systemu GoodStat</h1>
	</div>
	
  <div class="row">
	<div class="col-md-12">
		
	</div>
  </div>
	
	<div class="card shadow mb-4">
		<div class="card-body">
	
<div class="row my-2">

	<div class="col-sm-4">
		<div class="card text-white bg-success">
			<div class="card-body">
				<h3 class="card-title">1 - Zbieranie Informacji</h3>
					<p class="card-text">Dane niezbędne do prawidłowego działania Systemu GoodStat.</p>
			</div>
		</div>
	</div>

	<div class="col-sm-4">
		<div class="card text-white bg-success">
			<div class="card-body">
				<h4 class="card-title">2 - Baza Danych</h4>
					<p class="card-text">Czynności związane z bazą danych. Pamiętaj żeby utworzyć na swoim serwerze bazę danych dla Systemu GoodStat.</p>
			</div>
		</div>
	</div>
	
	<div class="col-sm-4">
<?php
	if(isset ($_POST['wyslij3'])){
		include('instalacja/baza_danych.php');
	}
	
	// PHP 8.4: Sprawdzamy stan zmiennej bezpiecznie
	// Jeśli $problem nie jest ustawiony, przyjmujemy false (brak problemu)
	if (($problem ?? false) == true) { 
		echo '<div class="card text-white bg-danger">'; 
	} else { 
		echo '<div class="card text-white bg-success">'; 
	}
?>
			<div class="card-body">
				<h4 class="card-title">3 - Wynik Instalacji</h4>
					<p class="card-text">Wynik instalacji i czynności konfiguracyjne System GoodStat.</p>
			</div>
		</div>
	</div>

</div>
	
<?php
	$zarejestrowany = 'nie';

	if (isset ($_POST['wyslij2'])){

		$problem = FALSE;
		
				//sprawdzenie czy wypelniono pola
				if (empty($_POST['adres_bazy'])){
					$problem = TRUE;	$problem_adres_bazy = 'tak';					
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> Podaj nazwę serwera swojej Bazy Danych</div>';
				}
				
				if (empty ($_POST['login_bazy'])){
					$problem = TRUE; 	$problem_login_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> Podaj login Bazy Danych</div></div>';
				}				
				if (empty($_POST['nazwa_bazy'])){
					$problem = TRUE;	$problem_nazwa_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> Podaj nazwę Bazy Danych</div></div>';
				}
				
				//sprawdzenie dlugosci danych
				if (strlen($_POST['adres_bazy']) > 250){
					$problem = TRUE;	$problem_adres_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> W polu: Nazwa serwera Bazy Danych jest za dużo znaków, max 250.</div></div>';
				}
				if (strlen($_POST['login_bazy']) > 150){
					$problem = TRUE;	$problem_login_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> W polu: Nazwa Użytkownika jest za dużo znaków, max 150.</div></div>';
				}
				if (strlen($_POST['haslo_bazy']) > 200){
					$problem = TRUE;	$problem_haslo_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> W polu: Hasło jest za dużo znaków, max 200.</div></div>';
				}
				if (strlen($_POST['nazwa_bazy']) > 200){
					$problem = TRUE;	$problem_nazwa_bazy = 'tak';
					echo'<div style="display: block;"><div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fas fa-exclamation-triangle"></i> W polu: Nazwa Bazy Danych jest za dużo znaków, max 200.</div></div>';
				}
						
			if (!$problem){
				
							$uruchom_alert = 'tak'; 
							$rodzaj_alert = 'info';
							$tresc_info = 'Jeśli dane Bazy Danych są prawidłowe - Przejdź dalej';
						
				$zarejestrowany = 'tak';
			}
//--- dolaczenie plikow
	include('inc/pole_alerts.php');
	}
		
?>





<?php

	if(isset ($_POST['wyslij3'])){

		$problem = FALSE;				
		
		//########## sprawdzenie BD
		include('instalacja/baza_danych.php');
		
			if (!$problem){
				
				//########## instalacja
				include('instalacja/tabele.php');

					if ($wp = fopen ("config.php",'w+')){

						$dane = 
						'<?php ' .		"\r\n"	.
							'error_reporting(E_ALL & ~E_NOTICE);'	.	"\r\n \r\n"	.
							'//##### glowne parametry strony'		.	"\r\n"		.
							'define(\'ADRES_BAZY\', '				.	'\'' 		. 	$_POST['adres_bazy'] 	. '\''	.	'); '	.	"\r\n"	.
							'define(\'LOGIN_BAZY\', '				.	'\'' 		. 	$_POST['login_bazy'] 	. '\''	.	'); '	.	"\r\n"	.
							'define(\'HASLO_BAZY\', '				.	'\'' 		. 	$_POST['haslo_bazy'] 	. '\''	.	'); '	.	"\r\n"	.
							'define(\'NAZWA_BAZY\', '				.	'\'' 		. 	$_POST['nazwa_bazy'] 	. '\''	.	'); '	.	"\r\n"	.
							'define(\'ADRES_STR\', '				.	'\'' 		. 	$_POST['adres_str'] 	. '\''	.	'); '	.	"\r\n";

		
						//zapis danych i zamkniecie pliku
						fwrite ($wp, $dane);
						fclose ($wp);

					}
					
	//wyslanie maila
	include('inc/email_instalacja.php');
				
					echo'
						<div class="container"><div class="alert px-3 py-3 bg-gradient-success text-white fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Sukces!</strong> Instalacja Systemu GoodStat przebiegła pomyślnie</div></div>';
?>
						
	<script type="text/javascript">
		function selectText_txt1() {
			var oTextbox1 = document.getElementById("txt1");
			oTextbox1.focus();
			oTextbox1.select();
		}
	</script>
	
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
	$do_kodu_java = $_SERVER['SERVER_NAME'].''.str_replace("index_3.php","zapis",$_SERVER['SCRIPT_NAME']);
	$do_kodu_java = $protocol.''.$do_kodu_java;
//======== do kodu JAVASCRIPT
?>
	
<?php
echo"
<div class='row'>

	<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
	
	<div class='d-sm-flex align-items-center justify-content-between mb-4'>
		<h1 class='h2 mb-0 text-gray-800'><img src='images/favicon/android-icon-72x72.png' /> Kod JavaScript do wklejenia na Twoją stronę:</h1>
	</div>

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

	</div>
	
	<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
		<div class='d-sm-flex align-items-center justify-content-between mb-4'>
			<h1 class='h2 mb-0 text-gray-800'><img src='images/favicon/android-icon-72x72.png' /> Co dalej ?</h1>
		</div>

		<ul>
			<li><span class='glyphicon glyphicon-hand-left'></span> Zaznacz dokładnie cały kod JavaScript aby go skopiowaći i wklej na każdą podstronę, którą chcesz monitorować, kod wklej na początku sekcji <strong>&lt;BODY&gt;</strong>.</li>
			<li>Pierwsze analizy z monitoringu Twojej strony internetowej, widoczne będą natychmiast po wklejeniu kodu JavaScript.</li>
			<li>Dostęp do kodu JavaScript będzie również dostępny po zalogowaniu do systemu GoodStat w dziale: \"<strong>Ustawienia/Kod JavaScript</strong>\".</li>
		</ul>
		
		<input type='button' class='btn btn-secondary js-textareacopybtn' value='Zaznacz żeby skopiować kod JavaScript' onclick='selectText_txt1()' />
	</div>
	
			<div class='col-md-12'>
				<div class='img-rounded' style='padding: 0px 50px; margin: 15px 0 15px 0;'>
					
					<a href='index.php' class='btn btn-primary btn-lg btn-block'>MOŻESZ SIĘ TERAZ ZALOGOWAĆ <span class='glyphicon glyphicon-triangle-right'></span></a>
					
				</div>
			</div>

</div>
";

						
			}else{
					echo' 
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign"></span> <strong>Błąd!</strong> Coś poszło Źle - system Goodstat nie został zainstalowany!
						</div>
						
	<div class="container my-4">
	  <div class="row">
		<div class="col-md-12">
			
				<a class="btn btn-primary btn-lg btn-block" href="index.php" role="button"><span class="icon text-white-60"><i class="fas fa-caret-left"></i></span> POWTÓRZ INSTALACJĘ</a>
			
		</div>
	  </div>
	</div>	
						';
			}
	}
		
?>


	


<?php
echo'
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h2 mb-0 text-gray-800"><img src="images/favicon/android-icon-72x72.png" /> Baza Danych</h1>
	</div>

<table class="table">
	<tbody>
    <tr>
		<td scope="row">nazwa serwera</td>
		<th>'.$_POST['adres_bazy'].'</th>
    </tr>
    <tr>
		<td scope="row">login bazy</td>
		<th>'.$_POST['login_bazy'].'</th>
    </tr>
    <tr>
		<td scope="row">hasło bazy</td>
		<th>'.$_POST['haslo_bazy'].'</th>
    </tr>
    <tr>
		<td scope="row">nazwa bazy</td>
		<th>'.$_POST['nazwa_bazy'].'</th>
    </tr>

  </tbody>
</table>
';
?>















<?php
echo'
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h2 mb-0 text-gray-800"><img src="images/favicon/android-icon-72x72.png" /> Zebrane Dane</h1>
	</div>

<table class="table">
	<tbody>
    <tr>
		<td scope="row">e-mail</td>
		<th>'.$_POST['email'].'</th>
    </tr>
    <tr>
		<td scope="row">login</td>
		<th>'.$_POST['login'].'</th>
    </tr>
    <tr>
		<td scope="row">hasło</td>
		<th>'.$_POST['haslo1'].'</th>
    </tr>
    <tr>
		<td scope="row">adres strony www</td>
		<th>'.$_POST['adres_str'].'</th>
    </tr>
    <tr>
		<td scope="row">akceptacja regulaminu</td>
		<th>tak</th>
    </tr>

  </tbody>
</table>';
?>

</div>


















    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

</div>
</div>

<?php
//--- dolaczenie plikow
	include('inc/stopka_bootstrap.php');
?>

</body>

</html>
