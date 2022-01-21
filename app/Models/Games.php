<?php
class Games
{
	public $db;

	public function __construct()
	{
		$this->db = connectDatabase();
	}

	/* Spiel hinzufügen */
	public function createGame($name, $entwickler, $img, $price){
		$statement = $this->db->prepare("INSERT INTO `video_game` (name, entwickler, img, price) VALUES (:name, :entwickler, :img, :price)");
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':entwickler', $entwickler, PDO::PARAM_STR);
		$statement->bindParam(':img', $img, PDO::PARAM_STR);
		$statement->bindParam(':price', $price, PDO::PARAM_STR);
		$statement->execute();
	}

	/* Spiel löschen */
	public function removeGame($id){
		$statement = $this->db->prepare('DELETE FROM `kaeufe` WHERE fk_video_gameId = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

		$statement = $this->db->prepare('DELETE FROM `video_game` WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}

	/* Spiel bearbeiten */
	public function changeGame($name, $entwickler, $img, $price, $id){
		$statement = $this->db->prepare('UPDATE `video_game` SET name = :name, entwickler = :entwickler, img = :img, price = :price WHERE id = :id');
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':entwickler', $entwickler, PDO::PARAM_STR);
		$statement->bindParam(':img', $img, PDO::PARAM_STR);
		$statement->bindParam(':price', $price, PDO::PARAM_STR);
		$statement->bindParam(':id', $id);
		$statement->execute();
	}

	/* Spiel kaufen */
	public function getGame($idSession, $id){
		$statement = $this->db->prepare("INSERT INTO `kaeufe` (fk_usersId, fk_video_gameId) VALUES (:fk_usersId, :fk_video_gameId)");
        $statement->bindParam(':fk_usersId', $idSession, PDO::PARAM_STR);
        $statement->bindParam(':fk_video_gameId', $id, PDO::PARAM_STR);
        $statement->execute();
	}

	/* Konto ändern */
	public function changeKonto($email, $username, $id){
		$statement = $this->db->prepare('UPDATE `users` SET email = :email, username = :username WHERE id = :id');
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
		$statement->bindParam(':username', $username, PDO::PARAM_STR);
		$statement->bindParam(':id', $id);
		$statement->execute();
	}
}