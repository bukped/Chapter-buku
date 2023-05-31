<?php
session_start();

$id_user = $_SESSION["id_user"];

$connect = mysqli_connect("localhost","root", "", "it-stores");

$query = mysqli_query($connect, "SELECT a.*,b.nama AS nama_kategori FROM produk a INNER JOIN kategori b ON a.id_kategori=b.id_kategori WHERE a.id_user = $id_user");





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

    <?php include("../Navbar_Seller/index.php") ?>


    <div class="main-pages">
        <div class="container-fluid">
            <div class="row g-2">
                <div class="col-12 col-lg-6 w-100">
                    <div class="d-block rounded shadow bg-white p-3">
                        <div class="cust-table">
                            <div class="d-flex justify-content-between flex-wrap gap-5 title-table w-100">
                                <h1>DATA PRODUK</h1>
                                <form class="d-flex " role="search" method="post">
                                    <table>
                                        <tr>
                                            <td>
                                                <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-success" name="search">Search</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="table mt-5">
                                <table class="table ms-0">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <!-- <th scope="col">Detail</th> -->
                                        <th scope="col">Aksi</th>
                                    </tr>
                                    <?php $i = 1; ?>
                                    <?php while ($produk = mysqli_fetch_assoc($query)) : ?>
                                        <tr>
                                            <td scope="row"><?= $i; ?></td>
                                            <td><img src="../img/<?= $produk["foto"]; ?>" 
                                                     width="100" alt=""></td>
                                            <td><?= $produk["nama_produk"]; ?></td>
                                            <td><?= $produk["nama_kategori"]; ?></td>
                                            <td><?= $produk["harga"]; ?></td>
                                            <td><?= $produk["stok"]; ?></td>
                                            <!-- <td><?= $produk["detail"]; ?></td> -->
                                            <!-- <td>
                                                <a href="Update/?id=<?= $produk["id"]; ?>" 
                                                   class="btn btn-warning">Ubah</a> |
                                                <a href="Delete/?id=<?= $produk["id"]; ?>" 
                                                   class="btn btn-danger" 
                                                   onclick="return confirm('Yakin mau di hapus?')">Delete
                                                </a>
                                            </td> -->
                                        </tr>
                                        <?php $i++; ?>
                                        <?php endwhile; ?>
                                    <?php //endforeach; ?>
                                </table>
                                <a href="Create/" class="btn btn-primary">INPUT</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>

</html>