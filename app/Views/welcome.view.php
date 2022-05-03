<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>GGames - Welcome</title>
    <link rel="stylesheet" href="public/style/navigation.css">
    <link rel="stylesheet" href="public/style/general.css">
    <link rel="stylesheet" href="public/style/welcome.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="assets/favicon.ico">

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
</head>

<body>

    <?php
include("nav.view.php");
?>

    <?php
    echo "<section class='parallax-image'>
        <img src='assets/welcome.jpg' />
        <h1>Welcome to GGAMES!</h1>
            </section>";
    ?>

    <main>
        <h1>About Us</h1>
        <p>GGames is a new founded game store with a lot of new games. We don't make a lot of revenue at this time, but
            we hompe, that we will grow and grow more every year. Our dream is to be once one of the biggest video game
            seller in the world. Maybe it will happen or maybe not. But at this time, we aren't so far away ;)
            Enjoy the visit of this webpage!
        </p>
        <h1>What We Do</h1>
        <p>We sell at this time a lot of different video games in all kind of categories. From kids up to adults. The
            special thing of our website is, that our games that we sell are much different as on steam, epic games or
            blizzard.
            We sell games which will have a big future and we don't roast them. We keep them and develop up, so that
            they can be better than others.
        </p>
    </main>


    <script src="public/js/app.js"></script>
</body>

</html>