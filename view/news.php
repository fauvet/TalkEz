
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
	<h6>Jean-Michel Dutrou</h6>
	<p>
		coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
	</p>


	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
		</p>
	</div>
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
		</p>
	</div>
</div>





<div class='post'>
	<img src='src/miniature1.jpg'/>
	<h6>Jean-Michel Dutrou</h6>
	<p>
		coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
	</p>


	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
		</p>
	</div>
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
		</p>
	</div>

</div>





<div class='post'>
	<img src='src/miniature1.jpg'/>
	<h6>Jean-Michel Dutrou</h6>
	<p>
		coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
	</p>

	
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
		</p>
	</div>
	<div class='postChild'>
		<img src='src/miniature1.jpg'/>
		<h6>Jean-Michel Dutrou</h6>
		<p>
			coucou<br> ça va?<br>sqldkjqslkdjq<br>sdfjdslfkjdslkfjsdkljflksdjfsdkjflksdjfmsljkdfmqlsjkfmqlsdjkfmqsdlkjfmldsqkjfmlqsdjflskj<br>sdkjflskdf
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

