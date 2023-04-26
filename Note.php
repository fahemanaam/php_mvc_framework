
html create navbar using ajax to load pages:
    function loadPage(url) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    -----------------------
    <a href="#" onclick="loadPage('page1.html')">Page 1</a>
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
