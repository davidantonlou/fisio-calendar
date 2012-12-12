/*This js contains major fuctions of login page*/


/**
 * This function checks if the login fields its fill
 * 
 */
function checkLogin()
{
	if(document.login_user.user == null ||document.login_user.user == "")
	{
		alert("Rellene el usuario");
		return false;
	}
	else if(document.login_user.pass == null ||document.login_user.pass == "")
	{
		alert("Rellene el password");
		return false;
	}
	return true;
}

/**
 * Do login
 */
function doLogin()
{
	if(checkLogin() == true)document.login_user.submit();
}

function clearLoginFields()
{
	document.login_user.user.value='';
	document.login_user.pass.value='';
}