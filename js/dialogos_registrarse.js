let url =String(window.location);
let error=false;
if(url.indexOf("email_valido=false") != -1)
{
    alert("Porfavor ingrese una dirección de correo valida");
    error=true;
}else if(url.indexOf("pwd=false") != -1)
{
    alert("Las contraseñas no coinciden");
    error=true;
}

if(error)
{
    location.href=url.substring(0,url.indexOf("?"));
}