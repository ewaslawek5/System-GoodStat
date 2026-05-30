<?php
	if (isset ($_POST['wyslij_2'])){

			//usuwa
			$stmt = $db->prepare("TRUNCATE `hist_operacji`;");	
			//kasujemy  
				if(@$stmt->execute()){
					
						$uruchom_alert = 'tak'; 
						$rodzaj_alert = 'ok';
						$tresc_info = 'Dokonano resetu Dziennika Systemu - Prawidłowo.';
						
						//zapis do logow systemu
						$stmttt = $db->query(
							"INSERT INTO hist_operacji (id, opis, data_utw)
							VALUES (0, 'Dokonanie resetu działu: <b>Dziennik Systemu</b>', ".time().")"
						);
						
				}else{
							$uruchom_alert = 'tak'; 
							$rodzaj_alert = 'uwaga';
							$tresc_info = 'Resetu NIE dokonano - coś poszło nie tak...';
				}

	}