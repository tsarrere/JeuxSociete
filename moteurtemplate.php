<?php
// gestion des templates avec Twig
	require_once('Views/Twig/autoload.php');
    
    $loader = new Twig_Loader_Filesystem('Views'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));
?>