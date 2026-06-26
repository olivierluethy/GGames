<?php
/**
 * Account dropdown for the nav. Pure CSS (group-hover), no JS needed.
 * Uses the session for the logged-in state.
 */
?>
<?php if (isLoggedIn()): ?>
    <div class="group relative">
        <button class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-neutral-200 hover:bg-neutral-800">
            <i class="fa fa-user-circle text-lg text-brand-green"></i>
            <span><?= e(($_SESSION['username'] ?? '') !== '' ? $_SESSION['username'] : 'Konto') ?></span>
            <i class="fas fa-chevron-down text-[10px] text-neutral-500"></i>
        </button>
        <div class="absolute right-0 top-full hidden w-52 pt-2 group-hover:block">
            <div class="card overflow-hidden p-1">
                <a href="konto" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-neutral-200 hover:bg-neutral-800">
                    <i class="fas fa-user-circle w-4 text-neutral-400"></i> Kontoinformationen
                </a>
                <a href="konto" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-neutral-200 hover:bg-neutral-800">
                    <i class="fas fa-gamepad w-4 text-neutral-400"></i> Meine Käufe
                </a>
                <div class="my-1 border-t border-neutral-800"></div>
                <a href="logout" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-red-400 hover:bg-neutral-800">
                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                </a>
            </div>
        </div>
    </div>
<?php else: ?>
    <a href="login" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Einloggen</a>
<?php endif; ?>
