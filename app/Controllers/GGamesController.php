<?php

class GGamesController
{
    /* Die Welcome Seite oder Startseite */
	public function index()
	{	
		session_start();
		
		require 'app/Views/welcome.view.php';
	}

    /* Der Shop — never lists games the current user already owns. */
	public function store(){
        session_start();

        $model = new Games();
        $games = $model->getStoreGames(currentUserId());

		require 'app/Views/store.view.php';
	}

    /* Inline detail data as JSON (consumed by the detail modal + edit form). */
    public function gameDetail(){
        session_start();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int) ($_GET['id'] ?? 0);
        $model = new Games();
        $game = $model->getGameDetail($id);

        if (!$game) {
            http_response_code(404);
            echo json_encode(['error' => 'not found']);
            return;
        }

        $userId = currentUserId();
        $game['owned']            = $userId ? $model->ownsGame($userId, $id) : false;
        $game['can_buy']          = isLoggedIn() && !$game['owned'];
        $game['price_history']    = $model->getPriceHistory($id);
        $game['buyers_per_price'] = $model->getBuyersPerPrice($id);
        $game['friends_who_own']  = $userId ? $model->getFriendsWhoOwn($id, $userId) : [];
        $game['recommendations']  = $model->getRecommendations($id, $userId);
        $game = $this->maybeEnrichWithRawg($game);

        echo json_encode($game);
    }

    /* Optional RAWG.io enrichment. Admin-entered data stays the source of truth;
     * this only augments images/rating. Requires RAWG_API_KEY; no-ops without. */
    private function maybeEnrichWithRawg(array $game): array
    {
        $key = env('RAWG_API_KEY');
        if (!$key) {
            return $game;
        }
        try {
            $url = 'https://api.rawg.io/api/games?key=' . urlencode($key)
                 . '&search=' . urlencode($game['name']) . '&page_size=1';
            $ctx = stream_context_create(['http' => ['timeout' => 3]]);
            $json = @file_get_contents($url, false, $ctx);
            if ($json === false) {
                return $game;
            }
            $data = json_decode($json, true);
            $r = $data['results'][0] ?? null;
            if (!$r) {
                return $game;
            }
            $extra = [];
            if (!empty($r['background_image'])) {
                $extra[] = $r['background_image'];
            }
            foreach (($r['short_screenshots'] ?? []) as $s) {
                if (!empty($s['image'])) {
                    $extra[] = $s['image'];
                }
            }
            if ($extra) {
                $game['images'] = array_values(array_unique(array_merge($game['images'], $extra)));
            }
            if (!empty($r['rating'])) {
                $game['rating'] = $r['rating'];
            }
            $game['api_enriched'] = true;
        } catch (\Throwable $e) {
            // Ignore — admin data is the source of truth.
        }
        return $game;
    }

    /* Spiele hinzufügen — processed from the inline modal, then back to store. */
    public function addGame(){
        session_start();
        if (!isAdmin()) {
            header('Location: store');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Games();
            $price = post('gratis') === '1' ? 'Gratis' : trim(post('price'));
            if ($price === '') {
                $price = 'Gratis';
            }
            $images = isset($_POST['images']) && is_array($_POST['images']) ? $_POST['images'] : [];
            $model->createGameFull(trim(post('name')), trim(post('entwickler')), $price, trim(post('description')), $images);
        }
        header('Location: store');
    }

    /* Spiele löschen (admins only). Images + price history cascade via FK. */
    public function deleteGame(){
        session_start();
        if (!isAdmin()) {
            header('Location: store');
            return;
        }
        $model = new Games();
        $model->removeGame((int) ($_GET['id'] ?? 0));
        header('Location: store');
    }

    /* Spiele bearbeiten — processed from the inline modal, then back to store. */
    public function editGame(){
        session_start();
        if (!isAdmin()) {
            header('Location: store');
            return;
        }
        $id = (int) ($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Games();
            $price = post('gratis') === '1' ? 'Gratis' : trim(post('price'));
            if ($price === '') {
                $price = 'Gratis';
            }
            $images = isset($_POST['images']) && is_array($_POST['images']) ? $_POST['images'] : [];
            $model->updateGameFull($id, trim(post('name')), trim(post('entwickler')), $price, trim(post('description')), $images);
        }
        header('Location: store');
    }

    /* Spiele kaufen — records the price paid via the saved card (simulated). */
    public function buyGame(){
        session_start();
        if (!isLoggedIn()) {
            header('Location: login');
            return;
        }
        $id = (int) ($_GET['id'] ?? 0);
        $model = new Games();
        if (!$model->ownsGame(currentUserId(), $id)) {
            $model->purchase(currentUserId(), $id);
        }
        header('Location: store');
    }

    /* Kontodaten anzeigen */
    public function konto(){
        $games = new Games();

        // Initialize the session
        session_start();

		/* Alle Informationen des Nutzers holen */
        $konto = $games -> getAllDataFromUser();
        $konto = $konto -> fetchAll();

        /* Spiele gekauft */
        $kaeufe = $games -> getAllBoughtGames();
        $kaeufe = $kaeufe -> fetchAll();

		require 'app/Views/konto.view.php';
    }

    /* Konto bearbeiten */
    public function editKonto(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email= $_POST['email'];
            $username = $_POST['username'];
            $passwort = $_POST['passwort'];

            $Games = new Games();

			$password = $Games -> GetPassword();
			$password = $password->fetchAll();

            if (password_verify($passwort, $password[0][0])) {
                $games->changeKonto($email, $username, $id);
                header('Location: logout');
            } else {
                echo 'Invalid password.';
                header('Location: home');
            }
        }else{

            $konto = $games -> getAllDataFromUser();
            $konto = $konto -> fetchAll();
        }
        require 'app/Views/editKonto.view.php';
    }

    /* Kauf wird gelöscht */
    public function returnGame(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        $games->returnGame($id, $_SESSION["id"]);

        header('Location: konto');
    }

    /* Login Page */
	public function login(){
        require 'app/Views/login.view.php';
    }

    /* Logout */
    public function logout(){
        require 'app/Views/logout.php';
    }

    /* Datenbankkonfigurationen für das Login und Register */
    public function config(){
        require 'app/Views/config.php';
    }

    /* Register Page */
    public function register(){
        require 'app/Views/register.view.php';
    }
}