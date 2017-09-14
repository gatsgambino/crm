<?php
    session_start();
	include __DIR__ . "/assets/includes/connect.php";
	include __DIR__ . "/assets/includes/functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Password Reset | HR System</title>

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
            <form id="hf-core">
                <div class="row">
                    <div id="hftl-cont" class="small-8 small-offset-2 medium-8 medium-offset-2">
                        <?php if($error===1): ?>
                    	<div class="label alert">
					  		Enter your login credentials.
						</div>
                        <?php endif; ?>
                        <?php if($error===2): ?>
						<div class="label alert">
					  		Invalid username and password combination.
						</div>
                        <?php endif; ?>
                        <label><span id="top-lbl">Get password reset link:</span></label>
                        <div class="input-group">
                            <input class="input-group-field hf-input" type="text" 
                                name="email" id="email" placeholder="Email" 
                                value="<?php if(!empty($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
                            <span id="user-icon" class="input-group-label hffa-cont">
                                <i class="fa fa-user hffa-custom" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="small-8 small-offset-2 medium-8 medium-offset-2">
                        <input type="submit" name="hf-submit" id="hf-submit" class="button primary" value="GET LINK">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="small-8 small-offset-2 medium-8 medium-offset-2">
                    <div id="hfbl-cont" >
                        <a href="./">Back to home</a>
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