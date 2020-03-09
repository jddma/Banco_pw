let url =String(window.location);
let error=false;

if(url.indexOf("transferencia=true") != -1)
{
    alert("Transferencia realizada");
    error=true;
}
else if(url.indexOf("retiro=true") != -1)
{
    alert("Retiro exitoso");
    error=true;
}
else if(url.indexOf("consignacion=true") != -1)
{
    alert("Consignacion exitosa");
    error=true;
}
else if(url.indexOf("nueva_clave=true") != -1)
{
    alert("Contraseña modificada exitosamente");
}

if(error)
{
    location.href=url.substring(0,url.indexOf("?"));
}