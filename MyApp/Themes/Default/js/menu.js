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
    console.log(ostoskori);
}