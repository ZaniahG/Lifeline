<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'aws_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $uploads_dir = 'uploads/';
    $target_file = $uploads_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["photo"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        try {
            $result = $s3->putObject([
                'Bucket' => $bucket,
                'Key'    => basename($_FILES["photo"]["name"]),
                'SourceFile' => $_FILES["photo"]["tmp_name"],
                'ACL'    => 'public-read'
            ]);

            $s3_url = $result['ObjectURL'];

            $images = json_decode(file_get_contents('images.json'), true);
            $images[] = ['username' => $_SESSION['username'], 'filename' => basename($_FILES["photo"]["name"]), 's3_url' => $s3_url];
            file_put_contents('images.json', json_encode($images));

            echo "The file " . basename($_FILES["photo"]["name"]) . " has been uploaded.";
        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }
}
?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="photo" id="photo">
    <button type="submit">Upload Image</button>
</form>
<a href="gallery.php">Back to Gallery</a>