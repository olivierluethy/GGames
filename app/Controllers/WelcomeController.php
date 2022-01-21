<?php

class WelcomeController
{
    /* Die Welcome Seite oder Startseite */
	public function index()
	{	
		session_start();
		
		require 'app/Views/welcome.view.php';
	}

    /* Der Shop */
	public function store(){
		session_start();

        /* Alle Spiele */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT * FROM video_game");
        $statement->execute();
        $games = $statement->fetchAll();

		/* Gekaufte Spiele */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT video_game.name, video_game.id, video_game.entwickler, video_game.img, video_game.price FROM video_game
INNER JOIN kaeufe ON kaeufe.fk_video_gameId = video_game.id
INNER JOIN users ON users.id = kaeufe.fk_usersId WHERE users.id = :id");
        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
        $gamesBought = $statement->fetchAll();

        /* Nicht Gekaufte Spiele */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT video_game.id, video_game.name, video_game.entwickler, video_game.img, video_game.price FROM video_game
WHERE video_game.id NOT IN (SELECT kaeufe.fk_video_gameId FROM kaeufe WHERE kaeufe.fk_usersId = :id)");
        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
        $gamesNotBought = $statement->fetchAll();

		require 'app/Views/store.view.php';
	}

    /* Spiele hinzufügen */
    public function addGame(){
        $games = new Games();

        // Initialize the session
        session_start();

        require 'app/Views/addGame.view.php';

        $title = '';
        $pdo = connectDatabase();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $entwickler = $_POST['entwickler'];
            $img = $_POST['img'];
            $price = $_POST['price'];

            $games->createGame($name, $entwickler, $img, $price);

            header('Location: http://localhost/GGames/shop/store');
        }
    }

    /* Spiele löschen */
    public function deleteGame(){
        $games = new Games();

        // Initialize the session
        session_start();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $games->removeGame($id);
        
        header('Location: http://localhost/GGames/shop/store');

        require 'app/Views/store.view.php';
    }

    /* Spiele bearbeiten */
    public function editGame(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $entwickler = $_POST['entwickler'];
            $img = $_POST['img'];
            $price = $_POST['price'];

            $games->changeGame($name, $entwickler, $img, $price, $id);

            header('Location: http://localhost/GGames/shop/store');
        }else{
            $statement = $pdo->prepare('SELECT * FROM video_game WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $game = $statement->fetchAll();
        }
        require 'app/Views/editGame.view.php';
    }

    /* Spiele kaufen */
    public function buyGame(){
        $games = new Games();

        // Initialize the session
        session_start();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();

        $games->getGame($_SESSION['id'], $id);

        header('Location: http://localhost/GGames/shop/store');
    
        require 'app/Views/store.view.php';
    }

    public function konto(){
        session_start();

		/* Alle Spiele */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindParam(':email', $_SESSION['email']);
        $statement->execute();
        $konto = $statement->fetchAll();

        /* Spiele gekauft */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT video_game.name, video_game.entwickler, video_game.img, video_game.price FROM video_game
INNER JOIN kaeufe ON kaeufe.fk_video_gameId = video_game.id
INNER JOIN users ON users.id = kaeufe.fk_usersId WHERE users.id = :fk_usersId");
        $statement->bindParam(':fk_usersId', $_SESSION['id']);
        $statement->execute();
        $kaeufe = $statement->fetchAll();


		require 'app/Views/konto.view.php';
    }

    public function editKonto(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email= $_POST['email'];
            $username = $_POST['username'];

            $games->changeKonto($email, $username, $id);

            header('Location: http://localhost/GGames/shop/logout');
        }else{
            $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $konto = $statement->fetchAll();
        }
        require 'app/Views/editKonto.view.php';
    }

	public function login(){
        require 'app/Views/login.view.php';
    }

    public function logout(){
        require 'app/Views/logout.php';
    }

    public function config(){
        require 'app/Views/config.php';
    }

    public function register(){
        require 'app/Views/register.view.php';
    }
}

