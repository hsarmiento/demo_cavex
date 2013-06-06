<?php

require_once('st_model.php');
require_once('st_crypt.php');
require_once('st_functions_generals.php');

class STLogin
{
	public $UserMail;
	private $sUserName;
	private $sUserPass;
	private $iUserId;
	private $iUserType;
	private $aPermisos;

	public function __construct()
	{
		$this->sUserMail = "";
		$this->sUserName = "";
		$this->sUserPass = "";
		$this->iUserId = "";
		$this->iUserTipo = "";
		$this->aPermisos = array('admin' => -1, 'supervisor' => -1, 'representante' => -1);
	}

	//Funcion que logea a un usuario por username y password enviado por post
	public function Login()
	{
		if (isset($_POST['session_action']) && !strcmp($_POST['session_action'], "login"))
		{
			session_start();
			$aPost = post_request();			
			if ($this->Authenticate($aPost['email'], $aPost['password']))
			{
				$oModel = new STModel();		
				$aUser = $oModel->Get('st_usuario', array('email' => $aPost['email']));				
				$_SESSION['usermail'] = $aUser[0]['email'];
				$_SESSION['username'] = $aUser[0]['nombres'];
				$_SESSION['userpass'] = $aUser[0]['password'];
				$_SESSION['userid'] = $aUser[0]['id'];
				$_SESSION['usertype'] = $aUser[0]['tipo'];

				header('Location: home.php');
			}
			else
			{
				return -1;
			}
		}
	}

	//funcion que deslogea, desetea variables y destruye las sessiones
	public function Logout()
	{
		session_unset();
    	session_destroy();  
	}

	//funcion verifica si existe algun usuario logeado, sino redirecciona al index
	public function IsLogged($insAdmin = "", $insSuper = "", $insRep = "")
	{
		if (!empty($insAdmin))
		{
			$this->aPermisos['admin'] = 0;
		}
		if (!empty($insSuper))
		{
			$this->aPermisos['supervisor'] = 1;
		}
		if (!empty($insRep))
		{
			$this->aPermisos['representante'] = 2;
		}
		if (isset($_SESSION['usertype']))
		{
			if ($_SESSION['usertype'] != $this->aPermisos['admin'])
			{
				if ($_SESSION['usertype'] != $this->aPermisos['supervisor'])
				{
					if ($_SESSION['usertype'] != $this->aPermisos['representante'])
					{
						$this->Logout();
						header('Location: index.php');
					}
				}
				
			}
		}
	}

	//funcion que hace el match entre el username y el password con el guardado en la bd
	//returna true en caso de xito y false en caso contrario
	public function Authenticate($insUserName, $insUserPass)
	{
		$oModel = new STModel();		
		$aUser = $oModel->Get('st_usuario', array('email' => $insUserName));
		$oCrypt = new STCrypt($aUser[0]['password']);
		if (!strcmp($aUser[0]['email'], $insUserName) && $oCrypt->IsEqual($insUserPass))		
		{			
			return true;
		}
		else
		{			
			return false;
		}
	}

	//funcion que verifica si existe alguna session activa
	//retorna true en caso de exito y false en caso contrario
	public function ExistAnySession()
	{
		session_start();		
		if (isset($_SESSION['usermail']) && isset($_SESSION['username']) && isset($_SESSION['userpass']) && isset($_SESSION['userid']) && isset($_SESSION['usertype']))
		{
			$this->sUserMail = $_SESSION['usermail'];
			$this->sUserName = $_SESSION['username'];
			$this->sUserPass = $_SESSION['userpass'];
			$this->iUserId = $_SESSION['userid'];
			$this->iUserTipo = $_SESSION['usertype'];			
		}
		else
		{
			$this->Logout();
			header('Location: index.php');
		}
	}
}

?>