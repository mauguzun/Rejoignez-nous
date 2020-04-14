<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
-->

<!-- include top css if needed -->

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js">
</script>


<script type="text/javascript" src="http://legacy.datatables.net/extras/thirdparty/ColReorderWithResize/ColReorderWithResize.js">
</script>



<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.20/filtering/type-based/accent-neutralise.js">
</script>



<!---->

<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />

<div class="overlay" id="overlay">

</div>


<style>
	th
	{
		min-height: 100px;
		border: 1px solid white;
	}
	#infivible_element
	{
		width: 200%;
		height: 200px;
		background-color: transparent;
		position: relative;
		padding-right: 100px;
	}

	#infivible_container
	{
		 height: 50px;
    width: 100%;
    position: fixed;
    bottom: 0px;
    left: 0px;
    overflow-x: scroll;
    z-index: 999;
	}

	#retracable
	{
		overflow-x: hidden !important;
	}
	.overlay
	{
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 21324;
		background: rgba(0,0,0,.7);
	}
	/*
	#infivible_element
	{
	width: 200%;
	height: 200px;
	background-color: transparent;
	position: relative;
	padding-right: 100px;
	z-index: -1;
	}

	#infivible_container
	{
	height: 50px;
	width: 100%;
	position: fixed;
	bottom: 0px;
	left: 0px;
	overflow-x: scroll;
	z-index: 999;
	}

	#retracable
	{
	overflow-x: hidden !important;
	}*/
</style>

<!---->
<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<!-- Marketing campaigns -->
			<div class="panel panel-flat">
				<div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
					<b>
						<?= $title ?>
					</b>

					<?
					if(isset($add_button)) :?>

					<div class="heading-elements">
						<div class="row">


							<div class="col-md-6">
								<a id="add" href="<?= $add_button  ?>" class="btn btn-primary">
									<b>
										<?= lang('add_new')?>
									</b>
								</a>
							</div>


						</div>
					</div>

					<? endif ; ?>

				</div>
				<!--<table id="example" class="table text-nowrap" style="width:100%">-->
				<table id="example" class="table " style="width:100%">
					<thead>
						<tr>
							<?
							foreach($headers as $header):?>
							<th style="white-space:nowrap ;">
								<?
								if($header != strip_tags($header)) :?>
								<?= $header ?>
								<?
								else :?>

								<?= lang($header) ?>
								<? endif;?>
							</th>
							<? endforeach ;?>
						</tr>
					</thead>
					<!-- <tfoot>
					<tr>
					<?
					foreach ($headers as $header):?>
					<th>
					<?
					if ($header != strip_tags($header)) :?>
					<?= $header ?>
					<? else :?>

					<?= lang($header) ?>
					<? endif;?>
					</th>
					<? endforeach ;?>
					</tr>
					</tfoot>-->
				</table>

			</div>
			<!-- /marketing campaigns -->
		</div>
	</div>




	<?
	if(isset($extra)):?>
	<?
	foreach($extra as $oneExtra):?>
	<?= $oneExtra ?>
	<? endforeach;?>
	<? endif;?>

</div>




<?
$order_by = ( isset($order_by) && $order_by > 0) ? $order_by : 2 ;
$order = ( isset($order)) ? $order : 'desc' ;


$pageLength = isset($_GET['l'])? $_GET['l'] : 10;
$startPage = isset($_GET['p'])? $_GET['p'] : 0;
$startFrom = $startPage == 0 ?0 : ($startPage - 1) * $pageLength;





