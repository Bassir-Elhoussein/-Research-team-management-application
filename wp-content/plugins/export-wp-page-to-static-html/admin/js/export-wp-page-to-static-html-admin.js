var $ = jQuery;

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.text += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

$(document).on("select2:selecting", function(e){
	if ( $(e.target).is('#export_pages') ) {
		if (!$('#posts_list').length) {
			$('#export_pages').append('<option id="posts_list" disabled="disabled">Posts</option>').change();
		}
	}	
});


$(document).on("click", ".select2-selection__choice__remove", function(){
  var data = $('#export_pages').val();

  if (data == null) {
  	$('.select_multi_pages').show();
  }
});

$(document).on("click", ".select_multi_pages", function(){
	$('.select2-selection__rendered').click();
});


$(document).on("click", ".static_html_settings .nav-item .nav-link", function(e){
	e.preventDefault();

	$('.static_html_settings .nav-item .nav-link').removeClass('active');
	$('.static_html_settings .tab-pane').removeClass('active');
	$(this).addClass('active');

	var link = $(this).attr('href');
	$(link).addClass('active');

});

$(document).on("mouseenter", ".newly-added-list", function(){
	$(this).addClass('select2-results__option--highlighted');
});

$(document).on("click", ".newly-added-list", function(){
	var page_id = $(this).attr('value');

	 $('#export_pages').val(page_id).change();
});

function rc_ajax_select2(){

	$('#export_pages').select2({
			minimumInputLength: 1,
			maximumSelectionLength: 3,
		  ajax: {
			url: rcewpp.ajax_url, // AJAX URL is predefined in WordPress admin
				dataType: 'json',
				delay: 250, // delay in ms while typing when to perform a AJAX search
				data: function (params) {
					return {
						value: params.term, // search query
						action: 'rc_search_posts' // AJAX action for admin-ajax.php
					};
				}
		  },
            templateResult: function (idioma) {
                var permalink = $(idioma.element).attr('permalink');
                var $span = $("<span permalink='"+idioma.permalink+"'>" + idioma.text + "</span>");
                return $span;
            }
	});	
}
$(document).on("change", "#search_posts_to_select2", function(e){
	if ($(this).is(":checked")) {
		rc_ajax_select2();
	} else {
		rc_select2_is_not_ajax();
	}
});




$(document).on("change", ".checkbox-container input", function(){
	if ($(this).is(':checked')) {
		$(this).parent().siblings('.export_html_sub_settings').slideDown();
	} else {
		$(this).parent().siblings('.export_html_sub_settings').slideUp();
	}
});

$(document).on("change", "#upload_to_ftp2", function(){
	if ($(this).is(':checked')) {
		$('.ftp_Settings_section2').slideDown();
	} else {
		$('.ftp_Settings_section2').slideUp();
	}
});

$(document).on("change", "#email_notification", function(){
	if ($(this).is(":checked")) {
		$('.email_settings_item').slideDown();
	} else {
		$('.email_settings_item').slideUp();
	}
});
function removeHtmlZipFile() {
  var txt;
  var r = confirm("Are you sure you would like to remove the file?");
  if (r == true) {
    return true;
  } else {
    return false;
  }
}

$(document).on("click", ".delete_zip_file", function(){
	var this_ = $(this);
	var file_name = this_.attr('file_name');
	if (removeHtmlZipFile()) {
		var datas = {
			'action': 'delete_exported_zip_file',
			'rc_nonce': rcewpp.nonce,
			'file_name': file_name,
		};


		$.ajax({
			url: rcewpp.ajax_url,
			data: datas,
			type: 'post',
			dataType: 'json',

			beforeSend: function(){

			},
			success: function(r){
				if(r.success == 'true'){

					this_.closest('.exported_zip_file').remove();


				} else {
					console.log('Something went wrong, please try again!');
				}

			}, error: function(){

			}
		});
	}
});

 $(document).on("click", ".support.my-2", function(e){
    e.preventDefault();

	 StopInterval();
	 console.log('Interval Stopped')
  });

$(document).on("click", ".btn_save_settings", function(e){
    e.preventDefault();

    var createIndexOnSinglePage = $('#createIndexOnSinglePage').is(':checked') ? true : false;
    var saveAllAssetsToSpecificDir = $('#saveAllAssetsToSpecificDir').is(':checked') ? true : false;
    var addContentsToTheHeader = $('#addContentsToTheHeader').val();
    var addContentsToTheFooter = $('#addContentsToTheFooter').val();

     var datas = {
       'action': 'saveAdvancedSettings',
       'rc_nonce': rcewpp.nonce,
       'createIndexOnSinglePage': createIndexOnSinglePage,
       'saveAllAssetsToSpecificDir': saveAllAssetsToSpecificDir,
       'addContentsToTheHeader': addContentsToTheHeader,
       'addContentsToTheFooter': addContentsToTheFooter,
     };

     $.ajax({
         url: rcewpp.ajax_url,
         data: datas,
         type: 'post',
         dataType: 'json',

         beforeSend: function(){
			$('.btn_save_settings .spinner_x').removeClass('hide_spin');
         },
         success: function(r){
            if(r.success){
                $('.badge_save_settings').show();
				$('.btn_save_settings .spinner_x').addClass('hide_spin');

                setTimeout(function(){
					$('.badge_save_settings').hide();
				}, 5000)
            } else {
                console.log('Something went wrong, please try again!');
				$('.btn_save_settings .spinner_x').addClass('hide_spin');
            }
         },
         error: function(){
            console.log('Something went wrong, please try again!');
			 $('.btn_save_settings .spinner_x').addClass('hide_spin');
         }
     });
});

$(document).on("click", ".cancel_rc_html_export_process", function(e){
	e.preventDefault();

	$('#cancel_ftp_process').val('true');

	var datas = {
	  'action': 'cancel_rc_html_export_process',
	  'rc_nonce': rcewpp.nonce,
	  'post2': '',
	};
	
	$.ajax({
	    url: rcewpp.ajax_url,
	    data: datas,
	    type: 'post',
	    dataType: 'json',
	
	    beforeSend: function(){
	
	    },
	    success: function(r){
	      	if(r.success == 'true'){
				rc_export_pages_failed(true)
				.then( (message) => {
					if(!$('.log.cancel_command').length){
						$('.logs_list').prepend('<div class="log main_log cancel_command" id="48"><span class="danger log_type">Export process has been canceled!</span></div>')
					}
				})
	        } else {
	          console.log('Something went wrong, please try again!');
	        }
	    	
	    }, error: function(){
	    	
	  	}
	});
});

