<?php

$lifetime = 30;                      /* lifetime of session in second */
//$session_name = session_name();       /* get current session name */
//$session_id = $_GET[$session_name];   /* get current session id */
//session_id($session_id);              /* set session id with id retrieved */
session_set_cookie_params($lifetime); /* set lifetime of session on browser */

session_start();
$_SESSION['test'] = "test";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" href="/base.css" type="text/css">
 <script language="javascript" src="/jquery.js"></script>
 <script type="text/javascript"> 
   $(document).ready(function() { 
              document.getElementById("wrapper").style.height = document.body.offsetHeight;
          }); 
 </script>
 <title>PCHMS-HLWX</title>
 </head>

 <body>
 <div id="wrapper" align="center">
   <div id="top_title"></div>
   <div id="log">
     <table width="700" border="0" class="frame">
       <tr>
         <td width="500" height="89"><img id="logo" src="/fox.png" alt="" width="300" height="300"/></td>
         <td id="user" align="left" valign="top"><form name="form1" action="action.php?action=login" method="post">
             <table width="100" border="0">
              <tr>
                 <p>
                <h3>登录</h3>
                   </p>
               <tr>
                 <p>
                   <label class="label_input" for="username">用户名:</label>
                   <input tabindex="1" type="text" name="username" id="username" />
                 </p>
               </tr>
              <tr>
                 <p>
                  <label class="label_input" for="passwd">密码:</label>
                  <input type="password" name="passwd" id="passwd" />
                </p>
               </tr>
              <tr>
                <td height="23"><input type="submit" name="submit" id="submit" value="登录"></td>
                </tr>
              <tr>
                <td><p><a href="register.php">注册</a></p></td>
              </tr>
            </table>
           </form></td>
       </tr>
     </table>
   </div>
   <br />
   <br />
   <div class="info">
     <ul class="proj">
       <li>SE09@SJTU Intel-SJTU Project 2011-2</li>
       |
       <li>Member: 洪扬，柳古月，王立擘，许欣昊</li>
     </ul>
   </div>
 </div>
</body>
</html>
