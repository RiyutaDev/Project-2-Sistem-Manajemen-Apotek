<!DOCTYPE html>
<html lang="en">
<head>

    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        /* Memperbaiki tampilan pagination agar sejajar */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            margin-left: 0;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .badge {
            font-size: 85%;
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">