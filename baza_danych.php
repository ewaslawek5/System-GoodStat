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
		<h1 class="h3 mb-0 text-gray-800">Baza Danych</h1>
	</div>
	
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Wykaz tabel w Bazie Danych</h6>
            </div>
            <div class="card-body">

<?php
// PHP 8.4: Musimy zdefiniować zmienne sumujące przed pętlą, aby uniknąć błędów
$suma_rows           = 0;
$suma_Avg_row_length = 0;
$suma_Data_length    = 0;
$suma_Index_length   = 0;
$suma_wielkosci      = 0;

// Wykonanie zapytania
$stmt = $db->query("SHOW TABLE STATUS FROM " . NAZWA_BAZY);

echo '
<div class="table-responsive">
    <table class="table table-striped small table-sm">
    <tr>
        <th>Name</th> <th>Rows</th> <th>Avg_row_length</th> <th>Data_length</th> <th>Index_length</th> <th>Auto_increment</th> <th>Create_time</th> <th>Update_time</th>
    </tr>';

if ($stmt) {
    while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        // PHP 8.4: Bezpieczne sumowanie z użyciem operatora ?? (na wypadek wartości null w bazie)
        $suma_rows           += ($wiersz['Rows'] ?? 0);
        $suma_Avg_row_length += ($wiersz['Avg_row_length'] ?? 0);
        $suma_Data_length    += ($wiersz['Data_length'] ?? 0);
        $suma_Index_length   += ($wiersz['Index_length'] ?? 0);
        $suma_wielkosci      += (($wiersz['Data_length'] ?? 0) + ($wiersz['Index_length'] ?? 0));

        echo '
        <tr>
            <td><span class="text-muted">' . ($wiersz['Name'] ?? '---') . '</span></td> 
            <td><span class="text-muted">' . ($wiersz['Rows'] ?? 0) . '</span></td> 
            <td><span class="text-muted">' . formatSize($wiersz['Avg_row_length'] ?? 0) . '</span></td> 
            <td><span class="text-muted">' . formatSize($wiersz['Data_length'] ?? 0) . '</span></td> 
            <td><span class="text-muted">' . formatSize($wiersz['Index_length'] ?? 0) . '</span></td> 
            <td><span class="text-muted">' . ($wiersz['Auto_increment'] ?? '---') . '</span></td> 
            <td><span class="text-muted">' . ($wiersz['Create_time'] ?? '---') . '</span></td> 
            <td><span class="text-muted">' . ($wiersz['Update_time'] ?? '---') . '</span></td>
        </tr>';
    }
}

echo '
    <tr>
        <th>suma:</th> 
        <th>' . $suma_rows . '</th> 
        <th>' . formatSize($suma_Avg_row_length) . '</th> 
        <th>' . formatSize($suma_Data_length) . '</th> 
        <th>' . formatSize($suma_Index_length) . '</th> 
        <th></th> <th></th> <th></th>
    </tr>
    <tr>
        <th colspan="3">wielkość Bazy:</th> 
        <th>' . formatSize($suma_wielkosci) . '</th> 
        <th></th> <th></th> <th></th> <th></th>
    </tr>
    </table>
</div>';
?>

	<hr />

<p>
	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		<i class="fas fa-question-circle"></i> Pomoc
	</button>
</p>
<div class="collapse" id="collapseExample">
	<div class="card card-body">
		Zakładka techniczna, dzięki niej można poznać nazwy tabel w Bazie Danych, ich wielkość, ilość rekordów itp.
	</div>
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
