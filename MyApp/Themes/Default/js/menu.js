window.onload = init;

function init()
{
    var linkit = document.querySelectorAll("#nav a.paakategoria");
    for(var i = 0, l = linkit.length; i < l; i++)
    {
        link = linkit[i];
        
        link.addEventListener('click', function(e){
            console.log("Show submenu");
        });
    }
}

function addTuote(tuote)
{
    xmlhttp.open("POST","ostoskori.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("add=" + tuote);
    
    updateOstoskori();
}

function updateOstoskori()
{
}