<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="public/style/editPage.css">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Spiel hinzufügen</title>
</head>
<body>
    <h1>Spiel hinzufügen</h1>

     <form action="addGame" method="post">
        <label for="Name">Name:</label><br>
        <input type="text" name="name" id="name" require><br><br>

        <label for="entwickler">Entwickler:</label><br>
        <input type="text" name="entwickler" id="entwickler" require><br><br>

        <label for="img">Bildpfad:</label><br>
        <input type="text" name="img" id="img"><br><br>

        <label for="price">Preis:</label><br>
        <input type="text" name="price" id="price"><br><br>
      
        <button class="reset" type="reset"><i class="fas fa-undo"></i> Reset</button>
        <button type="submit" name="form-submit"><i class="fas fa-plus"></i> Spiel hinzufügen</button>
    </form>
    <script src="public/js/clientSideValidationGame.js"></script>
</body>
</html>