<?php

class HashtagRepo
{

	public static function add($hashtag)
	{
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO hashtag (libelle, poids) VALUES (:libelle, :poids)');
		$query->execute([':libelle' => $hashtag, ':poids' => 0]);
		return StaticRepo::getConnexion()->lastInsertId();
	}

	public static function getOrCreate($hashtag)
	{
		// On sélectionne l'id du hastag
		$query = StaticRepo::getConnexion()->prepare('SELECT id FROM Hashtag WHERE libelle = :libelle');
		$query->execute([':libelle' => $hashtag]);
		$hashtag = $query->fetch();

		// Si il existe on le retourne
		if ($hashtag != false)
			return $hashtag['id'];

		// Sinon on insert un nouvel hashtag
		return self::add($hashtag);
	}

	public static function linkToTweet($tweet_id, $hashtag)
	{
		// Ajout du lien entre un hashtag et un tweet
		$hashtag_id = self::getOrCreate($hashtag);
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO contenir VALUES (:tweet_id, :hashtag_id)');
		$query->execute([':tweet_id' => $tweet_id,
						 ':hashtag_id' => $hashtag_id]);
	}

}
