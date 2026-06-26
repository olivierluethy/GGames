<?php
/** Store / shop. Expects: $games (store games, already excludes owned). */
$title = 'GGAMES - Shop';
$active = 'store';
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<main class="mx-auto max-w-7xl px-4 py-8">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl text-white">Shop</h1>
            <p class="mt-1 text-sm text-neutral-400">
                Entdecke neue Spiele<?= isLoggedIn() ? ' – gekaufte Spiele findest du unter „Käufe“.' : '.' ?>
            </p>
        </div>
        <?php if (isAdmin()): ?>
            <button onclick="GG.openCreate()" class="btn-green px-5 py-2.5 text-base shadow-lg shadow-brand-green/20">
                <i class="fas fa-plus"></i> Spiel erstellen
            </button>
        <?php endif; ?>
    </div>

    <?php if (empty($games)): ?>
        <div class="card flex flex-col items-center p-12 text-center">
            <i class="fas fa-ghost text-5xl text-neutral-700"></i>
            <h2 class="mt-4 text-xl font-semibold text-white">
                <?= isLoggedIn() ? 'Du besitzt bereits alle Spiele!' : 'Noch keine Spiele verfügbar.' ?>
            </h2>
            <p class="mt-1 text-sm text-neutral-400">
                <?= isLoggedIn() ? 'Schau später wieder vorbei oder wirf einen Blick in deine Käufe.' : 'Bald gibt es hier etwas zu entdecken.' ?>
            </p>
            <?php if (isAdmin()): ?>
                <button onclick="GG.openCreate()" class="btn-green mt-5"><i class="fas fa-plus"></i> Erstes Spiel hinzufügen</button>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php foreach ($games as $game): ?>
                <?php $context = 'store'; include __DIR__ . '/partials/game-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/partials/modals.php'; ?>
<script src="public/js/ggames.js"></script>
<?php include __DIR__ . '/partials/foot.php'; ?>
