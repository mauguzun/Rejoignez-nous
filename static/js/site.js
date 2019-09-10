$('a[href$="#help"] , a[href$="#contact"]').click(function(e)
	{
		
		e.preventDefault();

		let suffix = $(this).attr('href').includes("#help")?'help':'contact';
		let form = $.post(base + "helpajax/form/" + suffix);

		form.then(e=>
			{
				$('#footerModalText').html(e);
				$('#footerModal').modal('show');
			})
		return false;
	})




$('[data-toggle="tooltip"]').tooltip()



