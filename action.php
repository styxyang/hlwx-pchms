<?php
session_start();     /* initialize session */

$host = 'localhost';
$db = 'intelpchms';
$user = 'root';
$pwd = 'styx_hy';

echo count($_SESSION);
print_r($_SESSION);
switch ($_GET['action']) {
case "login":
  login();
  break;
case "logout":
  logout();
  break;
case "register":
  register();
  break;
}


/*!
 * Login: Connect to the database for authenticate
 * ========================================
 */

function login() {
  // refer to global variables
  global $host, $user, $pwd, $db;

  $link = mysql_connect($host, $user, $pwd);
  if (!isset($link))
    die("cannot connect to database");

  mysql_select_db($db, $link);

  $query = "SELECT * FROM usertable WHERE username = '$_POST[username]' AND password = '$_POST[passwd]'";
  $result = mysql_query($query, $link);
  echo $query;
  if (mysql_num_rows($result) == 0) {
    echo "this user does not exist";
    mysql_close($link);
  } else {
    echo "hello, $_POST[username]";
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['passwd'] = md5($_POST['passwd']);
    $_SESSION['userid'] = $row['userid'];
    $_SESSION['login'] = true;
    mysql_close($link);
    header("location:/navi.php");
  }
}

function logout() {
  session_destroy();
  header("location:/index.php");

}

function register() {
  $link = mysql_connect($host, $user, $pwd);
  if (!isset($link))
    die("cannot connect to database");

  mysql_select_db($db, $link);
  $query = "SELECT * FROM usertable WHERE username=('$_POST[user_name]') AND password=('$_POST[pwd]')";

  $result = mysql_query($query, $link);

  if (mysql_num_rows($result) == 0) {
    echo "this user does not exist";
    echo $_POST['username'];
    $query = "INSERT INTO usertable(username, password, regtime, age, faculty, sex, city, school, grade) values('$_POST[user_name]', '$_POST[pwd]',curtime(), $_POST[age], '$_POST[faculty], $_POST[sex])";
    mysql_query($query, $link);
    mysql_close($link);
  } else {
    echo "hello, $_POST[username]";
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['passwd'] = md5($_POST['passwd']);
    $_SESSION['userid'] = $row['userid'];
    $_SESSION['login'] = true;
    mysql_close($link);
    header("location:/navi.php");
  }
    
  
}
?>
