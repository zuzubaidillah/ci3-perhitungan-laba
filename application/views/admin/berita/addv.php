<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Tambah Berita</h1>
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
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <a href="<?= base_url(); ?>admin/berita" class="card-link">Lihat Data</a>

                            <form action="<?= base_url(); ?>admin/berita/proses_add" method="post">

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="">Id Berita</label>
                                        <input type="text" class="form-control"
                                            placeholder="Id Berita Otomatis dibuat Sistem" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tanggal">Tanggal*</label>
                                        <input value="<?= date('Y-m-d') ?>" type="date" class="form-control"
                                            id="tanggal" name="tanggal" required>
                                        <div class="">*tanggal jika melebihi <?= date('Y-m-d') ?>, maka ketika di public
                                            berita
                                            tidak akan ditampilkan</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="gambar">Gambar*</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar"
                                            placeholder="Upload Gambar" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="judul">Judul*</label>
                                        <input maxlength="150" type="text" class="form-control" id="judul" name="judul"
                                            placeholder="Masukan Judul yang uniq" autofocus required>
                                        <div class="">*pastikan judul tidak sama dengan data yang sudah tersimpan</div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tag">Tags*</label>
                                        <input type="text" class="form-control" id="tag" name="tag"
                                            placeholder="Masukan tag berita" required>
                                        <div class="">*pastikan setiap beda tag gunakan tanda koma ( , )</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi_singkat">Deskripsi Singkat*</label>
                                    <textarea maxlength="150" type="text" class="form-control" id="deskripsi_singkat"
                                        name="deskripsi_singkat"
                                        placeholder="Deskripsi sama seperti isi, hanya saja lebih singkat"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="isi">Isi*</label>
                                    <textarea type="text" class="form-control" id="isi" name="isi" required></textarea>
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
    const idmenu = document.getElementById('mnberita');
    // const idsubmenu = document.getElementById('');
    // liidmenu.classList.add('menu-open');
    idmenu.classList.add('active');
    // idsubmenu.classList.add('active');
})

var editor = CKEDITOR.replace('isi');
</script>