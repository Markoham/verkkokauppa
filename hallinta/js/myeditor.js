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

function addCategory()
{
    var search = document.getElementById("searchfield");

    if(searchfield.value != "")
    {
        var allOptions = document.getElementById("catlist");

        var selectedOption;
        for(var i = 0, c = allOptions.childNodes.length; i < c; i++)
        {
            console.log(allOptions.childNodes[i].id);
            if(allOptions.childNodes[i].value == searchfield.value)
            {
                selectedOption = allOptions.childNodes[i];
                break;
            }
        }

        if(selectedOption && !document.getElementById("catListItem_"+selectedOption.id))
        {
            var cat = document.createElement("div");
            cat.setAttribute("id", "catListItem_"+selectedOption.id);
            cat.setAttribute("class" ,"catListItem");
            cat.setAttribute("data-action", "add");
            console.log(searchfield);
            var spanText = document.createElement("span");
            spanText.setAttribute("class" ,"catListItemText");
            spanText.innerHTML = selectedOption.value;
            cat.appendChild(spanText);

            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "catElem[]");
            input.value = selectedOption.id + "_add";
            input.setAttribute("data-id", selectedOption.id);
            input.setAttribute("data-database", "false");
            cat.appendChild(input);

            var btnClose = document.createElement("button");
            btnClose.setAttribute("class" ,"catListItemClose");
            btnClose.setAttribute("type" ,"button");
            btnClose.setAttribute("onClick", "removeCategory('catListItem_"+selectedOption.id+"');");
            btnClose.innerHTML = "x";
            cat.appendChild(btnClose);

            document.getElementById("productcategylist").appendChild(cat);
        }
        else if(selectedOption && document.getElementById("catListItem_"+selectedOption.id))
        {
            var input = document.getElementById("catListItem_"+selectedOption.id).getElementsByTagName("input")[0];
            input.value = input.getAttribute("data-id") + "_add";
            input.parentElement.setAttribute("data-action", "add");
        }

    }
    searchfield.value = "";
}

function removeCategory(id)
{
    var input = document.getElementById(id).getElementsByTagName("input")[0];
    if(input.getAttribute("data-database") == "true")
    {
        input.value = input.getAttribute("data-id") + "_remove";
        input.parentElement.setAttribute("data-action", "remove");
    }
    else
    {
        var list = document.getElementById("productcategylist");
        var elem = document.getElementById(id);
        if(elem)
            list.removeChild(elem);
    }
}
