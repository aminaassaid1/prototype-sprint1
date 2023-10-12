<?php
class PersonneBLO {
    private $personneDao;

    public function __construct() {
        global $conn;
        $this->personneDao = new PersonneDAO($conn);
    }

    public function GetAllPersonnes()
    {
        return $this->personneDao->GetAllPersonnes();
    }

    public function GetPersonne($personneId)
    {
        return $this->personneDao->GetPersonne($personneId);
    }

    public function AddPersonne($personne)
    {
        $insertedId = 0;

        if ($personne->GetNom() == '' || $personne->GetPrenom() == '' || $personne->GetCNE() == '')
        {
            $this->errorMessage = 'Nom, Prenom, and CNE are required.';
            return $insertedId;
        }

        if ($this->IsValidPersonne($personne))
        {
            $insertedId = (int)$this->personneDao->AddPersonne($personne);
        }

        return $insertedId;
    }

    public function UpdatePersonne($personne)
    {
        $affectedRows = 0;

        if ($personne->GetNom() == '' || $personne->GetPrenom() == '' || $personne->GetCNE() == '')
        {
            $this->errorMessage = 'Nom, Prenom, and CNE are required.';
            return $affectedRows;
        }

        if ($this->IsValidPersonne($personne))
        {
            $affectedRows = (int)$this->personneDao->UpdatePersonne($personne);
        }

        return $affectedRows;
    }

    public function DeletePersonne($personneId)
    {
        $affectedRows = 0;

        if ($personneId > 0) {
            if ($this->IsIdExists($personneId))
            {
                $affectedRows = (int)$this->personneDao->DeletePersonne($personneId);
            } else
            {
                $this->errorMessage = 'Record not found.';
            }
        } else
        {
            $this->errorMessage = 'Invalid Id.';
        }

        return $affectedRows;
    }

    public function IsValidPersonne($personne)
    {
        return true;
    }

    public function IsIdExists($id)
    {
        return $this->personneDao->IsIdExists($id);
    }

}
?>
