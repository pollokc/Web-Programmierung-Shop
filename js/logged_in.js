function logged_in() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("logged_in").innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("GET", "logged_in.php", true);
    xhttp.send();
}
logged_in();
setInterval(logged_in, 5000);