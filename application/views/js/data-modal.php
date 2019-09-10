<script>
	$('*[data-modal-link]').click(function()
		{

			$.get($(this).attr('data-modal-link'),function(data)
				{

					$('#footerModalText').html(data);
					$('#footerModal').modal('show');
					$('#footerModal').on('hidden.bs.modal', function ()
					{
						location.reload();
					})
				})
			return false;
		})
</script>