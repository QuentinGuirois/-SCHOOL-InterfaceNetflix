<?php
session_start();
require('src/log.php');


if (!empty($_POST['email']) && !empty($_POST['password'])) {

	require('src/connection.php'); //CONNEXION BDD

	//VAR
	$email = $_POST['email'];
	$password = $_POST['password'];

	//ADRESSE EMAIL BONNE ?
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('location:../index.php?error=1&message=Votre adresse email est invalide.');
		exit();
	}
	// CRYPTAGE MDP
	$password = "Z3j" . sha1($password . "b8F2") . "2F";

	// EMAIL DEJA UTILISE
	$req = $bdd->prepare("SELECT count(*) as numberEmail FROM projetausers WHERE email = ?");
	$req->execute(array($email));

	while ($email_verification = $req->fetch()) {
		if ($email_verification['numberEmail'] != 1) {
			header('location :../inscription.php?error=1&message= Impossible de vous authentifier correctement.');
			exit();
		}
	}

	//CONNEXION
	$req = $bdd->prepare("SELECT * FROM projetausers WHERE email = ?");
	$req->execute(array($email));

	while ($user = $req->fetch()) {
		if ($password == $user['password']) {
			$_SESSION['connect'] = 1;
			$_SESSION['email'] = $user['email'];

			if(isset($_POST['auto'])){
				setcookie('auth', $user['secret'], time() + 364*24*3600, '/', null, false, true);
			}

			header('location:../index.php?success=1');
			exit();
		} else {
			header('location:../index.php?error=1&Impossible de vous authentifier correctement.');
			exit();
		}
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Nitfloux</title>
	<link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/png" href="img/favicon.png">
</head>

<body>

	<?php include('src/header.php'); ?>

	<section>
		<div id="login-body">
			<?php if (isset($_SESSION['connect'])) { //si l'utilisateur est déjà connecté, affichage 1 ?> 
				<h1>Bonjour !</h1>
				
				<?php 
				if (isset($_GET['success'])) {
					echo '<div class="alert success">Vous êtes maintenant connecté</div><br />';
				} ; ?>

				<p> Qu'allez vous regarder aujourd'hui ? </p>
				<small><a href="logout.php">Déconnexion</a></small>
			<?php } else { //sinon affichage du formulaire de connexion?>
				<h1>S'identifier</h1>
				<?php
				if (isset($_GET['error'])) {
					if (isset($_GET['message'])) {
						echo '<div class="alert error">' . htmlspecialchars($_GET['message']) . '</div>';
					}
				} 

				?>
				<form method="post" action="index.php">
					<input type="email" name="email" placeholder="Votre adresse email" required />
					<input type="password" name="password" placeholder="Mot de passe" required />
					<button type="submit">S'identifier</button>
					<label id="option"><input type="checkbox" name="auto" checked />Se souvenir de moi</label>
				</form>
				<p class="grey">Première visite sur Nitfloux ? <a href="inscription.php">Inscrivez-vous</a>.</p>
			<?php } ?>
		</div>
	</section>

	<?php include('src/footer.php'); ?>
</body>

</html>