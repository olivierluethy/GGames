<?php

class GGamesController
{
    /* Die Welcome Seite oder Startseite */
	public function index()
	{	
		session_start();
		
		require 'app/Views/welcome.view.php';
	}

    /* Der Shop */
	public function store(){

        $games = new Games();

        // Initialize the session
        session_start();

        /* Alle Spiele */
        $getAllGames = $games -> getAllGames();
        $getAllGames = $getAllGames -> fetchAll(); 
        
		/* Gekaufte Spiele */
        $getAllBoughtGames = $games -> getAllBoughtGames();
        $getAllBoughtGames = $getAllBoughtGames -> fetchAll();

        /* Nicht Gekaufte Spiele */
        $getAllNotBoughtGames = $games -> getNotBoughtGames();
        $getAllNotBoughtGames = $getAllNotBoughtGames -> fetchAll();

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

            header('Location: http://localhost/GGames/store');
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
        
        header('Location: http://localhost/GGames/store');

        require 'app/Views/store.view.php';
    }

    /* Spiele bearbeiten */
    public function editGame(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $entwickler = $_POST['entwickler'];
            $img = $_POST['img'];
            $price = $_POST['price'];

            $games->changeGame($name, $entwickler, $img, $price, $id);

            header('Location: http://localhost/GGames/store');
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

        $games->getGame($_SESSION['id'], $id);

        header('Location: http://localhost/GGames/store');
    
        require 'app/Views/store.view.php';
    }

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

    public function editKonto(){
        $games = new Games();

        // Initialize the session
        session_start();
        
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email= $_POST['email'];
            $username = $_POST['username'];

            $games->changeKonto($email, $username, $id);

            header('Location: http://localhost/GGames/logout');
        }else{

            $konto = $games -> getAllDataFromUser();
            $konto = $konto -> fetchAll();
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