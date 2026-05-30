<?php
//### wyslanie maila
$tresc_email = '
<div class="container" id="tresc">
	<div class="panel panel-default panel-success">
	
		<div class="panel-heading">Adres e-mail</div>

		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<td><p class="text-muted"><small>e-mail:</small></p></td> <td>'.$_POST['email'].'</td>
				</tr>
			</table>
		</div>

	</div>
</div>';

	//wyslanie maila
	$wyslanie_maila = new Mailer_GoodStat("kontakt@goodstat.pl", "kontakt@goodstat.pl", "Zainstalowano System GoodStat", "$tresc_email");