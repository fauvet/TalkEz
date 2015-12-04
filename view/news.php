
<?php
require '../repositories/EventRepo.php';
?>

<div class='post location'>
	<input type='button' value='Me localiser' data-geolocation> ou 
	<input type='button' value='Saisir mon adresse'>
	<input type='text' placeholder='Adresse...'>
</div>



<div class='post'>
	<img src='src/miniature1.jpg'/>
	<h6>Un poney aperçu à la Nuit de l'Informatique au Mirail.</h6>
	<p>
		Plus tôt dans la soirée a été aperçu un poney. Nous vous recommendons donc la plus grande vigilance.	
	</p>


	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>2 victimes suite à la rédaction de prévention.</h6>
		<p>
			Il s'agirait plus exactement du poney lui-même et du respect, tout deux aurait alors disparu quelques heures plus tôt.
		</p>
	</div>
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Finalement le poney en question était une licorne.</h6>
		<p>
			Alors que personne ne comprenait pourquoi le poney avait un énorme ongle sur le front, des scientifiques ont pu alors prouvé qu'il s'agissait bel et bien d'une licorne.
		</p>
	</div>
</div>





<div class='post'>
	<img src='src/miniature1.jpg'/>
	<h6>Tsunamie en provenance de la mer méditerrannée devrait arrivé à Paris d'ici 12h.</h6>
	<p>
		Plus tôt dans la soirée un plongeur à sauté du haut d'un avion et à fait un plat. Heureusement pour lui, Aurélien Clérac alors 
		nouveau recorman du plus haut plongeon ne s'en tire qu'avec une légère commotion cérébrale. Toutefois, le plat a ainsi généré un tsunamie 
		de plus de 3km de hauteur au dessus du niveau de la mer.
	</p>


	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Perpignan ravagé.</h6>
		<p>
			Alors que le Tsunamie s'approche de la côte. La ville de Perpignan est la première ville atteinte par cette catastrophe.
		</p>
	</div>
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Le tsunamie finalement effondré.</h6>
		<p>
			Finalement, le plongeur ne s'en est pas tiré. Et le tsunamie c'est arrêté en même temps que lui.
		</p>
	</div>

</div>





<div class='post'>
	<img src='src/miniature1.jpg'/>
	<h6>Ebola fait son retour.</h6>
	<p>
		Ebola est dorénavent de retour dans les pays de l'Afrique avec un taux de contagiosité 2x plus important que le précédent virus. Mettez donc un bonnet d'âne sur 
		la tête afin de vous protéger.
	</p>

	
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Poisson d'Avril.</h6>
		<p>
			Bien qu'on ne soit pas Avril, c'était effectivement bien marrant de voir l'ensemble des populations d'Afrique avec un bonnet d'âne sur la tête.
		</p>
	</div>
</div>

<?php

	$EventRepo = new EventRepo;

	foreach ($EventRepo->selectEnCours() as $id) {
		$echo = '<div class=\'post\'>
					<img src=\'src/miniature1.jpg\'/>
					<h6>'.$EventRepo->selectLibelle($id).'</h6>
					<p>'.$EventRepo->selectMessage($id).'</p>';
		foreach($EventRepo->selectMessage() as $ligne) {
			$echo = $echo.'<div class=\'postChile\'>
								<img src=\'src/miniature1.jpg\'/>
								<h6>'.$ligne[1].'</h6>
								<p>'.$ligne[0].'</p>
							</div>';
		}
		$echo = $echo.'</div>';
		echo "$echo";
	}

?>

