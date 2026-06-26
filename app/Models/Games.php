<?php
class Games
{
	public $db;

	public function __construct()
	{
		$this->db = connectDatabase();
		// Surface SQL errors instead of failing silently. Fetch mode is left at
		// the PDO default (BOTH) so legacy numeric-index access keeps working.
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/* Alle Spiele anzeigen */
	public function getAllGames(){
		$statement = $this->db->prepare("SELECT * FROM video_game");
        $statement->execute();
        return $statement;
	}

	/* Alle gekauften Spiele anzeigen */
	public function getAllBoughtGames(){
		$statement = $this->db->prepare("SELECT video_game.name, video_game.id, video_game.entwickler, video_game.img, video_game.price FROM video_game
INNER JOIN kaeufe ON kaeufe.fk_video_gameId = video_game.id
INNER JOIN users ON users.id = kaeufe.fk_usersId WHERE users.id = :id");
        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
		return $statement;
	}
	
	/* Alle nicht gekauften Spiele anzeigen */
	public function getNotBoughtGames(){
		$statement = $this->db->prepare("SELECT video_game.id, video_game.name, video_game.entwickler, video_game.img, video_game.price FROM video_game
WHERE video_game.id NOT IN (SELECT kaeufe.fk_video_gameId FROM kaeufe WHERE kaeufe.fk_usersId = :id)");
        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
		return $statement;
	}

	/* Alle Informationen des Nutzers holen */
	public function getAllDataFromUser(){
		$statement = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindParam(':email', $_SESSION['email']);
        $statement->execute();
		return $statement;
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

	/* Gekauftes Spiel zurückgeben */
	public function returnGame($spielId, $userId){
		$statement = $this->db->prepare("DELETE FROM `kaeufe` WHERE fk_usersId = :userId AND fk_video_gameId = :gameId");
        $statement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $statement->bindParam(':gameId', $spielId, PDO::PARAM_STR);
        $statement->execute();
	}

	/* Get Password for Account Update */
	public function GetPassword(){
		$statement = $this->db->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindParam(':email', $_SESSION['email']);
        $statement->execute();
		return $statement;
	}

	/* =====================================================================
	 * New data access for the store overhaul (images, prices, library,
	 * showcases, detail, social, payments). All return associative arrays.
	 * ===================================================================== */

	/* ---- Images ---------------------------------------------------------- */

	/** Image strings (URL/base64) for a game, ordered. */
	public function getImagesForGame($gameId): array
	{
		$stmt = $this->db->prepare("SELECT src FROM game_images WHERE fk_video_gameId = :id ORDER BY position ASC, id ASC");
		$stmt->bindValue(':id', (int) $gameId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}

	/** Attach an `images` array to each game row (falls back to legacy img). */
	private function attachImages(array $games): array
	{
		foreach ($games as &$g) {
			$images = $this->getImagesForGame($g['id']);
			if (!$images && !empty($g['img'])) {
				$images = ['assets/' . $g['img']];
			}
			$g['images'] = $images;
		}
		return $games;
	}

	/** Attach previous_price + price_dropped flag to each game row. */
	private function attachPriceInfo(array $games): array
	{
		foreach ($games as &$g) {
			$stmt = $this->db->prepare("SELECT price FROM price_history WHERE fk_video_gameId = :id ORDER BY changed_at DESC, id DESC LIMIT 2");
			$stmt->bindValue(':id', (int) $g['id'], PDO::PARAM_INT);
			$stmt->execute();
			$prices = $stmt->fetchAll(PDO::FETCH_COLUMN);

			$previous = $prices[1] ?? null;
			$g['previous_price'] = $previous;
			$g['price_dropped'] = (
				$previous !== null
				&& is_numeric($previous)
				&& is_numeric($g['price'])
				&& (float) $previous > (float) $g['price']
			);
		}
		return $games;
	}

	/* ---- Store / library / showcases ------------------------------------ */

	/** Games for the store. Logged-in users never see games they already own. */
	public function getStoreGames(?int $userId): array
	{
		if ($userId) {
			$stmt = $this->db->prepare(
				"SELECT * FROM video_game
				 WHERE id NOT IN (SELECT fk_video_gameId FROM kaeufe WHERE fk_usersId = :id)
				 ORDER BY created_at DESC, id DESC"
			);
			$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
		} else {
			$stmt = $this->db->prepare("SELECT * FROM video_game ORDER BY created_at DESC, id DESC");
		}
		$stmt->execute();
		return $this->attachPriceInfo($this->attachImages($stmt->fetchAll(PDO::FETCH_ASSOC)));
	}

	/** A user's owned games with the price paid and purchase date. */
	public function getLibrary(int $userId): array
	{
		$stmt = $this->db->prepare(
			"SELECT v.*, k.price_paid, k.purchased_at
			 FROM kaeufe k JOIN video_game v ON v.id = k.fk_video_gameId
			 WHERE k.fk_usersId = :id
			 ORDER BY k.purchased_at DESC, k.id DESC"
		);
		$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		return $this->attachImages($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	/** Newest games first, for the home showcase. */
	public function getLatestGames(int $limit = 6): array
	{
		$limit = max(1, (int) $limit);
		$stmt = $this->db->prepare("SELECT * FROM video_game ORDER BY created_at DESC, id DESC LIMIT $limit");
		$stmt->execute();
		return $this->attachPriceInfo($this->attachImages($stmt->fetchAll(PDO::FETCH_ASSOC)));
	}

	/** Developers with 2+ games and their most-bought titles, grouped by dev. */
	public function getPopularByDeveloper(): array
	{
		$sql = "SELECT v.*, COALESCE(p.cnt, 0) AS purchases
				FROM video_game v
				LEFT JOIN (SELECT fk_video_gameId, COUNT(*) cnt FROM kaeufe GROUP BY fk_video_gameId) p
					ON p.fk_video_gameId = v.id
				WHERE v.entwickler IN (
					SELECT entwickler FROM video_game GROUP BY entwickler HAVING COUNT(*) >= 2
				)
				ORDER BY v.entwickler ASC, purchases DESC, v.id ASC";
		$rows = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

		$byDev = [];
		foreach ($rows as $r) {
			$byDev[$r['entwickler']][] = $r;
		}
		foreach ($byDev as $dev => $list) {
			$byDev[$dev] = $this->attachImages($list);
		}
		return $byDev;
	}

	/* ---- Detail --------------------------------------------------------- */

	/** Full detail for one game (with images + price info), or null. */
	public function getGameDetail(int $gameId): ?array
	{
		$stmt = $this->db->prepare("SELECT * FROM video_game WHERE id = :id");
		$stmt->bindValue(':id', $gameId, PDO::PARAM_INT);
		$stmt->execute();
		$game = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$game) {
			return null;
		}
		$game = $this->attachPriceInfo($this->attachImages([$game]));
		return $game[0];
	}

	/** Ordered price points for a game (for the trend chart). */
	public function getPriceHistory(int $gameId): array
	{
		$stmt = $this->db->prepare("SELECT price, changed_at FROM price_history WHERE fk_video_gameId = :id ORDER BY changed_at ASC, id ASC");
		$stmt->bindValue(':id', $gameId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/** How many users bought a game at each price point. */
	public function getBuyersPerPrice(int $gameId): array
	{
		$stmt = $this->db->prepare("SELECT price_paid, COUNT(*) AS buyers FROM kaeufe WHERE fk_video_gameId = :id GROUP BY price_paid ORDER BY buyers DESC");
		$stmt->bindValue(':id', $gameId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/** Recommended games: same developer first, then other popular titles. */
	public function getRecommendations(int $gameId, ?int $userId, int $limit = 4): array
	{
		$game = $this->getGameDetail($gameId);
		if (!$game) {
			return [];
		}
		$exclude = [$gameId];
		if ($userId) {
			$owned = $this->db->prepare("SELECT fk_video_gameId FROM kaeufe WHERE fk_usersId = :id");
			$owned->bindValue(':id', $userId, PDO::PARAM_INT);
			$owned->execute();
			$exclude = array_merge($exclude, $owned->fetchAll(PDO::FETCH_COLUMN));
		}
		$exclude = array_map('intval', $exclude);
		$placeholders = implode(',', array_fill(0, count($exclude), '?'));

		$sql = "SELECT v.*, COALESCE(p.cnt,0) AS purchases,
					(v.entwickler = ?) AS same_dev
				FROM video_game v
				LEFT JOIN (SELECT fk_video_gameId, COUNT(*) cnt FROM kaeufe GROUP BY fk_video_gameId) p
					ON p.fk_video_gameId = v.id
				WHERE v.id NOT IN ($placeholders)
				ORDER BY same_dev DESC, purchases DESC, v.created_at DESC
				LIMIT $limit";
		$stmt = $this->db->prepare($sql);
		$params = array_merge([$game['entwickler']], $exclude);
		$stmt->execute($params);
		return $this->attachImages($stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	/* ---- Social --------------------------------------------------------- */

	/** Friends of a user (id + username). */
	public function getFriends(int $userId): array
	{
		$stmt = $this->db->prepare(
			"SELECT u.id, u.username FROM friends f JOIN users u ON u.id = f.fk_friendId WHERE f.fk_usersId = :id ORDER BY u.username"
		);
		$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/** Friends of $userId who already own $gameId. */
	public function getFriendsWhoOwn(int $gameId, int $userId): array
	{
		$stmt = $this->db->prepare(
			"SELECT u.id, u.username
			 FROM friends f
			 JOIN kaeufe k ON k.fk_usersId = f.fk_friendId AND k.fk_video_gameId = :gid
			 JOIN users u ON u.id = f.fk_friendId
			 WHERE f.fk_usersId = :uid
			 ORDER BY u.username"
		);
		$stmt->bindValue(':gid', $gameId, PDO::PARAM_INT);
		$stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/* ---- Admin CRUD (images + price history aware) ---------------------- */

	/** Replace all images for a game with the given ordered list. */
	private function replaceImages(int $gameId, array $images): void
	{
		$del = $this->db->prepare("DELETE FROM game_images WHERE fk_video_gameId = :id");
		$del->bindValue(':id', $gameId, PDO::PARAM_INT);
		$del->execute();

		$pos = 0;
		$ins = $this->db->prepare("INSERT INTO game_images (fk_video_gameId, src, position) VALUES (:id, :src, :pos)");
		foreach ($images as $src) {
			$src = trim((string) $src);
			if ($src === '') {
				continue;
			}
			$ins->bindValue(':id', $gameId, PDO::PARAM_INT);
			$ins->bindValue(':src', $src);
			$ins->bindValue(':pos', $pos++, PDO::PARAM_INT);
			$ins->execute();
		}
	}

	/** Record a price point in the history. */
	public function recordPrice(int $gameId, string $price): void
	{
		$stmt = $this->db->prepare("INSERT INTO price_history (fk_video_gameId, price) VALUES (:id, :price)");
		$stmt->bindValue(':id', $gameId, PDO::PARAM_INT);
		$stmt->bindValue(':price', $price);
		$stmt->execute();
	}

	/** Create a game with description + ordered images, recording the price. */
	public function createGameFull(string $name, string $entwickler, string $price, string $description, array $images): int
	{
		$stmt = $this->db->prepare(
			"INSERT INTO video_game (name, entwickler, img, price, description) VALUES (:n, :e, '', :p, :d)"
		);
		$stmt->bindValue(':n', $name);
		$stmt->bindValue(':e', $entwickler);
		$stmt->bindValue(':p', $price);
		$stmt->bindValue(':d', $description);
		$stmt->execute();

		$id = (int) $this->db->lastInsertId();
		$this->replaceImages($id, $images);
		$this->recordPrice($id, $price);
		return $id;
	}

	/** Update a game; records a new price point only when the price changed. */
	public function updateGameFull(int $id, string $name, string $entwickler, string $price, string $description, array $images): void
	{
		$cur = $this->db->prepare("SELECT price FROM video_game WHERE id = :id");
		$cur->bindValue(':id', $id, PDO::PARAM_INT);
		$cur->execute();
		$oldPrice = $cur->fetchColumn();

		$stmt = $this->db->prepare(
			"UPDATE video_game SET name = :n, entwickler = :e, price = :p, description = :d WHERE id = :id"
		);
		$stmt->bindValue(':n', $name);
		$stmt->bindValue(':e', $entwickler);
		$stmt->bindValue(':p', $price);
		$stmt->bindValue(':d', $description);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$this->replaceImages($id, $images);

		if ($oldPrice !== false && (string) $oldPrice !== $price) {
			$this->recordPrice($id, $price);
		}
	}

	/* ---- Purchase (records price paid) ---------------------------------- */

	/** Buy a game for a user, snapshotting the current price as price_paid. */
	public function purchase(int $userId, int $gameId): void
	{
		$priceStmt = $this->db->prepare("SELECT price FROM video_game WHERE id = :id");
		$priceStmt->bindValue(':id', $gameId, PDO::PARAM_INT);
		$priceStmt->execute();
		$price = (string) $priceStmt->fetchColumn();

		$stmt = $this->db->prepare(
			"INSERT INTO kaeufe (fk_usersId, fk_video_gameId, price_paid) VALUES (:u, :g, :p)"
		);
		$stmt->bindValue(':u', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':g', $gameId, PDO::PARAM_INT);
		$stmt->bindValue(':p', $price);
		$stmt->execute();
	}

	/** True if the user already owns the game. */
	public function ownsGame(int $userId, int $gameId): bool
	{
		$stmt = $this->db->prepare("SELECT 1 FROM kaeufe WHERE fk_usersId = :u AND fk_video_gameId = :g LIMIT 1");
		$stmt->bindValue(':u', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':g', $gameId, PDO::PARAM_INT);
		$stmt->execute();
		return (bool) $stmt->fetchColumn();
	}

	/* ---- Payment cards (dummy, never validated) ------------------------- */

	public function getCards(int $userId): array
	{
		$stmt = $this->db->prepare("SELECT * FROM payment_cards WHERE fk_usersId = :id ORDER BY id DESC");
		$stmt->bindValue(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addCard(int $userId, string $holder, string $number, string $expiry, string $brand): void
	{
		$stmt = $this->db->prepare(
			"INSERT INTO payment_cards (fk_usersId, cardholder, number, expiry, brand) VALUES (:u, :h, :n, :e, :b)"
		);
		$stmt->bindValue(':u', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':h', $holder);
		$stmt->bindValue(':n', $number);
		$stmt->bindValue(':e', $expiry);
		$stmt->bindValue(':b', $brand);
		$stmt->execute();
	}

	public function deleteCard(int $cardId, int $userId): void
	{
		$stmt = $this->db->prepare("DELETE FROM payment_cards WHERE id = :id AND fk_usersId = :u");
		$stmt->bindValue(':id', $cardId, PDO::PARAM_INT);
		$stmt->bindValue(':u', $userId, PDO::PARAM_INT);
		$stmt->execute();
	}
}