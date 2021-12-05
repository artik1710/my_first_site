<form action="reg.php" method="post">
 <p>login: <input type="text" name="login" /></p>
 <p>Email: <input type="text" name="mail" /></p>
 <p>password: <input type="password" name="password" /></p>
 <p>confirm password: <input type="password" name="repassword" /></p>
 <p><input type="submit" /></p>
</form>

<?php

$link = mysqli_connect("localhost","authuser","frogfrog","20julyDB");
if($link == false){echo "chumba" . mysqli_connect_error();};

/*<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"> */


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if ( (preg_match("/[^a-zA-Z0-9\-_]+/",$_POST['login'])) || ($_POST['login']=="")) {
		echo "invalid username";
	}
	else 
	{
	if( (preg_match("/[^a-zA-Z0-9\-_@.]+/",$_POST['mail'])) || ($_POST['mail']=="") ||(!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL))){	
	echo "invalid email";
        }
        else
	{
		if( (preg_match("/[^a-zA-Z0-9\-_@!?]+/",$_POST['login'])) || ($_POST['password']=="")){
                echo "invalid password";
        }
        else
	{ if($_POST['password']!=$_POST['repassword']) echo "passwords doesnt match";
else{	
		
	$login = $link -> real_escape_string($_POST['login']);
	$pass = ($_POST['password']);
	$mail = $link -> real_escape_string($_POST['mail']);
	$key = generateSalt();
//	setcookie('login', $login, time()+60*60*24);
//	setcookie('key', $key, time()+60*60*24);


	$find = $link -> query("SELECT email FROM users WHERE email ='" . $mail . "'
	UNION
	SELECT username FROM users WHERE username ='" . $login . "';" );	
 
	$row = $find->fetch_assoc(); 	
	if ( ($row['email'] == '') && ($row['login']=='') ){



	$sql = "INSERT INTO users (email, password, username, cookie) VALUES('" . $mail . "', '" .  hash('sha256',$pass) . "', '" . $login . "', '" . $key . "')";
  	
	
		if($link ->query($sql)==TRUE){
		      echo "succ";
     		 }
		else{
	echo $sql . "<br>" . $link->error;
	};

	}
	else echo "user already exist";
	};
	};
	};
	};
}
?>


<?php

function generateSalt()
{
	$chars = "qwertyuioplkjhgfdsazxcvbnm@#&!1234567890";
	for ($i; $i<8; $i++){
	$salt .= $chars[rand(0,40)];
	}
	return $salt;
}
?>
