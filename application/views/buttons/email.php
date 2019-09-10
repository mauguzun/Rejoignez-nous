<a href="<?= $email ?>"
 class="email"><i class="fas fa-envelope"></i>
	<div data-email-loader="<?= $email ?>"  class="lds-dual-ring hidden"></div>
</a>
<div class="collapse  " data-email-block="<?= $email ?>" style=" position: absolute !important;
  z-index: 20; background: #fff ; padding: 5px; 
   border: 1px solid white;box-shadow: 5px 5px 5px rgba(68, 68, 68, 0.6);" >
	<div   class="card card-body" >
		

		<ol data-email-list="<?= $email ?>">

		</ol>
	</div>
</div>

