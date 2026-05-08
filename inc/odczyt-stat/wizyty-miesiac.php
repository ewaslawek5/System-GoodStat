<?php
	//szukania najwiecej wizyt w miesiacu
	szukaj_naj($_GET['rok'].'_wiz_ods', 'wiz', $_GET['m'], $_GET['rok']);
	$dane = array(); //zainicjowanie tablicy bez wartosci
	szukaj_danych($_GET['rok'].'_wiz_ods', 'wiz', $_GET['m'], $_GET['rok']); //wymikiem jest tablica $dane
	
	// PHP 8.4: Bezpieczne pobranie parametrów z URL lub podstawienie bieżących wartości
	$get_rok = $_GET['rok'] ?? date('Y');
	$get_m   = $_GET['m']   ?? date('n');

	// Tworzymy obiekt daty korzystając z zabezpieczonych zmiennych
	// Dodajemy rzutowanie (string), aby format daty był zawsze poprawny
	$dni_w_miesiacu = new DateTime((string)$get_rok . '-' . (string)$get_m . '-01');

	$ilosc_dni = $dni_w_miesiacu->format("t"); // ilość dni w miesiącu

$suma_wartosci = 0;
    
    // PHP 8.4: count() działa tak samo, ale upewniamy się, że $dane jest tablicą
    $ile_elementow = count((array)$dane);
    
	for($a=0; $a < $ile_elementow; $a++){
        $wartosc = $dane[$a]; 
        $suma_wartosci = $suma_wartosci + $wartosc;
    }

    // PHP 8.4: Zabezpieczenie przed dzieleniem przez zero
    if($ilosc_dni > 0){
        $sr = $suma_wartosci / $ilosc_dni; 
        $sr = number_format($sr, 1);
    } else {
        $sr = 0;
    }

	/*
	echo '<pre>';
		print_r($dane);
	echo '</pre>';
	*/
