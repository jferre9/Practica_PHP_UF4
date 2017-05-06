<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Practica UF4</title>

	<link href="<?php echo base_url('public/estils/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/estil.css') ?>">
        <script src="http://maps.google.com/maps/api/js?sensor=true&key=AIzaSyCZPkegXzyFwgTb83GmaCKgzImVDSF1SUE" type="text/javascript"></script>
</head>
<body>
    <nav class="navbar navbar-static-top navbar-inverse" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Login dropdown</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url() ?>">Home</a></li>
                    <?php if($this->session->usuari): ?>
                    <li><a href="<?php echo site_url('comprar') ?>">Comprar</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Webservices <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo site_url('webservice/comandes')."?key=".$this->session->usuari["clau"] ?>">Comandes</a></li>
                            <li><a href="<?php echo site_url('webservice/productes')."?key=".$this->session->usuari["clau"] ?>">Productes</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo site_url('admin') ?>">Administració</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if ($this->session->usuari) echo $this->session->usuari['nom']; else echo "Login"; ?> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                        <?php if ($this->session->usuari): ?>
                                    <div class="col-md-12">
                                        <div class="social-buttons">
                                            <a class="btn btn-info" href="<?php echo site_url('welcome/usuari') ?>">Dades personals</a>
                                            <a class="btn btn-danger" href="<?php echo site_url('welcome/logout') ?>">Logout</a>
                                        </div>
                                    </div>
                                        <?php else: ?>
                                    <div class="col-md-12">
                                        Login via
                                        <div class="social-buttons">
                                            <a href="<?php echo site_url('welcome/facebook') ?>" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                                        </div>
                                        <p>o</p>
                                        <form class="form" role="form" method="post" action="<?php echo site_url('welcome/login')?>" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" name="pass" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="bottom text-center">
                                        Ets nou? <a href="<?php echo site_url('welcome/registre') ?>"><b>Registra't</b></a>
                                    </div>
                                        <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
    <?php $this->load->view($vista); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('public/estils/js/bootstrap.min.js') ?>"></script>
</body>
</html>