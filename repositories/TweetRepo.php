<?php

class TweetRepo
{

	public static function addTweets($tweets)
	{
		foreach ($tweets as $tweet)
		{
			$author_id = self::getOrCreateAuthor($tweet['user']);
			$localisation_id = ($tweet['localisation'] != null ? self::getOrCreateLocalisation($tweet['localisation']) : null);
			self::insertTweet($author_id, $location_id, $tweet);

			foreach ($tweet['hashtags'] as $hashtag)
				self::insertHashtag($tweet['id'], $hashtag);

		}
	}

	public static function authorExists($author_id)
	{
		$query = StaticRepo::getConnexion()->prepare('SELECT COUNT(*) FROM Author WHERE id = :id');
		$query->execute([':id' => $author_id]);
		return $query->fetchColumn() == 1;
	}

	public static function insertAuthor($user)
	{
		if (!self::authorExists($user['id']))
		{
			$query = StaticRepo::getConnexion()->prepare('INSERT INTO Author VALUES (:id, :name, :screen_name, :image_url)');
			$query->execute([':id' => $user['id'],
							 ':name' => $user['name'],
							 ':screen_name' => $user['screen_name'],
							 ':image_url' => $user['image_url']]);
		}
	}

	public static function getOrCreateHashtagId($hashtag)
	{
		$query = StaticRepo::getConnexion()->prepare('SELECT id FROM Hashtag WHERE libelle = :libelle');
		$query->execute([':libelle' => $hashtag]);
		$hashtag = $query->fetch();

		if ($hashtag !== false)
			return $hashtag['id'];

		$query = StaticRepo::getConnexion()->prepare('INSERT INTO hashtag (libelle) VALUES (:libelle)');
		$query->execute([':libelle' => $hashtag]);
		return StaticRepo::getConnexion()->lastInsertId();
	}

	public static function insertHashtag($tweet_id, $hashtag)
	{
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO contenir VALUES (:tweet_id, :hashtag_id)');
		$query->execute([':tweet_id' => $tweet_id,
						 ':hashtag_id' => self::getOrCreateHashtagId($hashtag)]);
	}

		public static function exists(int $id){
		$statement = StaticRepo::getConnexion()->prepare("SELECT * FROM tweet WHERE ID = :id");
		$ret = $statement->exec(array(':id' => $id));
		$tab = $ret->fetch();
		return isset($tab['ID']);
	}

	public static function add($lien, $contenu, $nbfav, $nbRT, $localisation, $langue, $auteur){
		$statement = StaticRepo::getConnexion()->prepare("INSERT INTO `tweet`(`LIEN`, `CONTENU`, `NB_FAVORIS`, `NB_RT`, `LOCALISATION`, `LANGUE`, `AUTHOR`)
								 VALUES (':lien', ':contenu', ':nbfav', :nbRT, ':localisation', ':langue', :auteur);");
		$ret = $statement->exec(array(	'lien' => ));
		//On teste l'existance de l'auteur du tweet dans la bdd
		if (AuthorRepo::exists()){
			//On teste l'existence de la localisation aussi
			if(LocalisationRepo::exists()){
				
			}
			else { //sinon... on crée la localisation
				LocalisationRepo::add();
			}
		}
		else { // sinon on crée l'auteur
			AuthorRepo::add();
		}
	}

}
