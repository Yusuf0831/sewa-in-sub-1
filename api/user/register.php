<?php
require_once "encrypt.php";
require_once "koneksi.php";
$username = isset($_POST['username']) ? $_POST['username'] : null;   
$password = isset($_POST['password']) ? $_POST['password'] : null;   
$namaLengkap = isset($_POST['namaLengkap']) ? $_POST['namaLengkap'] : null;   
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;   
$noTelf = isset($_POST['noTelf']) ? $_POST['noTelf'] : null;   
$kota = isset($_POST['kota']) ? $_POST['kota'] : null;   

$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

header('Content-Type: application/json');
$uploadDir = "uploads/"; 
$allowedTypes = ["jpg", "jpeg", "png"]; 
$fileName = $_FILES["fotoProfil"]["name"];
$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if (in_array($fileType, $allowedTypes)) {
    $tempFile = $_FILES["fotoProfil"]["tmp_name"];
    $targetFile = $uploadDir . uniqid() . "." . $fileType;                
    if (move_uploaded_file($tempFile, $targetFile)) {                                            
        
        $username = isset($_POST['username']) ? $_POST['username'] : null;   
        $password = isset($_POST['password']) ? $_POST['password'] : null;   
        $namaLengkap = isset($_POST['namaLengkap']) ? $_POST['namaLengkap'] : null;   
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;   
        $noTelf = isset($_POST['noTelf']) ? $_POST['noTelf'] : null;   
        $kota = isset($_POST['kota']) ? $_POST['kota'] : null;   

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
                                
        $sql = "INSERT INTO user (username, password, namaLengkap, alamat, noTelf,kota,fotoProfil) 
        VALUES ('$username', '$password', '$namaLengkap', '$alamat', '$noTelf', '$kota' ,'$targetFile')";  
            
        try {
            if ($conn->query($sql) === TRUE) {
                $jmlBarisDiubah = $conn->affected_rows;
                $data = array(
                    "message" => "registrasi suksess",         
                    "username" => $username,       
                );
                http_response_code(200);
                echo json_encode($data);
            } else {
                throw new Exception($conn->error);
            }
        } catch (Exception $e) {
            $data = array(
                "message" => "error",                
                "error" => $e->getMessage()
            );
            http_response_code(400);
            echo json_encode($data);
        }

    }                                   
} else {
    $data = array(
        "message" => "error",                
        "error" => "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed."
    );
    http_response_code(400);
    echo json_encode($data);
}                      
$conn->close();  
