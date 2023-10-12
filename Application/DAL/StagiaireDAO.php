<?php
global $conn;
include 'Application/DatabaseConnection.php';
include 'Application/Entities/Ville.php';
include 'Application/Entities/Stagiaire.php';

class PersonneDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createStagiaire($nom, $prenom, $cne, $id_ville) {
        try {
            if ($nom === null || $prenom === null || $cne === null) {
                throw new Exception("Stagiaire properties cannot be null.");
            }

            $sql = "INSERT INTO personne (nom, prenom, CNE, id_ville) VALUES (:nom, :prenom, :cne, :id_ville)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':cne', $cne);
            $stmt->bindParam(':id_ville', $id_ville);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            $this->logError("Error creating Stagiaire: " . $e->getMessage());
            throw new Exception("An error occurred while creating the Stagiaire.");
        }
    }


    public function getVilleIdByName() {
        try {
            $sql = "SELECT * FROM ville";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

           
                return $result;
           
        } catch (PDOException $e) {
            $this->logError("Error getting city id: " . $e->getMessage());
            throw new Exception("An error occurred while getting city id.");
        }
    }

    public function getStagiaireById($id) {
        try {
            $sql = "SELECT personne.id, personne.nom, personne.prenom, personne.CNE, ville.nom_ville
                    FROM personne
                    INNER JOIN ville ON personne.id_ville = ville.id
                    WHERE personne.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error getting Stagiaire by ID: " . $e->getMessage());
            return null;
        }
    }

    public function updateStagiaires($id, $nom, $cne, $ville) {
        try {
            $sql = "UPDATE personne 
                SET nom = :nom, CNE = :cne, id_ville = :ville
                WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cne', $cne);
            $stmt->bindParam(':ville', $ville);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->logError("Error updating Stagiaire: " . $e->getMessage());
        }
    }

   public function deleteStagiaire($id) {
       try {
           $sql = "DELETE FROM personne WHERE id = :id";
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(':id', $id);
           $stmt->execute();

           // Add a debugging statement
           echo "Stagiaire with ID $id deleted successfully.";

           return true;
       } catch (PDOException $e) {
           $this->logError("Error deleting Stagiaire with ID $id: " . $e->getMessage());
           return false;
       }
   }



    public function GetAllPersonnes()
    {
        try {
            $sql = "SELECT prototype.personne.id, prototype.personne.nom, prototype.personne.prenom, prototype.personne.CNE, prototype.ville.nom_ville
            FROM prototype.personne
            INNER JOIN prototype.ville ON prototype.personne.id_ville = prototype.ville.id";
            ;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // Fetch all persons as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error getting all persons: " . $e->getMessage());
            return []; // or handle the error in a way that suits your application
        }
    }


    private function logError($message) {
        error_log($message);
    }
}

?>