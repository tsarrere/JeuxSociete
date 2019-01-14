<?php

/**
* Définition d'une classe permettant de gérer les membres 
* en relation avec la base de données
*
*/

class MembreManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/** 
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }
		
		/**
		* Vérification de l'identité d'un membre (Login/password)
		* @param string $login
		* @param string $password
		* @return Membre si authentification ok, false sinon
		*/
		public function verif_identification($login, $password) {
		//echo $login." : ".$password;
			$req = "SELECT iduser, isadmin, nom, prenom FROM PROJET_UTILISATEUR WHERE email=:login AND password=:password ";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array(":login" => $login, ":password" => $password));
			if ($data=$stmt->fetch()) { 
				$membre = new Membre($data);
				return $membre;
				}
			else return false;
		}

		/**
         * Récupère la liste des utilisateurs
         * @return array $users (tableau de Membre)
         */
        public function getUsers() {
            $req = "SELECT PROJET_UTILISATEUR.iduser, PROJET_UTILISATEUR.pseudo"
            . " FROM PROJET_UTILISATEUR"
            . " ORDER BY PROJET_UTILISATEUR.iduser ASC";
			$stmt = $this->_db->prepare($req);
            $stmt->execute();
            $users = [];
            while ($donnees = $stmt->fetch())
            {
                $users[] = new Membre($donnees);
			}
			
            return $users;
        }

		/**
		 * Récupère le profil d'un utilisateur
		 * @param int $iduser
		 * @return Membre
		 */
		public function getProfil($iduser) {
			$req = "SELECT iduser, pseudo, nom, prenom, sexe, datenaissance, dateinscription, ville"
			. " FROM PROJET_UTILISATEUR WHERE iduser=?";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($iduser));
			$membre = new Membre($stmt->fetch());
			return $membre;
		}

		/**
		 * Ajoute un memnbre dans la base de données
		 * @param Membre
		 * @return int $ok
		 */
		public function addMembre(Membre $membre){

			$req = "INSERT INTO PROJET_UTILISATEUR (pseudo, nom, prenom, sexe, datenaissance, email, dateinscription, password, ville) VALUES (?,?,?,?,?,?,?,?,?)";
			$stmt = $this->_db->prepare($req);
			$ok  = $stmt->execute(array(
				$membre->pseudo(),
				$membre->nom(),
				$membre->prenom(), 
				$membre->sexe(), 
				$membre->datenaissance(),
				$membre->email(), 
				$membre->dateinscription(), 
				$membre->password(), 
				$membre->ville()
			));		
			return $ok;
		}
    }
?>