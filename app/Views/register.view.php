<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email adress.";
    } /*elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_err = "Email can only contain letters.";
    }*/ else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login");
            } else{
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

<?php $title = 'GGAMES - Registrieren'; include __DIR__ . '/partials/head.php'; ?>

<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">
        <a href="home" class="mb-8 block text-center font-display text-3xl tracking-wider">
            <span class="text-brand-orange">G</span><span class="text-brand-green">G</span><span class="text-white">AMES</span>
        </a>

        <div class="card p-8">
            <h2 class="font-display text-2xl text-white">Konto erstellen</h2>
            <p class="mt-1 text-sm text-neutral-400">Fülle das Formular aus, um loszulegen.</p>

            <form action="register" method="post" class="mt-6 space-y-4">
                <div>
                    <label class="label">Email</label>
                    <input type="text" name="email" class="input" value="<?= e($email) ?>" autofocus>
                    <?php if (!empty($email_err)): ?><p class="mt-1 text-sm font-semibold text-red-400"><?= e($email_err) ?></p><?php endif; ?>
                </div>
                <div>
                    <label class="label">Passwort</label>
                    <input type="password" name="password" class="input" value="<?= e($password) ?>">
                    <?php if (!empty($password_err)): ?><p class="mt-1 text-sm font-semibold text-red-400"><?= e($password_err) ?></p><?php endif; ?>
                </div>
                <div>
                    <label class="label">Passwort bestätigen</label>
                    <input type="password" name="confirm_password" class="input" value="<?= e($confirm_password) ?>">
                    <?php if (!empty($confirm_password_err)): ?><p class="mt-1 text-sm font-semibold text-red-400"><?= e($confirm_password_err) ?></p><?php endif; ?>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1"><i class="fas fa-user-plus"></i> Registrieren</button>
                    <button type="reset" class="btn-ghost">Zurücksetzen</button>
                </div>
            </form>

            <p class="mt-4 text-center text-sm text-neutral-400">
                Bereits ein Konto? <a href="login" class="font-semibold text-brand-orange hover:underline">Hier einloggen</a>.
            </p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/foot.php'; ?>