<?php
    include 'templates/header.php';
?>
    <form action="enter.php?action=registration" method="post">
        <div class="row">
            <label for="login" style="
    padding-left: 25px;
    ">Логин:</label>
            <input type="login" class="text" name="login" id="login" />
        </div>
        <div class="row">
            <label for="password" style="
    padding-left: 25px;
    ">Пароль:</label>
            <input type="password" class="text" name="password" id="password"/>
        </div>  
        <div class="row">
            <input type="submit" name="submit" style="
    padding-left: 25px;
    " id="btn-submit" value="Зарегистрироваться" />
        </div>
    </form>
<?php
    include 'templates/footer.php';
?>