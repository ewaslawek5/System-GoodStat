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
		<h1 class="h3 mb-0 text-gray-800">Historia</h1>
	</div>

<?php
	echo'
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Wykaz wpisów</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table  class="table table-striped small table-sm" data-order=\'[[ 0, "DESC" ]]\' data-page-length=\'10\' class="display" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-primary">
						<th>#</th> <th style="min-width: 75px;">data</th> <th>nr.ip</th>  <th>podstrona</th>  <th>system</th>  <th>przeglądarka</th>  <th>color</th>  <th>ekran</th>  <th>język</th>  <th>user agent</th> 
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-primary">
                      <th>#</th> <th>data</th> <th>nr.ip</th>  <th>podstrona</th>  <th>system</th>  <th>przeglądarka</th>  <th>color</th>  <th>ekran</th>  <th>język</th>  <th>user agent</th> 
                    </tr>
                  </tfoot>
                  <tbody>';
		
				$stmt = $db->query("SELECT * FROM `historia` ORDER BY `historia`.`id` DESC");

					while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
						$id					= $wiersz['id'];
						$data_utw			= $wiersz['data_utw'];	$data_utw = date('d-m-Y, H:i:s', $data_utw);
						$ip					= $wiersz['ip'];
						$podstrona			= $wiersz['podstrona'];
						$system				= $wiersz['system'];
						$przegladarki		= $wiersz['przegladarki'];
						$color				= $wiersz['color'];
						$ekran				= $wiersz['ekran'];
						$jezyk				= $wiersz['jezyk'];
						$ciaguser			= $wiersz['ciaguser'];

						echo'
						<tr>
							<td class="text-muted small">'.$id.'</td> <td class="text-muted small">'.$data_utw.'</td> <td class="text-muted small">'.$ip.'</td> <td class="text-muted small">'.$podstrona.'</td> <td class="text-muted small">'.$system.'</td> <td class="text-muted small">'.$przegladarki.'</td> <td class="text-muted small">'.$color.' bit.</td> <td class="text-muted small">'.$ekran.'</td> <td class="text-muted small">'.$jezyk.'</td> <td class="text-muted small">'.$ciaguser.'</td>
						</tr>';
					}
			
	echo'
		</tbody>
		</table>
	</div>';
?>
<?php
//		echo wskaznik($strona, $liczba_stron);	//stronnicowanie
?>

		<form action="" method="post">
			<fieldset class="border p-2">
			
				<legend class="w-auto">usuń logi</legend>			
				
				<button type="button" class="btn btn-danger btn-lg btn-block my-4" data-toggle="modal" data-target="#okienko_usun"><i class="fas fa-trash"></i> Usuń Historię <i class="fas fa-trash"></i></button>
			
			</fieldset>			
		</form>
		
	<!-- Modal -->
	<div class="modal fade" id="okienko_usun">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
      
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Czy chcesz usunąć całą Historię ?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
        
				<!-- Modal body -->
				<div class="modal-body">
					<form action="historia.php" method="post" class="form-horizontal">
						<fieldset class="border p-2">
							<legend class="w-auto">Pomoc</legend>
							<p class="text-muted small">Operacją tą stosuje się gdy jest już bardzo dużo rekordów w Historii. Po uruchomieniu tej operacji, przybywa nam również wolnego miejsca w Bazie Danych. Po tym zabiegu cała Historia zostanie bezpowrotnie usunięta.</p>
						</fieldset>
				</div>
        
				<!-- Modal footer -->
				<div class="modal-footer">
				
						<input type="hidden" value="Historia" name="tabelka">
				
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
						<button type="submit" class="btn btn-success" name="wyslij_6" title="tak usuń">Tak</button>
					</form>
				</div>
        
			</div>
		</div>
	</div>	
	
	<hr />
	
<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Pomoc - Historia
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Dane zawarte w powyższej tabeli pokazują wszystkie wejścia na stronę monitorowaną ze szczegółami takimi jak: data, nr.ip, podstrona, system, przeglądarka, color, ekran, język i ciąg user agent. User Agent według Wikipedi jest to aplikacja kliencka, nagłówek zawierający tzw. user agent string (UAString) służy serwisom internetowym (np. aplikacji napisanej w języku PHP) do rozpoznania typu programu klienckiego, również do budowania statystyk odwiedzin witryn WWW przez różne przeglądarki bądź roboty. Dane zapisywane są od góry tabeli, czyli najnowsza historia znajduje się na górze.
	</div>
</div>



</div>
<!-- end tresc -->















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
