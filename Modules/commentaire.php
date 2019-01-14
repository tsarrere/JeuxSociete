<?php
/**
* définition de la classe commentaire
*/
class Commentaire {
        private $_idjeu;   
        private $_iduser;
        private $_pseudo;
        private $_titrecom;
        private $_contenu;
        private $_note;
        private $_datecom;
       

        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['idjeu'])) { $this->_idjeu = $donnees['idjeu']; }
            if (isset($donnees['iduser'])) { $this->_iduser = $donnees['iduser']; }
            if (isset($donnees['pseudo'])) { $this->_pseudo = $donnees['pseudo']; }
            if (isset($donnees['titrecom'])) { $this->_titrecom = $donnees['titrecom']; }
            if (isset($donnees['contenu'])) { $this->_contenu = $donnees['contenu']; }
            if (isset($donnees['note'])) { $this->_note = $donnees['note']; }
            if (isset($donnees['datecom'])) { $this->_datecom = $donnees['datecom']; }
           
        }           
        // GETTERS //
        public function idJeu() { return $this->_idjeu;}
        public function idUser() { return $this->_iduser;}
        public function pseudo() { return $this->_pseudo;}
        public function titreCom() { return $this->_titrecom;}
        public function contenu() { return $this->_contenu;}
        public function note() { return $this->_note;}
        public function dateCom() { return $this->_datecom;}
        
		
		// SETTERS //
        public function setIdJeu($idjeu) { $this->_idjeu = $idjeu; }
        public function setIdUser($iduser) { $this->_iduser = $iduser; }
        public function setPseudo($pseudo) { $this->_pseudo = $pseudo; }
        public function setTitreCom($titrecom) { $this->_titrecom = $titrecom; }
        public function setContenu($contenu) { $this->_contenu = $contenu; }
        public function setNote($note) { $this->_note = $note; }
        public function setDateCom($datecom) { $this->_datecom = $datecom; }
        
}

