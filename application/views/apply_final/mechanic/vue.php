<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url() ?>/css/locales/bootstrap-datepicker.en.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />

<script src="<?= base_url()?>/static/js/ajaxupload.js"></script>


<script>
	let page =  new Vue({
			el: "#content",
			data: {
				filled :false,
				application_id:false,
				postData:null,
      
				error : true,
				message:null,
				// active:'show',
				active:'main',

				loader:true,


				langRows :[],
				expRows:[],

				models:{ 
					education_level_id:null,
					aviability:null,
				},
				
				files:{
					covver_letter:[],
					cv:[],
					complementary_documents:[],
					
				},
				uploaders:[],
				statuses: JSON.parse('<?= $status ?>'),
				
			},
			methods: {
				send(submitEvent){
					this.loader = true;
					this.setDefault();

					let data  = submitEvent.target
					let action  = data.action;
           
					this.postData = $(data).serialize() ;

					if (this.application_id){
						this.postData += "&application_id="+this.application_id
					}
					

					console.log(this.postData)
					
          
					$.post(action,this.postData)
					.then(data=>{ this.update(data) })
					.catch(e=>{alert(e) })
          
				},
				
				makeTooltip(){
					
					setupTool();
				},
				update(data){
					let result = JSON.parse(data);

					if(result.result === true){
						
						this.statuses = result.statuses;	
						this.error = false;
						if (this.application_id === false){
							this.application_id = result.application_id;
							this.setAllUploader();
						}
					}else{
						this.error = true;
					}
					this.message = result.message;
					this.loader = false;
				},

				

				setDefault(){
					this.message = null;
					this.error = true;
          
				},

				showPanel(panel){
					//  alert(panel +';' + this.active + this.active == panel)
					return this.active === panel ? 'show': null
				},

				headerClass(headerID){
					
					if(this.application_id === false){
						return 'disabled';
					}else{
						return this.statuses[headerID];
					
					}
				
				},

				showExtra(){
					alert(this.models.education_level_id)
				
				},

				_getArray(arg){
					let array = null;
					switch(arg){
						case 'lang':
						array = this.langRows;
						break;

						case 'exp':
						array = this.expRows;
						break;
					}
					return array;
				},


				open(div){
					if (this.application_id){
						this.active = div;
					}else{
						alert("<?= lang('please_save_main') ?>")
					}
				
				},
				addRow(arg){
					this._getArray(arg).push({id: new Date()/1000,flag : false});
					this.makeTooltip();
				},
				removeRow(row,arg){
					let array  = this._getArray(arg);	
					array.splice(array.indexOf(row), 1)
				},
				// only pnc
				aurExp(row){
					if (event.target.value.trim().toLowerCase() === 'aucune' ){
						
						row.flag = true;
					}else{
						row.flag = false;
					}
					
				},
				removeTemplate(rowRef){	
								
					this.$refs[rowRef].remove()
				},
				setupCalendar(){
					$('*[data-calendar]').datepicker({
							todayBtn: "linked",
							clearBtn: true,
							daysOfWeekHighlighted: [6,0],
							autoclose: true,
							format: 'dd/mm/yyyy',
							weekStart:1,
							language: "<?= $this->session->userdata('lang') ?>"
						});

				},

				deleteImg(id){
					this.loader=true;
					$.getJSON("<?= base_url()?>/apply/ajaxupload/delete_file/" + id).then(e=>{
							if (e.done === 'done'){
								this.updateStatuses();
								$('#file_'+id).remove()
								
							}else{
								alert(e.error)
							}
						})
		
				},

				updateStatuses(){
					this.message = null;
					this.loader=true;
					$.getJSON('<?= base_url()?>/apply/new/mechanic/json_statuses/'+ this.application_id )
					.then(e=>{
							this.statuses = e.statuses;
							this.filled = e.filled;
							this.loader=false;
						})
				},


				setupUploader(divId){
					/////////////////////////
	
					const up = this.$refs[divId];
					const files = this.files[divId];
					const that = this;

					
					$(up).find('#drag-and-drop-zone').dmUploader
					(
						{
							url:'<?= base_url()?>apply/ajaxupload/upload_vue/'+this.application_id + '/'+divId ,
							// only debug mode

							onInit(){
								$(up).find('#error').html();
							},
							
							onNewFile: function(id,file)
							{
			
								$(up).find('#error').html();
								//	$(up).find('#loglist').append("<span id='"+id+"'><progress id='"+id+"_file' value='1' max='100'></progress> "+ file.name + "</span>" );
							},
							onUploadProgress: function(id, percent)
							{
								$("#"+id+'_file').attr('value',percent);
								$("#"+id+'_file').attr('title',percent);

							},

							onUploadSuccess: function(id, data)
							{
								let result = JSON.parse(data);
							
								$(up).find('#loglist').html()
					
								if(result.error !== undefined)
								{
									$(up).find('#error').append(result.error)
								}
								else
								{
									files.push(result.upload_data)
									that.updateStatuses();
								}
							},
							onUploadError: function(id, message)
							{
								console.log(message);
								alert('Error trying to upload #' + id + ': ' + message);
							}
						});

				},

				setAllUploader(){
					
					this.$refs.delButton.href+="/"+this.application_id;
					this.$refs.printButton.href+="/"+this.application_id;
					for (let index in this.uploaders) {
						this.setupUploader(this.uploaders[index])
					}

				
				}

			},
			
			mounted(){


				// only for pnc
			
				// if (this.$refs.education_level_id.id)
				// {
				// 	this.models.education_level_id = this.$refs.education_level_id.id
				// // }
				// if(this.$refs.aviability.id)
				// {
				// 	this.models.aviability = this.$refs.aviability.id
				// }
 
			

				<? foreach ($uploaders as $up):?>
				this.uploaders.push('<?= $up ?>')
				<? endforeach;?>

				<? if (isset($applicaiton_id) && $applicaiton_id) :?>
				this.application_id = '<?= $applicaiton_id ?>';
				this.setAllUploader();
				<? endif;?>


			
				<? if (isset($filled) && $filled == '1') :?>
				this.filled = true;
				<? endif;?>
				
				
				  
				this.setupCalendar();
				// this.setAllUploader();
				this.loader= false;
				this.makeTooltip();
				

			},

				
			
		});



	
	/////////////
</script>