?>

    <!-- Graphs http://www.chartjs.org/ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
	<canvas id="myChart" style="width: 1000px;" class="chart-container"></canvas>
	<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: '<?php echo $_SESSION['sesja_uzyt']['wykres']; ?>',	/* bar, line, radar, polarArea */
		data: {
			labels: [
<?php
//wys dni miesiaca
for ($i = 0; $i < count($dane); $i++){
	$ii = $i + 1;
	echo "\"".$ii."\",";
}
?>
			],
			datasets: [{
				label: 'Wizyty',
				data: [
<?php
//ilosc wizyt dane
for ($i = 0; $i < count($dane); $i++) {
	
	echo "\"".$dane[$i]."\",";
}
?>
				],
				backgroundColor: [
<?php
//kolor slupka
for ($i = 0; $i < count($dane); $i++) {
	
	echo "'rgba(54, 162, 235, 0.5)',";
	
}
?>
				],
				borderColor: [
<?php
//kolor obramowania slupka
for ($i = 0; $i < count($dane); $i++) {
	
	echo "'rgba(54, 162, 235, 1)',";
	
}
?>
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
	</script>


<?php	
	echo'
	<hr />
	
	<div class="table-responsive">
		<table class="table table-striped small table-sm">
		<tr>
			<th>dzień roku</th> <th>data</th> <th>dzień tygodnia</th> <th>wizyty</th> <th>wykres</th> <th>wykres godzin</th> <th>nr.IP</th>
		</tr>';

	// PHP 8.4: Sprawdzamy czy $dane to tablica i czy nie jest pusta
	if (is_array($dane) && !empty($dane)) {
		reset($dane); // wskazanie na początek tablicy
		$wartosc = current($dane);
	} else {
		$wartosc = 0; // wartość domyślna, jeśli tablica jest pusta
	}

	// PHP 8.4: Bezpieczne sprawdzenie zmiennej $od (np. jeśli nie została przekazana w URL)
	if (($od ?? 0) == 0) {
		$a = -1;
	}

	// Inicjalizacja dnia
	$dzien = 1;
				

	// PHP 8.4: Pobieramy miesiąc raz przed pętlą, aby uniknąć błędów i przyspieszyć kod
	$get_m = $_GET['m'] ?? date('n');
	$miesiac = '';
	$m = 0;

	// Logika ustalania nazwy miesiąca (wyciągnięta przed pętlę)
	if($get_m == '1'){$miesiac = 'Styczeń'; $m = 1;}else
	if($get_m == '2'){$miesiac = 'Luty'; $m = 2;}else
	if($get_m == '3'){$miesiac = 'Marzec'; $m = 3;}else
	if($get_m == '4'){$miesiac = 'Kwiecień'; $m = 4;}else
	if($get_m == '5'){$miesiac = 'Maj'; $m = 5;}else
	if($get_m == '6'){$miesiac = 'Czerwiec'; $m = 6;}else
	if($get_m == '7'){$miesiac = 'Lipiec'; $m = 7;}else
	if($get_m == '8'){$miesiac = 'Sierpień'; $m = 8;}else
	if($get_m == '9'){$miesiac = 'Wrzesień'; $m = 9;}else
	if($get_m == '10'){$miesiac = 'Październik'; $m = 10;}else
	if($get_m == '11'){$miesiac = 'Listopad'; $m = 11;}else
	if($get_m == '12'){$miesiac = 'Grudzień'; $m = 12;}

	// PHP 8.4: Upewniamy się, że $dane to tablica przed count()
	$ile_danych = count((array)$dane);

	for ($i = 0; $i < $ile_danych; $i++) 
	{
		$a++;
		// Tutaj możesz teraz bezpiecznie używać zmiennych $miesiac i $m
		// bez obciążania serwera powtarzalnymi warunkami

				
		if($dane[$i] != 0){
			// PHP 8.4: Zabezpieczenie przed dzieleniem przez zero, jeśli $naj wynosi 0
			if(($naj ?? 0) > 0){
				// obliczanie wysokosci slupka
				$szer = ($dane[$i] / $naj) * 100; 
				$szer = round($szer, 0);
			} else {
				// Jeśli $naj to 0, ale $dane[$i] jakimś cudem nie, ustawiamy minimalną szerokość
				$szer = 1;
			}
		} else {
			$szer = 1;
		}

				// PHP 8.4: Przygotowanie zmiennych z URL (z wartościami domyślnymi)
				$get_rok   = $_GET['rok'] ?? date('Y');
				$get_m     = $_GET['m']   ?? date('n');
				// $dzien jest ustawiany wcześniej w Twojej pętli (zaczynając od 1)

				// Tworzymy obiekt daty dla konkretnego dnia w pętli
				// Używamy rzutowania (string) i czystego łączenia ciągów
				$dni_w_tygodniu = new DateTime((string)$get_rok . '-' . (string)$get_m . '-' . (string)$dzien);

				$dzien_tyg  = $dni_w_tygodniu->format("w"); // 0 (niedziela) do 6 (sobota)
				$dzien_roku = $dni_w_tygodniu->format("z"); // 0 do 365
				
				// Zachowanie Twojej logiki inkrementacji i zmiennych pomocniczych
				$d_roku = $dzien_roku;
				$dzien_roku++; 

				
				if($dzien_tyg == '0'){$dzien_tyg = 'Niedziela';}else
				if($dzien_tyg == '1'){$dzien_tyg = 'Poniedziałek';}else
				if($dzien_tyg == '2'){$dzien_tyg = 'Wtorek';}else
				if($dzien_tyg == '3'){$dzien_tyg = 'Środa';}else
				if($dzien_tyg == '4'){$dzien_tyg = 'Czwartek';}else
				if($dzien_tyg == '5'){$dzien_tyg = 'Piątek';}else
				if($dzien_tyg == '6'){$dzien_tyg = 'Sobota';}
				
				echo'
				<tr>
					<td class="text-muted">'.$dzien_roku.'</td> <td><a href="nr_ip.php?data_ip='.$dzien.'-'.$_GET['m'].'-'.$_GET['rok'].'&wyslij=" data-toggle="tooltip" data-placement="right" title="Zobacz wszystkie NR.IP w tym dniu">'.$dzien.' '.$miesiac.' '.$_GET['rok'].'</a></td> <td class="text-muted">'.$dzien_tyg.'</td> <td><span class="label-dane">'.number_format(str_replace(',','.',$dane[$i]), 0, '.', ' ').'</span></td> <td><div class="progress" data-toggle="tooltip" data-placement="right" title="'.$dzien.' '.$miesiac.' '.$_GET['rok'].', '.$dane[$i].' wiz."><div class="progress-bar" role="progressbar" style="width: '.$szer.'%;">'.number_format(str_replace(',','.',$dane[$i]), 0, '.', ' ').'</div></div></td> <td class="text-muted"><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#okienko_'.$dzien_roku.'" title="Zobacz ilość Wizyt w godzinach w tym dniu"><i class="far fa-chart-bar"></i></button></td> <th><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#okienko_ip_'.$d_roku.'" data-toggle="tooltip" data-placement="bottom" title="Zobacz ilość Odsłon, poszczególnych adresów IP"><i class="far fa-chart-bar"></i></button></th>
				</tr>';
				
				
//modal ip
				echo'
				<div class="modal fade" id="okienko_ip_'.$d_roku.'">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
				  
							<!-- Modal Header -->
							<div class="modal-header">
								<h5 class="modal-title">Odsłony nr. IP w dniu: '.$dzien.' '.$miesiac.' '.$_GET['rok'].', dzień roku: '.$dzien_roku.'</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
					
							<!-- Modal body -->
							<div class="modal-body">
								<div class="row">
									<div class="col-4"><b>nr. IP</b></div>
									<div class="col-4"><b>odsłony</b></div>
									<div class="col-4"><b>data</b></div>';
								
							$stmt_ip = $db->query("SELECT * FROM ".$_GET['rok']."_nr_ip WHERE dzien_roku=".$d_roku." ORDER BY `".$_GET['rok']."_nr_ip`.`ods` DESC LIMIT 20");
							if($stmt_ip->rowCount() > 0){
							
								while($wiersz = $stmt_ip->fetch(PDO::FETCH_ASSOC)){
									
									$nr_ip 		= $wiersz['nr_ip'];
									$ods_ip 	= $wiersz['ods'];
									$data_ip 	= $wiersz['data_utw'];	$data_ip = date('d-m-Y, H:i:s', $data_ip);						
								
										echo'
											<div class="col-4 text-muted small">
												'.$nr_ip.'
											</div>
											<div class="col-4 text-muted small">
												'.$ods_ip .'
											</div>
											<div class="col-4 text-muted small">
												'.$data_ip .'
											</div>';
								}
									echo'<div class="col-12">
											<fieldset class="border">
												<legend class="w-auto">Pomoc</legend>
													<p class="text-muted small">Dane pokazują 20 numerów IP z największą ilością odsłon w wybranym dniu. Kolumna <i>Data</i>, wskazuje ostatnią odsłonę w tym dniu.</p>
											</fieldset>
										</div>';
							}else{
								echo'<div class="col-12"><p class="text-muted my-4">brak numerów IP...</p></div>';
							}
							echo'
								</div>
							</div>
					
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
					
						</div>
					</div>
				</div>';				
				//end modal ip
				
				
				
				
				
				
					// modal
					echo'
					<div class="modal fade" id="okienko_'.$dzien_roku.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Wykres Wizyt w dniu: '.$dzien.' '.$miesiac.' '.$_GET['rok'].', '.$dzien_tyg.', dzień roku: '.$dzien_roku.'</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">';

						$dzien_r = $dzien_roku - 1;
						
//szukanie najwiekszej wizyty w godzinach
	$tab = array(); //zainicjowanie tablicy bez wartosci
for($a=0; $a<24; $a++){
	$nazwa_slupka = $a.'wiz';
	naj_god($_GET['rok'].'_wiz_ods', "$nazwa_slupka", "$dzien_r");
	$tab[] = $wartosc;
}
	rsort($tab); 
	$naj_g = $tab[0];
	
	$dane_g = array(); //zainicjowanie tablicy bez wartosci
	$suma = 0;
for($a=0; $a<24; $a++){
	$nazwa_slupka = $a.'wiz';
	naj_god($_GET['rok'].'_wiz_ods', "$nazwa_slupka", "$dzien_r");
	$dane_g[] = $wartosc;
	$suma = $suma + $wartosc; //sumuje
}

			echo'
			<div class="table-responsive">
			<center>
				<div class="wykres">';
				
reset($dane_g); // wskazanie na początek tablicy
$wartosc = current($dane_g);

if (($od ?? 0) == 0) { $a = -1; }

// PHP 8.4: Liczymy elementy przed pętlą dla wydajności
$ile_g = count((array)$dane_g);

for ($iii = 0; $iii < $ile_g; $iii++) 
{
    $a++;
    
    // PHP 8.4: Zabezpieczenie przed dzieleniem przez zero ($naj_g)
    if ($dane_g[$iii] != 0 && ($naj_g ?? 0) > 0) {
        // obliczanie wysokości słupka
        $szer = ($dane_g[$iii] / $naj_g) * 200; 
        $szer = round($szer, 0);
    } else {
        $szer = 1;
    }
    
    echo '
    <div class="row_wykres bottom-section">
        <div class="bottom-content">';
            
            // PHP 8.4: Poprawiony warunek logiczny (czy suma jest zero)
            if (!($suma > 0)) { 
                echo '<div style="height: 185px; width: 0px;"></div>'; 
            }
            
            echo '
            <div class="row_slupki ttooltip" data-toggle="tooltip" data-placement="bottom" title="godzina: '.$iii.'.00 - Wizyt: '.$dane_g[$iii].'" style="height: '.$szer.'px;">
                
            </div>
        </div>
        <div class="wykres-os-x">'.$iii.'</div>
    </div>';

} // KONIEC PĘTLI FOR
			
			echo'
				</div>
			</center>
			</div>';
								
								echo'
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
								</div>
						</div>
					</div>';
				
				$dzien++;

			}//zam while
	
				echo'
				<tr>
					<th colspan="3">średnio wizyt/dzień:</th> <th><span class="label-dane">'.number_format(str_replace(',','.',$sr), 1, '.', ' ').'</span></th> <th></th> <th></th> <th></th> 
				</tr>
				<tr>
					<th colspan="3">suma:</th> <th><span class="label-dane">'.number_format(str_replace(',','.',$suma_wartosci), 0, '.', ' ').'</span></th> <th></th> <th></th> <th></th>
				</tr>';

	
	echo'
		</table>
	';
	
	echo'</div>';
?>















<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Wizyta - Co to znaczy ?
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Wizyta jest to ciąg następujących po sobie odsłon wykonanych przez jednego użytkownika w ramach jednej witryny i tego samego numeru IP. Ilość wizyt pokazuje ilość numerów IP, które odwiedziły monitorowaną stronę www. 
	</div>
</div>
	