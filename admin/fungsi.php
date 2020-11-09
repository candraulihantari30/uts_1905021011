<?php
   // Koneksi Ke Database
$conn = mysqli_connect("localhost","root", "", "crudnativ");
 
function query($query){
global $conn;
   $result = mysqli_query($conn, $query);
   $rows = [];
   while($row = mysqli_fetch_assoc($result) ){
      $rows [] = $row;
   }
   return $rows;
}

function tambah($data){
    global $conn;
    $judul = htmlspecialchars ($data["judul"]);
    
    //upload
    $img = upload();
    if ( !$img){
       return false;
    }
    
    $kode =htmlspecialchars ($data["kode"]);
    $penulis = htmlspecialchars ($data["penulis"]);
    $tahun_terbit =htmlspecialchars ($data["tahun_terbit"]);
    
    $gambar= upload();
    if( !$gambar ){
       return false;
    }
   
   $query ="INSERT INTO detailbuku
             VALUES
             ('', '$img', '$judul', '$kode', '$penulis','$tahun_terbit')
         ";
      mysqli_query($conn, $query);
      return mysqli_affected_rows($conn);
   }

function upload() {
   $namaFile = $_FILES['img']['name'];
   $ukuranFile = $_FILES['img']['size'];
   $error = $_FILES['img']['error'];
   $tmpName = $_FILES['img']['tmp_name'];


   if ( $error === 4 ) {
      echo "<script>
            alert('pilih gambar terlebih dadulu');
            </script>";
       return false;      
   }
   
   $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
   $ekstensiGambar = explode('.', $namaFile);
   $ekstensiGambar = strtolower(end($ekstensiGambar));
   if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
      echo "<script>
            alert('file yang anda upload bukan gambar!') ;
            </script>";
      return false; 
   }
   
   if( $ukuranFile > 1000000) {
      echo "<script>
            alert('ukuran file melebihi kapasitas!');
            </script>";
      return false; 
   }

   move_uploaded_file($tmpName, '../img/'. $namaFile);
   return $namaFile;
}
   function hapus($id){
      global $conn;
      mysqli_query($conn, "DELETE FROM detailbuku WHERE id=$id");
      return mysqli_affected_rows($conn);
  }

function ubah($data) {
   global $conn;
   $id= $data["id"];
   $img = htmlspecialchars ($data["img"]);
   $judul = htmlspecialchars ($data["judul"]);
   $kode =htmlspecialchars ($data["kode"]);
   $penulis = htmlspecialchars ($data["penulis"]);
   $tahun_terbit =htmlspecialchars ($data["tahun_terbit"]);
  
  $query ="UPDATE detailbuku SET 
            img = '$img',
            judul = '$judul',
            kode = '$kode',
            penulis = '$penulis',
            tahun_terbit = '$tahun_terbit'
            WHERE id= $id
        ";
     mysqli_query($conn, $query);
     return mysqli_affected_rows($conn);
}
?>