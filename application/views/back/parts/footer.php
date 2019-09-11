				</div>
<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->
<? $this->view('popup/modal.php') ;?>
<!-- Modal -->


<div class="modal fade bs-example-modal-lg" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" style="color: #333330" class="close" data-dismiss="modal" aria-label="Close">
					<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</div>
			<div class="modal-body" id="footerModalText">

			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

<?
if( null ==! $this->session->flashdata('message')  ) :?>
<div class="alert 
<?= null ==! $this->session->flashdata('info')? 'alert-info'  : 'alert-danger'?>" 

 style="position: fixed;z-index: 10000;width: 100%;top:0;">
	<a href="#"  class="close" data-dismiss="alert" aria-label="close" title="close">
		<i class="fa fa-times" aria-hidden="true"></i>
	</a>
	<div style="text-align: center;">
		<?php echo $this->session->flashdata('message');?>
	</div>

</div>
<? endif ;?>


<style>
	.fstElement
	{
		display: inline-block;
		position: relative;
		border: 1px solid #D7D7D7;
		box-sizing: border-box;
		color: #232323;
		font-size: 1.1em;
		background-color: #fff
	}
	.fstElement>select,.fstElement>input
	{
		position: absolute;
		left: -999em
	}
	.fstToggleBtn
	{
		font-size: 1.4em;
		display: block;
		position: relative;
		box-sizing: border-box;
		padding: .71429em 1.42857em .71429em .71429em;
		min-width: 14.28571em;
		cursor: pointer
	}
	.fstToggleBtn:after
	{
		position: absolute;
		content: "";
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
		display: none
	}
	.fstResultItem
	{
		font-size: 1.4em;
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
		font-size: 1.4em;
		display: block;
		width: 100%;
		padding: .5em .35714em;
		color: #999;
		border: 1px solid #D7D7D7
	}
	.fstSingleMode.fstActive
	{
		z-index: 100
	}
	.fstSingleMode.fstActive.fstElement,.fstSingleMode.fstActive .fstControls,.fstSingleMode.fstActive .fstResults
	{
		box-shadow: 0 0.2em 0.2em rgba(0,0,0,0.1)
	}
	.fstSingleMode.fstActive .fstControls
	{
		display: block
	}
	.fstSingleMode.fstActive .fstResults
	{
		display: block;
		z-index: 10;
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
<script>
	
$('[data-toggle="tooltip"]').tooltip()

</script>
</body>
</html>
