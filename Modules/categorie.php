<?php
/**
* définition de la classe categorie
*/
class Categorie {
        private $_idcategorie;   
        private $_outils;

        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['idcategorie'])) { $this->_idcategorie = $donnees['idcategorie']; }
            if (isset($donnees['outils'])) { $this->_outils = $donnees['outils']; }
           
        }           
        // GETTERS //
        public function idCategorie() { return $this->_idcategorie;}
        public function outils() { return $this->_outils;}
        
		
		// SETTERS //
        public function setIdCategorie($idjeu) { $this->_idcategorie = $idjeu; }
        public function setOutils($iduser) { $this->_outils = $iduser; }
        
}

