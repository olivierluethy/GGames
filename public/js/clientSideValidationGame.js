// Clientside Validierung
window.addEventListener("load", function() {

    document.querySelector('form').addEventListener('submit', function(evt) {

        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }
        if (document.querySelector('#name') != null) {
            if (document.querySelector('#name').value.trim() === '') {
                document.querySelector('#name').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Namen ein</label>");
                errors = true;
            }
        }
        if (document.querySelector('#entwickler') != null) {
            if (document.querySelector('#entwickler').value.trim() === '') {
                document.querySelector('#entwickler').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie den Namen des Entwicklers ein</label>");
                errors = true;
            }
        }
        if (document.querySelector('#img') != null) {
            if (document.querySelector('#img').value.trim() === '') {
                document.querySelector('#img').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie den Bildpfad ein</label>");
                errors = true;
            }
        }
        if (document.querySelector('#price') != null) {
            if (document.querySelector('#price').value.trim() === '') {
                document.querySelector('#price').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie den Preis des Spieles ein</label>");
                errors = true;
            }
        }
        if (errors) {
            evt.preventDefault();
        }
    });
});