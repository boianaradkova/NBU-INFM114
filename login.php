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
    if (!$_POST['username']) {
        die('You did not fill in a username.');
    }

    if (!$_POST['pass']) {
        die('You did not fill in a password.');
    }
    
    $check = mysqli_query($conect, "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'") or die(mysql_error());
    
    /*
     * Грешка, ако потребителят не присъства в таблицата с потребителите.
     */ 
    $check2 = mysqli_num_rows($check);
    if ($check2 == 0) {
        die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
    }
    
    while ($info = mysqli_fetch_array($check)) {
        $_POST['pass']    = stripslashes($_POST['pass']);
        $info['password'] = stripslashes($info['password']);
        $_POST['pass']    = md5($_POST['pass']);
        
        /*
         * Грешка, ако паролата не съвпада.
         */ 
        if ($_POST['pass'] != $info['password']) {
            die('Incorrect password, please <a href="login.php">try again</a>.');
        } else { 
            /*
             * Ако паролата съвпада се създава cookies.
             */ 
            $_POST['username'] = stripslashes($_POST['username']);
            $hour              = time() + 3600;
            setcookie(ID_your_site, $_POST['username'], $hour);
            setcookie(Key_your_site, $_POST['pass'], $hour);
            
            /*
             * Пренасочване към скрипта с членовете.
             */ 
            header("Location: members.php");
        }
    }
} else {
    /*
     * Изпълнява се когато потребителят не е влязал в системата.
     */ 
?>

 <form action="<?php
    echo $_SERVER['PHP_SELF'];
?>" method="post"> 

 <table border="0"> 

 <tr><td colspan=2><h1>Login</h1></td></tr> 

 <tr><td>Username:</td><td> 

 <input type="text" name="username" maxlength="40"> 

 </td></tr> 

 <tr><td>Password:</td><td> 

 <input type="password" name="pass" maxlength="50"> 

 </td></tr> 

 <tr><td colspan="2" align="right"> 

 <input type="submit" name="submit" value="Login"> 

 </td></tr> 

 </table> 

 </form> 

 <?php
}
?> 
