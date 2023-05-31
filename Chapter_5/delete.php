<?php 

$connect = mysqli_connect("localhost", "root", "", "it-stores");

$id = $_GET["id"];

$query = mysqli_query($connect, "SELECT * FROM produk WHERE id = $id");
$data = mysqli_fetch_array($query);

// $count = mysqli_num_rows($query);

function hapus($id) {
    global $connect;
    mysqli_query($connect, "DELETE FROM produk WHERE id = $id");

    return mysqli_affected_rows($connect);
}


if ( hapus($id) > 0 ) {
    echo
    "<script>
        alert('Data berhasil dihapus');
        window.location.href = 'read.php';
    </script>";
} else {
     echo
    "<script>
        alert('Data gagal dihapus');
        window.location.href = 'read.php';
    </script>";
}



?>