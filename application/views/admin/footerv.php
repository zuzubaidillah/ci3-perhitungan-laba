<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

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

<script>
document.addEventListener('DOMContentLoaded', function() {

    // kondisi ketika menu login ditekan maka muncul pertanyaan
    const btnLogOut = document.getElementById('mnlogout');
    btnLogOut.addEventListener('click', function() {
        Swal.fire({
            title: 'Keluar dari sistem?',
            text: "Sesi akan dihilangkan, mengakibatkan harus login lagi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya...LogOut'
        }).then((result) => {
            if (result.isConfirmed) window.location = "<?= base_url('admin/logout') ?>";
        })
    })
})
</script>
</body>

</html>