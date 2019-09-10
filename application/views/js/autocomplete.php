
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js">
</script>

<script>


    $('#<?= $name ?>').typeahead({
            source: function (query, result) {
                let request =  $.ajax({
                        url: "<?= $url ?>",
                        data :{
                            'query' : query,
                            'table' : 'activities',
                            'column' : '<?= $name?>'
                        }   ,
                        dataType: "json",
                        type: "POST",

                    });

                request.then(data=>{
                        if(data.error === undefined){
                            result($.map(data, function (item) {
                                        return item;
                                    }));
                        }
                })
            }
        });
        
        
        
        
</script>

