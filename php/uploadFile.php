<?php
$studyNumber = $_SESSION["studyNumber"];

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"]. "<br>";
}
$fileName = "../upload/" . $studyNumber . "/" . $_FILES["file"]["name"];

// if (file_exists($fileName)) {
//       echo $_FILES["file"]["name"] . " already exists. <br>";
//     } else {
//       if(move_uploaded_file($_FILES["file"]["tmp_name"],'../upload/'. $_FILES["file"]["name"])) {
//         echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
//       } else {
//         echo "<br>Fail.";
//       }
      
//     }
 if(move_uploaded_file($_FILES["file"]["tmp_name"],$fileName)) {
        echo "Stored in: " . $fileName;
      } else {
        echo "<br>Fail.";

foreach(glob('../upload/'.$studyNumber.'*.*') as $file) {
    echo '<p><a href="'.$file.'">'.$file.'</a>: '.filesize($file).'</p>';
}
?>