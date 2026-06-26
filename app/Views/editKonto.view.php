<?php
/** Edit account. Expects: $konto (fetchAll rows; [0] => [id, email, password, username, ...]). */
$title = 'GGAMES - Konto bearbeiten';
$active = 'konto';
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<main class="mx-auto max-w-lg px-4 py-10">
    <h1 class="mb-6 font-display text-3xl text-white">Konto bearbeiten</h1>

    <form action="editKonto?id=<?= (int) $konto[0][0] ?>" method="post" class="card space-y-4 p-6">
        <div>
            <label class="label" for="email">Email</label>
            <input type="email" name="email" id="email" class="input" value="<?= e($konto[0][1]) ?>">
        </div>
        <div>
            <label class="label" for="username">Username</label>
            <input type="text" name="username" id="username" class="input" value="<?= e($konto[0][3]) ?>">
        </div>
        <div>
            <label class="label" for="passwort">Aktuelles Passwort (zur Bestätigung)</label>
            <input type="password" name="passwort" id="passwort" class="input">
        </div>
        <div>
            <label class="label" for="passwort_again">Passwort bestätigen</label>
            <input type="password" name="passwort_again" id="passwort_again" class="input">
        </div>
        <div class="flex justify-end gap-2 border-t border-neutral-800 pt-4">
            <a href="konto" class="btn-ghost">Abbrechen</a>
            <button type="submit" name="form-submit" class="btn-primary"><i class="fas fa-save"></i> Speichern</button>
        </div>
    </form>
</main>

<script src="public/js/clientSideValidationKonto.js"></script>
<?php include __DIR__ . '/partials/foot.php'; ?>
