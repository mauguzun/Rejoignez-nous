<div class="right_side_content">

<div class="page_banner" style="background-image:url('<?= base_url() ?>static/update/img/BusinessMen-1_1.png'); width: auto!important; height: 276px!important;">
<div class="table_breadcrumb">
		

		<div class="sort_block">
				<div class="form-group">
						<input
						type="text"
						id="type"

						data-url="<?= base_url().'offers/type' ?>"
						name="type" />
				</div>
	
				<div class="form-group">
					<input
					type="text"
					id="activity"
					data-url="<?= base_url().'offers/activity' ?>"
					name="activity" />
				</div>

				<div class="form-group">
					<button class="search_button" onclick="MyCoolFunction()"><?= lang('Search')?></button>	
				</div>
	</div>

	
				<script>
					$(".fstToggleBtn:nth-child(1)").addClass("CookOld");
						function MyCoolFunction(){
							type_parameter = $(".fstToggleBtn").first().text();
							switch(type_parameter){
								case "CDD":
									type_parameter = 1;
									break;
								case "CDI":
									type_parameter = 2;
									break;
								case "Contrat d'apprentissage":
									type_parameter = 3;
									break;
								case "Contrat de professionnalisation":
									type_parameter = 4;
									break;
								case "Stage":
									type_parameter = 5;
									break;
							}
							activity_parameter = $(".fstToggleBtn:eq(1)").text();
							switch(activity_parameter){
								case "Communication":
									activity_parameter = 33;
									break;
								case "DSI":
									activity_parameter = 34;
									break;
								case "Exploitation":
									activity_parameter = 35;
									break;
								case "Finance":
									activity_parameter = 36;
									break;
								case "Administratif":
									activity_parameter = 37;
									break;
								case "Commercial":
									activity_parameter = 38;
									break;
								case "Opérations aériennes":
									activity_parameter = 39;
									break;
								case "Qualité":
									activity_parameter = 40;
									break;
								case "Ressources humaines":
									activity_parameter = 41;
									break;
								case "Technique":
									activity_parameter = 42;
									break;
							}			
							window.location.href = "http://md-victoria.ru/?activity="+activity_parameter+"&location=&type="+type_parameter+"&category=&page=0";
						}
				</script>
				
		</div>
</div> 

<div id="content" role="main">

	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" >
			<span>
				<?= lang('Careers') ?>
			</span>
		</a>  &gt;
		<a href="<?= base_url().'offers'?>" >
			<span  >
				<?= lang('our_offers') ?>
			</span>
		</a>  &gt;
		<a href="" >
			<span  class="current-page" style="color: #484848 !important;">
				<?= $query['title']?>
			</span>
		</a>  
	</div>

	<div class="heading_bg">
			<?= $query['title']?> 
	</div>

	<div class="container" style="padding-top: 20px; padding-left: 180px; padding-right: 180px;">
		<div class="col-md-12">

	<div class="row">
		<div class="col-md-6 service_square_block">
			<img src="<?= base_url() ?>static/update/img/location 1.svg" alt="" style="width:59px;">
			<p class="serive_square"><?= $query['location']?></p>
		</div>
		<div class="col-md-6 service_square_block">
			<img src="<?= base_url() ?>static/update/img/Group.svg" alt="" style="width:59px;">
			<p class="serive_square"><?=  date_to_input($query['pub_date'])?></p>
		</div>
	</div><br>
    
	<div class="row">
		<div class="col-md-6 service_square_block">
				<? if($query['type'] != 2) :?>
				<img src="<?= base_url() ?>static/update/img/time.svg" alt="" style="width:59px;">
				<p class="serive_square"><?= $query['period'] ?></p>
				<? endif ;?>
		</div>

		<div class="col-md-6 service_square_block">
			<img src="<?= base_url() ?>static/update/img/Group22.svg" alt="" style="width:59px;">
			<p class="serive_square"><?= $query['start_date']?></p>
		</div>
	</div>
		</div>
	</div>


	<div class="heading_bg" style="margin-top: 75px!important;">
		<?= lang('mission')?>
	</div>
	<div class="content_query_block">
		<?= $query['mission']?>
	</div>

	<div class="heading_bg" style="margin-top: 75px!important;">
		<?= lang('profile')?>
	</div>

	<div class="content_query_block">
		<?= $query['profile']?>
	</div>


		<a href="<?= $url?>" class="offer_apply_link">
			<button type="button" class="offer_apply_btn">
				Apply now
			</button>
		</a>
	
		<div class="custom_hr"></div>

		<div class="posts_heading">You may also like</div> 

		<div class="row" style="margin-bottom: 45px;">
			<div class="col-md-4">
					<div class="post_card_like"> 
						<div class="post_card_title">
							Technical permanent	
						</div>

						<div class="row" style="margin-top: 14px;">
							<div class="col-md-4 post_card_context">
								12/04/2020
							</div>
							<div class="col-md-4 post_card_context">
								Roisy - CDG
							</div>
							<div class="col-md-4">
								<a href="<?= $url?>" class="post_card_link">View offer</a>
							</div>
						</div>
					</div>	
			</div>
			<div class="col-md-4">
			<div class="post_card_like"> 
						<div class="post_card_title">
							Aircraft technical(ne) B1/B2
						</div>

						<div class="row" style="margin-top: 14px;">
							<div class="col-md-4 post_card_context">
								12/04/2020
							</div>
							<div class="col-md-4 post_card_context">
								Roisy - CDG
							</div>
							<div class="col-md-4">
								<a href="<?= $url?>" class="post_card_link">View offer</a>
							</div>
						</div>
					</div>
			</div>
			<div class="col-md-4">
			<div class="post_card_like"> 
						<div class="post_card_title">
							Human Resources Assistant(e)
						</div>

						<div class="row" style="margin-top: 14px;">
							<div class="col-md-4 post_card_context">
								12/04/2020
							</div>
							<div class="col-md-4 post_card_context">
								Roisy - CDG
							</div>
							<div class="col-md-4">
								<a href="<?= $url?>" class="post_card_link">View offer</a>
							</div>
						</div>
					</div>
			</div>
		</div>



