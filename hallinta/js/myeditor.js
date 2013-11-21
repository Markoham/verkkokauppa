window.onload = initEditor;
function initEditor()
{
    var liveElement = document.getElementById("productdescriptionlive");
    var sourceElement = document.getElementById("productdescriptionsource");
    liveElement.addEventListener("focus", function(){
        if (liveElement.textContent)
            liveElement.dataset.divPlaceholderContent = 'true';
        else
            delete(liveElement.dataset.divPlaceholderContent);
    }, false);

    liveElement.addEventListener("blur", function(){
        if (liveElement.textContent)
            liveElement.dataset.divPlaceholderContent = 'true';
        else
            delete(liveElement.dataset.divPlaceholderContent);
    }, false);

    sourceElement.addEventListener("change", function(){
        if (sourceElement.value)
            liveElement.dataset.divPlaceholderContent = 'true';
        else
            delete(liveElement.dataset.divPlaceholderContent);
    }, false);

    if (liveElement.textContent)
        liveElement.dataset.divPlaceholderContent = 'true';
    else
        delete(liveElement.dataset.divPlaceholderContent);
}

function showMarkdown()
{
    document.getElementById("linkproductdescriptionlive").className = "";
    document.getElementById("linkproductdescriptionsource").className = "active";

    var elem = document.getElementById("productdescriptionsource");
    elem.style.visibility = "visible";
    elem.style.display = "inherit";

    var elem2 = document.getElementById("productdescriptionlive");
    elem2.style.visibility = "hidden";
    elem2.style.display = "none";
}

function showLive()
{
    document.getElementById("linkproductdescriptionlive").className = "active";
    document.getElementById("linkproductdescriptionsource").className = "";

    var elem = document.getElementById("productdescriptionlive");
    elem.style.visibility = "visible";
    elem.style.display = "inherit";

    var elem2 = document.getElementById("productdescriptionsource");
    elem2.style.visibility = "hidden";
    elem2.style.display = "none";
}
