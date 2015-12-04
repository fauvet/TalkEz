<?php

class TweetRepo
{

	public static function exists($id)
	{
		$query = StaticRepo::getConnexion()->prepare('SELECT COUNT(*) FROM tweet WHERE ID = :id');
		$query->execute([':id' => $id]);
		return $query->fetchColumn() == 1;
	}

	public static function addAll($tweets)
	{
		foreach ($tweets as $tweet)
		{
			// Si le tweet n'est pas dans la table
			if (!self::exists($tweet['id']))
			{
				// Création author si il n'exite pas
				$author_id = AuthorRepo::getOrCreate($tweet['user']['id'], $tweet['user']['name'], $tweet['user']['screen_name'], $tweet['user']['image_url']);
				// Création localisation si nécessaire
				$localisation_id = (($tweet['location'] != null) ? CoordonneesRepo::getOrCreate($tweet['location']['longitude'], $tweet['location']['latitude'], null, $tweet['location']['city'], $tweet['location']['state']) : null);
				// Insertion tweet
				self::add($tweet['id'], $tweet['link'], $tweet['text'], $tweet['nb_favourites'], $tweet['nb_retweet'], $localisation_id, $tweet['language'], $author_id, $tweet['created']);
				// Link du tweet avec ses hastags
				foreach ($tweet['hashtags'] as $hashtag)
					HashtagRepo::linkToTweet($tweet['id'], $hashtag);
			}
		}
	}

	private static function add($id, $lien, $contenu, $nbfav, $nbRT, $localisation, $langue, $auteur, $date)
	{
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO `tweet`(`ID`, `LIEN`, `CONTENU`, `NB_FAVORIS`, `NB_RT`, `LOCALISATION`, `LANGUE`, `AUTHOR`, `POIDS`, `DATE`)
								 VALUES (:id, :lien, :contenu, :nbfav, :nbRT, :localisation, :langue, :auteur, :poids, :date)');
		$query->execute([':id' => $id, ':lien' => $lien, ':contenu' => $contenu, ':nbfav' => $nbfav, ':nbRT' => $nbRT, ':localisation' => $localisation, ':langue' => $langue, ':auteur' => $auteur, 'poids' => 0, 'date' => $date]);
	}

}
