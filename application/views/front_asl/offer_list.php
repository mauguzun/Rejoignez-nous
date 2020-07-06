<div class="page_banner" style="background-image:url('<?= base_url() ?>static/update/img/51335600_1025530647617129_5232785357975584768_n.png');">
	<div class="banner_title">EMPLOYMENT OPPORTUNITIES</div>
</div> 
 
 <div id="content" role="main" style="min-height: 100vh;" >

	<div class="breadcrumbs eap-breadcrumbs" >


		<a href="<?= base_url()?>" >
			<span>
				<?= lang('Careers') ?>
			</span>
		</a>  &gt;



		<a href="<?= base_url()?>">
			<span   class="current-page">
				<?= lang('offer_list') ?>
			</span>
		</a>

	</div>

	
	<!--<h1 class="post-title">
		<?= lang('offer_list') ?>
	</h1><br>-->


	<div class="table_breadcrumb  ">
		

	<div class="sort_block">
				<div class="form-group">
					<label for="exampleInputEmail1" class="sort_labels">
						<?= lang('Sort by type')?>
					</label>

					<input
					type="text"
					id="type"

					data-url="<?= base_url().'offers/type' ?>"
					name="type" />
				</div>
				
			
				<!--<div class="form-group">
					<label for="exampleInputEmail1" class="sort_labels">
						<?= lang('Sort by location')?>
					</label>
					<input
					type="text"
					id="location"

					data-url="<?= base_url().'offers/location' ?>"
					name="location" />
				</div>-->
            
			
    			
				<div class="form-group" style="margin-left: 20px;">
					<label for="exampleInputEmail1" class="sort_labels activity_label">
						<?= lang('Sort by activity')?>
					</label>
					<input
					type="text"
					id="activity"
					data-url="<?= base_url().'offers/activity' ?>"
					name="activity" />
				</div>
</div>

			<div class="form-group">
				<button class="search_button" onclick="MyCoolFunction()"><?= lang('Search')?></button>	
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
						window.location.href = "http://rejoignez-nous/?activity="+activity_parameter+"&location=&type="+type_parameter+"&category=&page=0";
					}
			</script>
			
	</div>

	<h3 class="last_offers">Our last offers</h3>
           
          
	  
	

          
        



	<article id="offers">

		<?= $offers ; ?>
	</article>
</div><!-- #content -->

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


<div id="sidebar-right">
</div>
</div><!-- #primary -->

<style>
	.table_breadcrumb {
		height: 138px;
    	margin-bottom: 1rem;
    	background-color: #ebebeb;
    	color: #6c757d;
    	width: 100%;
    	display: inline-block;
    	position: relative;
	}
	.table_breadcrumb .form-group {
		float: left;
		width: 33%;
		
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
    border: 1px solid #D7D7D7;
    box-sizing: border-box;
    color: #232323;
    font-size: 1rem;
    background-color: #fff;
    padding: 2px;
    margin-top: 10px;
    border-radius: 6px;
	}
	.fstElement>select,.fstElement>input
	{
		position: absolute;
		left: -999em;
	}
	.fstToggleBtn
	{
		    font-size: 1rem;
		display: block;
		position: relative;
		box-sizing: border-box;
		padding: 10px ;
	
		min-width: 14.28571em;
		cursor: pointer
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