</div><!-- #content -->
</div>
<script src="https://rawgit.com/dbrekalo/fastselect/master/dist/fastselect.standalone.min.js">

</script>
<script>
$( document ).ready(function() {
	var current_page = "<?php echo lang('Sort by type'); ?>";
	var current_page2 = "<?php echo lang('Sort by activity'); ?>";
	var current_page3 = "<?php echo lang('Sort by activity'); ?>";

    $(".fstToggleBtn:first").text(current_page);
	$(".fstToggleBtn").eq(1).text(current_page3);
	$(".fstToggleBtn").eq(2).text(current_page2);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js">
</script>

<script>

	let filters = {
		activity:null,
		location:null,
		type:null,
		category:null,
		page:<?= isset($_GET['page']) ? $_GET['page'] : 0 ;?>

	}
	$('input[type="text"]').fastselect();


	$('input[type="text"]').change(e=>{
			$('input[type="text"]').each(function(){
					filters[$(this).attr('id')] = $(this).val();
				});
			convertToQuery()
		});
        
	function convertToQuery(){
		
		let filterString =  "?"  + jQuery.param(filters);

		if (history.pushState) {
			var newurl = window.location.protocol + "//" +
			window.location.host + window.location.pathname + filterString;
			window.history.pushState({path:newurl},'',newurl);
		}
		sendRequest(filterString);
	}


	function setupClik(){
		$('*[data-ci-pagination-page]').click(function()
			{

				filters.page = $(this).attr('data-ci-pagination-page')
				convertToQuery();
				return false;
			})
	}
  
	function sendRequest(filterString){

		// start
		$.get("<?= base_url()?>offers/ajax_result/" + filterString).then(e=>{
				$('#offers').html(e)
				setupClik();
			})
	}

	sendRequest();


	// filters


</script>
</div><!-- #primary -->

<style>
	.table_breadcrumb {
		height: 101px;
		padding-left: 15px;
		padding-top: 28px;
		padding-bottom: 28px;
		padding-right: 15px;
		margin-bottom: 1rem;
		background: #F5F5F5;
		color: #6c757d;
		width: 900px !important;
		display: inline-block;
		margin: 0;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.table_breadcrumb .form-group {
		float: left;
    	margin-right: 30px;
	}
	@media only screen and (max-width: 600px) {
  .table_breadcrumb .form-group {
		float: left;
		width: 90%;
		padding: 2 %;
	}
}
	
	.fstElement
	{
		display: inline-block;
		position: relative;
		color: #232323;
		font-size: 1rem;
		background-color: #fff;
		padding: 2px;
		width: 230px !important;
		background: #FFFFFF;
		border: 1px solid #CFCFCF;
		box-sizing: border-box;
		border-radius: 8px;
	}
	.fstElement>select,.fstElement>input
	{
		position: absolute;
		left: -999em;
	}
	.fstToggleBtn
	{
		height: 100%;
		font-family: Roboto;
		font-style: normal;
		font-weight: normal;
		font-size: 16px;
		line-height: 19px;
		color: #757B84;
		display: block;
		position: relative;
		box-sizing: border-box;
		padding: 10px ;
		cursor: pointer;
	}
	.fstToggleBtn:after
	{
		position: absolute;
		right: .71429em;
		top: 50%;
		margin-top: -.17857em;
		border: .35714em solid transparent;
		border-top-color: #cacaca
	}
	.fstQueryInput
	{
		-webkit-appearance: none;
		-moz-appearance: none;
		-ms-appearance: none;
		-o-appearance: none;
		appearance: none;
		outline: none;
		box-sizing: border-box;
		background: transparent;
		border: 0
	}
	.fstResults
	{
		position: absolute;
		left: -1px;
		top: 100%;
		right: -1px;
		max-height: 30em;
		overflow-x: hidden;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
		border: 1px solid #D7D7D7;
		border-top: 0;
		background-color: #FFF;
		display: none;
		z-index: 9999;
	}
	.fstResultItem
	{
		font-size:12 px ;
		display: block;
		padding: .5em .71429em;
		margin: 0;
		cursor: pointer;
		border-top: 1px solid #fff
	}
	.fstResultItem.fstUserOption
	{
		color: #707070
	}
	.fstResultItem.fstFocused
	{
		color: #fff;
		background-color: #43A2F3;
		border-color: #73baf6
	}
	.fstResultItem.fstSelected
	{
		color: #fff;
		background-color: #2694f1;
		border-color: #73baf6
	}
	.fstGroupTitle
	{
		font-size: 1.4em;
		display: block;
		padding: .5em .71429em;
		margin: 0;
		font-weight: bold
	}
	.fstGroup
	{
		padding-top: 1em
	}
	.fstGroup:first-child
	{
		padding-top: 0
	}
	.fstNoResults
	{
		font-size: 1.4em;
		display: block;
		padding: .71429em .71429em;
		margin: 0;
		color: #999
	}
	.fstSingleMode .fstControls
	{
		position: absolute;
		left: -1px;
		right: -1px;
		top: 100%;
		padding: 0.5em;
		border: 1px solid #D7D7D7;
		background-color: #fff;
		display: none
	}
	.fstSingleMode .fstQueryInput
	{
		font-size: 1rem ;
		display: block;
		width: 100%;
		padding: .5em .35714em;
		color: #999;
		border: 1px solid #D7D7D7
	}
	.fstSingleMode.fstActive
	{
		z-index: 100;
        
	}
	.fstSingleMode.fstActive.fstElement,.fstSingleMode.fstActive .fstControls,.fstSingleMode.fstActive .fstResults
	{
		box-shadow: 0 0.2em 0.2em rgba(0,0,0,0.1)
	}
	.fstSingleMode.fstActive .fstControls
	{
		display: block;
		/*        position: relative ;*/
		z-index: 777;
	}
	.fstSingleMode.fstActive .fstResults
	{
		display: block;
		z-index: 99999;
		position: relative ;
		margin-top: -1px
	}
	.fstChoiceItem
	{
		display: inline-block;
		font-size: 14px !important;
		position: relative;
		margin: 0 .41667em .41667em 0;
		padding: .33333em .33333em .33333em 1.5em;
		float: left;
		border-radius: .25em;
		border: 1px solid #43A2F3;
		cursor: auto;
		color: #fff;
		background-color: #43A2F3;
		-webkit-animation: fstAnimationEnter 0.2s;
		-moz-animation: fstAnimationEnter 0.2s;
		animation: fstAnimationEnter 0.2s
	}
	.fstChoiceItem.mod1
	{
		background-color: #F9F9F9;
		border: 1px solid #D7D7D7;
		color: #232323
	}
	.fstChoiceItem.mod1>.fstChoiceRemove
	{
		color: #a4a4a4
	}
	.fstChoiceRemove
	{
		margin: 0;
		padding: 0;
		border: 0;
		cursor: pointer;
		background: none;
		font-size: 1.16667em;
		position: absolute;
		left: 0;
		top: 50%;
		width: 1.28571em;
		line-height: 1.28571em;
		margin-top: -.64286em;
		text-align: center;
		color: #fff
	}
	.fstChoiceRemove::-moz-focus-inner
	{
		padding: 0;
		border: 0
	}
	.fstMultipleMode .fstControls
	{
		box-sizing: border-box;
		padding: 0.5em 0.5em 0em 0.5em;
		overflow: hidden;
		width: 20em;
		cursor: text
	}
	.fstMultipleMode .fstQueryInput
	{
		font-size: 1.4em;
		float: left;
		padding: .28571em 0;
		margin: 0 0 .35714em 0;
		width: 2em;
		color: #999
	}
	.fstMultipleMode .fstQueryInputExpanded
	{
		float: none;
		width: 100%;
		padding: .28571em .35714em
	}
	.fstMultipleMode .fstFakeInput
	{
		font-size: 1.4em
	}
	.fstMultipleMode.fstActive,.fstMultipleMode.fstActive .fstResults
	{
		box-shadow: 0 0.2em 0.2em rgba(0,0,0,0.1)
	}
	.fstMultipleMode.fstActive .fstResults
	{
		display: block;
		z-index: 10;
		border-top: 1px solid #D7D7D7
	}
</style>