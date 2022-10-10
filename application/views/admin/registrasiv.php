<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - Sistem Informasi Perhitungan Laba</title>

    <link rel="shortcut icon" href="https://smktiannajiyah.sch.id/resources/images/b915a903b2485a71e0cfa453b5ebfcbd.png"
        type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Perhitungan</b>LABA</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Tabel Users Masih Kosong datanya, untuk bisa melakukan login lakukan Registrasi
                    terlebih dahulu</p>

                <form action="<?= base_url() ?>admin/login/proses_add_registrasi" method="post">

                    <div class="input-group mb-3">
                        <input name="nd" type="text" class="form-control" placeholder="Nama Depan">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input name="nb" type="text" class="form-control" placeholder="Nama Belakang">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-users"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input name="u" type="text" class="form-control" placeholder="Enter Your Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input name="p" type="password" class="form-control" placeholder="Enter your Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets-admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets-admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets-admin/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets-admin/sweetalert2@11.js"></script>
    <?php
    echo $this->session->flashdata('notifikasi');
    ?>
</body>

</html>