<?php
  // utilisation des sessions
  session_start();

  require_once "connect.php";
  require_once "Modules/membre.php";
  require_once "Models/membreManager.php";
  require_once "Modules/jeux.php";
  require_once "Models/jeuxManager.php";
  require_once "Modules/commentaire.php";
  require_once "Models/commentaireManager.php";
  require_once "Modules/categorie.php";
  require_once "Models/categorieManager.php";
  $membreManager = new MembreManager($bdd);
  $jeuxManager = new JeuxManager($bdd);
  $comManager = new CommentaireManager($bdd);
  $catManager = new CategorieManager($bdd);

  // moteur de template pour les vues
  require_once ("moteurtemplate.php");

  // texte du message
  $message = "";

// -----------------------------------------------------------------------------------------------
// --------------------------------------- MODULE CONNEXION --------------------------------------
// -----------------------------------------------------------------------------------------------

  // si la variable de session n'existe pas, on la crée
  if (!isset($_SESSION['acces'])) {
  $_SESSION['acces']="non";
  }
  if (isset($_POST["connexion"]))  // click sur le bouton connexion
  { // verif du login et mot de passe
    // if ($_POST['login']=="user" && $_POST['passwd']=="pass")
    $membre = $membreManager->verif_identification($_POST['login'], $_POST['password']);
    if ($membre != false)
      { // acces autorisé : variable de session acces = oui
        $_SESSION['acces'] = "oui";
        $_SESSION['iduser'] = $membre->idMembre();
        $_SESSION['admin'] = $membre->isAdmin();
        $message = "Bonjour ".$membre->prenom()." ".$membre->nom()."!";
        //print_r ("OK");
        //print_r ($membre->idMembre());
        echo $twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'],'message'=>$message)); 
      }
    else
      { // acces non autorisé : variable de session acces = non
        $message = "Identification incorrecte.";
        $_SESSION['acces'] = "non";
        echo $twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'],'message'=>$message)); 
      }  
  }

// deconnexion : click sur le bouton deconnexion
if (isset($_GET["action"]) && $_GET['action']=="logout")
  { $_SESSION['acces'] = "non"; // acces non autorisé
    $_SESSION['iduser'] = NULL;
    $message = "Vous êtes maintenant déconnecté.";
    echo $twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
  } 

