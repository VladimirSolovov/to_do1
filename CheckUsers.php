<?php

class CheckUsers
{

	private static $db = null;

	public function __construct()
	{
		include_once 'DataBase.php';
		if (self::$db == null) self::$db = new DataBase(); 
	}


	public function registration($login, $password){
		if(!$login || !$password){
			return [
				'status' => false,
				'error' => 'Не заполнен логин или пароль'
			];
		}
		if($result = self::$db->getUserForLogin($login)){
			return [
				'status' => false,
				'error' => 'Пользователь с таким логином уже существует'
			];
		}

		$result = self::$db->newUser($login, $password);

		if($result){
			return [
				'status' => true,
			];	
		}else{
			return [
				'status' => false,
				'error' => 'Что то пошло не так'
			];
		}
	}
}