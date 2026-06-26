<?php
/**
 * Shared modal containers: inline game detail (everyone) and the admin
 * add/edit game form (admins only). Included once per page that shows cards.
 */
?>

<!-- Game detail modal -->
<div id="detailModal" class="gg-modal fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/70 p-4 backdrop-blur-sm">
    <div class="card my-8 w-full max-w-4xl animate-fade-in">
        <div class="flex items-center justify-between border-b border-neutral-800 px-5 py-3">
            <span class="font-display text-lg text-white">Spiel-Details</span>
            <button type="button" data-close-modal="detailModal" class="text-neutral-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
        </div>
        <div id="detailBody" class="p-5"></div>
    </div>
</div>

<?php if (isAdmin()): ?>
<!-- Admin add/edit game modal -->
<div id="gameFormModal" class="gg-modal fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/70 p-4 backdrop-blur-sm">
    <div class="card my-8 w-full max-w-2xl animate-fade-in">
        <div class="flex items-center justify-between border-b border-neutral-800 px-5 py-3">
            <span id="gameFormTitle" class="font-display text-lg text-white">Spiel hinzufügen</span>
            <button type="button" data-close-modal="gameFormModal" class="text-neutral-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form id="gameForm" action="addGame" method="post" class="space-y-4 p-5">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="gf_name">Name</label>
                    <input id="gf_name" name="name" class="input" required>
                </div>
                <div>
                    <label class="label" for="gf_entwickler">Entwickler</label>
                    <input id="gf_entwickler" name="entwickler" class="input" required>
                </div>
            </div>

            <div>
                <label class="label" for="gf_price">Preis (CHF)</label>
                <div class="flex items-center gap-3">
                    <input id="gf_price" name="price" type="number" step="0.01" min="0" class="input" placeholder="z. B. 59.95">
                    <label class="flex items-center gap-2 whitespace-nowrap text-sm text-neutral-300">
                        <input id="gf_gratis" name="gratis" value="1" type="checkbox" class="h-4 w-4 accent-brand-green"> Gratis
                    </label>
                </div>
            </div>

            <div>
                <label class="label" for="gf_description">Beschreibung</label>
                <textarea id="gf_description" name="description" rows="3" class="input" placeholder="Worum geht es in diesem Spiel?"></textarea>
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <span class="label mb-0">Bilder (URL oder base64)</span>
                    <button type="button" id="addImageBtn" class="btn-ghost"><i class="fas fa-plus"></i> Bild</button>
                </div>
                <div id="imageInputs" class="space-y-2"></div>
                <p class="mt-1 text-xs text-neutral-500">Das erste Bild ist das Cover. Vorschau erscheint automatisch.</p>
            </div>

            <div class="flex justify-end gap-2 border-t border-neutral-800 pt-4">
                <button type="button" data-close-modal="gameFormModal" class="btn-ghost">Abbrechen</button>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Speichern</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
