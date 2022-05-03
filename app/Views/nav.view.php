<nav>
    <div class="title">
        <a href="home">
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