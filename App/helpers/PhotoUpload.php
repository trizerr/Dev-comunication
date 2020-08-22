<?php


namespace App\helpers;


class PhotoUpload
{

    public function profileImage($postsubmite){


        if(!file_exists("img/".$_SESSION['id']))
            $result = mkdir ("img/".$_SESSION['id']);
        $target_dir = "img/".$_SESSION['id'].'/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if(isset($postsubmite)) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
              //  echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
              //  echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
           // echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
           // echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
          //  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          //  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          //      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

                header("Location: /user/profile");

            } else {
           //     echo "Sorry, there was an error uploading your file.";
            }
        }
        return $target_dir.$_FILES["fileToUpload"]["name"];
    }

    public function postImage( $files, $post_id){

        $filename = $files['image']['name'];
        if(!file_exists("img/post".$post_id))
            $result = mkdir ("img/post".$post_id);
        $target_dir = "img/post".$post_id.'/';
        $target_file = $target_dir . basename($filename);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if(isset($postsubmite)) {
            $check = getimagesize($filename);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
// Allow certain file formats

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {

            if (move_uploaded_file( $files['image']['tmp_name'], $target_file)) {

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        return $target_dir.$filename;
    }

}