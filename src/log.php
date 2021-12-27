<?php
    if(isset($_COOKIE['auth']) && !isset($_SESSION['connect'])){  //SI LE COOKIE EXISTE, ET SI LA SESSION CONNECT N'EXISTE PAS

        //VAR
        $secret = htmlspecialchars($_COOKIE['auth']);

        //VERIFICATION
        require('src/connection.php');
        $req = $bdd->prepare("SELECT count(*) as numberAcount FROM projetausers WHERE secret = ?");
        $req->execute(array($secret));

        while($user = $req->fetch()){
            if($user['numberAccount'] == 1){
                $reqUser = $bdd->prepare("SELECT * FROM projetausers WHERE secret = ?");
                $reqUser->execute(array($secret));

                while($userAccount = $reqUser->fetch()){

                    $_SESSION['connect'] = 1;
                    $_SESSION['email'] = $userAccount['email'];
                }
            }
        }
    }
    //UTILISATEUR BLOQUE / BAN :
    if(isset($_SESSION['connect'])){ //SI UTILISATEUR CONNECTE
        require('src/connection.php');

        $reqUser = $bdd->prepare("SELECT * FROM projetausers WHERE email = ?");
                $reqUser->execute(array($_SESSION['email']));

                while($userAccount = $reqUser->fetch()){

                    if($userAccount['blocked'] == 1){
                        header('location:../logout.php'); // ON REDIRIGE L'UTILISATEUR VERS LA SORTIE !
                        exit();
                    }

                    

    }
}

?>