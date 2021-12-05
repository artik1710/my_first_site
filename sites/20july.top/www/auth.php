<?php
//echo "hy";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if($_POST['quit']=="true"){
		setcookie('key',"",time()-1600,"/");
		setcookie('login',"",time()-1600,"/");
		echo $_POST['quit'];
		header('Location: index.html');
	};

	$link = mysqli_connect("localhost","authuser","frogfrog","20julyDB");
	echo $link->connect_error; 

	$login = $link -> real_escape_string($_POST['login']);
	$pass =  hash('sha256',($_POST['password']));
//	echo $login . $pass;
	$find = $link -> query("SELECT password FROM users WHERE username ='" . $login . "';" );
	
	$row = $find->fetch_assoc();
//	echo $row['password'];
	if(empty($row['password']))	
	{
		echo "sss";
	}
	else {
		if($row['password']==$pass){

		if(empty($_COOKIE['key'])){
		
			setcookie('key', generateSalt(),time()+60*60, "/");
			setcookie('login', $login, time()+60*60, "/");
			$link -> query("UPDATE users SET cookie='" . $_COOKIE['key'] . "' WHERE login ='" . $login . "';");
			echo"qe";	
			header('Location: index.html');
		} else {
			echo "horosho";
			header('Location: index.html');
		
	};
		} else echo "wrong pass";	 


		};
}
else echo "oooo";
?>
<form action="index.html">
    <input type="submit" value="Ho ho try agayn" />
</form>

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

