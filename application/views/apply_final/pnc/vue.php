<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url() ?>/css/locales/bootstrap-datepicker.en.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />

<script>
	let page =  new Vue({
    el: "#content",
    data: {
      formFilled :false,
      app_id:false,
      postData:null,
      
      error : true,
      message:null,
    },
    methods: {
        send(submitEvent){

          this.setDefault();

          let data  = submitEvent.target
          let action  = data.action;
          
          this.postData = $(data).serialize() ;
          
          $.post(action,this.postData)
          .then(data=>{ this.update(data) })
          .catch(e=>{alert(e) })
          
        },
        update(data){
           let result = JSON.parse(data);

           if(result.result === true){
             this.app_id = result.app_id;
             this.error = false;
           }
          this.message = result.message;
         
        },

        setDefault(){
          this.message = null;
          this.error = true;
          
        }




    },
    mounted(){
        
    }
  });
</script>