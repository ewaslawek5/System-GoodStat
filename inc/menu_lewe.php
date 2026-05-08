	<!-- Sidebar -->
	<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark toggled accordion" id="accordionSidebar">

		<!-- Sidebar - Brand -->
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" title="System GoodStat - Darmowe statystyki na stronę www">
			<div class="sidebar-brand-icon rotate-n-15">
				<img class="img-fluid" src="images/favicon/android-icon-48x48.png" />
			</div>
			<div class="sidebar-brand-text mx-1"><img class="img-fluid" src="images/logo_tekst.png" /></div>
		</a>
		
		<hr class="sidebar-divider">
<?php
if(isset($_SESSION['sesja_uzyt']['zalogowany'])){
?>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "index") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="index.php" title="Strona Główna">
				<i class="fas fa-fw fa-tachometer-alt"></i> <span>Home panel</span>
			</a>
		</li>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "zestawienie") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="zestawienie.php?rok=<?php echo date('Y'); ?>">
				<i class="far fa-chart-bar"></i> <span>Zestawienie</span>
			</a>
		</li>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "wizyty") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="wizyty.php?rok=<?php echo date('Y'); ?>">
				<i class="far fa-chart-bar"></i> <span>Wizyty</span>
			</a>
		</li>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "odslony") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="odslony.php?rok=<?php echo date('Y'); ?>">
				<i class="far fa-chart-bar"></i> <span>Odsłony</span>
			</a>
		</li>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "historia") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="historia.php">
				<i class="fas fa-table"></i> <span>Historia</span>
			</a>
		</li>
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "nr_ip") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="nr_ip.php">
				<i class="fas fa-table"></i> <span>Nr. IP</span>
			</a>
		</li>

		<!-- Staty Techniczne -->
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "systemy") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "przegladarki") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "rozdzielczosc") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "liczba_kolorow") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "jezyk") !==false){ echo(" active");} ?>">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#techniczne" aria-expanded="true" aria-controls="techniczne">
				<i class="far fa-chart-bar"></i>
				<span>Techniczne</span>
			</a>
			<div id="techniczne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "systemy") !==false){ echo(" active");} ?>" href="systemy.php">Systemy</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "przegladarki") !==false){ echo(" active");} ?>" href="przegladarki.php">Przeglądarki</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "rozdzielczosc") !==false){ echo(" active");} ?>" href="rozdzielczosc.php">Rozdzielczość</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "liczba_kolorow") !==false){ echo(" active");} ?>" href="liczba_kolorow.php">Kolory</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "jezyk") !==false){ echo(" active");} ?>" href="jezyk.php">Język</a>

				</div>
			</div>
		</li>

		<!-- Staty Globalne -->
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "dni_tyg") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "godziny") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "podstrony") !==false){ echo(" active");} ?>">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#globalne" aria-expanded="true" aria-controls="globalne">
				<i class="far fa-chart-bar"></i>
				<span>Globalne</span>
			</a>
			<div id="globalne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "podstrony") !==false){ echo(" active");} ?>" href="podstrony.php">Podstrony</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "dni_tyg") !==false){ echo(" active");} ?>" href="dni_tyg.php">Dni Tygodnia</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "godziny") !==false){ echo(" active");} ?>" href="godziny.php">Godziny</a>

				</div>
			</div>
		</li>

		<!-- Staty SEO -->
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "zrodlo") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "roboty") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "head") !==false){ echo(" active");} ?>">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seo" aria-expanded="true" aria-controls="seo">
				<i class="far fa-chart-bar"></i>
				<span>SEO</span>
			</a>
			<div id="seo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "zrodlo") !==false){ echo(" active");} ?>" href="zrodlo.php">Źródło</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "roboty") !==false){ echo(" active");} ?>" href="roboty.php">Roboty</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "head") !==false){ echo(" active");} ?>" href="head.php">Sekcja Head</a>

				</div>
			</div>
		</li>
		
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
	  
		<!-- System -->
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "kod_javascript") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "uzytkownicy") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "zm_hasla") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "logi") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "baza_danych") !==false){ echo(" active");}elseif(strpos($_SERVER['PHP_SELF'], "aktualizacja") !==false){ echo(" active");} ?>">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#system" aria-expanded="true" aria-controls="system">
				<i class="fas fa-fw fa-cog"></i>
				<span>System</span>
			</a>
			<div id="system" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "kod_javascript") !==false){ echo(" active");} ?>" href="kod_javascript.php">Kod JavaScript</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "uzytkownicy") !==false){ echo(" active");} ?>" href="uzytkownicy.php">Użytkownicy</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "zm_hasla") !==false){ echo(" active");} ?>" href="zm_hasla.php">Zmiana Hasła</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "logi") !==false){ echo(" active");} ?>" href="logi.php">Dziennik Systemu</a>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "baza_danych") !==false){ echo(" active");} ?>" href="baza_danych.php">Baza Danych</a>
						<div class="dropdown-divider"></div>
					<a class="dropdown-item<?php if(strpos($_SERVER['PHP_SELF'], "aktualizacja") !==false){ echo(" active");} ?>" href="aktualizacja.php">Aktualizacja</a>

				</div>
			</div>
		</li>
		
		<li class="nav-item<?php if(strpos($_SERVER['PHP_SELF'], "pomoc") !==false){ echo(" active");} ?>">
			<a class="nav-link" href="pomoc.php">
				<i class="fas fa-table"></i> <span>Pomoc</span>
			</a>
		</li>
<?php
}
?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->