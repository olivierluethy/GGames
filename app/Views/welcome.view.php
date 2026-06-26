<?php
/** Public landing page (guests only — logged-in users get home.view.php). */
$title = 'GGAMES - Welcome';
$active = 'home';
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<!-- Hero -->
<section class="relative h-[70vh] min-h-[420px] w-full overflow-hidden">
    <img src="assets/welcome.jpg" alt="" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/70 to-neutral-950/30"></div>
    <div class="relative mx-auto flex h-full max-w-7xl flex-col items-start justify-center px-4">
        <span class="chip bg-brand-orange/20 text-brand-orange"><i class="fas fa-gamepad"></i> Dein Game Store</span>
        <h1 class="mt-4 font-display text-5xl text-white drop-shadow-lg sm:text-6xl">
            Welcome to <span class="text-brand-orange">G</span><span class="text-brand-green">G</span>AMES!
        </h1>
        <p class="mt-4 max-w-xl text-lg text-neutral-300">
            Entdecke, kaufe und sammle deine Lieblingsspiele – ein Store, gebaut von Gamern für Gamer.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="store" class="btn-primary px-6 py-3 text-base"><i class="fas fa-store"></i> Zum Shop</a>
            <a href="register" class="btn-green px-6 py-3 text-base"><i class="fas fa-user-plus"></i> Konto erstellen</a>
        </div>
    </div>
</section>

<!-- About -->
<main class="mx-auto max-w-5xl px-4 py-16">
    <div class="grid gap-6 md:grid-cols-2">
        <div class="card p-6">
            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-lg bg-brand-orange/15 text-brand-orange">
                <i class="fas fa-users text-xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-white">About Us</h2>
            <p class="mt-2 leading-relaxed text-neutral-400">
                GGames ist ein junger Game Store mit vielen neuen Spielen. Unser Traum ist es, eines Tages
                einer der größten Videospiel-Anbieter der Welt zu werden. Viel Spaß beim Stöbern!
            </p>
        </div>
        <div class="card p-6">
            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-lg bg-brand-green/15 text-brand-green">
                <i class="fas fa-rocket text-xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-white">What We Do</h2>
            <p class="mt-2 leading-relaxed text-neutral-400">
                Wir verkaufen Spiele aus allen Kategorien – von Kids bis Erwachsene. Das Besondere: Wir setzen
                auf Titel mit großer Zukunft und entwickeln sie weiter, statt sie fallen zu lassen.
            </p>
        </div>
    </div>

    <div class="mt-12 rounded-2xl border border-neutral-800 bg-gradient-to-r from-brand-orange/10 to-brand-green/10 p-8 text-center">
        <h3 class="font-display text-2xl text-white">Bereit zum Spielen?</h3>
        <p class="mt-2 text-neutral-300">Erstelle ein Konto und baue deine Sammlung auf.</p>
        <a href="register" class="btn-primary mt-5 px-6 py-3 text-base"><i class="fas fa-user-plus"></i> Jetzt loslegen</a>
    </div>
</main>

<?php include __DIR__ . '/partials/foot.php'; ?>
