<!DOCTYPE html>
<html>
 <head>
  <title>Welcome!</title>
  <link rel='stylesheet' href='style.css'>
  <script type='text/javascript' src='click.js'></script>
<?php

  function loginExists($login) {
    $db_name='db.txt';
    $file=file($db_name);

    foreach ($file as $key=>$info)
    {
     $userInfo = explode(';', $info);

     if ($userInfo[0] == $login) return true;
    }

     return false;
  }

  function getData($login, $password) {
    $db_name='db.txt';
    $file=file($db_name);
    $data = null;

    foreach ($file as $key=>$info)
    {
     $userInfo = explode(';', $info);

     if ($userInfo[0] == $login && $userInfo[1] == $password) {
      $data = $userInfo;
     }
    }

     return $data;
  }

 function signUp($login, $password, $name, $surname, $age, $country)
 {
    if (!($login && $password && $name && $surname && $age && $country)) 
      return ['success' => false, 'message' => 'Please fill in all the fields'];

    if (loginExists($login)) return ['success' => false, 'message' => 'Sorry, login already exists, try again'];
    
    $db_name='db.txt';
    $ff=fopen($db_name, 'a+');

    $str=$login.';'. $password . ';' . $name . ';' . $surname . ';' . $age . ';' . $country . "\n";
    
    fwrite($ff, $str);
    fclose($ff);

    return ['success' => true];
 }

 function login($login, $password)
 {
    $data = getData($login, $password); 

    if ($data) return ['success' => true, 'data' => $data];

    return ['success' => false, 'message' => 'Sorry, login or password is wrong, try again'];
    
}

$userInfo = null;
$isLogin = false;
$successSignUp = null;
$successLogin = null;
$message = '';

if ($_POST['tp']=='signUp')
{
   $response = signUp($_POST['login'],$_POST['password'], $_POST['username'], $_POST['surname'], $_POST['age'], $_POST['country']);

   if (!$response['success']) {
    $message = $response['message'];
  }
   else $message = '';

} else if ($_POST['tp']=='login') {
  $response = login($_POST['login'],$_POST['password']);

  if ($response['success']) {
    $userInfo = $response['data'];
    $message = '';
    $isLogin = true;
  } else {
    $message = $response['message'];
  }
} else if ($_POST['exit']) {
  $isLogin = false;
  $userInfo = null;
  $message = '';
}

?>

</head>
<body>
  <div class='forms'>
    <img src='./img.jpg' alt='image'>
    <?php if(!$isLogin) {
    echo "<div class='topnav'>
      <a class='active' href='#' id='login' onclick=\"changeClass('login', 'signUp');\">Login</a>
      <a href='#' id='signUp' onclick=\"changeClass('signUp', 'login');\">Sign Up</a>
    </div>
    <form action='#' method=POST id='loginForm' class='login'>
      <input type=text name=login placeholder='Login'><br>
      <input type=text name=password placeholder='Password'><br>
      <input type=hidden name=tp value='login'>
      <input type=submit value='Login'><br>
    </form>

    <form action='#' method=POST id='signUpForm' class='signUp disable'>
      <input type=text name=login placeholder='Login'><br>
      <input type=text name=password placeholder='Password'><br>
      <input type=text name=username placeholder='Name'><br>
      <input type=text name=surname placeholder='Surname'><br>
      <input type=text name=age placeholder='Age'><br>
      <input type=text name=country placeholder='Country'><br>
      <input type=hidden name=tp value='signUp'>
      <input type=submit value='Sign Up'><br>
    </form>";
    if ($message) echo "<h5 id='message'>" . $message; } else {
      if ($userInfo[4] < 18) {
        echo "<h4>Только сегодня! –30% на подборку фантастики и фэнтези для детей!</h4>";
      } else if ($userInfo[4] >= 18 && $userInfo[4] <= 24) {
        echo "<h4>С 14.01-16.01 скидка для всех студентов <br/> –10% на подборку книг о космосе, медицине и не только</h4>";
      }
      echo "<div class='userInfo'>
    <h2>Hello, " . $userInfo[2] . "!" .
    "</h2> <hr/>
    <ul> 
      <li>Name: " . $userInfo[2] .
      "<li>Surname: " . $userInfo[3] . 
      "<li>Age: " . $userInfo[4] .
      "<li>Country: " . $userInfo[5] .
    "</ul>
    </div>
    <form action='/page.php' method=POST id='exitForm' class='exit'>
    <input type=hidden name=exit>
    <input type=submit value='Exit'>
    </form>";
    }
    ?>
  </div>
 </body>
</html>