if(document.location.hostname == "comprobantedigital.mx" || document.location.hostname == "www.comprobantedigital.mx")
{
	var webRoot = document.location.hostname+"/sistema";
}
else if(document.location.hostname == "facturase.com" || document.location.hostname == "www.facturase.com")
{
	var webRoot = document.location.hostname;
}
else
{
	var webRoot = document.location.hostname+"/facturacion";
}
var WEB_ROOT = 'http://' + webRoot+"/admin";
