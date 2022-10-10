<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Berita</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Layout</a></li>
                        <li class="breadcrumb-item active">Top Navigation</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">

                <?php
                if (count($dtBerita) == 0) {
                    echo '<div class="col-md-12"><div class="card text-center">
                        <div class="card-header">
                            Data Masih Kosong
                        </div>
                        <div class="card-body">
                            <p class="card-text">Menunggu Data diproses</p>
                            <a href="' . base_url('home') . '" class="btn btn-primary">Go Home</a>
                        </div>
                    </div></div>';
                } else {
                    foreach ($dtBerita as $value) {
                        $judul = $value['judul'];
                        $deskripsi_singkat = $value['deskripsi_singkat'];
                        $gambar = $value['gambar'];
                        $judul = $value['judul'];
                ?>
                <div class="col-md-3">

                    <div class="card">
                        <img class="card-img-top" src="<?= base_url('upload/berita/' . $gambar); ?>"
                            alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-bold mb-3"><?= $judul; ?></h5>
                            <p class="card-text"><?= $deskripsi_singkat; ?></p>
                            <a href="#" class="d-flex justify-content-end">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>

                </div>
                <?php }
                } ?>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->