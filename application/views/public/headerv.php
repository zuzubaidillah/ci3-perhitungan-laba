<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $head_title ?? "APPS Default"; ?> - Sistem Informasi Perhitungan Laba</title>

    <link rel="shortcut icon" href="https://smktiannajiyah.sch.id/resources/images/b915a903b2485a71e0cfa453b5ebfcbd.png"
        type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets-admin/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <img src="<?= base_url() ?>assets-admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Per. Laba</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?= base_url() ?>home" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">menu sub</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="<?= base_url() ?>berita" class="dropdown-item">Public Berita</a></li>
                            </ul>
                        </li>

                        <?php if ($this->session->userdata('session_id') != null) { ?>

                        <li class="nav-item">
                            <a href="<?= base_url() ?>admin/dashboard" class="nav-link">Dashboard</a>
                        </li>

                        <?php } else { ?>

                        <li class="nav-item">
                            <a href="<?= base_url() ?>admin/login" class="nav-link">Log In</a>
                        </li>

                        <?php } ?>

                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->