<?php
	session_start();
	include __DIR__ . "/assets/includes/connect.php";
	include __DIR__ . "/assets/includes/functions.php";

    if (!empty($_SESSION['login_token']))
    {
        header('Location: dashboard.php');
        exit;
    }

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		foreach($_POST as $key => $value) {
			if(empty($value)) {
				$error=1;
			}
		}

		if (!isset($error)) {
			$username = $_POST['username'];
			$pwd      = $_POST['pwd'];

			$query = $db->prepare('SELECT password FROM users WHERE username=:uname');
			$query->bindParam(':uname', $username, PDO::PARAM_STR);
			$query->execute();

			$row = $query->fetch();
			if (!empty($row)) {
				if(password_verify($pwd, $row['password'])) {
					$login_token = random_str(32);

					$query2 = $db->prepare('UPDATE users SET login_token=:token, last_login=Now() WHERE username=:uname');
					$query2->execute(array(
						':token' => $login_token,
						':uname' => $username
					));

					$_SESSION['login_token'] = $login_token;

					header('Location: dashboard.php');
				} else {
					$error=2;
				}
			} else {
				$error=2;
			}
		}	
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login | HR System</title>

<?php include __DIR__."/assets/includes/head.php"; ?>
</head>
<body>
<noscript>Please enable Javascript in your browser.</noscript>
<section id="home">
    <div class="row">
        <div id="hf-container" class="small-10 small-offset-1 medium-6 medium-offset-3 large-4 large-offset-4">
            <div id="msg-top">
                <img id="hr-logo" class="small-8 small-offset-2 medium-6 medium-offset-3" src="assets/images/human_resources.png">
            </div>
            <form id="hf-core" method="post" action="<?= htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="row">
                    <div id="hftl-cont" class="small-8 small-offset-2 medium-8 medium-offset-2">
                        <?php if($error===1): ?>
                    	<div class="label alert">
					  		<h6>Please enter your login credentials.</h6>
						</div>
                        <?php endif; ?>
                        <?php if($error===2): ?>
						<div class="label alert">
					  		<h6>Invalid login combination.</h6>
						</div>
                        <?php endif; ?>
                        <label><span id="top-lbl">Login:</span></label>
                        <div class="input-group">
                            <input class="input-group-field hf-input" type="text" 
                                name="username" id="username" placeholder="Username">
                            <span id="user-icon" class="input-group-label hffa-cont">
                                <i class="fa fa-user hffa-custom" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="small-8 small-offset-2 medium-8 medium-offset-2">
                        <div class="input-group">
                            <input class="input-group-field hf-input" type="password" 
                                name="pwd" id="pwd" placeholder="Password">
                            <span id="pwd-icon" class="input-group-label hffa-cont">
                                <i class="fa fa-lock hffa-custom" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="small-8 small-offset-2 medium-8 medium-offset-2">
                        <input type="submit" name="hf-submit" id="hf-submit" class="button primary" value="LOGIN">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="small-8 small-offset-2 medium-8 medium-offset-2">
                    <div id="hfbl-cont" >
                        <a href="passwordreset.php">Forgot password?</a>
                    </div>
                </div>
                <ul id="hfsm-cont" class="small-8 small-offset-2 medium-8 medium-offset-2">
                    <li>
                        <a href="#">
                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php include __DIR__."/assets/includes/footer.php"; ?>
</section>

<?php include __DIR__ . "/assets/includes/jsdependencies.php"; ?>
</body>
</html>