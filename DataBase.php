<?php
class DataBase
{
	private static $db = null;
	private $connect;

	public function __construct()
	{
		try
		{
    		$config = require_once 'config.php';
            $dsn = 'mysql:host='.$config['host'].';dbname='.$config['dbName'].';charset='.$config['charset'];
            $this->connect = new PDO($dsn, $config['userName'], $config['userPassword']);
		}catch (PDOException $e) {
    	    echo "Соединение с базой данных не установлено";
            exit;
	    }
	}

    public static function getDB()
    {
        if (self::$db == null) self::$db = new DataBase();
        return self::$db;   
    }

    /**
    * Подгружаем все данные из таблицы task
    *
    * @param string $order - сортировка
    * @return array 
    */
    public function selectAllTask($order, $assigned_user_id)
    {   
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `task` WHERE assigned_user_id = $assigned_user_id AND user_id = 0 ORDER BY " . $order;
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":description", $description, PDO::PARAM_STR);
        $st->bindValue( ":date_added", $date_added, PDO::PARAM_STR);
        $st->execute();
        return  $st->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
    * Выбираем записи из БД, имеющие уникальный ID пользователя
    *
    * @return array
    */

    public function selectIdTask($order, $user_id)
    {
        $sql = "SELECT * FROM `task` WHERE user_id != $user_id AND user_id != 0 AND assigned_user_id = $user_id ORDER BY " . $order;
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":description", $description, PDO::PARAM_STR);
        $st->bindValue( ":date_added", $date_added, PDO::PARAM_STR);
        $st->execute();
        return  $st->fetchALL(PDO::FETCH_ASSOC);
    } 

    /**
    * Записываем задания, созданные конкретному пользователю
    *
    * @param string $assigned_user_id - запись id пользователя
    * @param string $description - текст задания
    */
    public function insertUserTask($user_id, $assigned_user_id, $description)
    {   
    	$date_added = date('Y-m-d H:i:s');
    	$sql = "INSERT INTO `task` (`user_id`, `assigned_user_id`,`description`,`date_added`) VALUES (:user_id, :assigned_user_id, :description, :date_added)";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":user_id", $user_id, PDO::PARAM_INT);
        $st->bindValue( ":assigned_user_id", $assigned_user_id, PDO::PARAM_INT);
        $st->bindValue( ":description", $description, PDO::PARAM_STR);
        $st->bindValue( ":date_added", $date_added, PDO::PARAM_STR);
        $st->execute();
        
    }

    /**
    * Запись задач и ID её создателя в БД
    * @param string $description - текст задания
    *
    */

    public function insertTask($assigned_user_id, $description)
    {   
        $date_added = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `task` (`assigned_user_id`, `description`,`date_added`) VALUES (:assigned_user_id, :description, :date_added)";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":assigned_user_id", $assigned_user_id, PDO::PARAM_STR);
        $st->bindValue( ":description", $description, PDO::PARAM_STR);
        $st->bindValue( ":date_added", $date_added, PDO::PARAM_STR);
        $st->execute();
        
    }

    /**
    * Удаление записей задач из БД
    *
    */

    public function deleteTask($id)
    {   
    	$sql = "DELETE FROM `task` WHERE id = :id LIMIT 1";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
    }

    /**
    * Установка меток о выполнении задач
    *
    */
    
    public function markTask($id)
    {   
    	$sql = "UPDATE `task` SET `is_done` = :is_done WHERE `id` LIKE :id";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":is_done", 1, PDO::PARAM_INT );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
    }

    /**
    * Редактирование текста задания в БД по id
    *
    */

    public function editTask($id, $description)
    {   
    	$sql = "UPDATE `task` SET `description` = ':description' WHERE `id` LIKE ':id'";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":description", $description, PDO::PARAM_STR );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
    }

    /**
    * Вывод списка пользователей
    *
    */    

    public function userList($id, $login)
    {
        $sql = "SELECT id, login FROM `user`";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":id", $id, PDO::PARAM_STR);
        $st->bindValue( ":login", $login, PDO::PARAM_STR);
        $st->execute(); 
        return $st->fetchALL(PDO::FETCH_ASSOC); 
    }

    /**
    * Создание нового пользователя в БД
    *
    * @return true
    */    

    public function newUser($login, $pass)
    {   
        $sql = "INSERT INTO user (login, password) VALUES (:login, :pass)";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":login", $login, PDO::PARAM_STR);
        $st->bindValue( ":pass", $pass, PDO::PARAM_STR);
        $st->execute();
        return true;
    }

    /**
    * Класс аутентификации пользователя
    * @return array 
    *
    */

    public function authUser($login, $password)
    {   
        $sql = "SELECT login, password,id FROM `user` WHERE login = :login AND password = :password";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":login", $login, PDO::PARAM_STR);
        $st->bindValue( ":password", $password, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
    * Выдача списка всех логинов пользователей
    * @return array 
    */

    public function getUserForLogin($login)
    {   
        $sql = "SELECT * FROM `user` WHERE `login` LIKE :login";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":login", $login, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchALL(PDO::FETCH_ASSOC);
    }


    /**
    * Поиск заданий в БД по значению $search
    * @return array 
    */

    public function searchTask($user_id, $search)
    {
        $sql = "SELECT * FROM task WHERE assigned_user_id = $user_id AND description LIKE '%$search%'";
        $st = $this->connect->prepare($sql);
        $st->bindValue( ":description", $search, PDO::PARAM_STR);
        $st->execute();
        return  $st->fetchALL(PDO::FETCH_ASSOC);
    }
}
?>