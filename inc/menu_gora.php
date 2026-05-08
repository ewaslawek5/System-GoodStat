<?php
if(isset($_SESSION['sesja_uzyt']['zalogowany'])){
?>
	<!-- wersja -->
	<div id="wersja" class="d-sm-flex align-items-center justify-content-between mb-0 small">
		<div class="text-gray-800"></div> <div id="pion_hr_wer" class="d-none d-sm-inline-block">System GoodStat, wersja: <?php echo $wersja_uzyt; ?>, data instalacji: <?php echo $data_inst; ?></div>
	</div>
<?php					
}
?>
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white border-bottom-primary topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
		  
			<!-- zegar i data -->
			<span class="navbar-text">			
				<div class="clockbox rounded-bottom d-none d-sm-inline-block">
					<div id="clockbox"></div>
				</div>
			</span>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
<?php
if(isset($_SESSION['sesja_uzyt']['zalogowany'])){
?>
            <!-- Dziennik Systemu -->
			<li class="nav-item dropdown no-arrow mx-1">
				<a class="nav-link dropdown-toggle" href="#" title="Dziennik Systemu" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-bell fa-fw"></i>
				</a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
				<h6 class="dropdown-header">
					Dziennik Systemu
                </h6>
<?php
				$stmt = $db->query("SELECT * FROM hist_operacji ORDER BY id DESC LIMIT 5");

					while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){
						$id		 			= $wiersz['id'];
						$opis 				= $wiersz['opis'];
						$data_utw 			= $wiersz['data_utw']; $data_utw = date('d-m-Y, H:i:s', $data_utw);
?>
					<div class="dropdown-item d-flex align-items-center">
					<div class="mr-3">
						<div class="icon-circle bg-primary">
							<i class="fas fa-file-alt text-white"></i>
						</div>
					</div>
					<div>
						<div class="small text-gray-500"><?php echo $data_utw; ?></div>
						<span class=""><?php echo $opis; ?></span>
					</div>
					</div>
<?php					
					}
?>
						<a class="dropdown-item text-center small text-gray-600" href="logi.php">Pokaż wszystko</a>
              </div>
			  
			</li>

            <!-- System -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" title="System" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-fw fa-cog"></i>
              </a>
              
				<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
					<h6 class="dropdown-header">
						System
					</h6>
					<a class="dropdown-item" href="kod_javascript.php">
						<i class="fas fa-cubes fa-sm fa-fw mr-2 text-primary"></i>
							Kod JavaScript
					</a>
					<a class="dropdown-item" href="uzytkownicy.php">
						<i class="fas fa-users fa-sm fa-fw mr-2 text-primary"></i>
							Użytkownicy
					</a>
					<a class="dropdown-item" href="zm_hasla.php">
						<i class="fas fa-key fa-sm fa-fw mr-2 text-primary"></i>
							Zmiana Hasła
					</a>
					<a class="dropdown-item" href="logi.php">
						<i class="fas fa-file-alt fa-sm fa-fw mr-2 text-primary"></i>
							Dziennik Systemu
					</a>
					<a class="dropdown-item" href="baza_danych.php">
						<i class="fas fa-database fa-sm fa-fw mr-2 text-primary"></i>
							Baza Danych
					</a>
					<a class="dropdown-item" href="aktualizacja.php">
						<i class="fas fa-code-branch fa-sm fa-fw mr-2 text-primary"></i>
							Aktualizacja
					</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link" href="wyloguj_uzyt.php" title="Wyloguj się">
				<i class="fas fa-sign-out-alt"></i>
              </a>
            </li>
<?php
}
?>

          </ul>

        </nav>
        <!-- End of Topbar -->