﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload - Events example</title>

<!-- production -->
<script type="text/javascript" src="../js/plupload.full.min.js"></script>


<!-- debug 
<script type="text/javascript" src="../js/moxie.js"></script>
<script type="text/javascript" src="../js/plupload.dev.js"></script>
-->

</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<h1>分段上传文件（每段90kb）290秒超时</h1>

<div id="container">
    <a id="pickfiles" href="javascript:;">[选择文件]</a> 
    <a id="uploadfiles" href="javascript:;">[上传文件]</a>
</div>

<br />
<pre id="console"></pre>
 
<script type="text/javascript">
	var uploader = new plupload.Uploader({
        // General settings
		// multipart : false,
        runtimes : 'flash',
		browse_button : 'pickfiles', // you can pass in id...
        url : 'upload.php?timeout=290',
        chunk_size : '90kb',
        unique_names : true,
 
        // Resize images on client-side if we can
        resize : { width : 320, height : 240, quality : 90 },
        
        filters : {
            max_file_size : '600mb',

			// Specify what files to browse for
            mime_types: [
				{title : "Image files", extensions : "jpg,gif,png"},
				{title : "Compress files", extensions : "zip,rar,7z"},
				{title : "MS Office files", extensions : "doc,docx,ppt,pptx,xls,xlsx"},
				{title : "WPS files", extensions : "wps,et,dps"},
				{title : "PDF files", extensions : "pdf"},
				{title : "txt files", extensions : "txt,rtf"}
            ]
        },
 
		flash_swf_url : '../js/Moxie.swf',
		silverlight_xap_url : '../js/Moxie.xap',
         
        // PreInit events, bound before the internal events
        preinit : {
            Init: function(up, info) {
                log('[Init]', 'Info:', info, 'Features:', up.features);
            },
 
            UploadFile: function(up, file) {
                log('[UploadFile]', file);
 
                // You can override settings before the file is uploaded
                // up.setOption('url', 'upload.php?id=' + file.id);
                // up.setOption('multipart_params', {param1 : 'value1', param2 : 'value2'});
            }
        },
 
        // Post init events, bound after the internal events
        init : {
			PostInit: function() {
				// Called after initialization is finished and internal event handlers bound
				log('[PostInit]');
				
				document.getElementById('uploadfiles').onclick = function() {
					uploader.start();
					return false;
				};
			},

			Browse: function(up) {
                // Called when file picker is clicked
                log('[Browse]');
            },

            Refresh: function(up) {
                // Called when the position or dimensions of the picker change
                log('[Refresh]');
            },
 
            StateChanged: function(up) {
                // Called when the state of the queue is changed
                var date = new Date();
				log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED", "[Tick(ms)]: ", date.getTime().toString());
            },
 
            QueueChanged: function(up) {
                // Called when queue is changed by adding or removing files
                log('[QueueChanged]');
            },

			OptionChanged: function(up, name, value, oldValue) {
				// Called when one of the configuration options is changed
				log('[OptionChanged]', 'Option Name: ', name, 'Value: ', value, 'Old Value: ', oldValue);
			},

			BeforeUpload: function(up, file) {
				// Called right before the upload for a given file starts, can be used to cancel it if required
				log('[BeforeUpload]', 'File: ', file);
			},
 
            UploadProgress: function(up, file) {
                // Called while file is being uploaded
                log('[UploadProgress]', 'File:', file, "Total:", up.total);
            },

			FileFiltered: function(up, file) {
				// Called when file successfully files all the filters
                log('[FileFiltered]', 'File:', file);
			},
 
            FilesAdded: function(up, files) {
                // Called when files are added to queue
                log('[FilesAdded]');
 
                plupload.each(files, function(file) {
                    log('  File:', file);
                });
            },
 
            FilesRemoved: function(up, files) {
                // Called when files are removed from queue
                log('[FilesRemoved]');
 
                plupload.each(files, function(file) {
                    log('  File:', file);
                });
            },
 
            FileUploaded: function(up, file, info) {
                // Called when file has finished uploading
                log('[FileUploaded] File:', file, "Info:", info);
            },
 
            ChunkUploaded: function(up, file, info) {
                // Called when file chunk has finished uploading
                log('[ChunkUploaded] File:', file, "Info:", info);
            },

			UploadComplete: function(up, files) {
				// Called when all files are either uploaded or failed
                log('[UploadComplete]');
			},

			Destroy: function(up) {
				// Called when uploader is destroyed
                log('[Destroy] ');
			},
 
            Error: function(up, args) {
                // Called when error occurs
                log('[Error] ', args);
            }
        }
    });
 
 
    function log() {
        var str = "";
 
        plupload.each(arguments, function(arg) {
            var row = "";
 
            if (typeof(arg) != "string") {
                plupload.each(arg, function(value, key) {
                    // Convert items in File objects to human readable form
                    if (arg instanceof plupload.File) {
                        // Convert status to human readable
                        switch (value) {
                            case plupload.QUEUED:
                                value = 'QUEUED';
                                break;
 
                            case plupload.UPLOADING:
                                value = 'UPLOADING';
                                break;
 
                            case plupload.FAILED:
                                value = 'FAILED';
                                break;
 
                            case plupload.DONE:
                                value = 'DONE';
                                break;
                        }
                    }
 
                    if (typeof(value) != "function") {
                        row += (row ? ', ' : '') + key + '=' + value;
                    }
                });
 
                str += row + " ";
            } else {
                str += arg + " ";
            }
        });
 
        var log = document.getElementById('console');
        log.innerHTML += str + "\n";
    }

	uploader.init();

</script>
</body>
</html>