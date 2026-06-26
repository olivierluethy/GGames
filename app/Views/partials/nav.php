<?php
/**
 * Shared top navigation (dark, brand-themed).
 * Expects (optional): $active in {'home', 'store', 'konto'}
 */
$active = $active ?? '';
$navClass = function (string $key) use ($active) {
    return $active === $key
        ? 'text-white border-brand-orange'
        : 'text-neutral-400 border-transparent hover:text-white hover:border-neutral-600';
};
?>
<nav class="sticky top-0 z-40 border-b border-neutral-800 bg-neutral-950/80 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
        <a href="home" class="font-display text-2xl tracking-wider">
            <span class="text-brand-orange">G</span><span class="text-brand-green">G</span><span class="text-white">AMES</span>
        </a>

        <div class="flex items-center gap-1 sm:gap-2">
            <a href="home" class="border-b-2 px-3 py-1.5 text-sm font-medium transition <?= $navClass('home') ?>">Home</a>
            <a href="store" class="border-b-2 px-3 py-1.5 text-sm font-medium transition <?= $navClass('store') ?>">Shop</a>
            <?php if (isLoggedIn()): ?>
                <a href="konto" class="border-b-2 px-3 py-1.5 text-sm font-medium transition <?= $navClass('konto') ?>">
                    <i class="fas fa-gamepad"></i> Käufe
                </a>
            <?php endif; ?>
            <div class="ml-2">
                <?php include __DIR__ . '/account-menu.php'; ?>
            </div>
        </div>
    </div>
</nav>
