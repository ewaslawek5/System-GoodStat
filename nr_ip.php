<?php
//--- dolaczenie plikow
if(file_exists('config.php')) {
	include('config.php');
	include('inc/baza_polacz.php');
}
	include('funkcje/funkcje.php');
	include('funkcje/funkcje_odczytu.php');
	include("inc/sesje.php");
	
//######## STRONNICOWANIE
function wskaznik($strona, $liczba_stron)
{
    $wynik = "<span class='text-muted small'><center>strona $strona/$liczba_stron</center></span><nav aria-label='Page navigation example'><ul class='pagination justify-content-center'>";

    if ($strona > 1) {
		$wynik .= " <li class='page-item'><a class='page-link' href='nr_ip.php?strona=1'><i class='fas fa-angle-double-left'></i></a></li> ";
    } else {
        $wynik .= " <li class='page-item disabled'><a class='page-link' href='' tabindex='-1' aria-disabled='true'><i class='fas fa-angle-double-left'></i></a></li>  ";
    }

    $poprzednia = $strona - 1;
    if ($poprzednia > 0) {
        $wynik .= " <li class='page-item'><a class='page-link' href='nr_ip.php?strona=$poprzednia'><i class='fas fa-angle-left'></i></a></li> ";
    } else {
        $wynik .= " <li class='page-item disabled'><a class='page-link' href=''><i class='fas fa-angle-left'></i></a></li> ";
    }

    $nastepna = $strona + 1;
    if ($nastepna <= $liczba_stron) {
        $wynik .= " <li class='page-item'><a class='page-link' href='nr_ip.php?strona=$nastepna'><i class='fas fa-angle-right'></i></a></li> ";
    } else {
        $wynik .= " <li class='page-item disabled'><a class='page-link' href=''><i class='fas fa-angle-right'></i></a></li> ";
    }

    if ($strona < $liczba_stron) {
        $wynik .= " <li class='page-item'><a class='page-link' href='nr_ip.php?strona=$liczba_stron'><i class='fas fa-angle-double-right'></i></a></li> ";
    } else {
        $wynik .= " <li class='page-item disabled'><a class='page-link'><i class='fas fa-angle-double-right'></i></a></li> ";
    }
    
   $wynik .= "</ul></nav>";
    return $wynik;

}
?>
<!DOCTYPE html>
<html lang="pl">

<head>

<?php	
//--- dolaczenie plikow
	include('inc/head.php');
?>
	<!-- datepicker kalendarz -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	 
	
	<script>
	  $(function() {
		$( "#data_ip" ).datepicker({dateFormat: "d-m-yy", duration: 300, showWeek: false, dayNamesMin: ["Nd", "Pn", "Wt", "Śr", "Cz", "Pt", "Sb"], monthNames: [ "Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień" ], showAnim: "slideDown" });
	  });
	</script>
	<!--/ datepicker kalendarz -->
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
		<h1 class="h3 mb-0 text-gray-800">Numery IP</h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Wskaż Dzień</h6>
		</div>
		<div class="card-body">

		
		
	
		
		
		
	<form action="nr_ip.php" method="get" class="form-inline">
	
		<div class="row">
			<div class="form-group">
				<label for="data_ip" class="col-md-2 col-form-label"><i class="far fa-calendar-alt"></i></label>
				<div class="col-md-6">
					<input type="text" class="form-control input-sm" id="data_ip" name="data_ip" placeholder="d-m-rrrr" required>
				</div>
			</div>
		
			<div class="form-group">
				<div class="col-md-4">
					<button type="submit" class="btn btn-primary btn-sm" name="wyslij" title="Pokaż wejścia dla nr IP w wybranym dniu">wyślij</button>
				</div>  
			</div>
		</div>

	</form>

	<hr />
	
