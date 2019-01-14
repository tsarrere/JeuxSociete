<?php


/**
* Définition d'une classe permettant de gérer les jeux 
*   en relation avec la base de données	
*/
class JeuxManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
         * Récupère la liste des jeux validés
         * @return array $jeux (tableau de Jeux)
         */
        public function getList() {
            $jeux = array();
            $req = "SELECT PROJET_JEUX.idjeu,PROJET_JEUX.idcategorie,PROJET_JEUX.nbjoueursmin,PROJET_JEUX.nbjoueursmax,PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.nomjeu,PROJET_JEUX.theme,PROJET_JEUX.auteur,PROJET_JEUX.editeur,PROJET_CATEGORIE.outils AS categorie, PROJET_JEUX.ajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " WHERE PROJET_JEUX.ajout = '0'";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
            while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
        }

        /**
         * Récupère la liste des jeux en demande d'ajout
         * @return array $jeux (tableau de Jeux)
         */
        public function getListAdminAjout() {
            $jeux = array();
            $req = "SELECT PROJET_JEUX.idjeu,PROJET_JEUX.idcategorie,PROJET_JEUX.nbjoueursmin,PROJET_JEUX.nbjoueursmax,PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.nomjeu,PROJET_JEUX.theme,PROJET_JEUX.auteur,PROJET_JEUX.editeur,PROJET_CATEGORIE.outils AS categorie, PROJET_JEUX.ajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " WHERE PROJET_JEUX.ajout = '1'";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
            while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
        }

        /**
         * Récupère la liste des jeux en demande de modification
         * @return array $jeux (tableau de Jeux)
         */
        public function getListAdminModif() {
            $jeux = array();
            $req = "SELECT PROJET_JEUX.idjeu,PROJET_JEUX.idcategorie,PROJET_JEUX.nbjoueursmin,PROJET_JEUX.nbjoueursmax,PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.nomjeu,PROJET_JEUX.theme,PROJET_JEUX.auteur,PROJET_JEUX.editeur,PROJET_CATEGORIE.outils AS categorie, PROJET_JEUX.ajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " WHERE PROJET_JEUX.modif = '1'";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
            while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
        }

        /**
         * Récupère la liste des jeux en demande de suppression
         * @return array $jeux (tableau de Jeux)
         */
        public function getListAdminSuppr() {
            $jeux = array();
            $req = "SELECT PROJET_JEUX.idjeu,PROJET_JEUX.idcategorie,PROJET_JEUX.nbjoueursmin,PROJET_JEUX.nbjoueursmax,PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.nomjeu,PROJET_JEUX.theme,PROJET_JEUX.auteur,PROJET_JEUX.editeur,PROJET_CATEGORIE.outils AS categorie, PROJET_JEUX.ajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " WHERE PROJET_JEUX.suppr = '1'";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
            while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
        }

        /**
         * Récupère la description d'un jeu
         * @param int $idjeu
         * @return Jeux
         */
        public function getDescription($idjeu) {
            $req = "SELECT PROJET_JEUX.idjeu, PROJET_JEUX.iduser, PROJET_JEUX.idcategorie, PROJET_CATEGORIE.outils AS categorie,"
            . " PROJET_JEUX.nomjeu, PROJET_JEUX.theme, PROJET_UTILISATEUR.pseudo AS pseudo, PROJET_JEUX.auteur, PROJET_JEUX.editeur, PROJET_JEUX.illustrateur,"
            . " PROJET_JEUX.nbjoueursmin, PROJET_JEUX.nbjoueursmax, PROJET_JEUX.categorieage, PROJET_JEUX.materiel, PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.description, PROJET_JEUX.dateajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " INNER JOIN PROJET_UTILISATEUR ON PROJET_JEUX.iduser = PROJET_UTILISATEUR.iduser"
            . " WHERE PROJET_JEUX.idjeu=?";
			$stmt = $this->_db->prepare($req);
            $stmt->execute(array($idjeu));
            $jeu = new Jeux($stmt->fetch());
			return $jeu;
        }

        /**
         * Récupère la description d'un jeu en attente de modification
         * @param int $idjeu
         * @return Jeux
         */
        public function getDescriptionModif($idjeu) {
            $req = "SELECT PROJET_JEUXMODIF.idjeu, PROJET_JEUXMODIF.iduser, PROJET_JEUXMODIF.idcategorie, PROJET_CATEGORIE.outils AS categorie,"
            . " PROJET_JEUXMODIF.nomjeu, PROJET_JEUXMODIF.theme, PROJET_UTILISATEUR.pseudo AS pseudo, PROJET_JEUXMODIF.auteur, PROJET_JEUXMODIF.editeur," 
            . " PROJET_JEUXMODIF.illustrateur, PROJET_JEUXMODIF.nbjoueursmin, PROJET_JEUXMODIF.nbjoueursmax, PROJET_JEUXMODIF.categorieage,"
            . " PROJET_JEUXMODIF.materiel, PROJET_JEUXMODIF.dureepartie, PROJET_JEUXMODIF.description, PROJET_JEUXMODIF.dateajout"
            . " FROM PROJET_JEUXMODIF INNER JOIN PROJET_CATEGORIE ON PROJET_JEUXMODIF.idcategorie = PROJET_CATEGORIE.idcategorie"
            . " INNER JOIN PROJET_UTILISATEUR ON PROJET_JEUXMODIF.iduser = PROJET_UTILISATEUR.iduser"
            . " WHERE PROJET_JEUXMODIF.idjeu=?";
			$stmt = $this->_db->prepare($req);
            $stmt->execute(array($idjeu));
            $jeu = new Jeux($stmt->fetch());
			return $jeu;
        }

        /**
         * Valide l'ajout d'un jeu
         * @param int $idjeu
         * @return int $ok
         */
        public function validerJeu($idjeu){
            $req = "UPDATE PROJET_JEUX"
            . " SET PROJET_JEUX.ajout='0'"
            . " WHERE PROJET_JEUX.idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($idjeu));

			return $ok;
        }

        /**
         * Refuse la suppression d'un jeu
         * @param int $idjeu
         * @return int $ok
         */
        public function refuserSupprJeu($idjeu){
            $req = "UPDATE PROJET_JEUX"
            . " SET PROJET_JEUX.suppr='0'"
            . " WHERE PROJET_JEUX.idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($idjeu));

			return $ok;
        }

        /**
         * Valide la modification d'un jeu
         * @param Jeux $jeuxModif
         * @return int $ok
         */
        public function validerModif(Jeux $jeuModif){
            
            $req = "UPDATE PROJET_JEUX"
            . " SET nomjeu=?, dureepartie=?, nbjoueursmin=?, nbjoueursmax=?, description=?, materiel=?, auteur=?, editeur=?,"
            . " illustrateur=?, modif='0'"
            . " WHERE idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array(
                $jeuModif->nomJeu(), 
                $jeuModif->dureePartie(),
                $jeuModif->nbJoueursMin(), 
                $jeuModif->nbJoueursMax(), 
                $jeuModif->description(),  
                $jeuModif->materiel(), 
                $jeuModif->auteur(),
                $jeuModif->editeur(), 
                $jeuModif->illustrateur(), 
                $jeuModif->idJeu()
            ));

			return $ok;
        }

        /**
         * Refuse la modification d'un jeu
         * @param int $idjeu
         * @return int $ok
         */
        public function refuserModif($idjeu){

            $req = "DELETE FROM PROJET_JEUXMODIF"
            . " WHERE PROJET_JEUXMODIF.idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($idjeu));

            $req = "UPDATE PROJET_JEUX SET modif = 0 WHERE idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($idjeu));

            return $ok;
        }

        /**
         * Supprime un jeu
         * @param int $idjeu
         * @return int $ok
         */
        public function supprimerJeu($idjeu){
            $req = "DELETE FROM PROJET_JEUX"
            . " WHERE PROJET_JEUX.idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($idjeu));

			return $ok;
        }

        /**
         * Récupère la liste des jeux postés par un membre
         * @param int $iduser
         * @return array $jeux (tableau de Jeux)
         */
        public function getListMembre($iduser) {
            $jeux = array();
            $req = "SELECT PROJET_JEUX.idjeu, PROJET_JEUX.nomjeu, PROJET_JEUX.dateajout"
            . " FROM PROJET_JEUX INNER JOIN PROJET_UTILISATEUR ON PROJET_JEUX.iduser = PROJET_UTILISATEUR.iduser"
            . " WHERE PROJET_JEUX.iduser=?";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($iduser));
            while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
        }
        
        /**
         * Récupère la liste des catégories existantes
         * @return array (catégories)
         */
        public function getListCategories() {
            $categories = array();
            $req = "SELECT idcategorie, outils FROM PROJET_CATEGORIE";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
            while ($donnees = $stmt->fetch())
            {
                $categories[] = $donnees;
            }
            return $categories;
        }

        /**
         * Ajoute un jeu dans la base de données
         * @param Jeux
         * @return int $ok
         */
        public function addJeu(Jeux $jeu){
            $req = "INSERT INTO PROJET_JEUX (iduser, idcategorie, nomjeu, theme, auteur, editeur, illustrateur, nbjoueursmin, nbjoueursmax, categorieage,"
            . " materiel, dureepartie, description, dateajout, ajout, modif, suppr) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array(
                $jeu->idUser(),
                $jeu->idCategorie(), 
                $jeu->nomJeu(), 
                $jeu->theme(), 
                $jeu->auteur(),
                $jeu->editeur(), 
                $jeu->illustrateur(), 
                $jeu->nbJoueursMin(), 
                $jeu->nbJoueursMax(), 
                $jeu->categorieAge(), 
                $jeu->materiel(), 
                $jeu->dureePartie(), 
                $jeu->description(), 
                $jeu->dateAjout(),
                $jeu->ajout(),
                $jeu->modif(),
                $jeu->suppr()
            ));

			return $ok;
        }

        /**
         * Retourne les jeux correspondants aux filtres en paramètres de la fonction
         * @param string $nomjeu
         * @param int $idcategorie
         * @param string $theme
         * @param string $auteur
         * @param string $editeur
         * @param int $nbjoueursmin
         * @param int $nbjoueursmax
         * @return array $jeux (tableau de Jeux)
         */
        public function search($nomjeu, $idcategorie, $theme, $auteur, $editeur, $nbjoueursmin, $nbjoueursmax)
		{
            $req = "SELECT PROJET_JEUX.idjeu,PROJET_JEUX.idcategorie,PROJET_JEUX.nbjoueursmin,PROJET_JEUX.nbjoueursmax,PROJET_JEUX.dureepartie,"
            . " PROJET_JEUX.nomjeu,PROJET_JEUX.theme,PROJET_JEUX.auteur,PROJET_JEUX.editeur,PROJET_CATEGORIE.outils AS categorie"
            . " FROM PROJET_JEUX INNER JOIN PROJET_CATEGORIE ON PROJET_JEUX.idcategorie = PROJET_CATEGORIE.idcategorie";
			$cond = '';

            if ($nomjeu<>"") 
			{ 	$cond = $cond . " PROJET_JEUX.nomjeu like '%". $nomjeu ."%'";
			}
            if ($idcategorie<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
                $cond = $cond . " PROJET_JEUX.idcategorie = '". $idcategorie ."'";
			}
			if ($theme<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " PROJET_JEUX.theme like '%" . $theme ."%'";
			}
			if ($auteur<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " PROJET_JEUX.auteur like '%" . $auteur ."%'";
            }
            if ($editeur<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " PROJET_JEUX.editeur like '%" . $editeur ."%'";
            }
            if ($nbjoueursmin<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " PROJET_JEUX.nbjoueursmin >= '" . $nbjoueursmin . "'";
            }
            if ($nbjoueursmax<>"") 
			{ 	if ($cond<>"") $cond .= " AND ";
				$cond = $cond . " PROJET_JEUX.nbjoueursmax <= '" . $nbjoueursmax . "'";
			}
			if ($cond <>"")
			{ 	$req .= " WHERE PROJET_JEUX.ajout = 0 AND" . $cond;
            }

			// execution de la requete				
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			$jeux = array();
			while ($donnees = $stmt->fetch())
            {
                $jeux[] = new Jeux($donnees);
            }
            return $jeux;
		}

    }

// fontion de changement de format d'une date
// tranformation de la date au format j/m/a au format a/m/j
function dateChgmtFormat($date) {
		list($j,$m,$a) = explode("/",$date);
		return "$a/$m/$j";
}
?>