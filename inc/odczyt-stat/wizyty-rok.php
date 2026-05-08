<?php
$tablica = array(); // zainicjowanie tablicy bez wartosci

	// PHP 8.4: Bezpieczne pobranie roku przed pętlą, aby nie obciążać procesora
	$get_rok = $_GET['rok'] ?? date('Y');

	for($a=1; $a<=12; $a++){
		// Przekazujemy $a jako string (zgodnie z oryginałem), ale bez zbędnych cudzysłowów wokół zmiennej
		// Zachowujemy oryginalną nazwę funkcji szukaj_danych3 i zmiennej globalnej $suma
		szukaj_danych3($get_rok.'_wiz_ods', 'wiz', (string)$a, $get_rok); 
		
		$tablica[] = $suma;
	}
// Sortowanie tablicy malejąco, aby wyciągnąć największą wartość
        rsort($tablica); 
        // PHP 8.4: Bezpieczne pobranie pierwszej wartości. 
        // Jeśli tablica jest pusta, przypisujemy 0, aby uniknąć Warning: Undefined array key 0.
        $naj = $tablica[0] ?? 0;

    // Pobranie roku raz przed pętlą dla stabilności PHP 8.4
    $get_rok = $_GET['rok'] ?? date('Y');
    // Inicjujemy tablicę $dane, aby uniknąć błędów przy pierwszym dopisaniu
    $dane = array();

    // szukanie danych
    for($a=1; $a<=12; $a++){
        // Przekazujemy $a jako string, zachowując oryginalną strukturę wywołania
        szukaj_danych3($get_rok.'_wiz_ods', 'wiz', (string)$a, $get_rok); // wynikiem jest zmienna $suma
        $dane[] = $suma;
    }
	
	//zliczanie wszystkich wizyt w roku
	$suma_wartosci = 0;
	for($a=0; $a < count($dane); $a++){$wartosc = $dane[$a]; $suma_wartosci = $suma_wartosci + $wartosc;}
	$sr = $suma_wartosci / 12; $sr = number_format ($sr, 1);

	/*
	echo '<pre>';
		print_r($dane);
	echo '</pre>';
	*/	
?>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
	<canvas id="myChart" style="width: 1000px;" class="chart-container"></canvas>
	<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: '<?php echo $_SESSION['sesja_uzyt']['wykres']; ?>',	/* bar, line, radar, polarArea */
		data: {
			labels: [
			
<?php
//wysw miesiace
for ($i = 0; $i < count($dane); $i++) {
	
	if($i == '0'){$miesiac = 'Styczeń'; $m = 1; echo "\"".$miesiac."\",";}else
	if($i == '1'){$miesiac = 'Luty'; $m = 2; echo "\"".$miesiac."\",";}else
	if($i == '2'){$miesiac = 'Marzec'; $m = 3; echo "\"".$miesiac."\",";}else
	if($i == '3'){$miesiac = 'Kwiecień'; $m = 4; echo "\"".$miesiac."\",";}else
	if($i == '4'){$miesiac = 'Maj'; $m = 5; echo "\"".$miesiac."\",";}else
	if($i == '5'){$miesiac = 'Czerwiec'; $m = 6; echo "\"".$miesiac."\",";}else
	if($i == '6'){$miesiac = 'Lipiec'; $m = 7; echo "\"".$miesiac."\",";}else
	if($i == '7'){$miesiac = 'Sierpień'; $m = 8; echo "\"".$miesiac."\",";}else
	if($i == '8'){$miesiac = 'Wrzesień'; $m = 9; echo "\"".$miesiac."\",";}else
	if($i == '9'){$miesiac = 'Październik'; $m = 10; echo "\"".$miesiac."\",";}else
	if($i == '10'){$miesiac = 'Listopad'; $m = 11; echo "\"".$miesiac."\",";}else
	if($i == '11'){$miesiac = 'Grudzień'; $m = 12; echo "\"".$miesiac."\",";}
}
?>
			
			
			],
			datasets: [{
				label: '<?php echo"Wizyty"; ?>',
				data: [
<?php
//ilosc wizyt dane
for ($i = 0; $i < count($dane); $i++) {
	
	echo $dane[$i].',';
	
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
			<th>rok</th> <th>miesiąc</th> <th>wizyty</th> <th>wykres</th> 
		</tr>';
	
// Resetowanie wskaźnika tablicy i pobranie pierwszej wartości
if (!empty($dane)) {
    reset($dane); // wskazanie na początek tablicy
    $wartosc = current($dane);
} else {
    $wartosc = 0; // wartość domyślna, jeśli tablica $dane jest pusta
}

// Logika zmiennej $a
// PHP 8.4: Upewniamy się, że $od jest zainicjowane (np. przez ?? 0 wcześniej w kodzie)
if (($od ?? 0) == 0) {
    $a = -1;
}	
				
for ($i = 0; $i < count($dane); $i++) 
	
//			while(list($index, $wartosc) = each( $dane))
			{
				$a++;
				
				if($i == '0'){$miesiac = 'Styczeń'; $m = 1;}
				if($i == '1'){$miesiac = 'Luty'; $m = 2;}
				if($i == '2'){$miesiac = 'Marzec'; $m = 3;}
				if($i == '3'){$miesiac = 'Kwiecień'; $m = 4;}
				if($i == '4'){$miesiac = 'Maj'; $m = 5;}
				if($i == '5'){$miesiac = 'Czerwiec'; $m = 6;}
				if($i == '6'){$miesiac = 'Lipiec'; $m = 7;}
				if($i == '7'){$miesiac = 'Sierpień'; $m = 8;}
				if($i == '8'){$miesiac = 'Wrzesień'; $m = 9;}
				if($i == '9'){$miesiac = 'Październik'; $m = 10;}
				if($i == '10'){$miesiac = 'Listopad'; $m = 11;}
				if($i == '11'){$miesiac = 'Grudzień'; $m = 12;}
				
				if($dane[$i] != 0){
					// obliczanie wysokosci slupka
					$szer = ($dane[$i] / $naj) * 100; $szer = round($szer, 0);
				}else{$szer = 1;}
				
			echo'
			<tr>
				<td class="text-muted">'.$_GET['rok'].'</td> <td class="text-muted"><a href="wizyty.php?rok='.$_GET['rok'].'&m='.$m.'" role="button" data-toggle="tooltip" data-placement="right" title="Zobacz wizyty w miesiącu: '.$miesiac.'">'.$miesiac.'</a></td> <td><span class="label-dane">'.number_format(str_replace(',','.',$dane[$i]), 0, '.', ' ').'</span></td> <td><div class="progress" data-toggle="tooltip" data-placement="right" title="'.$miesiac.' '.$_GET['rok'].', '.$dane[$i].' wiz."><div class="progress-bar" role="progressbar" style="width: '.$szer.'%;">'.number_format(str_replace(',','.',$dane[$i]), 0, '.', ' ').'</div></div></td> 
			</tr>';

			}//zam while
	
				echo'
				<tr>
					<th colspan="2">średnio wizyt/miesiąc:</th> <th><span class="label-dane">'.number_format(str_replace(',','.',$sr), 0, '.', ' ').'</span></th> <th></th> 
				</tr>
				<tr>
					<th colspan="2">suma:</th> <th><span class="label-dane">'.number_format(str_replace(',','.',$suma_wartosci), 0, '.', ' ').'</span></th> <th></th> 
				</tr>';

	
	echo'
		</table>
	';
	
	echo'</div>';
?>

	<hr />
	
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

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		