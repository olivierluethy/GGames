<?php
$dataCounter = 0;

foreach($getAllGames as $game){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style/navigation.css">
    <link rel="stylesheet" href="public/style/general.css">
    <link rel="stylesheet" href="public/style/shop.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="shortcut icon" href="assets/favicon.ico">

    <!-- Importing font-family from google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <title>GGames - Store</title>
</head>

<body>

    <?php
include("nav.view.php");
?>
    <main>
        <?php
if($dataCounter > 0){
    echo "<h1>New Games</h1>";

    echo "<div class='gameRow'>";

    foreach ($getAllBoughtGames as $gamesBoughts){
        echo "<div class='game'>
                <img src='assets/" . $gamesBoughts['img'] . "' alt=''>";
                echo "<div class='desc'>";
                    echo "<p>Name: " . $gamesBoughts['name'] . "</p>";
                    echo "<p>Entwickler: " . $gamesBoughts['entwickler'] . "</p>";
                        
                    if($gamesBoughts['price'] == 'Gratis'){
                        echo "<p>" . $gamesBoughts['price'] . "</p>";
                    }else{
                        echo "<p>Preis: " . $gamesBoughts['price'] . "</p>";
                    }
                echo "</div>";
            echo "<button class='bought'><i class='fas fa-check'></i> Gekauft</button>";
            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == "1" && $_SESSION['email'] != "") {
                echo "<button title='Spiel bearbeiten' class='edit' onclick='editGame(" . $gamesBoughts['id'] . ")'><i class='fas fa-edit'></i> Bearbeiten</button>";
                echo "<button title='Spiel löschen' class='delete' onclick='deleteGame(" . $gamesBoughts['id'] . ")'><i class='fas fa-trash-alt'></i> Löschen</button>";
            }
        echo "</div>";
    }

    foreach ($getAllNotBoughtGames as $gamesNotBoughts){
        echo "<div class='game'>
                <img src='assets/" . $gamesNotBoughts['img'] . "' alt=''>";
                echo "<div class='desc'>";
                    echo "<p>Name: " . $gamesNotBoughts['name'] . "</p>";
                    echo "<p>Entwickler: " . $gamesNotBoughts['entwickler'] . "</p>";
                        
                    if($gamesNotBoughts['price'] == 'Gratis'){
                        echo "<p>" . $gamesNotBoughts['price'] . "</p>";
                    }else{
                        echo "<p>Preis: " . $gamesNotBoughts['price'] . "</p>";
                    }
                echo "</div>";

                if(isset($_SESSION['loggedin']) == true){
                    echo "<button title='Spiel kaufen' class='buy' onclick='Buy_It(" . $gamesNotBoughts['id'] . ")'><i class='fas fa-shopping-bag'></i> Buy now</button><br>";
                }else{
                    echo "<button title='Spiel kaufen' class='buy' onclick='login()'><i class='fas fa-shopping-bag'></i> Buy now</button><br>";
                }
            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == "1" && $_SESSION['email'] != "") {
                echo "<button title='Spiel bearbeiten' class='edit' onclick='editGame(" . $gamesNotBoughts['id'] . ")'><i class='fas fa-edit'></i> Bearbeiten</button>";
                echo "<button title='Spiel löschen' class='delete' onclick='deleteGame(" . $gamesNotBoughts['id'] . ")'><i class='fas fa-trash-alt'></i> Löschen</button>";
            }
        echo "</div>";
    }

    if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == "1" && $_SESSION['email'] != "") {
        echo "<div class='videospiel_hinzufuegen'>
                <i onclick='addGame()' class='fas fa-plus'></i>
                </div>";
        echo "</div>";
    }
}else{
    echo "<div class='noData'>";
        echo "<h1>There are no games available yet</h1>";
        if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == "1" && $_SESSION['email'] != "") {
            echo "
            <div class='videospiel_hinzufuegen_nodata'>
                <i onclick='addGame()' class='fas fa-plus'></i>
            </div>";
        }
    echo "</div>";
}?>
        </div>

        <script src="public/js/store.js"></script>

    </main>
</body>

</html>