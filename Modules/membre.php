<?php
/** 
* définition de la classe itineraire
*/
class Membre {
		private $_iduser;
		private $_isadmin;
		private $_pseudo;
        private $_nom;
		private $_prenom;
		private $_sexe;
		private $_datenaissance;
		private $_email;
		private $_dateinscription;
		private $_password;
		private $_ville;
		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['iduser'])) { $this->_iduser = $donnees['iduser']; }
			if (isset($donnees['isadmin'])) { $this->_isadmin = $donnees['isadmin']; }
			if (isset($donnees['pseudo'])) { $this->_pseudo = $donnees['pseudo']; }
			if (isset($donnees['nom'])) { $this->_nom = $donnees['nom']; }
			if (isset($donnees['prenom'])) { $this->_prenom = $donnees['prenom']; }
			if (isset($donnees['sexe'])) { $this->_sexe = $donnees['sexe']; }
			if (isset($donnees['datenaissance'])) { $this->_datenaissance = $donnees['datenaissance']; }
			if (isset($donnees['email'])) { $this->_email = $donnees['email']; }
			if (isset($donnees['dateinscription'])) { $this->_dateinscription = $donnees['dateinscription']; }
			if (isset($donnees['password'])) { $this->_password = $donnees['password']; }
			if (isset($donnees['ville'])) { $this->_ville = $donnees['ville']; }
        }           
        // GETTERS //
		public function idMembre() { return $this->_iduser;}
		public function isAdmin() { return $this->_isadmin;}
		public function pseudo() { return $this->_pseudo;}
		public function nom() { return $this->_nom;}
		public function prenom() { return $this->_prenom;}
		public function sexe() { return $this->_sexe;}
		public function dateNaissance() { return $this->_datenaissance;}
		public function email() { return $this->_email;}
		public function dateInscription() { return $this->_dateinscription;}
		public function password() { return $this->_password;}
		public function ville() { return $this->_ville;}
		public function getAge() { return (date('Y')- $this->_datenaissance) ; }
		
		// SETTERS //
		public function setIdMembre($iduser) { $this->_iduser = $iduser; }
		public function setIsAdmin($isadmin) { $this->_isadmin = $isadmin; }	
		public function setPseudo($pseudo) { $this->_pseudo = $pseudo; }
        public function setNom($nom) { $this->_nom= $nom; }
		public function setPrenom($prenom) { $this->_prenom = $prenom; }
		public function setSexe($sexe) { $this->_sexe = $sexe; }
		public function setDateNaissance($datenaissance) { $this->_datenaissance = $datenaissance; }
		public function setEmail($email) { $this->_email = $email; }
		public function setDateInscription($dateinscription) { $this->_dateinscription = $dateinscription; }
		public function setPassword($password) { $this->_password = $password; }
		public function setVille($ville) { $this->_ville = $ville; }			

    }

?>