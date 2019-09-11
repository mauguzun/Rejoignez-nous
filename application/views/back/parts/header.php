<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="<?= $charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>
       <?= isset($meta['title'])? $meta['title'] : '-' ?>
    </title>
    <meta name="description"  content="<?= isset($meta['description'])? $meta['description'] : "-"?>">   
    <meta name="keywords"  content="<?= isset($meta['keywords'])? $meta['keywords'] : "-"?>" >
    	
    	
    	<script>
    		var callFunctions = [];
    	</script>

    <!-- Global stylesheets -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>css/back/my.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url()?>static/update/css/admin-style.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/loaders/pace.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/core/libraries/jquery.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/core/libraries/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/loaders/blockui.min.js">
    </script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/visualization/d3/d3.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/visualization/d3/d3_tooltip.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/forms/styling/switchery.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/forms/styling/uniform.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/forms/selects/bootstrap_multiselect.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/ui/moment/moment.min.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/plugins/pickers/daterangepicker.js">
    </script>

    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/core/app.js">
    </script>
    <script type="text/javascript" src="<?= base_url()?>css/back/assets/js/pages/dashboard.js?ASdf">
    </script>
    <!-- /theme JS files -->

    <style>
        @font-face {
            font-family: "Calibri";
            src: url("Calibri.ttf") format("truetype")
        }
    </style>
</head>
 
<body>

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href=""<?= base_url()?>/back">
            <img src="<?= base_url()?>css/back/assets/images/logo.svg" alt="">
        </a>

        <ul class="nav navbar-nav visible-xs-block">
          <!--  <li>
                <a data-toggle="collapse" data-target="#navbar-mobile">
                    <i class="icon-tree5">
                    </i>
                </a>
            </li>-->
            <li>
                <a class="sidebar-mobile-main-toggle">
                    <i class="icon-paragraph-justify3">
                    </i>
                </a>
            </li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">


        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown language-switch">
                <a href="<?= base_url().'shared/user'?>" title="edit account">
                    <i class="fas fa-user-circle">
                    </i>
                </a>
            </li>
            <li class="dropdown language-switch">
                <a href="<?= base_url().'shared/resetpassword'?>" title="reset passwrod" >
                    <i class="fas fa-cog">
                    </i>
                </a>
            </li>
          
            <li class="dropdown language-switch">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= base_url()?>css/back/assets/images/flags/<?=$current_lang ?>.png" class="position-left" alt="">
                   <?= $current_lang ?>
                    <span class="caret">
                    </span>
                </a>


              
                
                 <ul class="dropdown-menu">
                   <? foreach($lang_list  as  $key=>$value):?>
                   		
                    <li>
                        <a href="<?= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>?lang=<?= $key ?>">
                            <img src="<?= base_url()?>css/back/assets/images/flags/<?= $key ?>.png" alt=""> <?= $value ?>
                        </a>
                    </li>
                  
                   
                   <? endforeach ;?>
                </ul>
                   
                
            </li>


        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">


        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header">
                        <div class="row">
                           
                          <!--  <div class="col-md-12">
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search">
                            </div>-->
                        </div>
                    </li>
                    
                    

                    <?foreach ( $admin_menu as $text=>$array ):?>
					
					<?if(count($array) == 1 ) : ?>
						 <? foreach ($array as $class=>$link ):?>
						 		 <li  
						 		 	 <?
						 		 		if ($link == $current){
											echo 'class="active"';
										}
						 		 	 ?>
						 		 
						 		 ><a  href="<?= base_url().$link  ?>"><i class="<?= $class ?> menu-icon"></i>
						 		  <span ><?= lang($text)?></span></a></li>
						 <? endforeach ?> 
					<? else :?>
					 <li >
							<a href="#" ><i class=" <?= key($array) ?> menu-icon"></i>
							 <span ><?= lang($text)  ?></span>
							
							 </a>
							<ul>
							<? foreach($array as $class=>$link) :?>
							
								  
       									
								
								  <? foreach($link as $urltext => $url):?>
							           <li><a href="<?= base_url().$url ?>" id="layout5">
							           <?=   lang($urltext) ?></a></li>
								  <? endforeach ;?>

						    <? endforeach ;?>
						    </ul>
				    </li>
					
					<? endif;?>
					
                    
                  	
                    <? endforeach;?>




                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->


<!-- Main content -->
<div class="content-wrapper">

<!-- Page header -->
<div class="page-header page-header-default">


    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">
                   
                </span>Dashboard
            </h4>
        </div>
        


    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="<?= base_url()?>">
                    Site public
                </a>
            </li>
            <li class="active">
           		 <a href="<?= base_url().'shared/viewoffers'?>">
                    Dashboard
                </a>
               
            </li>
          
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">