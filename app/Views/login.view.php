<?php
// Initialize the session
session_start();
session_destroy();
session_start();
$_SESSION['email'] = "";

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home");
    exit;
}

// Include config file
require_once "config.php";

$password_err = $email_err ="";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $isValid = true;
    /* Serverside Validation */
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = true;
    }
    else {
        $isValid = false;
        $email_err = "Please enter a valid email.";
    }

    // Validate credentials
    if ($isValid) {
        // Prepare a select statement
        $sql = "SELECT id, email, username, istAdmin, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $username, $istAdmin, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // The session was already started at the top of this
                            // file, so we just store the data in session variables.
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["username"] = $username;
                            $_SESSION["istAdmin"] = $istAdmin;

                            // Redirect user to index page
                            header("location: home");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<?php $title = 'GGAMES - Login'; include __DIR__ . '/partials/head.php'; ?>

<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">
        <a href="home" class="mb-8 block text-center font-display text-3xl tracking-wider">
            <span class="text-brand-orange">G</span><span class="text-brand-green">G</span><span class="text-white">AMES</span>
        </a>

        <div class="card p-8">
            <h2 class="font-display text-2xl text-white">Login</h2>
            <p class="mt-1 text-sm text-neutral-400">Melde dich mit deinen Zugangsdaten an.</p>

            <form action="login" method="post" class="mt-6 space-y-4">
                <div>
                    <label class="label">Email</label>
                    <input type="text" name="email" class="input" autofocus>
                    <?php if (!empty($email_err)): ?><p class="mt-1 text-sm font-semibold text-red-400"><?= e($email_err) ?></p><?php endif; ?>
                </div>
                <div>
                    <label class="label">Passwort</label>
                    <input type="password" name="password" class="input">
                    <?php if (!empty($password_err)): ?><p class="mt-1 text-sm font-semibold text-red-400"><?= e($password_err) ?></p><?php endif; ?>
                </div>
                <button type="submit" class="btn-primary w-full"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>

            <p class="mt-4 text-center text-sm text-neutral-400">
                Noch kein Konto? <a href="register" class="font-semibold text-brand-orange hover:underline">Jetzt registrieren</a>.
            </p>
        </div>

        <?php if (env('QUICK_LOGIN')): ?>
            <?php
                // Dev-only one-click logins. Each button submits a seeded account
                // through the normal login flow. Every seeded user's password is "password".
                $quickUsers = [
                    ['email' => 'olivier@ggames.test', 'label' => 'Olivier', 'role' => 'Admin'],
                    ['email' => 'sarah@ggames.test',   'label' => 'Sarah',   'role' => 'Admin'],
                    ['email' => 'max@ggames.test',     'label' => 'Max',     'role' => 'User'],
                    ['email' => 'lena@ggames.test',    'label' => 'Lena',    'role' => 'User'],
                    ['email' => 'jonas@ggames.test',   'label' => 'Jonas',   'role' => 'User · keine Spiele'],
                    ['email' => 'mia@ggames.test',     'label' => 'Mia',     'role' => 'User · besitzt alle'],
                ];
            ?>
            <div class="card mt-5 p-5">
                <p class="mb-3 flex items-center gap-2 text-sm font-semibold text-neutral-300"><i class="fas fa-bolt text-brand-orange"></i> Quick Login (Dev)</p>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ($quickUsers as $quickUser): ?>
                        <form action="login" method="post">
                            <input type="hidden" name="email" value="<?= e($quickUser['email']) ?>">
                            <input type="hidden" name="password" value="password">
                            <button type="submit" class="btn-ghost w-full justify-start text-left">
                                <i class="fas fa-user <?= $quickUser['role'] === 'Admin' ? 'text-brand-orange' : 'text-brand-green' ?>"></i>
                                <span class="truncate"><?= e($quickUser['label']) ?> <span class="text-xs text-neutral-500"><?= e($quickUser['role']) ?></span></span>
                            </button>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/partials/foot.php'; ?>