<?php
		$dane_g = array(); //zainicjowanie tablicy bez wartosci

		// PHP 8.4: Musimy zainicjować zmienną $suma przed pętlą, 
		// aby uniknąć błędu "Warning: Undefined variable" podczas dodawania.
		$suma = 0;

		$stmt = $db->query("SELECT * FROM `dni_tyg` ORDER BY `dni_tyg`.`dzien` ASC");

		if ($stmt) {
			while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
				// PHP 8.4: Rzutujemy na (int), aby mieć pewność, że operacje matematyczne są poprawne
				$wejscia = (int)($wiersz['wejscia'] ?? 0);
				
				$dane_g[] = $wejscia;
				$suma = $suma + $wejscia; //sumuje
			}
		}

			szukaj_naj_godziny('dni_tyg');

	/*
	echo '<pre>';
		print_r($dane_g);
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
for ($i = 0; $i < count($dane_g); $i++) {
	
	if($i == '0'){$miesiac = 'Niedziela'; $m = 1; echo "\"".$miesiac."\",";}else
	if($i == '1'){$miesiac = 'Poniedziałek'; $m = 2; echo "\"".$miesiac."\",";}else
	if($i == '2'){$miesiac = 'Wtorek'; $m = 3; echo "\"".$miesiac."\",";}else
	if($i == '3'){$miesiac = 'Środa'; $m = 4; echo "\"".$miesiac."\",";}else
	if($i == '4'){$miesiac = 'Czwartek'; $m = 5; echo "\"".$miesiac."\",";}else
	if($i == '5'){$miesiac = 'Piątek'; $m = 6; echo "\"".$miesiac."\",";}else
	if($i == '6'){$miesiac = 'Sobota'; $m = 7; echo "\"".$miesiac."\",";}
}
?>
			
			
			],
			datasets: [{
				label: '<?php echo"Wizyty"; ?>',
				data: [
<?php
//ilosc wizyt dane
for ($i = 0; $i < count($dane_g); $i++) {
	
	echo $dane_g[$i].',';
	
}
?>
					
					
					],
				backgroundColor: [
				
<?php
//kolor slupka
for ($i = 0; $i < count($dane_g); $i++) {
	
	echo "'rgba(54, 162, 235, 0.5)',";
	
}
?>
				],
				borderColor: [
				
<?php
//kolor obramowania slupka
for ($i = 0; $i < count($dane_g); $i++) {
	
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
			<th>dzień tygodnia</th> <th>wizyty</th> <th>wykres</th> 
		</tr>';
	
		// PHP 8.4: Sprawdzamy, czy $dane_g jest tablicą, aby uniknąć Fatal Error w funkcjach reset/current
		if (is_array($dane_g)) {
			reset($dane_g); // wskazanie na początek tablicy
			$wartosc = current($dane_g);
		} else {
			$wartosc = false; // Wartość domyślna w przypadku braku tablicy
		}

		// PHP 8.4: Bezpieczne sprawdzenie zmiennej $od (zapobiega Warning: Undefined variable)
		if (($od ?? 0) == 0) {
			$a = -1;
		}	
				
for ($i = 0; $i < count($dane_g); $i++) 
	
//			while(list($index, $wartosc) = each( $dane))
			{
				$a++;
				
				if($i == '0'){$miesiac = 'Niedziela'; $m = 1;}
				if($i == '1'){$miesiac = 'Poniedziałek'; $m = 2;}
				if($i == '2'){$miesiac = 'Wtorek'; $m = 3;}
				if($i == '3'){$miesiac = 'Środa'; $m = 4;}
				if($i == '4'){$miesiac = 'Czwartek'; $m = 5;}
				if($i == '5'){$miesiac = 'Piątek'; $m = 6;}
				if($i == '6'){$miesiac = 'Sobota'; $m = 7;}
				
				if($dane_g[$i] != 0){
					// obliczanie wysokosci slupka
					$szer = ($dane_g[$i] / $naj_g) * 100; $szer = round($szer, 0);
				}else{$szer = 1;}
				
			echo'
			<tr>
				<td class="text-muted">'.$miesiac.'</td> <td><span class="label-dane">'.$dane_g[$i].'</span></td> <td><div class="progress" data-toggle="tooltip" data-placement="right" title="'.$dane_g[$i].' wiz."><div class="progress-bar" role="progressbar" style="width: '.$szer.'%;">'.$dane_g[$i].' wiz.</div></div></td> 
			</tr>';

			}//zam while

	
	echo'
		</table>
	';
	
	echo'</div>';
?>

	<hr />
	
<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Co znaczą te dane ?
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Dane zawarte w powyższej tabeli wskazują dni tygodnia w których najczęściej stwierdzono Nową Wizytę na stronie monitorowanej, dzięki temu można określić w jakim dniu tygodnia najczęściej wchodzą nowi Użytkownicy.
	</div>
</div>

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		