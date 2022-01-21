<?php
$dataCounter = 0;

foreach($kaeufe as $kaeufen){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/konto.css">
    <link rel="stylesheet" href="../public/css/navigation.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="shortcut icon" href="../images/favicon.ico">

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="title">
            <a href="konto">
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
            <a class="anchors_a" href="store">Shop</a>

            <?php
            if(isset($_SESSION['loggedin']) == true){
                echo "<div class='dropdown'>
                <button style='font-size: 16px; color: white; cursor: pointer; border: none; outline: none; padding: 14px 16px; background-color: inherit; font-family: inherit; margin: 0;'> ";
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
                    <button style='font-size: 16px; color: white; cursor: pointer; border: none; outline: none; padding: 14px 16px; background-color: inherit; font-family: inherit; margin: 0;'>
                    <i class='fa fa-user' aria-hidden='true'></i>&nbsp Nicht angemeldet
                    </button> <div style='min-width: 220px;' class='dropdown-content'>
                    <a href='login'><i class='fas fa-sign-in-alt'></i> Einloggen</a>
                    </div>
                </div>";   
            }
            ?>
        </div>
    </nav>

    <h1>Konto</h1>

    <div class="section">
        <div class="leftPage">
            <h3 id="heading1" onclick="openKonto()">Kontoinformationen</h3>
            <h3 id="heading2" onclick="openGuthaben()">Guthaben</h3>
            <h3 id="heading3" onclick="openKaeufe()">Käufe</h3>
        </div>
        <div class="rightPage">
            <div id="konto">
                <h1>Kontoübersicht</h1>
                <div class="rightPageContent">
                    <br>
                    <?php
                    echo "<div class='uebersicht'>";
                        foreach($konto as $konten){
                            echo "<div class='formatter'>";
                                echo "<p>Email: </p>";
                                echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $konten['email'] . "</p>";
                            echo "</div>";
                            echo "<div class='formatter'>";
                                echo "<p>Passwort: </p>";
                                echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $konten['password'] . "</p>";
                            echo "</div>";
                            echo "<div class='formatter'>";
                                echo "<p>Username: </p>";
                                if(empty($konten['username'])){
                                    echo "<p>&nbsp&nbsp Leer</p>";
                                }else{
                                    echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $konten['username'] . "</p>";
                                }
                            echo "</div>";
                            echo "<div class='formatter'>";
                                echo "<p>Das Konto wurde erstellt am: </p>";
                                echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $konten['created_at'] . "</p>";
                            echo "</div>";
                            echo "<button title='Konto bearbeiten' class='edit' onclick='editKonto(" . $konten['id'] . ")'><i class='fas fa-edit'></i> Bearbeiten</button>";
                        }
                    echo "</div>";
                    ?>
                    <br>
                </div>
            </div>
            <div id="guthaben">
                <h1>Guthaben</h1>
                <div class="rightPageContent">
                    <br>
                    <?php
                    echo "<div class='uebersicht'>";
                        foreach($konto as $konten){
                            echo "<p>Guthaben: 0.-</p>";
                        }
                    echo "</div>";
                    ?>
                    <br>
                </div>
            </div>
            <div id="kaeufe">
                <h1>Käufe</h1>
                <div class="rightPageContent">
                    <br>
                    <?php
                        echo "<div class='gameRow'>";

                        if($dataCounter > 0){
                            foreach($kaeufe as $kaeufen){
                                echo "<div class='game'>
                                    <img src='../images/" . $kaeufen['img'] . "' alt=''>";
                                    echo "<div class='desc'>";
                                        echo "<div class='formatter'>";
                                            echo "<p>Name: </p>";
                                            echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $kaeufen['name'] . "</p>";
                                        echo "</div>";
                                        echo "<div class='formatter'>";
                                            echo "<p>Entwickler: </p>";
                                            echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $kaeufen['entwickler'] . "</p>";
                                        echo "</div>";
                                        echo "<div class='formatter'>";
                                            echo "<p>Preis: </p>";
                                            if($kaeufen['price'] == 'Gratis'){
                                                echo "<p style='font-weight: bold;'>&nbsp Gratis</p>";
                                            }else{
                                                echo "<p style='font-weight: bold;'>&nbsp&nbsp" . $kaeufen['price'] . ".-</p>";
                                            }
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }else{
                            echo "<div class='noData'>
                            <h1>Bisher wurden noch keine Käufe getätigt</h1>
                            </div>";
                        }

                        echo "</div>";
                    ?>
                    <br>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../public/js/konto.js"></script>
</body>
</html>