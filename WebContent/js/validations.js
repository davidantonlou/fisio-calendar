/*
 * 
 * JS que valida los datos del formulario, asi evitamos mandar datos erroneos la servidor
 * 
 */
function validateEmail(mail) {
	var exr = /^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i;
	return exr.test(mail);
}

function validateTelephone(tel)
{
	var test = /^[689]\d{8}$/;
	var telReg = new RegExp(test);
	return telReg.test(tel);
}