?>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js">
</script>
<script src="<?= base_url().'static/js/notify.js'?> ">
</script>
<script>

	//alert("<?= $startFrom ?>");

	$('#add').click(function()
		{

			$.post($(this).attr('href')).then(e=>
				{
					$('#footerModalText').html(e);
					$("#footerModal").modal()
					setShit();
				});

			return false;
		})




	function setShit()
	{

		const loadme = ['https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js',
			'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js'];

		let promisArray = [];

		loadme.forEach(i =>
			{

				let script =  $.getScript( i, function( data, textStatus, jqxhr )
					{
						console.log( textStatus ); // Success
					});
				promisArray.push(script);
			});



		Promise.all(promisArray).then(e=>{setAllExtra()});
	}

	function setAllExtra()
	{



		$('*[data-form-url]').click(function()
			{

				// clear before send
				let errors = $('*[data-error]');
				errors.html('')


				var form = $('#form').serializeArray();


				let post = $.post($(this).attr('data-form-url'),
					form
				);

				post.done(e=>
					{
						let result =  JSON.parse(e);


						if(result.error !== undefined)
						{
							for (var prop in result.error)
							{
								$('[data-error="'+prop+'"]').html(result.error[prop]);
								if(prop.indexOf('[]'))
								{
									console.log(result.error[prop]);
									console.log($('[data-error="'+prop+'"]').length);
									console.log(result.error[prop]);
								}
							}
						}
						else
						{
							$('#footerModal').modal('hide')
							x.ajax.reload( null, false )

							$.notify(
								{

									message: '<?= lang("saved")?>'
								},
								{
									// settings
									type: 'info'
								});
							// alert???
							//alert(123)
							//location.reload(true);
						}
					})
				return false;
			})

		$('*[data-typehead]').each(function()
			{
				var $this = $(this);
				$this.typeahead(
					{
						source: function (query, result)
						{
							let request =  $.ajax(
								{
									url:  $this.attr('data-typehead-url'),
									data :
									{
										'query' : query,
										'table' : $this.attr('data-typehead-table'),
										'column' : $this.attr('data-typehead-column')
									}   ,
									dataType: "json",
									type: "POST",

								});

							request.then(data=>
								{
									if(data.error === undefined)
									{
										result($.map(data, function (item)
												{
													return item;
												}));
									}
								})
						}
					})
			})



		$('*[data-calendar]').datepicker(
			{
				todayBtn: "linked",
				clearBtn: true,
				daysOfWeekHighlighted: [6,0],
				autoclose: true,
				format: 'dd/mm/yyyy',
				weekStart:1,

			});

	}

	//	x.page();


	let page = parseFloat("<?= $startPage ?>")  ;
	let pageLength=  parseInt("<?= $pageLength ?>");
	let search =  "<?=  isset($_GET['s'])? $_GET['s'] : ''  ?>";
	let orderBy = "<?=  isset($_GET['orderBy'])? $_GET['orderBy'] : '0'  ?>";
	let orderVal= "<?=  isset($_GET['orderVal'])? $_GET['orderVal'] : 'desc'  ?>";



	let x =  $('#example').DataTable(
		{


			"ajax":
			{
				url:"<?= $url ?>" ,
				type :  'POST',

				dataSrc: function(d)
				{

					$('#overlay').slideUp();
					return d.data;
				}
			},


			"order": [[orderBy , orderVal ]],

			"pageLength": parseInt("<?= $pageLength ?>"),
			"displayStart":parseInt("<?= $startFrom ?>"),

			"drawCallback": function( settings )
			{

				$( '*[data-trash="true"]' ).off("click").on('click', function()
					{

						if(confirm('Are You Sure?'))
						{
							$.get($(this).attr('data-href')).then(()=>
								{
									location.reload()
								})
						}

					})



				<?= $js ?>

				$('.paginate_button').click(function()
					{
						page = $(this).attr('data-dt-idx') ;
						changeUrl();
					})

				if($('#infivible_container').length == 0)
				{
					$('.dataTables_scroll').append('<div id="infivible_container"> <div class="dataTables_scrollBody" id="infivible_element"></div></div>');


					let scrollWidth  = $("#example").width();

					scrollWidth = scrollWidth * 1.03;
					$("#infivible_element").css("width",""+scrollWidth+"px");



					$("#infivible_container").scroll(function()
						{
							$(".dataTables_scrollBody,.dataTables_wrapper")
							.scrollLeft($(this).scrollLeft());
						});
				}




			},



			'dom': 'Rlfrtip',
			"columnDefs": [ {"visible": false, "targets": 0}],
			"lengthMenu": [ 10, 20 , 50,  100 ],
			"scrollX": true,
			search:
			{
				"caseInsensitive": true,
				"search":search

			},
			processing: true,
			select: true,
			fixedColumns:
			{
				leftColumns: 4
			},
			//displayStart : 10,
			language:
			{

				url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?= $current_lang == 'en' ? 'English' : 'French' ?>.json",
				processing: "asdf"
				//search: "" , lengthMenu:"_MENU_  ",
			},


		} );



	$('#mode').change(function()
		{
			$('#overlay').slideDown();
		})


	function changeUrl()
	{

		let mode = $("#mode").val()
		let status = $("#status").val();
		let offer =     $("#offer").val() ;
		let func =     $("#function").val() ;
		let group =     $("#group").val() ?$("#group").val() : 0  ;



		window.history.replaceState(null,null,
			`?p=${page}&l=${pageLength}&s=${search}&orderBy=${orderBy}&orderVal=${orderVal}
			&mode=${mode}&status=${status}&offer=${offer}&function=${func}&group=${group}`);

		//	if (typeof x !== 'undefined')
		//x.ajax.url( "<?= $url ?>?mode="+mode +"&offer="+offer+"&status="+status  + '&function='+func ).load();
	}
	$('#example').on( 'order.dt',  function ()
		{

			let order = x.order();
			orderBy = order[0][0];
			orderVal  =  order[0][1];
			changeUrl();
			//console.log("Ordered column " + order[0][0] + ", in direction " + order[0][1]);
		} )
	$('#example').on( 'length.dt', function ( e, settings, len )
		{
			pageLength= len;
			changeUrl();
		});

	$('#example').on('search.dt', function()
		{
			var value = $('.dataTables_filter input').val();

			search = value;
			changeUrl()

		});

	//$('#example_filter label input[type=text]').val('Default Product')

	function sendEmail(href,user)
	{


		let email = prompt("<?= lang('email') ?>  " + user );
		var re = /\S+@\S+\.\S+/;

		$('[data-email-loader="'+href+'"]').removeClass('hidden')
		if(  re.test(email) )
		{
			let request	= $.post(href, {email: email});
			request.then(x=>
				{

					$('[data-email-list="'+href+'"]').append("<li>"+email+"</li>")

					$('[data-email-block="'+href+'"]').addClass('in');
					$('[data-email-loader="'+href+'"]').addClass('hidden')

					setTimeout(()=>
						{

							$('[data-email-block="'+href+'"]').removeClass('in');
						},3000)



				})
		}


	}

	///////scrop
	let scrollWidth  = $("#example").width();
	scrollWidth = scrollWidth * 1.03;
	$("#infivible_element").css("width",""+scrollWidth+"px");



	$("#infivible_container").scroll(function()
		{
			$(".dataTables_scrollBody,.dataTables_wrapper")
			.scrollLeft($(this).scrollLeft());
		});
</script>


