<!--CHANGES GOES HERE-->


<div id="content" role="main">

   
	<?= $header?>
			

	<div class="accordion" id="accordionExample">
		<!--main-->
		<?= $main ?>
		<!---->
		<!--eu -->

		<div  class="card" data-accordion="eu">
			<div  class="card-header"   id="heading9" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
				<h2 class="mb-0">
					<button    class="btn btn-link collapsed" type="button">
						<?= lang('eu')?>
					</button>
				</h2>
			</div>

			<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordionExample">
				<div class="card-body">
					<div class="row row_mb">
						<div class="col-md-6">
							<div class="input_label">Do you have EU citizenship?</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="">No</option>
								<option value="">Yes</option>
							</select>
						</div>
						<div class="col-md-6">
							<div class="input_label">Can you travel across Europe?</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="">No</option>
								<option value="">Yes</option>
							</select>
						</div>
					</div>
					<div class="row_mb buttons_bar" v-if="application_id" >
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		
		<!---->
		
		<div class="card">
			<div class="card-header" id="heading16" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						<?= lang('education')?> 
					</button>
				</h2>
			</div>
			<div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordionExample">
				<div class="card-body">

					<div class="row row_mb">
						<div class="col-md-6">
							<div class="input_label">Last level of education attained</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="2">BAC+2</option>
								<option value="3">BAC+3</option>
								<option value="3">BAC+4</option>
							</select>
						</div>
						<div class="col-md-6">
							<div class="input_label">Date of Safety Training Certificate</div>
							<input type="search" name="end_day" value="04/03/2010" class="form-control" id="start_day" required="required" data-calendar="1">
						</div>
					</div>
					<div class="row row_mb">
						<div class="col-md-12">
							<div class="input_label">Safety training certificate organization</div>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<!---->
		
		<div class="card">
			<div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						Foreign languages 
					</button>
				</h2>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
				<div class="card-body">

					<div class="popout_bg" id="popout_bg_languages">
					</div>
					<div class="popout_window" id="popout_window_languages">
						<img src="img/Close.png" alt="" class="cross_button" id="cross_button_expirence">
						<p>You are about to <span>delete</span> this skill.
							<br> Would you like to proceed?</p>
						<div class="popout_buttons" id="popout_buttons_languages">
							<center>
								<button class="btn sc_button_disabled" style="width:100px; height:30px; float:none; margin-right: 17px !important;">No, cancel</button>
								<button class="btn bg-blue_min" style="width:100px; height:30px; margin-left: 17px !important;">Yes, delete</button>
							</center>
						</div>
					</div>
					<div class="row row_mb">
						<div class="col-md-6">
							<div class="input_label">Language</div>
							<input type="text" class="form-control">
						</div>
						<div class="col-md-6">
							<div class="input_label">Level</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="2">C2</option>
								<option value="3">C1</option>
								<option value="3">B2</option>
							</select>
						</div>
					</div>

					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="heading15" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						Aeronautical experience    
					</button>
				</h2>
			</div>
			<div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordionExample">
				<div class="card-body">

					<div class="row row_mb">
						<div class="col-md-12">
							<div class="input_label">Function</div>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="heading12" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						Medical aptitudes
					</button>
				</h2>
			</div>
			<div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordionExample">
				<div class="card-body">

					<div class="row row_mb">
						<div class="col-md-12">
							<div class="input_label">Date of last medical visit</div>
							<input type="search" name="start_day" value="04/03/2010" class="form-control" id="start_day" required="required" data-calendar="1">
						</div>
					</div>

					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						Further information
					</button>
				</h2>
			</div>
			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
				<div class="card-body">

					<div class="row row_mb">
						<div class="col-md-6">
							<div class="input_label">Employment center</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="2">No</option>
								<option value="3">Yes</option>
							</select>
						</div>
						<div class="col-md-6">
							<div class="input_label">Do you have a vehicle?</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="2">No</option>
								<option value="3">Yes</option>
							</select>
						</div>
					</div>
					<div class="row row_mb">
						<div class="col-md-12">
							<div class="input_label">Availability</div>
							<select name="" class="form-control selectpicker" data-live-search="true">
								<option value="2">Immediate</option>
								<option value="3">1 month notice</option>
								<option value="3">2 month notice</option>
							</select>
						</div>
					</div>
					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				<h2 class="mb-0">
					<button class="btn btn-link collapsed" type="button" >
						My documents
					</button>
				</h2>
			</div>
			<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
				<div class="card-body">
					<div class="row row_mb">
						<div class="col-md-12">Acccepted file types : DOCX, PDF.</div>
					</div>

					<div class="row row_mb">
						<div class="col-md-12 files_block">
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Upload a CV</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Cover letter</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Certificate of foreign languages</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Medical aptitude</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Photo</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Passport</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Yellow fever vaccine
								</span> </button>
							<input type="file" id="real-file" hidden="hidden">
							<button type="button" id="file_button" class="file_button"> <span id="custom-text">Photo ID</span> </button>
						</div>

					</div>
					<div class="row_mb buttons_bar">
						<button type="button" class="btn bg-blue_min" id="publish">Save</button>
						<button type="button" class="sc_button_disabled cancel_button_languages" id="cancel_button">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--END OF CODE CHANGES-->
	
</div>

</div>


