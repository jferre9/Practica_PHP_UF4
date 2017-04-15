<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Practica UF3</title>

	<link href="<?php echo base_url('public/estils/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/estil.css') ?>">
</head>
<body>
    <?php $this->load->view($vista); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('public/estils/js/bootstrap.min.js') ?>"></script>
</body>
</html>