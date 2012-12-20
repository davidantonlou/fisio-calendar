/*
 * 
 * JS que valida los datos del formulario, asi evitamos mandar datos erroneos la servidor
 * 
 */
function validateEmail(valor) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/.test(valor)){
	 return true;
  } else {
     return false;
  }
}

function validateTelephone(tel)
{
	var test = /^[689]\d{8}$/;
	var telReg = new RegExp(test);
	return telReg.test(tel);
}