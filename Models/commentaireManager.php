<?php

/**
* Définition d'une classe permettant de gérer les commentaires 
*   en relation avec la base de données	
*/
class CommentaireManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
         * Récupère la liste des commentaires
         * @param int $idjeu
         * @return array $coms (tableau de Commentaire)
         */
        public function getCommentaires($idjeu) {
            $req = "SELECT PROJET_COMMENTAIRE.iduser, PROJET_COMMENTAIRE.idjeu, PROJET_COMMENTAIRE.contenu, PROJET_COMMENTAIRE.note,"
            . " PROJET_UTILISATEUR.pseudo, PROJET_COMMENTAIRE.datecom, PROJET_COMMENTAIRE.titrecom"
            . " FROM PROJET_COMMENTAIRE INNER JOIN PROJET_UTILISATEUR ON PROJET_COMMENTAIRE.iduser = PROJET_UTILISATEUR.iduser"
            . " INNER JOIN PROJET_JEUX ON PROJET_COMMENTAIRE.idjeu = PROJET_JEUX.idjeu"
            . " WHERE PROJET_COMMENTAIRE.idjeu=?"
            . " ORDER BY PROJET_COMMENTAIRE.datecom DESC";
			$stmt = $this->_db->prepare($req);
            $stmt->execute(array($idjeu));
            $coms = [];
            while ($donnees = $stmt->fetch())
            {
                $coms[] = new Commentaire($donnees);
            }
			return $coms;
        }

        /**
         * Récupère la note moyenne d'un jeu
         * @param int $idjeu
         * @return float $notemoy (arrondie au dixième)
         */
        public function getNoteMoy($idjeu) {
            $req = "SELECT AVG(note)"
            . " FROM PROJET_COMMENTAIRE"
            . " WHERE idjeu=?"
            . " GROUP BY idjeu";
			$stmt = $this->_db->prepare($req);
            $stmt->execute(array($idjeu));
            $notemoy = $stmt->fetch();
            return number_format((float)$notemoy['AVG(note)'], 1, ',', '');
        }

        /**
         * Ajoute un commentaire
         * @param Commentaire $com
         * @return int $ok
         */
        public function addCom(Commentaire $com){
            $req = "INSERT INTO PROJET_COMMENTAIRE (iduser, idjeu, titrecom, contenu, note, datecom)"
            . " VALUES (?,?,?,?,?,?)";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array(
                $com->idUser(),
                $com->idJeu(), 
                $com->titreCom(), 
                $com->contenu(), 
                $com->note(),
                $com->dateCom()
            ));
    
            return $ok;
        }

        /**
         * Supprime un commentaire
         * @param int $iduser
         * @param int $idjeu
         * @return int $ok
         */
        public function supprimerCom($iduser, $idjeu){
            $req = "DELETE FROM PROJET_COMMENTAIRE"
            . " WHERE PROJET_COMMENTAIRE.iduser=? AND PROJET_COMMENTAIRE.idjeu=?";
            $stmt = $this->_db->prepare($req);
            $ok  = $stmt->execute(array($iduser, $idjeu));

            return $ok;
        }

    }
?>