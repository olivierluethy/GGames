<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Konto bearbeiten</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="public/style/editPage.css">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Konto bearbeiten</h1>

    <form action="editKonto?id=<?= $konto[0][0] ?>" method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?= $konto[0][1] ?>"><br><br>

        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" value="<?= $konto[0][3] ?>"><br><br>

        <label for="passwort">Passwort:</label><br>
        <input type="password" name="passwort" id="passwort"><br><br>

        <label for="passwort_again">Passwort bestätigen:</label><br>
        <input type="password" name="passwort_again" id="passwort_again"><br><br>

        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Konto bearbeiten</button> 
    </form>
    <script src="public/js/clientSideValidationKonto.js"></script>
</body>

</html>