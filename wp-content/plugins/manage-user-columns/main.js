jQuery(document).ready(function($) {
		
		$('#newColForm #col_id').on('keyup', function(e) {
		$this = $(this);
		$sugg_ul = $this.closest('table').find('.muc-search-sug');
		if($this.val().length != 0){
			var data = {
				action: 'dpk_muc_umeta_search',
				q: $this.val()
            };
            $.post(ajax_dpk_muc_obj.ajaxurl, data, function (response) {
				if (response.length > 0) {
					$sugg_ul.html(response);
					$sugg_ul.show();
				} else{
					$sugg_ul.html('');
					$sugg_ul.hide();
				}
            });
		} else{
			$('input#col_id').val('');
			$sugg_ul.html('');
			$sugg_ul.hide();
		}
	});
	
	$('input#col_id').focusin(function(){
		if($(this).val().length != 0){
			$(this).closest('table').find('.muc-search-sug').show();
		}
	});
	
	$('.muc-search-sug').on('click', 'li', function(){
		$srch_val = $(this).text().replace(/(<([^>]+)>)/ig,"");
		$search_input = $(this).closest('table').find('#col_id');
		$search_input.val($srch_val);
		$('.muc-search-sug').html('').hide();
	});
	
});