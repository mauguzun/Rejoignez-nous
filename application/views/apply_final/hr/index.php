<!--CHANGES GOES HERE-->


<div id="content" role="main">

   
	<?= $views['header']?>
			

	<div >
		<!--main-->
		<? foreach($views as $name=>$view):?>
		<? if($name !='header'):?>
		<?= $view ;?>
			
		<? endif;?>
		<? endforeach;?>
		
	

		
	</div>
	<!--END OF CODE CHANGES-->
	
</div>

</div>
