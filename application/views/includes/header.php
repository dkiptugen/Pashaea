<!DOCTYPE html>
<html>
<head>
  <title>PASHA EA | <?=@$meta->title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Arvo|Josefin+Slab|Lato|Open+Sans|Oswald|Pinyon+Script|Playfair+Display|Raleway|Roboto|Ubuntu|Vollkorn" rel="stylesheet">    
	<link rel="stylesheet" type="text/css" href="<?=base_url("assets/"); ?>bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url("assets/"); ?>bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url("assets/"); ?>bootstrap/css/bootstrap-reboot.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url("assets/"); ?>style.css">
  <link rel="stylesheet" href="<?=base_url("assets/"); ?>demo.css">
  <link rel="stylesheet" href="<?=base_url("assets/"); ?>footer-distributed-with-address-and-phones.css">
</head>
<body>
 <nav class="navbar navbar-sec navbar-light " style="background: rgb(255,255,255);">
            <div class="container">
                <a class="navbar-brand m-r-3" href="<?php echo base_url(); ?>"><img style="width: 100%" src="<?php echo base_url(); ?>assets/img/pasha-final.png" alt="Pasha East Africa logo"></a>
                
                <input class=" ml-auto navbar-right" type="text" placeholder="Search">

            </div>
        </nav>

        <nav class="navbar navbar-main navbar-light main px-0" id="nav1" style="border-radius: 0; margin-bottom: 2rem;">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#CollapsingNavbar1"  aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse navbar-toggleable-sm" id="CollapsingNavbar1">

                    <ul class="nav navbar-nav">
                        <li class="nav-item active">
                          <a href="<?=site_url(); ?>" class="nav-link">Home</a>
                        </li>
                        <?php
                       
                        foreach($Navigation as $value)
                          {
                            echo'  <li class="nav-item ">
                                <a class="nav-link" href="'.site_url("category/".$value->id."/".$value->name).'">'.$value->name.'</a>
                              </li>';
                              
                          }
                      
                         ?>
            
                    </ul>

                </div>          
            </div>
        </nav>
<div class="container">
	
<!-- <nav class="navbar navbar-toggleable-md navbar-light main" >
    <a class="navbar-brand" href="<?=site_url(); ?>"><img src="assets/img/pasha-final.png" alt=""></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a href="<?=site_url(); ?>" class="nav-link">Home</a>
      </li>
      <?php
     
      foreach($Navigation as $value)
        {
          echo'  <li class="nav-item ">
              <a class="nav-link" href="'.site_url("category/".$value->id."/".$value->name).'">'.$value->name.'</a>
            </li>';
            
        }
    
       ?>
    </ul>
      <input class=" ml-auto" type="text" placeholder="Search">
      
    
   </div>
</nav> -->
</div>
<div class="clearfix"></div>