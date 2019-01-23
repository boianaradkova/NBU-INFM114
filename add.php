<?php
/*
 * Отваряне на връзка към базата данни.
 */ 
$conect = mysqli_connect("localhost", "root", "", "INFM114") or die(mysql_error());

/*
 * Тази част от скрипта се изпълнява след изпращане на данни от браузъра, чрез формата за submit.
 */ 
if (isset($_POST['submit'])) {
    /*
     * Проверка на входните за скрипта параметри.
     */ 
    if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2']) {
        die('You did not complete all of the required fields');
    }
    
    /*
     * Проверка за това дали потребителското име се използва.
     */ 
    if (!get_magic_quotes_gpc()) {
        $_POST['username'] = addslashes($_POST['username']);
    }
    
    $usercheck = $_POST['username'];
    $check = mysqli_query($conect, "SELECT username FROM users WHERE username = '$usercheck'") or die(mysql_error());
    $check2 = mysqli_num_rows($check);
    
    /*
     * Ако потребителското име се ползва, то показване на грешка.
     */ 
    if ($check2 != 0) {
        die('Sorry, the username ' . $_POST['username'] . ' is already in use.');
    }
    
    /*
     * Валидация за съвпадение на повторното въвеждане на паролата.
     */ 
    if ($_POST['pass'] != $_POST['pass2']) {
        die('Your passwords did not match. ');
    }
    
    /*
     * Хеширане на паролата за да не бъде в открит текст в базата данни.
     */ 
    $_POST['pass'] = md5($_POST['pass']);
    
    if (!get_magic_quotes_gpc()) {
        $_POST['pass']     = addslashes($_POST['pass']);
        $_POST['username'] = addslashes($_POST['username']);
    }
    
    /*
     * Въвеждане на нов запис в тяблицата с потребители.
     */ 
    $insert     = "INSERT INTO users (username, password) VALUES ('" . $_POST['username'] . "', '" . $_POST['pass'] . "')";
    $add_member = mysqli_query($conect, $insert);
?>

 <h1>Registered</h1>

 <p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>

 <?php
}

else {
?>
 
 <form action="<?php
    echo $_SERVER['PHP_SELF'];
?>" method="post">

 <table border="0">

 <tr><td>Username:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>

 <tr><td>Password:</td><td>

 <input type="password" name="pass" maxlength="10">

 </td></tr>

 <tr><td>Confirm Password:</td><td>

 <input type="password" name="pass2" maxlength="10">

 </td></tr>

 <tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table>

 </form>

 <?php
}
?> 
