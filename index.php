<?php
global $conn, $personneDAO;
require_once('loader.php');

$personneDAO = new PersonneDAO($conn);

$deleteSuccess = false;
$errorMessage = '';

if (isset($_POST["delete"])) {
    $id = $_POST["delete-id"];

    echo $id;
    try {
        $personneDAO->deleteStagiaire($id);
        $deleteSuccess = true;
    } catch (Exception $e) {
        $errorMessage = 'Error deleting Stagiaire: ' . $e->getMessage();
    }

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is a simple implementation of OOP in PHP. This application is created for educational purposes." />
    <meta name="author" content="Arif Uddin" />
    <link href="/Assets/Styles/Styles.css" rel="stylesheet">

    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>List of Students</title>
</head>

<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./">Student Information</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-success" href="add.php"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Header -->
<header class="page-header">
    <h1>List of Students</h1>
</header>

<!-- Student Table -->
<section class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>CNE</th>
            <th>Ville</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT personne.*, ville.nom_ville
                FROM personne
                JOIN ville ON personne.id_ville = ville.id";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['CNE'] . "</td>";
                echo "<td>" . $row['nom_ville'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>";

                echo "<button type='submit' class='btn btn-danger deleteInTable' data-bs-toggle='modal'
                                    data-bs-target='#deleteModal'
                                    data-id='" . $row['id'] . "'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No Stagiaires found.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteVehicleModalLabel">Delete Stagiaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Stagiaire?</p>
                    <form method="POST" id="deleteForm" action="#">
                        <input type="hidden" id="delete-id" name="delete-id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" name="delete" id="deleteBtn">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModal">Edit Stagiaire</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="edit-id" name="edit-id">
                        <label for="edit-nom">Nom:</label>
                        <input type="text" name="edit-nom" id="edit-nom" required>
                        <br>
                        <label for="edit-CNE">CNE:</label>
                        <input type="text" name="edit-CNE" id="edit-CNE" required>
                        <label for="edit-ville">Ville:</label>
                        <input type="text" name="edit-ville" id="edit-ville" required>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap and jQuery Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script>
    function btnEdit(Button) {
        var id = Button.getAttribute('data-id');
        var nom = Button.getAttribute('data-nom');
        var cne = Button.getAttribute('data-CNE');
        var ville = Button.getAttribute('data-ville');

        var inputNom = document.querySelector('#edit-nom');
        var inputCNE = document.querySelector('#edit-CNE');
        var inputID = document.querySelector('#edit-id');
        var inputVille = document.querySelector('#edit-ville');

        inputNom.value = nom;
        inputCNE.value = cne;
        inputID.value = id;
        inputVille.value = ville;
    }

</script>
<script>
    $("#deleteBtn").click(function () {
        console.log("Delete button clicked");
        $("#deleteForm").submit();
    });

    $(document).ready(function () {
        $("#deleteForm").submit(function (event) {
            console.log("Form submitted");
        });
    });
</script>
</body>
</html>

