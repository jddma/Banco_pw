let url =String(window.location);
let error=false;

if(url.indexOf("destino=false") != -1)
{
    alert("No se encontro la cuenta de destino");
    error=true;
}
else if(url.indexOf("origen=false") != -1)
{
    alert("No se encontro la cuenta de origen");
    error=true;
}
else if(url.indexOf("monto=false") != -1)
{
    alert("La cuenta de origen no cuenta con el monto suficiente");
    error=true;
}
else if(url.indexOf("negativo=true") != -1)
{
    alert("No puede transferir valores negativos");
    error=true;
}

if(error)
{
    location.href=url.substring(0,url.indexOf("?"));
}