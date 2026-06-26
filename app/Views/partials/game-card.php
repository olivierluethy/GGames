<?php
/**
 * Reusable game card.
 * Expects: $game (with images[], price, price_dropped, previous_price, and in
 *          library context: purchased_at, price_paid)
 * Optional: $context in {'store', 'library'} (default 'store')
 */
$context = $context ?? 'store';
$images = !empty($game['images']) ? $game['images'] : ['assets/favicon.ico'];
$isGratis = strcasecmp((string) $game['price'], 'Gratis') === 0;
$gid = (int) $game['id'];
?>
<div class="card group flex flex-col overflow-hidden transition hover:-translate-y-1 hover:border-neutral-700 hover:shadow-xl hover:shadow-black/40 animate-fade-in">
    <!-- Cover / hover carousel (click opens detail) -->
    <div class="relative cursor-pointer" onclick="GG.openDetail(<?= $gid ?>)">
        <div data-carousel class="relative h-44 w-full overflow-hidden bg-neutral-800">
            <?php foreach ($images as $k => $src): ?>
                <img data-slide src="<?= e($src) ?>" alt="<?= e($game['name']) ?>"
                     class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 <?= $k === 0 ? '' : 'opacity-0' ?>">
            <?php endforeach; ?>

            <?php if (count($images) > 1): ?>
                <button data-prev class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 py-1 text-white opacity-0 transition group-hover:opacity-100 hover:bg-black/70"><i class="fas fa-chevron-left"></i></button>
                <button data-next class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 py-1 text-white opacity-0 transition group-hover:opacity-100 hover:bg-black/70"><i class="fas fa-chevron-right"></i></button>
                <div class="absolute bottom-2 left-1/2 flex -translate-x-1/2 gap-1.5">
                    <?php foreach ($images as $k => $src): ?>
                        <span data-dot class="h-1.5 w-1.5 rounded-full <?= $k === 0 ? 'bg-brand-orange' : 'bg-white/40' ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($game['price_dropped'])): ?>
                <span class="absolute left-2 top-2 chip bg-brand-green text-neutral-950 shadow"><i class="fas fa-arrow-trend-down"></i> Sale</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Body -->
    <div class="flex flex-1 flex-col p-4">
        <button onclick="GG.openDetail(<?= $gid ?>)" class="text-left">
            <h3 class="truncate font-semibold text-white hover:text-brand-orange"><?= e($game['name']) ?></h3>
        </button>
        <p class="mt-0.5 truncate text-sm text-neutral-400"><i class="fas fa-code text-xs"></i> <?= e($game['entwickler']) ?></p>

        <div class="mt-3 flex items-center gap-2">
            <?php if (!empty($game['price_dropped']) && isset($game['previous_price'])): ?>
                <span class="text-sm text-neutral-500 line-through"><?= e(formatPrice($game['previous_price'])) ?></span>
            <?php endif; ?>
            <span class="text-lg font-bold <?= $isGratis ? 'text-brand-green' : 'text-white' ?>"><?= e(formatPrice($game['price'])) ?></span>
        </div>

        <?php if ($context === 'library'): ?>
            <div class="mt-3 flex items-center justify-between">
                <span class="chip bg-brand-green/15 text-brand-green"><i class="fas fa-check"></i> Gekauft</span>
                <?php if (!empty($game['purchased_at'])): ?>
                    <span class="text-xs text-neutral-500"><i class="far fa-calendar"></i> <?= e(date('d.m.Y', strtotime($game['purchased_at']))) ?></span>
                <?php endif; ?>
            </div>
            <div class="mt-3 flex gap-2">
                <button onclick="GG.openDetail(<?= $gid ?>)" class="btn-ghost flex-1"><i class="fas fa-circle-info"></i> Details</button>
                <a href="returnGame?id=<?= $gid ?>" class="btn-danger" title="Zurückgeben"
                   onclick="return confirm('Dieses Spiel wirklich zurückgeben?')"><i class="fas fa-undo"></i></a>
            </div>
        <?php else: ?>
            <div class="mt-4 flex flex-wrap gap-2">
                <?php if (isAdmin()): ?>
                    <!-- Admins manage the catalogue and cannot buy games. -->
                    <button type="button" class="btn-ghost flex-1" title="Bearbeiten" onclick="GG.openEdit(<?= $gid ?>)"><i class="fas fa-edit"></i> Bearbeiten</button>
                    <a href="deleteGame?id=<?= $gid ?>" class="btn-danger" title="Löschen"
                       onclick="return confirm('Dieses Spiel wirklich löschen?')"><i class="fas fa-trash-alt"></i></a>
                <?php elseif (isLoggedIn()): ?>
                    <a href="buyGame?id=<?= $gid ?>" class="btn-primary flex-1" onclick="event.stopPropagation()">
                        <i class="fas fa-shopping-bag"></i> <?= $isGratis ? 'Holen' : 'Kaufen' ?>
                    </a>
                <?php else: ?>
                    <a href="login" class="btn-primary flex-1"><i class="fas fa-shopping-bag"></i> Kaufen</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
