<?php

require_once('bs_model.php');
require_once('bs_crypt.php');
require_once('bs_functions_generals.php');

class BSLogin
{
	// public $UserMail;
	private $sUserName;
	private $sUserPass;
	private $iUserId;
	// private $iUserType;
	// private $aPermisos;

	public function __construct()
	{
		// $this->sUserMail = "";
		$this->sUserName = "";
		$this->sUserPass = "";
		$this->iUserId = "";
		// $this->iUserTipo = "";
		// $this->aPermisos = array('admin' => -1, 'supervisor' => -1, 'representante' => -1);
	}

	//Funcion que logea a un usuario por username y password enviado por post
	public function Login()
	{
		if (isset($_POST['session_action']) && !strcmp($_POST['session_action'], "login"))
		{
			session_start();
			$aPost = post_request();			
			if ($this->Authenticate($aPost['username'], $aPost['password']))
			{
				$oModel = new BSModel();		
				$aUser = $oModel->Get('usuarios', array('username' => $aPost['username']));				
				$_SESSION['username'] = $aUser[0]['username'];
				$_SESSION['user_nombres'] = $aUser[0]['nombres'];
				$_SESSION['user_apellidos'] = $aUser[0]['apellidos'];
				$_SESSION['user_password'] = $aUser[0]['password'];
				$_SESSION['user_id'] = $aUser[0]['id'];
				// $_SESSION['usertype'] = $aUser[0]['tipo'];

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
		$oModel = new BSModel();		
		$aUser = $oModel->Get('usuarios', array('username' => $insUserName));
		$oCrypt = new BSCrypt($aUser[0]['password']);
		if (!strcmp($aUser[0]['username'], $insUserName) && $oCrypt->IsEqual($insUserPass))		
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
		if (isset($_SESSION['username']) && isset($_SESSION['user_password']) && isset($_SESSION['user_id']))
		{
			// $this->sUserMail = $_SESSION['usermail'];
			$this->sUserName = $_SESSION['username'];
			$this->sUserPass = $_SESSION['user_password'];
			$this->iUserId = $_SESSION['user_id'];
			// $this->iUserTipo = $_SESSION['usertype'];			
		}
		else
		{
			$this->Logout();
			header('Location: index.php');
		}
	}
}

?>