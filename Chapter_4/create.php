<?php
session_start();

$connect = mysqli_connect("localhost", "root", "", "it-stores");


$id_user = $_SESSION["id_user"];



$kategori = mysqli_query($connect, "SELECT * FROM kategori WHERE id_user = $id_user");
// $kategori = query("SELECT a.*,b.nama AS nama_kategori FROM produk a INNER JOIN kategori b ON a.id_kategori=b.id_kategori WHERE a.id_user = $id_user");


function tambahProduk($data)
{
    global $connect;

    $id_penjual = $_SESSION["id_user"];
    $produk = $data["produk"];
    $harga = $data["harga"];
    $kategori = $data["kategori"];
    $detail = $data["detail"];
    $stok = $data["stok"];

    $foto = upload();

    if (!$foto) {
        return false;
    }

    $query = "INSERT INTO produk (`id` ,`id_kategori`,`id_user` ,`nama_produk`, `harga`,`foto`,`stok`, `detail` )  VALUES ('', '$kategori', '$id_penjual','$produk','$harga', '$foto' ,'$stok' ,'$detail')";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function upload()
{
    $namaFile = $_FILES["foto"]["name"];
    $error = $_FILES["foto"]["error"];
    $tmpName = $_FILES["foto"]["tmp_name"];

    //cek apakah ada foto yg di upload atau tidak
    if ($error === 4) {
        echo
        "<script>
                alert('Upload foto terlebih dahulu');
            </script>";
        return false;
    }

    //cek apakah yang di upload foto atau bukan
    $ekstensiFotoValid = ["jpg", "jpeg", "png"];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));

    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo
        "<script>
             alert('Upload foto dongg');
         </script>";
        return false;
    }
    //lolos semua pengecekan
    //generate nama foto baru

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFoto;




    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;
}

if (isset($_POST["submit"])) {

    if (tambahProduk($_POST) > 0) {
        echo
        "<script>
                alert('Data berhasil ditambahkan');
                window.location.href = 'read.php';
            </script>";
    } else {
        echo
        "<script>
                alert('Data gagal ditambahkan :( ');
            </script>";
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../Style/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!-- <?php include("../Navbar_Seller/index.php") ?> -->


    <div class="main-pages">
        <div class="container-fluid">
            <div class="row g-2">
                <div class="col-12 col-lg-6 w-100">
                    <div class="d-block rounded shadow bg-white p-3 mt-3">
                        <div class="cust-table">
                            <div class="d-flex justify-content-between flex-wrap gap-5 title-table w-100">
                                <h1>TAMBAH PRODUK</h1>
                            </div>
                            <div class="table mt-5">

                            </div>
                        </div>
                    </div>
                    <div class="d-block rounded shadow bg-white p-3 mt-3">
                        <div class="cust-table">
                            <div class="d-flex justify-content-between ps-5 pt-1 flex-wrap gap-5 title-table w-100">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <table>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="produk">Nama Produk</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4"><input type="text" placeholder="isi produk..." name="produk" id="produk" required class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="kategori">Kategori</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4">
                                                <select class="form-select" aria-label="Default select example" name="kategori" id="kategori">
                                                    <option selected>Open this select menu</option>
                                                    <?php foreach ($kategori as $kategories) : ?>
                                                        <option value="<?= $kategories["id_kategori"]; ?>"><?= $kategories["nama"]; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="harga">Harga Produk</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4"><input type="number" placeholder="isi harga..." name="harga" id="harga" required class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="foto">Foto</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4"><input type="file" name="foto" id="foto" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="stok">Ketersediaan Stok</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4"><input type="number" name="stok" id="stok" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4 pb-4"><label for="detail">Detail</label></td>
                                            <td class="pe-3 pb-4">:</td>
                                            <td class="pb-4"><textarea name="detail" id="detail" cols="30" rows="10" class="form-control" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><button type="submit" name="submit" class="btn btn-primary">Tambah </button></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="table mt-5">

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>

</html>