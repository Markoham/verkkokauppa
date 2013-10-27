function addTuote(tuote)
{
    var xmlhttp;
    
    if(tuote != "")
    {
        xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function()
        {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                updateOstoskori(JSON.parse(xmlhttp.responseText));
            }
        }
        xmlhttp.open("POST",basepath,true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("add=" + tuote + "&ostoskori=true");
    }
}

function updateOstoskori(ostoskori)
{
    var parent = document.getElementById("shoppingcartList");
    var button = document.getElementById("ostoskoributton");
    parent.innerHTML = "";
    
    button.innerHTML = "Ostoskorin sisältö (" + ostoskori.ostoskori.length + ")";
    
    var totalprice = 0.0;
    for(var t in ostoskori.ostoskori)
    {
        var tuote = document.createElement("li");
        tuote.innerHTML = ostoskori.ostoskori[t].tuote + " (" + ostoskori.ostoskori[t].maara + ") " + ostoskori.ostoskori[t].hintayht + " &euro;";
        parent.appendChild(tuote);
        
        totalprice += parseFloat(ostoskori.ostoskori[t].hintayht);
    }
    var divider = document.createElement("li");
    divider.setAttribute("class", "divider");
    parent.appendChild(divider);
    
    var total = document.createElement("li");
    total.innerHTML = "Yhteensä: " + totalprice + " &euro;";
    parent.appendChild(total);
}