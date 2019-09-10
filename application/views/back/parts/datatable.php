<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
-->

<!-- include top css if needed -->

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js">
</script>


<script type="text/javascript" src="http://legacy.datatables.net/extras/thirdparty/ColReorderWithResize/ColReorderWithResize.js">
</script>



<!---->

<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />

<div style="position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 21324;
    background : rgba(0,0,0,.5);"
    id="overlay"
    >
	
</div>

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
							<th>
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
$order_by = ( isset($order_by) && $order_by > 0) ? $order_by : 0 ;
$order = ( isset($order)) ? $order : 'desc' ;

?>


<script>

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

		/* $('textarea').summernote({
		maxTextLength:2500
		});
		*/



	}
	
//	x.page();
	

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
			
		    
			"order": [[ <?= $order_by ?>, '<?= $order ?>' ]],
			"drawCallback": function( settings )
			{
				<?= $js ?>
			},
			
			'dom': 'Rlfrtip',
			"columnDefs": [ {"visible": false, "targets": 0}],
			"lengthMenu": [ 10, 20 , 50,  100 ],
			"scrollX": true,
			processing: true,
			select: true,
			//displayStart : 10,
			language:
			{
				 
				url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?= $current_lang == 'en' ? 'English' : 'French' ?>.json",
				processing: "asdf"
				//search: "" , lengthMenu:"_MENU_  ",
			},
			

		} );
		
		$('#mode').change(function(){
			$('#overlay').slideDown();
		})

	

		
		function sendEmail(href){
		
		
			let email = prompt("<?= lang('email') ?>");
			var re = /\S+@\S+\.\S+/;
						
			$('[data-email-loader="'+href+'"]').removeClass('hidden')    
			if(  re.test(email) )
			{
				let request	= $.post(href, {email: email});
				request.then(x=>
					{
					
						if(x.trim() == "")
						$('[data-email-list="'+href+'"]').append("<li>"+email+"</li>")
				
						$('[data-email-block="'+href+'"]').addClass('in');
						$('[data-email-loader="'+href+'"]').addClass('hidden')    
					})
			}

			
		}

</script>
<style>
	#example_wrapper
	{
		padding-top: 10px;
	}
</style>


