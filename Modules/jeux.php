<?php
/**
* définition de la classe jeux
*/
class Jeux {
        private $_idjeu;   
        private $_iduser;
        private $_pseudo;
        private $_idcategorie;
        private $_categorie;
        private $_nomjeu;
        private $_theme;
        private $_auteur;
        private $_editeur;
        private $_illustrateur;
        private $_nbjoueursmin;
        private $_nbjoueursmax;
        private $_categorieage;
        private $_materiel;
        private $_dureepartie;
        private $_description;
        private $_dateajout;
        private $ajout;
        private $modif;
        private $suppr;

        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['idjeu'])) { $this->_idjeu = $donnees['idjeu']; }
            if (isset($donnees['iduser'])) { $this->_iduser = $donnees['iduser']; }
            if (isset($donnees['pseudo'])) { $this->_pseudo = $donnees['pseudo']; }
            if (isset($donnees['idcategorie'])) { $this->_idcategorie = $donnees['idcategorie']; }
            if (isset($donnees['categorie'])) { $this->_categorie = $donnees['categorie']; }
            if (isset($donnees['nomjeu'])) { $this->_nomjeu = $donnees['nomjeu']; }
            if (isset($donnees['theme'])) { $this->_theme = $donnees['theme']; }
            if (isset($donnees['auteur'])) { $this->_auteur = $donnees['auteur']; }
            if (isset($donnees['editeur'])) { $this->_editeur = $donnees['editeur']; }
            if (isset($donnees['illustrateur'])) { $this->_illustrateur = $donnees['illustrateur']; }
            if (isset($donnees['nbjoueursmin'])) { $this->_nbjoueursmin = $donnees['nbjoueursmin']; }
            if (isset($donnees['nbjoueursmax'])) { $this->_nbjoueursmax = $donnees['nbjoueursmax']; }
            if (isset($donnees['categorieage'])) { $this->_categorieage = $donnees['categorieage']; }
            if (isset($donnees['materiel'])) { $this->_materiel = $donnees['materiel']; }
            if (isset($donnees['dureepartie'])) { $this->_dureepartie = $donnees['dureepartie']; }
            if (isset($donnees['description'])) { $this->_description = $donnees['description']; }
            if (isset($donnees['dateajout'])) { $this->_dateajout = $donnees['dateajout']; }
            if (isset($donnees['ajout'])) { $this->_ajout = $donnees['ajout']; }
            if (isset($donnees['modif'])) { $this->_modif = $donnees['modif']; }
            if (isset($donnees['suppr'])) { $this->_suppr = $donnees['suppr']; }
        }           
        // GETTERS //
        public function idJeu() { return $this->_idjeu;}
        public function idUser() { return $this->_iduser;}
        public function pseudo() { return $this->_pseudo;}
        public function idCategorie() { return $this->_idcategorie;}
        public function categorie() { return $this->_categorie;}
        public function nomJeu() { return $this->_nomjeu;}
        public function theme() { return $this->_theme;}
        public function auteur() { return $this->_auteur;}
        public function editeur() { return $this->_editeur;}
        public function illustrateur() { return $this->_illustrateur;}
        public function nbJoueursMin() { return $this->_nbjoueursmin;}
        public function nbJoueursMax() { return $this->_nbjoueursmax;}
        public function categorieAge() { return $this->_categorieage;}
        public function materiel() { return $this->_materiel;}
        public function dureePartie() { return $this->_dureepartie;}
        public function description() { return $this->_description;}
        public function dateAjout() { return $this->_dateajout;}
        public function ajout() { return $this->_ajout;}
        public function modif() { return $this->_modif;}
        public function suppr() { return $this->_suppr;}
		
		// SETTERS //
        public function setIdJeu($idjeu) { $this->_idjeu = $idjeu; }
        public function setIdUser($iduser) { $this->_iduser = $iduser; }
        public function setPseudo($pseudo) { $this->_pseudo = $pseudo; }
        public function setIdCategorie($idcategorie) { $this->_idcategorie = $idcategorie; }
        public function setCategorie($categorie) { $this->_categorie = $categorie; }
        public function setNomJeu($nomjeu) { $this->_nomjeu = $nomjeu; }
        public function setTheme($theme) { $this->_theme = $theme; }
        public function setAuteur($auteur) { $this->_auteur = $auteur; }
        public function setEditeur($editeur) { $this->_editeur = $editeur; }
        public function setIllustrateur($illustrateur) { $this->_illustrateur = $illustrateur; }
        public function setNbJoueursMin($nbjoueursmin) { $this->_nbjoueursmin = $nbjoueursmin; }
        public function setNbJoueursMax($nbjoueursmax) { $this->_nbjoueursmax = $nbjoueursmax; }
        public function setCategorieAge($categorieage) { $this->_categorieage = $categorieage; }
        public function setMateriel($materiel) { $this->_materiel = $materiel; }
        public function setDureePartie($dureepartie) { $this->_dureepartie = $dureepartie; }
        public function setDescription($description) { $this->_description = $description; }
        public function setDateAjout($dateajout) { $this->_dateajout = $dateajout; }
        public function setAjout($ajout) { $this->_ajout = $ajout; }
        public function setModif($modif) { $this->_modif = $modif; }
        public function setSuppr($suppr) { $this->_suppr = $suppr; }


}

