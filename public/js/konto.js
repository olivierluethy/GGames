function openGuthaben() {
    document.getElementById("konto").style = "display: none";
    document.getElementById("kaeufe").style = "display: none";
    document.getElementById("guthaben").style = "display: block";

    document.getElementById("heading2").style = "font-style: italic; color: yellow;";
    document.getElementById("heading3").style = "font-style: normal; color: white;";
    document.getElementById("heading1").style = "font-style: normal; color: white;";
}

function openKaeufe() {
    document.getElementById("konto").style = "display: none";
    document.getElementById("kaeufe").style = "display: block";
    document.getElementById("guthaben").style = "display: none";

    document.getElementById("heading3").style = "font-style: italic; color: yellow;";
    document.getElementById("heading2").style = "font-style: normal; color: white;";
    document.getElementById("heading1").style = "font-style: normal; color: white;";
}

function openKonto() {
    document.getElementById("konto").style = "display: block";
    document.getElementById("kaeufe").style = "display: none";
    document.getElementById("guthaben").style = "display: none";

    document.getElementById("heading1").style = "font-style: italic; color: yellow;";
    document.getElementById("heading2").style = "font-style: normal; color: white;";
    document.getElementById("heading3").style = "font-style: normal; color: white;";
}

function editKonto(id) {
    location.href = "editKonto?id=" + id;
}