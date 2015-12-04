<?php

class LocationRepo {

	public static function exists(int $id){
		$statement = StaticRepo::getConnexion()->prepare("SELECT * FROM coordonnees WHERE ID = :id");
		$ret = $statement->exec(array(':id' => $id));
		$tab = $ret->fetch();
		return (isset($tab['ID']) && $tab['ID'] != null);

	}
}

?>