<?php
if(isset($_GET['data_ip'])){
	
// PHP 8.4: Sprawdzamy czy parametr data_ip istnieje, jeśli nie - używamy dzisiejszej daty
$data_wejsciowa = $_GET['data_ip'] ?? date('Y-m-d');

try {
    // Inicjalizacja obiektu daty
    $dni_w_tygodniu = new DateTime((string)$data_wejsciowa);
} catch (Exception $e) {
    // W razie błędnego formatu w URL, ustawiamy datę bieżącą, aby skrypt działał dalej
    $dni_w_tygodniu = new DateTime();
}

$rok        = $dni_w_tygodniu->format("Y"); // rok
$miesiac    = $dni_w_tygodniu->format("n"); // miesiac 1-12
$dzien_mies = $dni_w_tygodniu->format("j"); // dzien miesiaca 1-31
$dzien_tyg  = $dni_w_tygodniu->format("w"); // dzien tygodnia jako cyfra 0 to niedziela
// $data_unix = $dni_w_tygodniu->format("U"); // Sekundy liczone od ery UNIX-a
$dzien_roku = $dni_w_tygodniu->format("z"); // Dzień roku (0 aż do 365)
$nr_tyg     = $dni_w_tygodniu->format("W"); // Numer tygodnia w roku

// Logika zamiany cyfry na nazwę dnia - bez zmian
if($dzien_tyg == 0){$dzien_tyg = 'Niedziela';}else
if($dzien_tyg == 1){$dzien_tyg = 'Poniedziałek';}else
if($dzien_tyg == 2){$dzien_tyg = 'Wtorek';}else
if($dzien_tyg == 3){$dzien_tyg = 'Środa';}else
if($dzien_tyg == 4){$dzien_tyg = 'Czwartek';}else
if($dzien_tyg == 5){$dzien_tyg = 'Piątek';}else
if($dzien_tyg == 6){$dzien_tyg = 'Sobota';}

// PHP 8.4: Bezpieczne wyświetlanie wartości z $_GET
echo '<p class="lead text-right"><b>Odsłony</b> nr.IP dla dnia: <b>' . htmlspecialchars((string)($_GET['data_ip'] ?? $data_wejsciowa)) . '</b></p>';
	
//-------------------------------------------------------------------
//STRONNICOWANIE
	$p = array(); //zainiciowanie tablicy $p
	$stmt = $db->query("SELECT * FROM ".$rok."_nr_ip WHERE dzien_roku='".$dzien_roku."' AND dzien='".$dzien_mies."' AND miesiac='".$miesiac."'");
	// PHP 8.4: Poprawiona pętla z weryfikacją istnienia klucza
		while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
			// Sprawdzamy, czy klucz 'id' istnieje. Jeśli nie, szukamy 'nr_ip' lub przypisujemy null.
			$id_art = $wiersz['id'] ?? $wiersz['nr_ip'] ?? null; 
			
			if ($id_art !== null) {
				$p[] = $id_art;
			}
		}

	$liczba_rekordow = count($p); 	//liczba wszystkich rekordow
	$rekordow_na_stronie = 20;		//liczba rekordow na stronie
	
	$liczba_stron = (int) (($liczba_rekordow + $rekordow_na_stronie - 1) / $rekordow_na_stronie);

	if (isset($_GET['strona']) && str_ievpifr($_GET['strona'], 1, $liczba_stron)) {
		$strona = $_GET['strona'];
	}else{
		$strona = 1;
	}
	
	$start = ($strona - 1) * $rekordow_na_stronie;
	
	echo'
	<div class="table-responsive">
		<table class="table table-striped small table-sm">
		<tr>
			<th>nr. IP</th> <th>odsłony</th> <th>wykres</th> <th>ostatnio widziany</th> <th>dzień tygodnia</th> <th>nr.tyg</th> <th>dzień roku</th> 
		</tr>';
		
//szukanie NAJ
	$stmt = $db->query("SELECT * FROM ".$rok."_nr_ip WHERE dzien_roku='".$dzien_roku."' AND dzien='".$dzien_mies."' AND miesiac='".$miesiac."' ORDER BY ".$rok."_nr_ip.ods DESC LIMIT 1");

		while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
			$naj				= $wiersz['ods'];
		}
//end szukanie NAJ
	
	$stmt = $db->query("SELECT * FROM ".$rok."_nr_ip WHERE dzien_roku='".$dzien_roku."' AND dzien='".$dzien_mies."' AND miesiac='".$miesiac."' ORDER BY ".$rok."_nr_ip.ods DESC LIMIT $start ,$rekordow_na_stronie");
		
	if($stmt->rowCount() > 0){
		while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
			$nr_ip				= $wiersz['nr_ip'];
			$ods				= $wiersz['ods'];
			$data_utw			= $wiersz['data_utw'];	$data_utw = date('d-m-Y, H:i:s', $data_utw);
			
				if($ods != 0){
					// obliczanie wysokosci slupka
					$szer = ($ods / $naj) * 100; $szer = round($szer, 0);
				}else{$szer = 1;}
			
			echo'
			<tr>
				<td class="text-muted">'.$nr_ip.'</td> <td><span class="label-dane">'.$ods.'</span></td> <td><div class="progress"><div class="progress-bar" role="progressbar" style="width: '.$szer.'%;">'.$ods.' ods.</div></div></td> <td class="text-muted">'.$data_utw.'</td> <td class="text-muted">'.$dzien_tyg.'</td> <td class="text-muted">'.$nr_tyg.'</td> <td class="text-muted">'.$dzien_roku.'</td>
			</tr>';			
		}//end while

	}else{
			echo'
			<tr>
				<td colspan="7" class="text-muted"><span class="label-dane"> - w dniu: <b>'.$_GET['data_ip'].'</b> brak wejść na stronie - </span></td>
			</tr>';	
	}
	
	echo'
		</table>
	</div>';

			echo'<hr />';
			echo wskaznik($strona, $liczba_stron);	//stronnicowanie
			echo'<hr />';
}

?>

<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Numer IP - Co to znaczy ?
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Numer IP to numeryczny identyfikator serwera podłączonego do sieci o protokole TCP/IP. Adres jest ciągiem liczb od 0 do 255, oddzielonych kropkami np. 36.192.55.234. Dzięki temu narzędziu dowiemy się o ilości odsłon w wybranym dniu dla poszczególnych Nr.Ip odwiedzających stronę monitorowaną.
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

    <!-- datepicker kalendarz -->
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<!--/ datepicker kalendarz -->

</body>

</html>
