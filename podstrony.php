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
		<h1 class="h3 mb-0 text-gray-800">Podstrony</h1>
	</div>
	
<?php
	$tab_danych = array(); //zainicjowanie tablicy bez wartosci
	szukaj_danych4('podstrony', 'wejscia', "podstrony");
?>

<?php
	echo'
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Zebrane Dane</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table  class="table table-striped small table-sm" data-order=\'[[ 1, "DESC" ]]\' data-page-length=\'10\' class="display" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-primary">
						<th>podstrony</th> <th>odsłony</th> <th>wykres</th> <th>usuń</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-primary">
						<th>podstrony</th> <th>odsłony</th> <th>wykres</th> <th>usuń</th>
                    </tr>
                  </tfoot>
                  <tbody>';
				  
				szukaj_naj_godziny('podstrony');
		
				$stmt = $db->query("SELECT * FROM `podstrony` ORDER BY `podstrony`.`wejscia` DESC");

					while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
						$id = $wiersz['id'];
						$podstrony = $wiersz['podstrony'];
						$wejscia = $wiersz['wejscia'];
						
						if($wejscia != 0){
							// obliczanie wysokosci slupka
							$szer = ($wejscia / $naj_g) * 100; $szer = round($szer, 0);
						}else{$szer = 1;}

				echo'
				<tr>
					<td class="text-muted">'.$podstrony.'</td> <td class="text-muted">'.$wejscia.'</td> <td><div class="progress" data-toggle="tooltip" data-placement="left" title="'.$wejscia.' ods."><div class="progress-bar" role="progressbar" style="width: '.$szer.'%;">'.$wejscia.' ods.</div></div></td> <td><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#szczegoly'.$id.'" title="Usuń"><i class="fas fa-trash-alt"></i></button></td> 
				</tr>';

					//szczegoly
					echo'
					<!-- Modal -->
					<div class="modal fade" id="szczegoly'.$id.'">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
					  
								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title">Na pewno usunąć tą pozycję ?</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
						
								<!-- Modal body -->
								<div class="modal-body">

									<form action="podstrony.php" method="post" class="form-horizontal">
										<ul class="list-group">								
											<li class="list-group-item">
												<div class="row">
													<div class="col-md-3">nazwa</div>						
													<div class="col-md-9"><b>'.$podstrony.'</b></div>						
												</div>
											</li>									
										</ul>
								</div>
						
								<!-- Modal footer -->
								<div class="modal-footer">
										<input type="hidden" value="'.$id.'" name="id">
										<input type="hidden" value="'.$podstrony.'" name="podstrony">
								
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
										<button type="submit" class="btn btn-success" name="wyslij_12" title="tak usuń">Tak</button>
									</form>
								</div>
						
							</div>
						</div>
					</div>
					<!-- end Modal -->';	

					}
			
	echo'
		</tbody>
		</table>
	</div>';
?>

<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Pomoc
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Dane zawarte w powyższej tabeli wskazują odsłony poszczególnych podstron strony monitorowanej. Dodano też możliwość usunięcia pojedynczych rekordów.
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
