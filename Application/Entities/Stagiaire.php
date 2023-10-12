<?php
class Stagiaire {
    private $id;
    private $nom;
    private $CNE;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getCNE() {
        return $this->CNE;
    }

    public function setCNE($CNE) {
        $this->CNE = $CNE;
    }
}
?>