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

        if (document.querySelector('#passwort') != null) {
            if (document.querySelector('#passwort').value.trim() === '') {
                document.querySelector('#passwort').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte geben Sie ein Passwort ein</label>");
                errors = true;
            } else if (document.querySelector('#passwort').value.length < 6) {
                document.querySelector('#passwort').insertAdjacentHTML("afterend", "<label class=\"warning\"> Passwort muss mindestens 6 Zeichen enthalten</label>");
                errors = true;
            }
        }

        if (document.querySelector('#passwort_again') != null) {
            if (document.querySelector('#passwort_again').value.trim() === '') {
                document.querySelector('#passwort_again').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte Passwort erneut eingeben.</label>");
                errors = true;
            } else if (document.querySelector('#passwort_again').value != document.querySelector('#passwort_again').value) {
                document.querySelector('#passwort_again').insertAdjacentHTML("afterend", "<label class=\"warning\"> Nicht das gleiche Passwort.</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }
    });
});