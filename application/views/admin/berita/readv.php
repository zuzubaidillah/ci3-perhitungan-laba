<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Halaman Lihat Berita</h1>
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
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <a href="<?= base_url(); ?>admin/berita/add" class="card-link">Tambah Data</a>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 40px">Aksi</th>
                                        <th>Judul</th>
                                        <th>Dilihat</th>
                                        <th>Tag</th>
                                        <th>Tgl Dibuat</th>
                                        <th>Tgl DiUpdate</th>
                                        <th>Id Buat</th>
                                        <th>Id Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($dt) >= 1) {
                                        // jika ada datanya
                                        $nomorUrut = 0;
                                        foreach ($dt as $value) {
                                            // menambahkan nomor urut
                                            $nomorUrut++;

                                            $id_berita = $value['id_berita'];

                                            $judul = $value['judul'];
                                            $judulSlug = url_title($judul, "dash", true);
                                            $linkJudul = "<a target='_blank' href='" . base_url('berita/' . $judulSlug) . "'>$judul</a>";

                                            $dilihat = $value['dilihat'];
                                            $tag = $value['tag'];
                                            $tgl_buat = $value['tgl_buat'];
                                            $tgl_update = $value['tgl_update'];
                                            $id_buat = $value['id_buat'];
                                            $id_update = $value['id_update'];
                                    ?>
                                    <tr>
                                        <td><?= $nomorUrut; ?></td>
                                        <td>
                                            <a href="<?= base_url() ?>admin/berita/update/<?= $id_berita; ?>"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <button
                                                onclick="clickHapus('<?= base_url() ?>admin/berita/proses_delete/<?= $id_berita; ?>')"
                                                class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                        <td><?= $linkJudul; ?></td>
                                        <td><?= $dilihat; ?></td>
                                        <td><?= $tag; ?></td>
                                        <td><?= $tgl_buat; ?></td>
                                        <td><?= $tgl_update; ?></td>
                                        <td>
                                            <?= $id_buat; ?>
                                        </td>
                                        <td>
                                            <?= $id_update; ?>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr>
                                            <td colspan="9">
                                                Data Masih Kosong
                                            </td>
                                        </tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
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

function clickHapus(url) {
    Swal.fire({
        title: 'Hapus Data',
        text: "Data akan dilakukan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya...Hapus'
    }).then((result) => {
        if (result.isConfirmed) window.location = url;
    })
}
</script>