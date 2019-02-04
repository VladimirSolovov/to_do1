<?php
include 'templates/header.php';
include_once 'DataBase.php';
$newDb = new DataBase;
$action = '';
$assigned_user_id = $_SESSION['id'];
if (isset($_POST['addTask'])) 
{
	$action = (isset($_POST['addTask'])) ? 'addTask': "";
	$description = (isset($_POST['addTask'])) ? strip_tags(htmlspecialchars($_POST['description'])) : "";
}
elseif (isset($_GET['action'])) 
{
	$action = (isset($_GET['action'])) ? strip_tags(htmlspecialchars($_GET['action'])) : "";
	$id = intval($_GET['id']);
	$description = strip_tags(htmlspecialchars($_GET['description']));
}
elseif(isset($_POST['order']))
{
	$action = (isset($_POST['order'])) ? 'order' : "";
	$order = strip_tags(htmlspecialchars($_POST['order_by']));
}
elseif (isset($_POST['change']))
{
	$action = (isset($_POST['change'])) ? 'change' : "";
	$description = strip_tags(htmlspecialchars($_POST['description']));
	$id = intval($_POST['id']);
}
elseif (isset($_POST['role']))
{
    $action = (isset($_POST['role'])) ? 'role': "";
    $description = (isset($_POST['role'])) ? strip_tags(htmlspecialchars($_POST['description'])) : "";
}
elseif (isset($_GET['search'])) 
{
    $action = (isset($_GET['search'])) ? 'search': "";
    $search = (isset($_GET['search'])) ? strip_tags(htmlspecialchars($_GET['description'])) : "";
}

switch ($action)
{
    case 'addTask':
        if ($description != ''){
            $newDb->insertTask($assigned_user_id, $description);
        } else {
            echo "Поле описания задачи пустое! ";
        }
        break;

    case 'change':
        $newDb->editTask($id, $description);
        break;

    case 'done':
        $newDb->markTask($id);
        break;

    case 'delete':
        $newDb->deleteTask($id);
        break;

    case 'role':
        if ($description == ''){
            echo "Поле описания задачи пустое!";
        } else if($_POST['login'] == $_SESSION['id']) {
            echo "Ошибка назначения";
        } else {
            $newDb->insertUserTask($_SESSION['id'], $_POST['login'], $_POST['description']);
        }
        break;

    case 'search':
        if($search != ''){
            $newDb->searchTask($_SESSION['id'], $search);
        } else {
            echo "Пустой поисковый запрос";
        break;
    }
}

$order = ($action == 'order') ?  $order : "date_added";
$task = $newDb->selectAllTask($order, $assigned_user_id);
$row = $newDb->userList($id, $login);
$user_id = $_SESSION['id'];
$iduser = $newDb->selectIdTask($order, $user_id);
$find = $newDb->searchTask($_SESSION['id'], $search);
include_once 'template.php';
include 'templates/footer.php';
?>