// formulaire de connexion
if (isset($_GET["action"])  && $_GET["action"]=="login") {
  echo @$twig->render('membre_connexion.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ------------------------------------- MODULE INSCRIPTION --------------------------------------
// -----------------------------------------------------------------------------------------------

// affiche la page d'enregistrement
if (isset($_GET["action"]) && $_GET["action"]=="register")
{ 
  echo $twig->render('membre_inscription.html.twig',array('message'=>$message)); 
}

if (isset($_POST["register"]))  // click sur le bouton "s'inscrire"
{ 
  $membre = new Membre($_POST);
  $ok = $membreManager->addMembre($membre);
  if ($ok) $message = "Bienvenue sur le site !" ;
  else $message = "Inscription impossible";
  echo @$twig->render('membre_connexion.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ------------------------------------ MODULE LISTE DES JEUX ------------------------------------
// -----------------------------------------------------------------------------------------------

// liste des jeux dans un tableau HTML
if (isset($_GET["action"]) && $_GET["action"]=="liste")
{ $jeux=$jeuxManager->getList();
  echo @$twig->render('jeux_liste.html.twig',array('jeux'=>$jeux,'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin']));
}

// -----------------------------------------------------------------------------------------------
// ------------------------------ MODULE DESCRIPTION ET COMMENTAIRES -----------------------------
// -----------------------------------------------------------------------------------------------

// affiche la description d'un jeu ainsi que la liste de commentaires dans des tableaux HTML
if (isset($_GET["action"]) && $_GET["action"]=="description")
{ $idjeu = $_GET["idjeu"];
  $jeu=$jeuxManager->getDescription($idjeu);
  $coms=$comManager->getCommentaires($idjeu);
  $notemoy=$comManager->getNoteMoy($idjeu);
  echo @$twig->render('jeux_description.html.twig',array('jeu'=>$jeu,'notemoy'=>$notemoy,'coms'=>$coms,'acces'=> $_SESSION['acces'],
        'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 
}

// Ajout d'un commentaire
if (isset($_POST["valider_com"]))
{ 
  $com = new Commentaire($_POST);
  $ok = $comManager->addCom($com);
  if ($ok) $message = "Commentaire ajouté" ;
  else $message = "Problème lors de l'ajout";

  $idjeu=$_POST["idjeu"];
  $jeu=$jeuxManager->getDescription($idjeu);
  $coms=$comManager->getCommentaires($idjeu);
  $notemoy=$comManager->getNoteMoy($idjeu);
  echo @$twig->render('jeux_description.html.twig',array('jeu'=>$jeu,'notemoy'=>$notemoy,'coms'=>$coms,'acces'=> $_SESSION['acces'],
        'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ---------------------------------- MODULE PROFIL UTILISATEUR ----------------------------------
// -----------------------------------------------------------------------------------------------

// affiche le profil d'un utilisateur
if (isset($_GET["action"]) && $_GET["action"]=="profil")
{ $iduser = $_GET["user"];
  $membre=$membreManager->getProfil($iduser);
  $jeux=$jeuxManager->getListMembre($iduser);
  echo @$twig->render('membre_profil.html.twig',array('membre'=>$membre,'jeux'=>$jeux,'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}

// Affiche les jeux ajoutés par l'utilisateur
if (isset($_GET["action"]) && $_GET["action"]=="mesjeux")
{ 
  $iduser = $_SESSION['iduser'];
  $jeux=$jeuxManager->getListMembre($iduser);
  echo @$twig->render('jeux_membres.html.twig',array('jeux'=>$jeux,'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ------------------------------------ MODULE AJOUT DE JEU  -------------------------------------
// -----------------------------------------------------------------------------------------------

// Affiche un formulaire d'ajout de nouveau jeu
if (isset($_GET["action"]) && $_GET["action"]=="ajout")
{ 
  $iduser = $_SESSION['iduser'];
  $categories=$jeuxManager->getListCategories();
  echo @$twig->render('jeux_ajouter.html.twig',array('categories'=>$categories,'acces'=> $_SESSION['acces'], 'iduser'=>$iduser,'admin'=>$_SESSION['admin'])); 
}

// Si le formulaire d'ajout de jeu est validé
if (isset($_POST["valider_ajout"]))
{ 
  $jeu = new Jeux($_POST);
  $ok = $jeuxManager->addJeu($jeu);
  if ($ok) $message = "Jeu ajouté" ;
  else $message = "Problème lors de l'ajout";
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 

}

// -----------------------------------------------------------------------------------------------
// ----------------------------------- MODULE RECHERCHE DE JEU  ----------------------------------
// -----------------------------------------------------------------------------------------------

// recherche de jeux : saisie des critres de recherche dans un formulaire
if (isset($_GET["action"]) && $_GET["action"]=="recher")
 {
  $categories=$jeuxManager->getListCategories();
  echo @$twig->render('jeux_recherche.html.twig',array('categories'=>$categories, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
 }

// recherche de jeux : construction de la requete SQL en fonction des critères de recherche et affichage du résultat dans un tableau HTML 
if (isset($_POST["valider_recher"]))
{ 
  $jeux = @$jeuxManager->search($_POST["nomjeu"], $_POST["idcategorie"], $_POST["theme"], $_POST["auteur"], $_POST["editeur"], 
        $_POST["nbjoueursmin"], $_POST["nbjoueursmax"]);
  echo @$twig->render('jeux_liste.html.twig',array('jeux'=>$jeux,'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 

}

// -----------------------------------------------------------------------------------------------
// ------------------------------------ MODULE ADMINISTRATION ------------------------------------
// -----------------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------------
// ------------------------------------- ADMIN AJOUT DE JEU  -------------------------------------
// -----------------------------------------------------------------------------------------------

// interface d'administrateur pour validation d'ajout de jeu
if (isset($_GET["action"]) && $_GET["action"]=="admin-ajout")
 {
  $jeux=$jeuxManager->getListAdminAjout();
  $action="ajouter";
  echo @$twig->render('Admin/demande.html.twig',array('action'=>$action,'categories'=>$categories, 'acces'=> $_SESSION['acces'],'jeux'=>$jeux,
        'admin'=>$_SESSION['admin'])); 
 }

// affiche la description d'un jeu en attente d'ajout
if (isset($_GET["action"]) && $_GET["action"]=="admin-ajout-description")
{ $idjeu = $_GET["idjeu"];
  $jeu=$jeuxManager->getDescription($idjeu);
  $action="ajouter";
  echo @$twig->render('Admin/demande_description.html.twig',array('action'=>$action,'jeu'=>$jeu,'acces'=> $_SESSION['acces'],
        'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 
}

// Si l'ajout du jeu est validé
if (isset($_POST["valider_ajout_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $ok = $jeuxManager->validerJeu($idjeu);
  if ($ok) $message = "Demande d'ajout de jeu validée" ;
  else $message = "Problème lors de la validation";
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
}

// Si l'ajout du jeu est refusé
if (isset($_POST["supprimer_ajout_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $ok = $jeuxManager->supprimerJeu($idjeu);
  if ($ok) $message = "Jeu supprimé" ;
  else $message = "Problème lors de la suppression";
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ------------------------------------- ADMIN MODIF DE JEU  -------------------------------------
// -----------------------------------------------------------------------------------------------

// interface d'aministrateur pour validation de modification de jeu
 if (isset($_GET["action"]) && $_GET["action"]=="admin-modif")
 {
  $jeux=$jeuxManager->getListAdminModif();
  $action="modifier";
  echo @$twig->render('Admin/demande.html.twig',array('action'=>$action,'categories'=>$categories, 'acces'=> $_SESSION['acces'],
        'jeux'=>$jeux,'admin'=>$_SESSION['admin'])); 
 }

 // affiche la description d'un jeu en attente de modification
if (isset($_GET["action"]) && $_GET["action"]=="admin-modif-description")
{ 
  $idjeu = $_GET["idjeu"];
  $jeuOriginal=$jeuxManager->getDescription($idjeu);
  $jeuModifie=$jeuxManager->getDescriptionModif($idjeu);
  echo @$twig->render('Admin/demande_description_modif.html.twig',array('jeuOriginal'=>$jeuOriginal,'jeuModifie'=>$jeuModifie,
        'acces'=> $_SESSION['acces'],'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 

}

// Si la modification du jeu est validée
if (isset($_POST["valider_modif_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $jeuModifie=$jeuxManager->getDescriptionModif($idjeu);
  $ok = $jeuxManager->validerModif($jeuModifie);
  if ($ok) $message = "Demande de modification de jeu validée" ;
  else $message = "Problème lors de la validation de modification";

  $jeux=$jeuxManager->getListAdminModif();
  $action="modifier";
  echo @$twig->render('Admin/demande.html.twig',array('action'=>$action,'categories'=>$categories, 'acces'=> $_SESSION['acces'],
        'jeux'=>$jeux,'admin'=>$_SESSION['admin'])); 
}

// Si la modification du jeu est refusée
if (isset($_POST["refuser_modif_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $ok = $jeuxManager->refuserModif($idjeu);
  if ($ok) $message = "Modification refusée et supprimée" ;
  else $message = "Problème lors du refus de modification";

  $jeux=$jeuxManager->getListAdminModif();
  $action="modifier";
  echo @$twig->render('Admin/demande.html.twig',array('action'=>$action,'categories'=>$categories, 'acces'=> $_SESSION['acces'],
        'jeux'=>$jeux,'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ------------------------------------- ADMIN SUPPR DE JEU  -------------------------------------
// -----------------------------------------------------------------------------------------------

 // interface d'administrateur pour validation de suppression de jeu
if (isset($_GET["action"]) && $_GET["action"]=="admin-suppr")
 {
  $jeux=$jeuxManager->getListAdminSuppr();
  $action="supprimer";
  echo @$twig->render('Admin/demande.html.twig',array('action'=>$action,'categories'=>$categories, 'acces'=> $_SESSION['acces'],
        'jeux'=>$jeux,'admin'=>$_SESSION['admin'])); 
 }

// affiche la description d'un jeu en attente de suppression
if (isset($_GET["action"]) && $_GET["action"]=="admin-suppr-description")
{ $idjeu = $_GET["idjeu"];
  $jeu=$jeuxManager->getDescription($idjeu);
  $action="supprimer";
  echo @$twig->render('Admin/demande_description.html.twig',array('action'=>$action,'jeu'=>$jeu,'acces'=> $_SESSION['acces'],
        'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 
}

// Si la suppression du jeu est validée
if (isset($_POST["valider_suppr_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $ok = $jeuxManager->supprimerJeu($idjeu);
  if ($ok) $message = "Jeu supprimé" ;
  else $message = "Problème lors de la suppression";
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin']));
}

// Si la suppression du jeu est refusée
if (isset($_POST["refuser_suppr_admin"]))
{ 
  $idjeu = $_POST["idjeu"];
  $ok = $jeuxManager->refuserSupprJeu($idjeu);
  if ($ok) $message = "Demande de suppression refusée." ;
  else $message = "Problème lors du changement d'état 'suppr'.";
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message,'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// ----------------------------------- ADMIN GERER CATEGORIES  -----------------------------------
// -----------------------------------------------------------------------------------------------

 // interface d'administrateur pour gérer les catégories
 if (isset($_GET["action"]) && $_GET["action"]=="admin-cat")
 {
  $cats = $catManager->getCategories();
  echo @$twig->render('Admin/gerer_categories.html.twig',array('categories'=>$cats, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
 }

 // Suppression d'une catégorie
 if (isset($_POST["supprimer_categorie"]))
{ 
  $ok = $catManager->supprimerCat($_POST["idcategorie"]);
  if ($ok) $message = "Catégorie supprimée" ;
  else $message = "Problème lors de la suppression de la catégorie";

  $cats = $catManager->getCategories();
  echo @$twig->render('Admin/gerer_categories.html.twig',array('categories'=>$cats, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}

 // Ajout d'une catégorie
 if (isset($_POST["ajouter_categorie"]))
{ 
  $cat = $_POST["outils"];
  $ok = $catManager->addCat($cat);
  if ($ok) $message = "Catégorie ajoutée" ;
  else $message = "Problème lors de l'ajout de la catégorie";

  $cats = $catManager->getCategories();
  echo @$twig->render('Admin/gerer_categories.html.twig',array('categories'=>$cats, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}

// Modification d'une catégorie
if (isset($_POST["modifier_categorie"]))
{ 
  $cat = new Categorie($_POST);
  $ok = $catManager->modifierCat($cat);
  if ($ok) $message = "Catégorie modifiée" ;
  else $message = "Problème lors de la modification de catégorie";

  $cats = $catManager->getCategories();
  echo @$twig->render('Admin/gerer_categories.html.twig',array('categories'=>$cats, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}


// -----------------------------------------------------------------------------------------------
// ---------------------------------- ADMIN GERER UTILISATEURS  ----------------------------------
// -----------------------------------------------------------------------------------------------

 // interface d'administrateur pour gérer les utilisateurs
 if (isset($_GET["action"]) && $_GET["action"]=="admin-uti")
 {
  $users = $membreManager->getUsers();
  echo @$twig->render('Admin/gerer_utilisateurs.html.twig',array('users'=>$users, 'acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
 }

// -----------------------------------------------------------------------------------------------
// ---------------------------------- ADMIN GERER COMMENTAIRES  ----------------------------------
// -----------------------------------------------------------------------------------------------

if (isset($_POST["supprimer_com_admin"]))
{ 
  $ok = $comManager->supprimerCom($_POST["iduser"],$_POST["idjeu"]);
  if ($ok) $message = "Commentaire supprimé" ;
  else $message = "Problème lors de la suppression de commentaire";
  
  $jeu=$jeuxManager->getDescription($_POST["idjeu"]);
  $coms=$comManager->getCommentaires($_POST["idjeu"]);
  $notemoy=$comManager->getNoteMoy($_POST["idjeu"]);
  echo @$twig->render('jeux_description.html.twig',array('jeu'=>$jeu,'notemoy'=>$notemoy,'coms'=>$coms,'acces'=> $_SESSION['acces'],
        'iduser'=> $_SESSION['iduser'],'admin'=>$_SESSION['admin'])); 
}

// -----------------------------------------------------------------------------------------------
// --------------------------------------- VUE PAR DEFAUT ----------------------------------------
// -----------------------------------------------------------------------------------------------

if (!isset($_GET["action"]) && empty($_POST)) {
  echo @$twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'admin'=>$_SESSION['admin'])); 
}
?>