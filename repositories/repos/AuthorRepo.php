<?php

class AuthorRepo
{

	public static function exists($id)
	{
		$query = StaticRepo::getConnexion()->prepare('SELECT COUNT(*) FROM Author WHERE id = :id');
		$query->execute([':id' => $id]);
		return $query->fetchColumn() == 1;
	}

	public static function getOrCreate($id, $name, $screen_name, $image_url)
	{
		if (self::exists($id))
			return $id;

		return self::add($id, $name, $screen_name, $image_url);
	}

	public static function add($id, $name, $screen_name, $image_url)
	{
		$query = StaticRepo::getConnexion()->prepare('INSERT INTO Author VALUES (:id, :name, :screen_name, :image_url)');
		$query->execute([':id' => $id, ':name' => $name, ':screen_name' => $screen_name, ':image_url' => $image_url]);
		return StaticRepo::getConnexion()->lastInsertId();
	}

}
