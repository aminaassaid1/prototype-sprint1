<?php
require_once('loader.php');


if (isset($_GET['id'])) {
    global $conn, $personneDAO;

    $personneDAO = new PersonneDAO($conn);
    $id = $_GET['id'];

    $sql = "SELECT * FROM personne WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Invalid request. Please provide student ID.";
    exit();
}

if (isset($_POST['updateS'])) {
    $personneDAO = new PersonneDAO($conn);
    $id_persone = $_POST['edit-id'];
    $nom = $_POST['edit-nom'];
    $cne = $_POST['edit-CNE'];
    $nom_ville= $_POST['stagiaireVille'];

    try {
        $result = $personneDAO->updateStagiaires($id_persone, $nom, $cne, $nom_ville);

        if($result){
            header('location:index.php');
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Edit Stagiaire</title>
</head>

<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./">Stagiaire Information</a>
    </div>
</nav>

<!-- Page Header -->
<header class="page-header text-center">
    <h1>Edit Stagiaire</h1>
</header>

<!-- Edit Form -->
<section class="container mt-4">
    <form method="POST" action="">
        <input type="hidden" name="edit-id" value="<?php echo $id; ?>">

        <div class="mb-3">
            <label for="edit-nom" class="form-label">Nom:</label>
            <input type="text" class="form-control" name="edit-nom" id="edit-nom"
                   value="<?php echo isset($student['nom']) ? $student['nom'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="edit-CNE" class="form-label">CNE:</label>
            <input type="text" class="form-control" name="edit-CNE" id="edit-CNE"
                   value="<?php echo isset($student['CNE']) ? $student['CNE'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="edit-ville" class="form-label">Ville:</label>
            <select name="stagiaireVille" id="stagiaireVille">
                <?php 
                $villeData = new PersonneDAO($conn);
                $villeList = $villeData->getVilleIdByName();
                // var_dump($villeList);
                foreach($villeList as $ville){?>
                  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom_ville'] ?></option>
                  <?php
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="updateS">Update</button>
    </form>
</section>

<!-- Bootstrap and jQuery Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</body>

</html>
