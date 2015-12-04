<?php

class CoordonneesRepo
{

	public static function add($longitude, $latitude, $region, $pays, $ville)
	{
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO Coordonnees (longitude, latitude, region, pays, ville)
													  VALUES (:longitude, :latitude, :region, :pays, :ville) ');
		$query->execute([':longitude' => $longitude, ':latitude' => $latitude, ':region' => $region, 'pays' => $pays, 'ville' => $ville]);
		return StaticRepo::getConnexion()->lastInsertId();
	}

	public static function getOrCreate($longitude, $latitude, $region, $pays, $ville)
	{
		$query = StaticRepo::getConnexion()->prepare('SELECT id FROM Coordonnees
													  WHERE longitude = :longitude AND latitude = :latitude');
		$query->execute([':longitude' => $longitude, ':latitude' => $latitude]);
		$coordonnee = $query->fetch();

		// Si il existe on le retourne
		if ($coordonnee !== false)
			return $coordonnee['id'];

		// Sinon on insert un nouvel hashtag
		return self::add($longitude, $latitude, $region, $pays, $ville);
	}

}