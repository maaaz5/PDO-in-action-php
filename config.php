<?php
try {
    $pdoConn = new PDO("mysql:host=localhost;dbname=dbpdo", "root", "");

} catch (\Throwable$th) {
    echo "db has not been connected <br>";
    echo $th;
}

if (isset($_POST['submit'])) {
    $target_dir = "imgs/";
    $target_file = $_FILES['photo']['name'];
    $target_tmp = $_FILES['photo']['tmp_name'];
    $target_dir = "imgs/${target_file}";
    move_uploaded_file($target_tmp, $target_dir);

    $ref = $_POST['ref'];
    $lib = $_POST['lib'];
    $prix = $_POST['prix'];
    $photo = $target_dir;

    $sql = "INSERT INTO Article (Reference , Libelle, Prix,Photo) VALUES (?,?,?,?)";
    $pdoConn->prepare($sql)->execute([$ref, $lib, $prix, $photo]);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO TEST</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <form action="<?php echo htmlspecialchars(
    $_SERVER['PHP_SELF']
); ?>" method="post" enctype="multipart/form-data">

    <div class="flex flex-col items-center justify-center space-y-10 ">
    <h1 class="text-5xl font-semibold">Gestion des articles</h1>
    <div class="flex justify-space-between items-center">
        <!-- details -->
        <div>
            <ul class="space-y-4">
                <li class="space-x-5"><span>Reference:</span> <input class="border-4" name="ref" type="text"> </li>
                <li class="space-x-10"><span>Libelle:</span> <input class="border-4" name="lib" type="text"> </li>
                <li class="space-x-14"><span>Prix:</span> <input class="border-4" name="prix" type="number"></li>
                <li class="space-x-10"><span>Photo:</span> <input class="border-4" name="photo" type="file"> </li>
            </ul>
        </div>

        <!-- image -->
        <div class="w-50">
        <img src="<?php echo $target_dir ?>" alt="">
        </div>
    </div>

    <div class="space-x-6">
      <input type="submit" name="submit">
        <button type="reset">Annuler</button>
    </div>
    </div>
    </form>
</body>
</html>
