	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<meta name="keywords" content="statystyki stron www, darmowe statystyki stron www, statystyki na bloga, darmowe statystyki, system goodstat, statystyki goodstat, statystyki do instalacji" />
	<meta name="description" content="GoodStat - Darmowe statystyki stron www do samodzielnej instalacji na zdalnym hostingu." />
	<meta name="author" content="GoodStat.com.pl" />

	<title>System GoodStat - Darmowe statystyki na stronę www</title>
	
	<!-- bootstrap js 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>-->

	<!-- tooltip 
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>-->

	<!-- Custom fonts for this template-->
	<!-- https://fontawesome.com/icons?d=gallery -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
	
	<!-- Custom styles for this template-->
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link href="css/goodstat.css" rel="stylesheet">
	<link rel="stylesheet" href="css/prism.css">
	
	<!-- favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href=">images/favicon/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
	<!-- start data i zegar -->
	<script type="text/javascript">
		tday=new Array("Niedziela","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota");
		tmonth=new Array("Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień");

		function GetClock(){
			var d=new Date();
			var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

			if(nyear<1000) nyear+=1900;
			if(nmin<=9) nmin="0"+nmin;
			if(nsec<=9) nsec="0"+nsec;

			document.getElementById('clockbox').innerHTML="<i class='far fa-calendar-alt'></i> "+ndate+" "+tmonth[nmonth]+" "+nyear+", "+tday[nday]+" <i class='far fa-clock'></i> "+nhour+":"+nmin+":"+nsec+"";
		}

		window.onload=function(){
			GetClock();
			setInterval(GetClock,1000);
		}
	</script>
	<!-- stop data i zegar -->
	
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  
<?php
if(file_exists('config.php')) {
// ####################### wersja systemu
		$stmt = $db->query("SELECT * FROM klient_stat WHERE id='1' LIMIT 1");

			while($wiersz = $stmt->fetch(PDO::FETCH_ASSOC)){

				$wersja_uzyt 	= $wiersz['wersja'];
				$data_inst 		= $wiersz['data_inst']; $data_inst = date('d-m-Y, H:i:s', $data_inst);
			}
}
?>