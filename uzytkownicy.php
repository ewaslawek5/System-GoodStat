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
		<h1 class="h3 mb-0 text-gray-800">Użytkownicy Systemu</h1>
	</div>

<?php
	echo'
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Wykaz użytkowników</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped small table-sm" data-order=\'[[ 0, "DESC" ]]\' data-page-length=\'10\' class="display" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-primary">
						<th>#</th> <th>login</th> <th>e-mail</th> <th>data utw</th> <th>usuń</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-primary">
                      <th>#</th> <th>login</th> <th>e-mail</th> <th>data utw</th> <th>usuń</th>
                    </tr>
                  </tfoot>
                  <tbody>';
		
				$stmt = $db->query("SELECT * FROM `uzyt_stat` ORDER BY `uzyt_stat`.`id` ASC");

					while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
						$id 		= $wiersz['id'];
						$login 		= $wiersz['login'];
						$mail 		= $wiersz['mail'];
						$data_utw 	= $wiersz['data_utw']; $data_utw = date('d-m-Y, H:i:s', $data_utw);

						echo'
						<tr>
							<td class="text-muted">'.$id.'</td> <td class="text-muted">'.$login.'</td> <td class="text-muted"><a href="mailto:'.$mail.'">'.$mail.'</a></td> <td class="text-muted">'.$data_utw.'</td> <td class="text-muted">'; if($id!=1){ echo'<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#szczegoly'.$id.'" title="Usuń"><i class="fas fa-trash-alt"></i>'; }else{ echo'-'; } echo'</td> 
						</tr>';	
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
									<form action="uzytkownicy.php" method="post" class="form-horizontal">
										<ul class="list-group">								
											<li class="list-group-item">
												<div class="row">
													<div class="col-md-3">login</div>						
													<div class="col-md-9"><b>'.$login.'</b></div>						
												</div>
											</li>									
										</ul>
				</div>
        
				<!-- Modal footer -->
				<div class="modal-footer">

										<input type="hidden" value="'.$id.'" name="id">
										<input type="hidden" value="'.$login.'" name="login">
								
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
										<button type="submit" class="btn btn-success" name="wyslij_4" title="tak usuń">Tak</button>
									</form>

				
				</div>
        
			</div>
		</div>
	</div>';
						
					}
			
	echo'
		</tbody>
		</table>
	</div>';
?>
	
	<hr />
	
<div class="row justify-content-md-center my-1">
	<div class="col-xl-4 col-lg-9 col-md-9">
		
	<form action="uzytkownicy.php" method="post">
		<fieldset class="border p-2">
			<legend class="w-auto">Dodanie nowego Użytkownika</legend>
		
		<div class="form-group<?php if($problem_email == 'tak'){echo ' has-error has-feedback';} ?>">
			<label for="mail">Adres e-mail</label>
			<input type="email" class="form-control" id="mail" placeholder="e-mail" name="email" required>
		</div>
		
		<div class="form-group<?php if($problem_login == 'tak'){echo ' has-error has-feedback';} ?>">
			<label for="login">Login</label>
			<input type="text" class="form-control" id="login" placeholder="login" name="login" required>
		</div>
		
		<div class="form-group<?php if($problem_haslo1 == 'tak'){echo ' has-error has-feedback';} ?>">
			<label for="haslo1">Hasło</label>
			<input type="password" class="form-control" id="haslo1" placeholder="hasło" name="haslo1" required>
		</div>
		
		<div class="form-group<?php if($problem_haslo2 == 'tak'){echo ' has-error has-feedback';} ?>">
			<label for="haslo2">Powtórz Hasło</label>
			<input type="password" class="form-control" id="haslo2" placeholder="powtórz hasło" name="haslo2" required>
		</div>

		</fieldset>
		
			<fieldset class="border tblFooters">
				<button type="submit" name="wyslij_3" class="btn btn-primary btn-lg btn-block my-4">Dodaj</button>
			</fieldset>
	  
	</form>
		
	</div>
</div>

	<hr />
	
<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Pomoc
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Dzięki temu działowi, można dodawać osoby uprawnione do oglądania statystyk monitorowanej strony internetowej.
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
