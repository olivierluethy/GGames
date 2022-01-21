<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Spiel bearbeiten</title>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Spiel bearbeiten</h1>

    <form action="editGame?id=<?= $game[0][0] ?>" method="post">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" value="<?= $game[0][1] ?>"><br><br>

        <label for="entwickler">Entwickler:</label><br>
        <input type="text" name="entwickler" id="entwickler" value="<?= $game[0][2] ?>"><br><br>

        <label for="img">Bildpfad:</label><br>
        <input type="text" name="img" id="img" value="<?= $game[0][3] ?>"><br><br>

        <label for="price">Preis:</label><br>
        <input type="text" name="price" id="price" value="<?= $game[0][4] ?>"><br><br>

        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Spiel bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationGame.js"></script>
</body>

</html>