<?php
/**
 * Logged-in home: store-style landing. No welcome banner here.
 * Expects: $latest (newest store games, excl. owned), $popularByDev (dev => games[]).
 */
$title = 'GGAMES - Home';
$active = 'home';
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';

$heroGames = array_slice($latest, 0, 5);
?>

<main class="mx-auto max-w-7xl px-4 py-8">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl text-white">Willkommen zurück, <?= e($_SESSION['username'] ?? 'Gamer') ?>!</h1>
            <p class="mt-1 text-sm text-neutral-400">Frisch im Shop und beliebt bei der Community.</p>
        </div>
        <?php if (isAdmin()): ?>
            <button onclick="GG.openCreate()" class="btn-green px-5 py-2.5 text-base shadow-lg shadow-brand-green/20">
                <i class="fas fa-plus"></i> Spiel erstellen
            </button>
        <?php endif; ?>
    </div>

    <?php if (!empty($heroGames)): ?>
        <!-- Hero showcase: auto-sliding latest games -->
        <section data-showcase class="relative mb-10 h-80 overflow-hidden rounded-2xl border border-neutral-800 bg-neutral-900 sm:h-96">
            <?php foreach ($heroGames as $k => $g): ?>
                <?php $cover = !empty($g['images']) ? $g['images'][0] : 'assets/favicon.ico'; $gratis = strcasecmp((string) $g['price'], 'Gratis') === 0; ?>
                <div data-show-slide class="absolute inset-0 transition-opacity duration-700 <?= $k === 0 ? '' : 'opacity-0 pointer-events-none' ?>">
                    <img src="<?= e($cover) ?>" alt="<?= e($g['name']) ?>" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/60 to-transparent"></div>
                    <div class="absolute bottom-0 max-w-2xl p-6 sm:p-10">
                        <span class="chip bg-brand-orange text-white"><i class="fas fa-bolt"></i> Neu im Shop</span>
                        <h2 class="mt-3 font-display text-3xl text-white drop-shadow sm:text-4xl"><?= e($g['name']) ?></h2>
                        <p class="mt-1 text-neutral-300"><i class="fas fa-code"></i> <?= e($g['entwickler']) ?></p>
                        <div class="mt-3 text-2xl font-bold <?= $gratis ? 'text-brand-green' : 'text-white' ?>"><?= e(formatPrice($g['price'])) ?></div>
                        <div class="mt-4 flex gap-3">
                            <button onclick="GG.openDetail(<?= (int) $g['id'] ?>)" class="btn-ghost"><i class="fas fa-circle-info"></i> Ansehen</button>
                            <?php if (!isAdmin()): ?>
                                <a href="buyGame?id=<?= (int) $g['id'] ?>" class="btn-primary"><i class="fas fa-shopping-bag"></i> <?= $gratis ? 'Holen' : 'Kaufen' ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (count($heroGames) > 1): ?>
                <button data-show-prev class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-3 py-2 text-white hover:bg-black/70"><i class="fas fa-chevron-left"></i></button>
                <button data-show-next class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-3 py-2 text-white hover:bg-black/70"><i class="fas fa-chevron-right"></i></button>
                <!-- Pause/play toggle (auto-plays on load) -->
                <button data-show-toggle title="Pause / Play" class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70"><i class="fas fa-pause"></i></button>
                <div class="absolute bottom-4 right-6 flex items-center gap-1.5">
                    <?php foreach ($heroGames as $k => $g): ?>
                        <button data-show-dot class="h-2 rounded-full transition-all <?= $k === 0 ? 'w-6 bg-brand-orange' : 'w-2 bg-white/40' ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Latest games grid -->
        <section class="mb-12">
            <h2 class="mb-4 flex items-center gap-2 font-display text-2xl text-white"><i class="fas fa-fire text-brand-orange"></i> Neueste Spiele</h2>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach (array_slice($latest, 0, 8) as $game): ?>
                    <?php $context = 'store'; include __DIR__ . '/partials/game-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php else: ?>
        <section class="card mb-12 flex flex-col items-center p-12 text-center">
            <i class="fas fa-trophy text-5xl text-brand-orange"></i>
            <h2 class="mt-4 text-xl font-semibold text-white">Du besitzt bereits alle Spiele!</h2>
            <p class="mt-1 text-sm text-neutral-400">Deine komplette Sammlung findest du unter „Käufe“.</p>
            <a href="konto" class="btn-primary mt-5"><i class="fas fa-gamepad"></i> Zu meinen Käufen</a>
        </section>
    <?php endif; ?>

    <!-- Popular by developer -->
    <?php if (!empty($popularByDev)): ?>
        <section class="space-y-8">
            <h2 class="flex items-center gap-2 font-display text-2xl text-white"><i class="fas fa-ranking-star text-brand-green"></i> Beliebt nach Entwickler</h2>
            <?php foreach ($popularByDev as $dev => $list): ?>
                <div>
                    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-neutral-400"><?= e($dev) ?></h3>
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        <?php foreach ($list as $g): ?>
                            <?php $cover = !empty($g['images']) ? $g['images'][0] : 'assets/favicon.ico'; ?>
                            <button onclick="GG.openDetail(<?= (int) $g['id'] ?>)" class="card w-44 shrink-0 overflow-hidden text-left transition hover:-translate-y-1 hover:border-neutral-700">
                                <div class="h-24 w-full overflow-hidden bg-neutral-800">
                                    <img src="<?= e($cover) ?>" alt="<?= e($g['name']) ?>" class="h-full w-full object-cover">
                                </div>
                                <div class="p-3">
                                    <p class="truncate text-sm font-semibold text-white"><?= e($g['name']) ?></p>
                                    <div class="mt-1 flex items-center justify-between">
                                        <span class="text-xs <?= strcasecmp((string) $g['price'], 'Gratis') === 0 ? 'text-brand-green' : 'text-neutral-300' ?>"><?= e(formatPrice($g['price'])) ?></span>
                                        <span class="chip bg-neutral-800 text-neutral-400"><i class="fas fa-shopping-bag text-[10px]"></i> <?= (int) ($g['purchases'] ?? 0) ?></span>
                                    </div>
                                </div>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/partials/modals.php'; ?>
<script src="public/js/ggames.js"></script>
<?php include __DIR__ . '/partials/foot.php'; ?>
