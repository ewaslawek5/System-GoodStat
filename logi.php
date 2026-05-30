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
		<h1 class="h3 mb-0 text-gray-800">Dziennik Systemu</h1>
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
						<th>#</th> <th>opis</th> <th>data</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-primary">
                      <th>#</th> <th>opis</th> <th>data</th>
                    </tr>
                  </tfoot>
                  <tbody>';
		
				$stmt = $db->query("SELECT * FROM `hist_operacji` ORDER BY `hist_operacji`.`id` ASC");

					while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
						$id		 			= $wiersz['id'];
						$opis 				= $wiersz['opis'];
						$data_utw 			= $wiersz['data_utw']; $data_utw = date('d-m-Y, H:i:s', $data_utw);
						echo'
						<tr>
							<td class="text-muted">'.$id.'</td> <td class="text-muted">'.$opis.'</td> <td class="text-muted">'.$data_utw.'</td> 
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
				
				<button type="button" class="btn btn-danger btn-lg btn-block my-4" data-toggle="modal" data-target="#okienko_usun"><i class="fas fa-trash"></i> Wyczyść Dziennik Systemu <i class="fas fa-trash"></i></button>
			
			</fieldset>			
		</form>
		
	<!-- Modal -->
	<div class="modal fade" id="okienko_usun">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
      
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Czy chcesz usunąć wszystkie Logi z Dziennika Systemu ?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
        
				<!-- Modal body -->
				<div class="modal-body">
					<form action="logi.php" method="post" class="form-horizontal">
						<fieldset class="border p-2">
							<legend class="w-auto">Pomoc</legend>
							<p class="text-muted small">Operacją tą stosuje się gdy jest już bardzo dużo rekordów w Logach. Po uruchomieniu tej operacji, przybywa nam również wolnego miejsca w Bazie Danych. Po tym zabiegu wszystkie wpisy zostaną bezpowrotnie usunięte.</p>
						</fieldset>
				</div>
        
				<!-- Modal footer -->
				<div class="modal-footer">
				
						<input type="hidden" value="Historia" name="tabelka">
				
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
						<button type="submit" class="btn btn-success" name="wyslij_2" title="tak usuń">Tak</button>
					</form>
				</div>
        
			</div>
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
