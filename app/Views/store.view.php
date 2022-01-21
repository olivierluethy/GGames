<?php
$dataCounter = 0;

foreach($games as $game){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/navigation.css">
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/shop.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Font Family -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <title>Store</title>
</head>
<body>
    <nav>
        <div class="title">
            <a href="store">
                <h1>G</h1>
                <h1>G</h1>
                <h1>A</h1>
                <h1>M</h1>
                <h1>E</h1>
                <h1>S</h1>
            </a>
        </div>

        <div class="anchors">
            <a class="anchors_a" href="home">Home</a>
            <a class="anchors_a_active" href="store">Shop</a>

            <?php
            if(isset($_SESSION['loggedin']) == true){
                echo "<div class='dropdown'>
                <button class='buttonText'>";
                    if (empty($_SESSION['username'])) {
                        echo "<i class='fa fa-user' aria-hidden='true'></i>&nbsp Name
                        </button> <div style='min-width: 220px;' class='dropdown-content'>
                        <a href='konto'><i class='fas fa-user-circle'></i> Konto</a>
                        <a href='logout'><i class='fas fa-sign-out-alt'></i> Logout</a>
                        </div>
                </div>";
                    } else {
                        echo "<i class='fa fa-user' aria-hidden='true'></i>", "&nbsp&nbsp", $_SESSION['username'];
                        echo "</button> <div style='min-width: 160px;' class='dropdown-content'>
                        <a href='konto'><i class='fas fa-user-circle'></i> Konto</a>
                        <a href='logout'><i class='fas fa-sign-out-alt'></i> Logout</a>
                        </div>
                </div>";
                }
            }else{
                echo "<div class='dropdown'>
                    <button class='buttonText'>
                    <i class='fa fa-user' aria-hidden='true'></i>&nbsp Nicht angemeldet
                    </button> <div style='min-width: 220px;' class='dropdown-content'>
                    <a href='login'><i class='fas fa-sign-in-alt'></i> Einloggen</a>
                    </div>
                </div>";   
            }
            ?>
        </div>
    </nav>
<main>

<?php
if($dataCounter > 0){
    echo "<h1>New Games</h1>";

    echo "<div class='gameRow'>";

    foreach ($gamesBought as $gamesBoughts){
        echo "<div class='game'>
                <img src='../images/" . $gamesBoughts['img'] . "' alt=''>";
                echo "<div class='desc'>";
                    echo "<p>Name: " . $gamesBoughts['name'] . "</p>";
                    echo "<p>Entwickler: " . $gamesBoughts['entwickler'] . "</p>";
                        
                    if($gamesBoughts['price'] == 'Gratis'){
                        echo "<p>" . $gamesBoughts['price'] . "</p>";
                    }else{
                        echo "<p>Preis: " . $gamesBoughts['price'] . "</p>";
                    }
                echo "</div>";
            echo "<button class='bought'>Gekauft</button>";
            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == "1" && $_SESSION['email'] != "") {
                echo "<button title='Spiel bearbeiten' class='edit' onclick='editGame(" . $gamesBoughts['id'] . ")'><i class='fas fa-edit'></i> Bearbeiten</button>";
                echo "<button title='Spiel löschen' class='delete' onclick='deleteGame(" . $gamesBoughts['id'] . ")'><i class='fas fa-trash-alt'></i> Löschen</button>";
            }
        echo "</div>";
    }

    foreach ($gamesNotBought as $gamesNotBoughts){
        echo "<div class='game'>
                <img src='../images/" . $gamesNotBoughts['img'] . "' alt=''>";
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

<script src="../public/js/store.js"></script>

</main>
</body>
</html>