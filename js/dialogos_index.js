let url =String(window.location);
let error=false;
if(url.indexOf("usuario=false") != -1)
{
    alert("Usuario no registrado");
    error=true;
}
else if(url.indexOf("registro=true") != -1)
{
    alert("Regsitro exitoso");
    error=true;
}
else if(url.indexOf("existente=true") != -1)
{
    alert("El usuaro ya se encuentra registrado");
    error=true;
}else if(url.indexOf("pwd=false") != -1)
{
    alert("Contraseña incorrecta");
    error=true;
}

if(error)
{
    location.href=url.substring(0,url.indexOf("?"));
}