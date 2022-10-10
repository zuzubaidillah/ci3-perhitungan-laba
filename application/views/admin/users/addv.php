<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Tambah User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <a href="<?= base_url(); ?>admin/users" class="card-link">Lihat Data</a>

                            <form action="<?= base_url(); ?>admin/users/proses_add" method="post">

                                <div class="form-group">
                                    <label for="">Id User</label>
                                    <input type="text" class="form-control" placeholder="Id User Otomatis dibuat Sistem"
                                        readonly>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="namaDepan">Nama Depan (mak:10)</label>
                                        <input maxlength="10" type="text" class="form-control" id="namaDepan"
                                            name="namaDepan" placeholder="Masukan nama depan" autofocus required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="namaBelakang">Nama Belakang</label>
                                        <input type="text" class="form-control" id="namaBelakang" name="namaBelakang"
                                            placeholder="Masukan nama depan" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="u">Username</label>
                                    <input type="text" class="form-control" id="u" name="u"
                                        placeholder="Masukan username pastikan tidak boleh sama dengan yang sudah ada"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="p">Password</label>
                                    <input type="password" class="form-control" id="p" name="p"
                                        placeholder="Masukan password" required>
                                </div>

                                <div class="form-group">
                                    <label>Level Pengguna</label>
                                    <div class="form-check">
                                        <input value="administrator" class="form-check-input" type="radio" name="level"
                                            id="administrator">
                                        <label class="form-check-label" for="administrator">Administrator</label>
                                    </div>
                                    <div class="form-check">
                                        <input value="kasir" class="form-check-input" type="radio" name="level"
                                            checked="" id="kasir">
                                        <label class="form-check-label" for="kasir">Kasir</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>

                    </div><!-- /.card -->

                </div>

            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
// perintah untuk, ketika html sudah di load semua oleh browser maka kode javascript didalamnya akan dijalankan
document.addEventListener('DOMContentLoaded', function() {
    // const liidmenu = document.getElementById('');
    const idmenu = document.getElementById('mnusers');
    // const idsubmenu = document.getElementById('');
    // liidmenu.classList.add('menu-open');
    idmenu.classList.add('active');
    // idsubmenu.classList.add('active');
})
</script>