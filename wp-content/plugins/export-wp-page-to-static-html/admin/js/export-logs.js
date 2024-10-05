
var percentage = 0;
var log_id = 0;

var intrvar;
function get_export_log_percentage(intervalTime=5000){

  StopInterval('intrvar');
  intrvar = setInterval(function(){
    var datas = {
      'action': 'export_log_percentage',
      'rc_nonce': rcewpp.nonce,
      'id': log_id,
    };

    $.ajax({
      url: rcewpp.ajax_url,
      data: datas,
      type: 'post',
      dataType: 'json',

      beforeSend: function(){

      },
      success: function(r){
        if(r.success){
          logWorkers(r);
        } else {
          console.log('Something went wrong, please try again!');
        }

      }, error: function(){
        console.log('Something went wrong, please try again!');
      }
    });
  }, intervalTime);
  log_id = 0;
}

$(document).on("click", ".see_logs_in_details", function(e){
  e.preventDefault();
  $('.logs').show();

  var datas = {
    'action': 'see_logs_in_details',
    'rc_nonce': rcewpp.nonce,
    'id': log_id,
  };

  $.ajax({
    url: rcewpp.ajax_url,
    data: datas,
    type: 'post',
    dataType: 'json',

    beforeSend: function(){

    },
    success: function(r){
      if(r.success) {
        if(r.logs.length){
          export_logs_process(r.logs, r);
          if(r.cancel_command){
            $('.log.cancel_command').remove();
            $('.logs_list').prepend('<div class="log main_log cancel_command" id="48"><span class="danger log_type">Export process has been canceled!</span></div>')
          }
        }
      } else {
        console.log('Something went wrong, please try again!');
      }
    },
    error: function(){
      console.log('Something went wrong, please try again!');
    }
  });
});

/*Working with logs by logs objects*/
function export_logs_process(logs, r){
  if (logs !== "" || logs !== "[]") {
    var logHtml = "";
    var logsReverse = logs.reverse();
    $.each(logs, function (i, log) {
      //log_id = log.id;
      if (!$('#' + log.id).length) {
        logHtml += export_log_create_html(log);
      }
    });
    if(logsReverse[0] !== undefined){
      log_id = logsReverse[0].id;
    }
    $('.logs_list').prepend(logHtml);
  }

}

function generateHtmlExportLog(r, total_url_exported, total_urls_log) {
  if (r.creating_html_process == 'running') {
    percentage = ((total_url_exported / total_urls_log) * 100).toFixed(0);

    $('.htmlExportLogs .total_exported_files').text(total_url_exported);
    $('.htmlExportLogs .total_fetched_files').text(total_urls_log);

    if (percentage !== '100' && r.export_status !== "completed" && percentage !== null && percentage !== 'NaN') {
      $('.htmlExportLogs .progress-bar').css({'width': percentage + '%'});
      $('.htmlExportLogs .progress-value').html(percentage + '%');
    }
  } else if (r.creating_html_process == 'completed') {
    $('.htmlExportLogs .total_exported_files').text(total_urls_log);
    $('.htmlExportLogs .total_fetched_files').text(total_urls_log);

    $('.htmlExportLogs .progress-bar').css({'width': 100 + '%'});
    $('.htmlExportLogs .progress-value').html(100 + '%');

    $('.view_exported_file').attr('href', r.createdLastHtmlFile).removeClass('hide');
    rcExportPagesToHtmlLogsCompleted();

    $('.creatingZipFileLogs').show();
  } else if (r.creating_html_process == 'failed') {
    rc_export_pages_failed();
    $('.htmlExportLogs .error').show();
  }
  return Promise.resolve("Success");
}

