<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?= $charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<title><?= $meta['title'] ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url()?>css/front/css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"/>
	<script>
		var base = "<?= base_url() ?>";
		
		
	</script>
</head>
<body >

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a href="<?= base_url()?>">
		<img src="<?= $logo ?>" alt="<? $title ?>" class="logo">
	</a>


	<button class="navbar-toggler" type="button" data-toggle="collapse"
  data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02"
  aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>




	<div class="row">
		<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0 list_menu_offer">
				<li class="nav-item active">
					<div class="dropdown show">
						<a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink"
   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?= $current_lang[key($current_lang)] ?>					</a>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">



							<?
							foreach($lang_list  as  $key=>$array):?>
							<?
							foreach($array  as $flag=>$title):?>

							<a  class="dropdown-item" href="<?= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>?lang=<?= $key ?>">
								<img src="<?= base_url()?>css/back/assets/images/flags/<?= $flag ?>.png" alt=""> <?= $title ?>
							</a>

							<? endforeach ?>

							<? endforeach ;?>

						</div>
					</div>
				</li>
				<?
				foreach($top_menu as $link=>$value): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url().$link?>">
						<?= lang($value)  ?>
					</a>
				</li>
				<? endforeach;?>
			</ul>

		</div>

		<?
		if(!isset($user)):?>

		<form action="<?= base_url().'auth/login'?>"
  		 class="form-inline my-2 my-lg-0"  method="post" accept-charset="utf-8">
			<input required="require" name="identity" class="form-control"
			type="email" placeholder="<?= lang('create_user_email_label')?>"
			aria-label="Email"
			style=" margin-left: 5px; margin-right: 5px; width: 33%;">
			<input required="require"  name="password" class="form-control" type="password"
			placeholder="<?= lang('create_user_password_label')?>"
			aria-label="Password" style="margin-right: 5px; width: 33%;">
			<button class="btn btn-outline-success my-2 my-sm-0" style="padding-left: 0px !important ;
		padding-right: 0px !important;text-align: center; width: 28%; font-size: 14px;" type="submit" ><?= lang('login_submit_btn') ?></button>
		</form>

		<? endif ;?>

	</div>

	<!--old-->

</nav>
<article style="min-height: 100vh;">
<div class="col-md-10 offset-md-1 cards">