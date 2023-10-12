<?php
global $conn;
include 'Application/DatabaseConnection.php';
include 'Application/Entities/Ville.php';
include 'Application/Entities/Student.php';

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

    // GestionStagiaire3.php
    public function getVilleIdByName($nom_ville) {
        try {
            $sql = "SELECT id FROM ville WHERE nom_ville = :nom_ville";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nom_ville', $nom_ville);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['id'];
            } else {
                throw new Exception("City not found: $nom_ville");
            }
        } catch (PDOException $e) {
            $this->logError("Error getting city id: " . $e->getMessage());
            throw new Exception("An error occurred while getting city id.");
        }
    }



    public function getStagiaireById($id) {
        try {
            $sql = "SELECT personne.id, personne.nom, personne.prenom, personne.CNE, ville.nom_ville
                    FROM personne
                    JOIN ville ON personne.id_ville = ville.id
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

    public function updateStagiaire($id, $nom, $cne, $ville) {
        try {
            $sql = "UPDATE personne 
                SET nom = :nom, CNE = :cne, id_ville = (SELECT id FROM ville WHERE nom_ville = :ville) 
                WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cne', $cne);
            $stmt->bindParam(':ville', $ville);

            $stmt->execute();
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
            $sql = "SELECT id, nom, prenom, CNE, id_ville FROM personne";
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

$personneDAO = new PersonneDAO($conn);
?>