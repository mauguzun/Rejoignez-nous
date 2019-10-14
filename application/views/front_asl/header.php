<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?= $charset ?>">
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=2.0, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">


	<title><?= $meta['title'] ?></title>

	<!--[if lt IE 9]>
	<script src="https://www.aslairlines.fr/wp-content/themes/eap/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

	<link rel="alternate" hreflang="en-us" href="<?= base_url()?>?lang=en">
	<link rel="alternate" hreflang="fr-fr" href="<?= base_url()?>?lang=fr">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300,700,300italic">
	<link rel="stylesheet" href="<?= base_url().'/css/front/css/style.css '?>">
	<link rel="stylesheet" href="<?= base_url().'/css/front/css/update.css '?>">

	<script>
		var base = "<?= base_url() ?>";
	</script>



	<link rel="stylesheet" id="controlled-admin-access-css" href="https://www.aslairlines.fr/wp-content/plugins/controlled-admin-access/public/css/controlled-admin-access-public.css?ver=1.0.0" type="text/css" media="all">
	<link rel="stylesheet" id="wpml-legacy-dropdown-0-css" href="https://www.aslairlines.fr/wp-content/plugins/sitepress-multilingual-cms/templates/language-switchers/legacy-dropdown/style.css?ver=1" type="text/css" media="all">
	<style id="wpml-legacy-dropdown-0-inline-css" type="text/css">
		.wpml-ls-sidebars-sidebar-1, .wpml-ls-sidebars-sidebar-1 .wpml-ls-sub-menu, .wpml-ls-sidebars-sidebar-1 a
		{
			border-color: #cdcdcd;
		}
		.wpml-ls-sidebars-sidebar-1 a
		{
			color: #444444;
			background-color: #ffffff;
		}
		.wpml-ls-sidebars-sidebar-1 a:hover,.wpml-ls-sidebars-sidebar-1 a:focus
		{
			color: #000000;
			background-color: #eeeeee;
		}
		.wpml-ls-sidebars-sidebar-1 .wpml-ls-current-language>a
		{
			color: #444444;
			background-color: #ffffff;
		}
		.wpml-ls-sidebars-sidebar-1 .wpml-ls-current-language:hover>a, .wpml-ls-sidebars-sidebar-1 .wpml-ls-current-language>a:focus
		{
			color: #000000;
			background-color: #eeeeee;
		}
		.wpml-ls-statics-shortcode_actions, .wpml-ls-statics-shortcode_actions .wpml-ls-sub-menu, .wpml-ls-statics-shortcode_actions a
		{
			border-color: #cdcdcd;
		}
		.wpml-ls-statics-shortcode_actions a
		{
			color: #444444;
			background-color: #ffffff;
		}
		.wpml-ls-statics-shortcode_actions a:hover,.wpml-ls-statics-shortcode_actions a:focus
		{
			color: #000000;
			background-color: #eeeeee;
		}
		.wpml-ls-statics-shortcode_actions .wpml-ls-current-language>a
		{
			color: #444444;
			background-color: #ffffff;
		}
		.wpml-ls-statics-shortcode_actions .wpml-ls-current-language:hover>a, .wpml-ls-statics-shortcode_actions .wpml-ls-current-language>a:focus
		{
			color: #000000;
			background-color: #eeeeee;
		}
	</style>
	
	<link rel="stylesheet" id="rptools-style-css" href="https://www.aslairlines.fr/wp-content/themes/eap/rptools_core/css/style.css?ver=1" type="text/css" media="all">
	<link rel="stylesheet" id="default-style-css" href="https://www.aslairlines.fr/wp-content/themes/eap/style.css?ver=1" type="text/css" media="all">
	<link rel="stylesheet" id="twentytwelve-fonts-css" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&amp;subset=latin,latin-ext" type="text/css" media="all">
	<link rel="stylesheet" id="twentytwelve-style-css" href="https://www.aslairlines.fr/wp-content/themes/eap/style.css?ver=4.8.8" type="text/css" media="all">
	<!--[if lt IE 9]>
	<link rel='stylesheet' id='twentytwelve-ie-css'  href='https://www.aslairlines.fr/wp-content/themes/eap/css/ie.css?ver=20121010' type='text/css' media='all' />
	<![endif]-->
	<link rel="stylesheet" id="slick-css" href="https://www.aslairlines.fr/wp-content/themes/eap/css/slick.css?ver=4.8.8" type="text/css" media="all">
	<link rel="stylesheet" id="eap-style-css" href="https://www.aslairlines.fr/wp-content/themes/eap/css/eap.css?version=3&amp;ver=4.8.8" type="text/css" media="all">
	
	<link rel="stylesheet" id="A2A_SHARE_SAVE-css" href="https://www.aslairlines.fr/wp-content/plugins/add-to-any/addtoany.min.css?ver=1.14" type="text/css" media="all">


	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script type="text/javascript" src="https://www.aslairlines.fr/wp-content/plugins/add-to-any/addtoany.min.js?ver=1.0"></script>
	<script type="text/javascript" src="https://www.aslairlines.fr/wp-content/plugins/controlled-admin-access/public/js/controlled-admin-access-public.js?ver=1.0.0"></script>
	<script type="text/javascript" src="https://www.aslairlines.fr/wp-content/plugins/sitepress-multilingual-cms/templates/language-switchers/legacy-dropdown/script.js?ver=1"></script>
	<script type="text/javascript" src="https://www.aslairlines.fr/wp-content/themes/eap/js/libs/modernizr.min.js?ver=4.8.8"></script>
	<script type="text/javascript" src="https://www.aslairlines.fr/wp-content/themes/eap/js/libs/swfkrpano.js?ver=4.8.8"></script>


	<style type="text/css">.recentcomments a
		{
			display: inline !important;
			padding: 0 !important;
			margin: 0 !important;
		}
	</style>
	<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0047/4296.js" async="async"></script>	<style type="text/css">
		.site-title,
		.site-description
		{
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	</style>
	<style type="text/css" id="custom-background-css">
		body.custom-background
		{
			background-color: #ffffff;
		}
	</style>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url()?>/static/update/css/slick.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/update/css/my_custom_css.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/update/css/bootstrap.css">
	<link rel="stylesheet" href="<?= base_url()?>/static/update/css/home-v2.css" >
	<link rel="stylesheet" href="<?= base_url()?>/static/update/css/update.css" >
</head>
<div class="modal fade bs-example-modal-lg" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg"   style="z-index: 999999999" role="document">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="footerModalText">
				<?= isset($modal)? $modal : null ;?>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
<body class="page-template page-template-page-templates page-template-qui_sommes_nous page-template-page-templatesqui_sommes_nous-php page page-id-972 page-child parent-pageid-957 custom-background custom-background-white custom-font-enabled no-press-file lang-en">
<div id="main" class="wrapper">

<header id="masthead" class="site-header " role="banner">
	<div class="site-container">
		<hgroup>
			<h1 class="site-title"><a href="<?= base_url()?>" title="ASL Airlines France" rel="home">ASL Airlines France</a></h1>
			<h2 class="site-description">Planes for People</h2>
		</hgroup>
			
		<a href="<?= base_url()?>" class="logo-eap"></a>
		<a href="#" class="logo-asl"></a>
		
		<div id="bandeau-header">

			
			
				
			<div class="bloc-outils">
				<ul id="menu-top-menu-en" class="menu"><li id="menu-item-9009" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9009"><a href="https://fo-emea.ttinteractive.com/Zenith/FrontOffice/Europeairpost/en-GB/WebCheckin?mode=iframe">Check-in</a></li>
					<li id="menu-item-8102" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8102"><a target="_blank" href="https://emea.ttinteractive.com/Zenith/FrontOffice/europeairpost/en-GB/Home/FindBooking">My booking</a></li>
					<li id="menu-item-8103" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8103"><a href="https://www.aslairlines.fr/en/contact-2/">Contact us</a></li>
				</ul>					    <div class="eap-lang-selector">
    	      		
					<?
					foreach($lang_list  as  $key=>$value):?>
					
					
					<a class="lang-item "
						     href="<?= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>?lang=<?= $key   ?>">
						<img
						src="https://www.aslairlines.fr
						/wp-content/plugins/sitepress-mu
						ltilingual-cms/res/flags/<?= $key ?>.png" alt="<?= $value ?>" />
					</a>
					<? endforeach ;?>
					
    	      		
      	      		
				</div>
				<div class="phone-number parent_number">
					<a href="tel:+33 825 825 849" class="row special_phone">
						<i class="material-icons"></i>
						<span>+33 825 825 849</span>
					</a>
				</div>
			</div>
			<a href="#" class="mnu-bt-mobile"></a>
		</div>
		<?= $asl_top_menu ;?>
		<div id="alerte-crise-off"></div>		</div>
</header>

<div id="primary" class="site-content two-sidebars">
<div id="sidebar-left">



	<div class="eap-sidenav">

		<ul id="menu-qui-sommes-nous-en" class="menu">
			<?
			
			
			
			foreach($usermenu as $key=>$value) :?>


			<li id="menu-item-5751"
				class="menu-item
				menu-item-type-post_type
				menu-item-object-page
				<?= $key == $page ?  'current-menu-item ' : null ?>
			
				page_item page-item-976 current_page_item menu-item-5755">
				
				
				<? if(!is_array($value)) :?>
				<a href="<?= base_url().$key?>"><?= lang($value)  ?>
				
					<? else: ?>
					<ul class="sub-menu">
	
						<? foreach($value as $k=>$v):?>
						<li id="menu-item-5737" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5737"><a href="<?= base_url().$k?>"><?= lang($v)  ?></a></li>
						<? endforeach ;?>
					</ul>
					<? endif;?>
				</a></li>
			<? endforeach ; ?>

			<!--		<li id="menu-item-5752" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5752"><a href="https://www.aslairlines.fr/en/about-us/our-quality-of-service/">Speculative application</a></li>
			<li id="menu-item-5753" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5753"><a href="https://www.aslairlines.fr/en/about-us/our-certifications/">Equal Opportunity</a></li>
			<li id="menu-item-5754" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5754"><a href="https://www.aslairlines.fr/en/about-us/key-facts/">Meet our staff</a></li>
			<li id="menu-item-5755" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5755 current-menu-item current_page_item"><a href="https://www.aslairlines.fr/en/about-us/innovation/">Login</a>
			<ul class="sub-menu">
			<li id="menu-item-5737" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5737"><a href="https://www.aslairlines.fr/en/cargo-flights/scheduled-cargo-flights/cargo-network/">Edit profile</a></li>
			<li id="menu-item-5737" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5737"><a href="https://www.aslairlines.fr/en/cargo-flights/scheduled-cargo-flights/cargo-network/">Offers I have applied for</a></li>
			<li id="menu-item-5737" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5737"><a href="https://www.aslairlines.fr/en/cargo-flights/scheduled-cargo-flights/cargo-network/">Reset your password</a></li>
			</ul>
			</li>-->
		</ul>



	</div>

</div>