function generateCreatingZipLogs(r, total_pushed_file_to_zip, total_zip_files) {
  if (r.creating_zip_status == 'running') {
    percentage = ((total_pushed_file_to_zip / total_zip_files) * 100).toFixed(0);

    $('.creatingZipFileLogs .total_pushed_files_to_zip').html(total_pushed_file_to_zip);
    $('.creatingZipFileLogs .total_files_to_push').html(total_zip_files);

    if (percentage !== '100' && r.export_status !== "completed" && percentage !== null && percentage !== 'NaN') {
      $('.creatingZipFileLogs .progress-bar').css({'width': percentage + '%'});
      $('.creatingZipFileLogs .progress-value').html(percentage + '%');
    }
  } else if (r.creating_zip_status == 'completed') {
    $('.creatingZipFileLogs .total_pushed_files_to_zip').html(total_zip_files);
    $('.creatingZipFileLogs .total_files_to_push').html(total_zip_files);

    $('.creatingZipFileLogs .progress-bar').css({'width': 100 + '%'});
    $('.creatingZipFileLogs .progress-value').html(100 + '%');

    rcCreatingZipFilesLogsCompleted();

    if (r.zipDownloadLink !== "") {
      setTimeout(function () {
        $('.download-btn').text($('.download-btn').attr('btn-text')).removeClass('hide').attr('href', r.zipDownloadLink);
      }, 1000);
    }

    if (r.ftp_upload_enabled == "yes") {
      $('.uploadingFilesToFtpLogs').show();
    }
  } else if (r.creating_zip_status == 'failed') {
    rc_export_pages_failed();
    $('.creatingZipFileLogs .error').show();
  }
  return Promise.resolve("Success");
}

function generateFtpFileUploadLogs(r, total_file_uploaded, total_zip_files) {
  if (r.ftp_upload_enabled == 'yes' && r.ftp_status == "running") {
    percentage = ((total_file_uploaded / total_zip_files) * 100).toFixed(0);

    $('.uploadingFilesToFtpLogs .progress_').html(total_file_uploaded);
    $('.uploadingFilesToFtpLogs .total_').html(total_zip_files);

    if (percentage !== '100' && r.export_status !== "completed" && percentage !== null && percentage !== 'NaN') {
      $('.uploadingFilesToFtpLogs .progress-bar').css({'width': percentage + '%'});
      $('.uploadingFilesToFtpLogs .progress-value').html(percentage + '%');
    }
  } else if (r.ftp_upload_enabled == 'yes' && r.ftp_status == 'completed') {
    $('.uploadingFilesToFtpLogs .progress_').html(total_zip_files);
    $('.uploadingFilesToFtpLogs .total_').html(total_zip_files);

    $('.uploadingFilesToFtpLogs .progress-bar').css({'width': 100 + '%'});
    $('.uploadingFilesToFtpLogs .progress-value').html(100 + '%');

    rcUploadingFileCompleted();
  } else if (r.ftp_upload_enabled == 'yes' && r.ftp_status == 'failed') {
    rc_export_pages_failed();
    $('.uploadingFilesToFtpLogs .error').show();
  }
  return Promise.resolve("Success");
}

/*Log workers*/
function logWorkers(r) {
  var cancel_command = parseInt(r.cancel_command);
  var totalLogs = parseInt(r.total_logs);
  //var totalExported = parseInt(r.total_exported);
  var total_pushed_file_to_zip = parseInt(r.total_pushed_file_to_zip);
  var total_zip_files = parseInt(r.total_zip_files);
  var total_file_uploaded = parseInt(r.total_file_uploaded);
  var total_urls_log = r.total_urls_log !== null ? parseInt(r.total_urls_log) : 0;
  var total_url_exported = r.total_url_exported !== null ? parseInt(r.total_url_exported) : 0;

  if(!r.error){
    generateHtmlExportLog(r, total_url_exported, total_urls_log)
        .then( (m) => {
          generateCreatingZipLogs(r, total_pushed_file_to_zip, total_zip_files);
        } )
        .then(m => {
          generateFtpFileUploadLogs(r, total_file_uploaded, total_zip_files);
        }).then(m =>{
      if( (r.export_status == "completed" && !r.logs_in_details) || (r.export_status == "completed" && totalLogs <= parseInt(log_id)) ){
        rc_export_pages_completed();
        //setTimeout(function(){
        StopInterval('intrvar');

        //}, 1001);

        // if(r.zipDownloadLink !== ""){
        //   $('.download-btn').removeClass('hide').attr('href', r.zipDownloadLink);
        // }
      }
      else if(r.export_status == 'failed'){
        rc_export_pages_failed();
      }
      /*Insert logs data*/
      if(r.logs_in_details){
        export_logs_process(r.logs, r);
      }
      if(cancel_command){
        rc_export_pages_failed('cancel command')
            .then( (message) => {
              if(!$('.log.cancel_command').length){
                $('.logs_list').prepend('<div class="log main_log cancel_command" id="48"><span class="danger log_type">Export process has been canceled!</span></div>')
              }
            })
      }
    })
  }
  else{
    rc_export_pages_failed();
    $('.logs_list').prepend('<div class="log main_log" id="timeout_error"><span class="danger log_type">Something went wrong! Please try again later.</span></div>');
    alert('Something went wrong! Please try again later.');
  }
}

