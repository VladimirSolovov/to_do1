<?
if(empty($_SESSION['username'])){?>
	<p class="to_reg">Если вы не зарегистрированы в системе, <a href="form_register.php">зарегистрируйтесь</a></p><?}?>
</br>
<?	if(!isset($_SESSION['username'])){?>
	   <form action="enter.php?action=login" method="post">
        	    <div class="row">
        	        <label for="name" >Логин:</label>
        	        <input type="text" class="text" name="login" id="login" />
        	    </div>
        	    <div class="row">
        	        <label for="password">Пароль:</label>
        	        <input type="password" class="text" name="password" id="password" />
        	    </div>
	    <div class="row">
    	        <input type="submit" name="submit" id="btn-submit" value="Авторизоваться" />
	    </div><?}?>
<?
	   if(isset($_SESSION['username'])){?>
	       <h5>Список дел на сегодня: </h5>
        	<? if($action == 'edit') { ?>
            	<div class="form">
                    <form method="post" action="index.php">
                        <input class="field" type="text" name="description" value="<?php echo $description;?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="change" value="Изменить задачу">
                    </form>
                </div>
            <? }else{ ?>
                <div class="form">
                    <form method="post" action="index.php">
                        <input class="field" type="text" name="description" placeholder="Описание задания" value="">
                        <input type="submit" name="addTask" class="btn btn-secondary" value="Добавить задачу">
                    </form>
                    <form method="POST" action="index.php">
                        <label for="order">Сортировать по:</label></br>
                        <select class="form" name="order_by">
                            <option value="date_added">Дате добавления</option>
                            <option value="is_done">Статусу</option>
                            <option value="description">Описанию</option>
                        </select>
                        <input type="submit" name="order" class="btn btn-secondary" value="Cортировать">
                <br>
                        <label for="role">Добавить задание пользователю: </label></br>
                <div class="form">
            	    <form action="index.php?action=role" method="post"> 
                        <input class="field" type="text" name="description" placeholder="Описание задания" value="">
                    <select class="form" name="login">
<?
            		foreach ($row as $key => $value){?>
                  		<option value="<?= $value['id']?>"><?= $value['login'] ?></option>
                    <? } ?>
            		</select> 
                    	<input type="submit" name="role" class="btn btn-secondary" value="Добавить">
                    		</form>
                        </div>
                		<div class="form">
                			<form method="get" action="index.php"> 
                			<input class="field" type="text" name="description" placeholder="Найти задание" value="">
                			<input type="submit" name="search" class="btn btn-secondary" value="Поиск">
                		</div>
                        <div>
                        	<h5>Ваши задания: </h5>
                        </div>
                            </form>
                        </div>
                <? } ?>
		<div>
        <table class="table table-bordered table-striped">
                <tr>
                    <th>Описание задачи</th>
                    <th>Дата добавления</th>
                    <th>Статус</th>
                    <th>Редактирование</th>
                </tr>
<?
             foreach ($task as $key => $value){
?>
                <tr>
                    <td><?php echo htmlspecialchars($value['description'], ENT_QUOTES); ?></td>
                    <td><?php echo $value['date_added']; ?></td>
                    <? if ($value['is_done']){ ?>
                        <td style='color: #41f4a3;'>Выполнено</td>
                    <? }else{ ?>
                        <td style='color: #f46241;'>Не выполнено</td>
                    <? } ?>
                    <td>
                        <a href="?id=<?=$value['id']; ?>&description=<?=$value['description'];?> $action=editData">Изменить</a>
                        <a href="?id=<?=$value['id']; ?>&action=done">Выполнено</a>
                        <a href="?id=<?=$value['id']; ?>&action=delete">Удалить</a>
                    </td>
                </tr>
<? } ?>
        </table>
    </div>
<? } ?>
            <div>
<? if(!empty($iduser)){ 
?>
            	<h5>Назначенные задания: </h5>
            </div>
        </form>
    </div>
		<div>
        <table class="table table-bordered table-striped">
                <tr>
                    <th>Описание задачи</th>
                    <th>Дата добавления</th>
                    <th>Статус</th>
                    <th>Редактирование</th>
                </tr>
<?
    foreach ($iduser as $key => $value){
?>
                <tr>
                    <td><? echo htmlspecialchars($value['description'], ENT_QUOTES); ?></td>
                    <td><? echo $value['date_added']; ?></td>
                    <? if ($value['is_done']){ ?>
                        <td style='color: #41f4a3;'>Выполнено</td>
                    <? }else{ ?>
                        <td style='color: #f46241;'>Не выполнено</td>
                    <? } ?>
                    <td>
                        <a href="?id=<?=$value['id']; ?>&description=<?=$value['description']; $action='editData'?>">Изменить</a>
                        <a href="?id=<?=$value['id']; ?>&action=done">Выполнено</a>
                        <a href="?id=<?=$value['id']; ?>&action=delete">Удалить</a>
                    </td>
                </tr>
            <? } ?>
        </table>
    </div>
<? } ?>    
<?    
    if(!empty($_GET['search'])){?>
    	<h5>Найденные задания: </h5>
		<div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Описание задачи</th>
                <th>Дата добавления</th>
                <th>Статус</th>
                <th>Редактирование</th>
            </tr>
<?
      foreach ($find as $key => $value){
?>
                <tr>
                    <td><? echo htmlspecialchars($value['description'], ENT_QUOTES); ?></td>
                    <td><? echo $value['date_added']; ?></td>
                    <? if ($value['is_done']){ ?>
                        <td style='color: #41f4a3;'>Выполнено</td>
                    <? }else{ ?>
                        <td style='color: #f46241;'>Не выполнено</td>
                    <? } ?>
                    <td>
                        <a href="?id=<?=$value['id']; ?>&description=<?=$value['description']; $action='editData'?>">Изменить</a>
                        <a href="?id=<?=$value['id']; ?>&action=done">Выполнено</a>
                        <a href="?id=<?=$value['id']; ?>&action=delete">Удалить</a>
                    </td>
                </tr>
            <? }} 
                unset($search) ?>
            </table>
        </div>