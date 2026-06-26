<?php
/**
 * Account page. Expects: $user (assoc), $library[], $cards[], $friends[].
 * Tabs: Käufe (library), Zahlung (cards), Freunde, Kontoinformationen.
 */
$title = 'GGAMES - Konto';
$active = 'konto';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<main class="mx-auto max-w-7xl px-4 py-8">
    <h1 class="mb-2 font-display text-3xl text-white">Mein Konto</h1>

    <?php if ($flash): ?>
        <div class="mb-5 rounded-lg border border-brand-orange/40 bg-brand-orange/10 px-4 py-3 text-sm text-brand-orange-soft">
            <i class="fas fa-circle-info"></i> <?= e($flash) ?>
        </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="mb-6 flex flex-wrap gap-1 border-b border-neutral-800">
        <button data-tab="kaeufe" class="gg-tab border-b-2 border-brand-orange px-4 py-2 text-sm font-semibold text-white"><i class="fas fa-gamepad"></i> Käufe</button>
        <button data-tab="zahlung" class="gg-tab border-b-2 border-transparent px-4 py-2 text-sm font-semibold text-neutral-400 hover:text-white"><i class="fas fa-credit-card"></i> Zahlung</button>
        <button data-tab="freunde" class="gg-tab border-b-2 border-transparent px-4 py-2 text-sm font-semibold text-neutral-400 hover:text-white"><i class="fas fa-user-group"></i> Freunde</button>
        <button data-tab="konto" class="gg-tab border-b-2 border-transparent px-4 py-2 text-sm font-semibold text-neutral-400 hover:text-white"><i class="fas fa-user"></i> Kontoinformationen</button>
    </div>

    <!-- Käufe / library -->
    <section data-panel="kaeufe">
        <?php if (empty($library)): ?>
            <div class="card flex flex-col items-center p-12 text-center">
                <i class="fas fa-box-open text-5xl text-neutral-700"></i>
                <h2 class="mt-4 text-xl font-semibold text-white">Noch keine Käufe</h2>
                <p class="mt-1 text-sm text-neutral-400">Stöbere im Shop und hol dir dein erstes Spiel.</p>
                <a href="store" class="btn-primary mt-5"><i class="fas fa-store"></i> Zum Shop</a>
            </div>
        <?php else: ?>
            <p class="mb-4 text-sm text-neutral-400"><?= count($library) ?> Spiel(e) in deiner Bibliothek.</p>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($library as $game): ?>
                    <?php $context = 'library'; include __DIR__ . '/partials/game-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Zahlung / payment cards -->
    <section data-panel="zahlung" class="hidden">
        <div class="grid gap-6 lg:grid-cols-2">
            <div>
                <h2 class="mb-3 text-lg font-semibold text-white">Gespeicherte Karten</h2>
                <?php if (empty($cards)): ?>
                    <div class="card p-6 text-center text-sm text-neutral-400">
                        <i class="fas fa-credit-card text-2xl text-neutral-600"></i>
                        <p class="mt-2">Noch keine Karte gespeichert.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($cards as $card): ?>
                            <?php $last4 = substr(preg_replace('/\s+/', '', (string) $card['number']), -4); ?>
                            <div class="card flex items-center justify-between bg-gradient-to-br from-neutral-800 to-neutral-900 p-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-credit-card text-brand-orange"></i>
                                        <span class="font-semibold text-white"><?= e($card['brand'] ?: 'Karte') ?></span>
                                        <span class="text-neutral-400">•••• <?= e($last4) ?></span>
                                    </div>
                                    <p class="mt-1 text-xs text-neutral-500"><?= e($card['cardholder']) ?> · gültig bis <?= e($card['expiry']) ?></p>
                                </div>
                                <a href="deleteCard?id=<?= (int) $card['id'] ?>" class="btn-danger" title="Entfernen"
                                   onclick="return confirm('Karte entfernen?')"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <p class="mt-3 text-xs text-neutral-500"><i class="fas fa-circle-info"></i> Simulierte Zahlung – Kartendaten werden nicht geprüft oder verarbeitet.</p>
            </div>

            <div>
                <h2 class="mb-3 text-lg font-semibold text-white">Karte hinzufügen</h2>
                <form action="addCard" method="post" class="card space-y-4 p-5">
                    <div>
                        <label class="label" for="c_holder">Karteninhaber</label>
                        <input id="c_holder" name="cardholder" class="input" placeholder="Max Mustermann" required>
                    </div>
                    <div>
                        <label class="label" for="c_number">Kartennummer</label>
                        <input id="c_number" name="number" class="input" placeholder="4242 4242 4242 4242" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="c_expiry">Gültig bis</label>
                            <input id="c_expiry" name="expiry" class="input" placeholder="MM/JJ" required>
                        </div>
                        <div>
                            <label class="label" for="c_brand">Typ</label>
                            <input id="c_brand" name="brand" class="input" placeholder="Visa">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full"><i class="fas fa-plus"></i> Karte speichern</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Freunde -->
    <section data-panel="freunde" class="hidden">
        <h2 class="mb-3 text-lg font-semibold text-white">Meine Freunde</h2>
        <?php if (empty($friends)): ?>
            <div class="card p-6 text-center text-sm text-neutral-400">Noch keine Freunde verknüpft.</div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                <?php foreach ($friends as $f): ?>
                    <div class="card flex items-center gap-3 p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-green/15 text-brand-green">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="font-medium text-white"><?= e($f['username']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="mt-3 text-xs text-neutral-500"><i class="fas fa-circle-info"></i> In der Spiel-Detailansicht siehst du, welche Freunde ein Spiel besitzen.</p>
        <?php endif; ?>
    </section>

    <!-- Kontoinformationen -->
    <section data-panel="konto" class="hidden">
        <div class="card max-w-xl p-6">
            <h2 class="mb-4 text-lg font-semibold text-white">Kontoinformationen</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-neutral-800 pb-2">
                    <dt class="text-neutral-400">Email</dt>
                    <dd class="font-medium text-white"><?= e($user['email'] ?? '') ?></dd>
                </div>
                <div class="flex justify-between border-b border-neutral-800 pb-2">
                    <dt class="text-neutral-400">Username</dt>
                    <dd class="font-medium text-white"><?= e(($user['username'] ?? '') !== '' ? $user['username'] : 'Leer') ?></dd>
                </div>
                <div class="flex justify-between border-b border-neutral-800 pb-2">
                    <dt class="text-neutral-400">Rolle</dt>
                    <dd><span class="chip <?= isAdmin() ? 'bg-brand-orange/20 text-brand-orange' : 'bg-neutral-800 text-neutral-300' ?>"><?= isAdmin() ? 'Admin' : 'Benutzer' ?></span></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-400">Erstellt am</dt>
                    <dd class="font-medium text-white"><?= e(!empty($user['created_at']) ? date('d.m.Y', strtotime($user['created_at'])) : '-') ?></dd>
                </div>
            </dl>
            <a href="editKonto?id=<?= (int) ($user['id'] ?? 0) ?>" class="btn-primary mt-5"><i class="fas fa-edit"></i> Bearbeiten</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/partials/modals.php'; ?>
<script src="public/js/ggames.js"></script>
<script>
    // Simple tab switching for the account page.
    document.querySelectorAll('.gg-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-tab');
            document.querySelectorAll('.gg-tab').forEach(function (b) {
                var on = b === btn;
                b.classList.toggle('border-brand-orange', on);
                b.classList.toggle('text-white', on);
                b.classList.toggle('border-transparent', !on);
                b.classList.toggle('text-neutral-400', !on);
            });
            document.querySelectorAll('[data-panel]').forEach(function (p) {
                p.classList.toggle('hidden', p.getAttribute('data-panel') !== key);
            });
        });
    });
</script>
<?php include __DIR__ . '/partials/foot.php'; ?>
