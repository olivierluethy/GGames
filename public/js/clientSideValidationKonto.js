// Clientside Validierung
window.addEventListener("load", function () {

    document.querySelector('form').addEventListener('submit', function (evt) {

        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }


        if (document.querySelector('#email') != null) {
            if (document.querySelector('#email').value.trim() === '') {
                document.querySelector('#email').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Namen ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#username') != null) {
            if (document.querySelector('#username').value.trim() === '') {
                document.querySelector('#username').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie einen Nutzername ein</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }
    });
});