/*Generate log html element by log array object*/
function export_log_create_html(log){
  var type = "";
  var comment = log.comment;
  var path = log.path;

  if (log.type == "copying") {
    type = '<span class="copying log_type">Copying</span>';
  }
  if(log.type == "reading") {
    type = '<span class="reading log_type">Reading</span>';
  }
  if(log.type == "creating") {
    type = '<span class="creating log_type">Creating</span>';
  }
  if(log.type == "creating_zip_file") {
    type = '<span class="creating log_type">Creating</span>';
  }
  if(log.type == "creating_html_file") {
    type = '<span class="creating log_type">Creating</span>';
  }
  if(log.type == "created_html_file") {
    type = '<span class="success log_type">Created</span>';
  }
  if(log.type == "created_zip_file") {
    type = '<span class="success log_type">Successfully created the zip file!</span>';
    path = '';
    comment = '<a href="'+log.comment+'">Download</a>';
  }
  if(log.type == "replacing") {
    type = '<span class="replacing log_type">Replacing</span>';
  }
  if(log.type == "added_into_zip_file") {
    type = '<span class="push log_type">Added into zip</span>';
  }
  if(log.type == "all_pages_exported") {
    type = '<span class="success log_type">Successfully exported all pages as html!</span>';
  }
  if(log.type == "uploading_to_ftp") {
    type = '<span class="creating log_type">Uploading</span>';
    path = '';
    comment = 'files to ftp server';
  }
  if(log.type == "file_uploaded_to_ftp") {
    type = '<span class="creating log_type">Uploading</span>';
    comment = '';
  }
  if(log.type == "uploaded_to_ftp") {
    type = '<span class="success log_type">Successfully uploaded all files to ftp server!</span>';
    path = '';
    comment = '';
  }



  var log_text = '<span class="path">' + path + '</span>';
  var comment = '<span class="comment">' + comment + '</span>';

  var logHtml = '<div class="log main_log" id="'+log.id+'">'+type+' ' +log_text+ ' ' + comment + '</div>';

  return logHtml;
}

/*Stop interval by interval variable name*/
function StopInterval(intervalName) {
  clearInterval(window[intervalName]);
}

/*If export process completed this function will trigger*/
function rc_export_pages_completed() {
  $('.spinner_x').addClass('hide_spin');
  $('.cancel_rc_html_export_process').hide();
  $('.export_external_page_to_html.btn--radius-2, .export_internal_page_to_html.btn--radius-2').removeAttr('disabled');
}
function rcExportPagesToHtmlLogsCompleted() {
  $('.htmlExportLogs .progress').addClass('completed');
}
function rcCreatingZipFilesLogsCompleted() {
  $('.creatingZipFileLogs .progress').addClass('completed');
}
function rcUploadingFileCompleted() {
  $('.uploadingFilesToFtpLogs .progress').addClass('completed');
}
/*If export process failed this function will trigger*/
function rc_export_pages_failed(text="") {
  console.log(text);
  $('.progress').addClass('failed');
  $('.export_internal_page_to_html .spinner_x, .export_external_page_to_html .spinner_x').addClass('hide_spin');
  $('.cancel_rc_html_export_process').hide();
  StopInterval('intrvar');
  $('.tab-pane.active .btn--radius-2').removeAttr('disabled');
  $('.view_exported_file').attr('href', '').addClass('hide');
  return Promise.resolve("Success");
}

/*Clear logs data with percentage*/
function ClearExportLogsData() {
  $('.progress_').text(0);
  $('.total_').text(0);

  $('.progress-bar').css({'width': 0 + '%'});
  $('.progress-value').html(0 + '%');
  $('.download-btn').addClass('hide').attr('href', "");
  $('.creatingZipFileLogs').hide();
  $('.uploadingFilesToFtpLogs').hide();
  $('.logs').hide();
  $('.logs_list').html('');
  $('.view_exported_file').attr('href', '').addClass('hide');
}