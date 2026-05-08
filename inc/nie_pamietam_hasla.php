    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

	<div class="px-3 py-4 mb-1 bg-gradient-primary text-white">
		<div class="rounded postep_0">
			<p class="lead">Jeśli nie pamiętasz hasła do Systemu, nic się nie martw, podaj Swój Login, a system automatycznie wygeneruje Nowe Hasło, po zalogowaniu będzie można je zmienić na inne w dziale: <b>System/Zmiana Hasła</b>.</p>
		</div>
	</div>

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
<?php
if($wynik_logowania == 'zle'){
	$login = $_POST['l'];
					echo' 
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign"></span> <strong>Błąd!</strong> Coś poszło źle - Login lub Hasło jest niepoprawne!
						</div>';
						
						//zapis do logow systemu
						$stmt = $db->prepare(
							"INSERT INTO hist_operacji (id, opis, data_utw)
							VALUES (0, '<b>Nieudane logowanie</b> do Systemu, nr.IP: ".$nr_ip.", login: <b>".$_POST['l']."</b>', ".time().")"
						);		
						$stmt->execute();	//dodanie
}

?>

					<form action="nie_pamietam_hasla.php" method="post">
						<fieldset class="border p-2">
						
							<legend class="w-auto"><i class="fas fa-lock"></i> Nie Pamiętam Hasła</legend>
						<div class="form-group">
							<label for="login"> Login</label>
							<input type="password" class="form-control" id="login" name="l" placeholder="podaj Swój Login" required>
						</div>

						<div class="checkbox">
							
						</div>
						</fieldset>
						<hr />
						<fieldset class="border tblFooters">
							<button type="submit" name="wyslij_5" class="btn btn-primary btn-block my-4">Wyślij</button>
						</fieldset>
					</form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

