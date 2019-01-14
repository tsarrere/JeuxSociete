<?php

/**
* Définition d'une classe permettant de gérer les categories 
*   en relation avec la base de données	
*/
class CategorieManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
         * Récupère la liste des categories
         * @return array $cats (tableau de Categorie)
         */
        public function getCategories() {
            $req = "SELECT PROJET_CATEGORIE.idcategorie, PROJET_CATEGORIE.outils"
            . " FROM PROJET_CATEGORIE"
            . " ORDER BY PROJET_CATEGORIE.idcategorie ASC";
			$stmt = $this->_db->prepare($req);
            $stmt->execute();
            $cats = [];
            while ($donnees = $stmt->fetch())
            {
                $cats[] = new Categorie($donnees);
            }
            return $cats;
        }

        /**
         * Ajoute une catégorie
         * @param Categorie $cat
         * @return int $ok
         */
        public function addCat($cat){
            $req = "INSERT INTO PROJET_CATEGORIE (outils)"
            . " VALUES (?)";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($cat));
    
            return $ok;
        }

        /**
         * Modifie une catégorie
         * @param Categorie $cat
         * @return int $ok
         */
        public function modifierCat(Categorie $cat){
            
            $req = "UPDATE PROJET_CATEGORIE"
            . " SET outils=?"
            . " WHERE idcategorie=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array(
                $cat->outils(), 
                $cat->idCategorie()
            ));

            return $ok;
        }

        /**
         * Supprime une catégorie
         * @param int $idcat
         * @return int $ok
         */
        public function supprimerCat($idcat){
            $req = "DELETE FROM PROJET_CATEGORIE"
            . " WHERE PROJET_CATEGORIE.idcategorie=".$idcat;
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute();

            return $ok;
        }

    }
?>