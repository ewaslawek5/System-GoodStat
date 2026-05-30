<?php	
//-- wyslanie zapytania
	if (isset($_POST['wyslij_14'])){

			//usuwa
			$stmt = $db->prepare("DELETE FROM roboty WHERE id='{$_POST['id']}'");

			if(@$stmt->execute()){
			
							$uruchom_alert = 'tak'; 
							$rodzaj_alert = 'ok';
							$tresc_info = 'Pozycja została usunięta - Prawidłowo ('.$_POST['roboty'].').';
							
						//zapis do logow systemu
						$stmttt = $db->query(
							"INSERT INTO hist_operacji (id, opis, data_utw)
							VALUES (0, 'Usunięcie pozycji: <b>".$_POST['roboty']."</b> z działu Roboty', ".time().")"
						);
			}else{
							$uruchom_alert = 'tak'; 
							$rodzaj_alert = 'uwaga';
							$tresc_info = 'Coś poszło źle, pozycja NIE została usunięta.';
			}

	}