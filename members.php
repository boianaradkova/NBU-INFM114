<?php
/*
 * Отваряне на връзка към базата данни.
 */ 
$conect = mysqli_connect("localhost", "root", "", "INFM114") or die(mysql_error());

/*
 * Проверка на cookies за статуса на логването.
 */ 
if (isset($_COOKIE['ID_your_site'])) {
    $username = $_COOKIE['ID_your_site'];
    $pass     = $_COOKIE['Key_your_site'];
    $check = mysqli_query($conect, "SELECT * FROM users WHERE username = '$username'") or die(mysql_error());
    
    while ($info = mysqli_fetch_array($check)) {
        /*
         * Проверка на cookies за статуса на логването.
         */ 
        //if the cookie has the wrong password, they are taken to the login page 
        if ($pass != $info['password']) {
            header("Location: login.php");
        }
        else {
            /*
             * Проверка на cookies за статуса на логването.
             */ 
            //otherwise they are shown the admin area
            echo "Admin Area<p>";
            echo "Your Content<p>";
            echo "<a href=logout.php>Logout</a>";
        }
    }
} else { 
    /*
     * Проверка на cookies, ако не съществуват биват взети от входния прозорец.
     */ 
    header("Location: login");
}
?>
