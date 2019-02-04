<?php
include 'templates/header.php';
if($_GET['action'] == 'logout')
{
	unset($_SESSION);
	include_once 'index.php';
}else if($_GET['action'] == 'login')
{
	if(!$_POST['login'] || !$_POST['password'])
	{
		echo 'Вы не заполнили обязательные поля, поле логин или пароль пустое';
	   die();
	}else{
		include 'db.php';
		$users = new DataBase();
		$result = $users->authUser($_POST['login'], $_POST['password']);
		if(empty($result))
	{
		echo "Введены неверные данные";
	}else{
		echo "Вы авторизованы, вернитесь на главную";
		$_SESSION['username'] = $result[0]['login'];
		$_SESSION['id'] = $result[0]['id'];
		?><a href="index.php"> Вернуться</a></p><?
		}
	}
	}else if($_GET['action'] == 'registration')
		{
		include_once 'Users.php';
		$users = new Users();
		$result = $users->registration($_POST['login'], $_POST['password']);
		if($result['status']){
			echo 'Вы успешно зарегистрировались, вернитесь на главную чтобы авторизоваться';
			?><a href="index.php"> На главную</a></p><?
		}else{
			echo $result['error'];
		}
}
include 'templates/footer.php';
?>