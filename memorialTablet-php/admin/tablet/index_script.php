<script type="text/javascript">
    var url;
    /******************************************** 牌位基本信息 ********************************************/
    function newTablet(){
        $('#dlgTablet').dialog('open').dialog('setTitle','新增牌位');
        $('#fm').form('clear');
        $("#avatar_url").hide();

        $("#video_url").hide();
        url = 'save.php';
    }
    function saveTablet(){
        $('#fm').form('submit',{
            url: url,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if (result.errorMsg){
                    $.messager.alert({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                } else {
                    $('#dlgTablet').dialog('close');		// close the dialog
                    $('#dg').datagrid('reload');	// reload the user data
                }
            }
        });
    }
    function editTablet(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlgTablet').dialog('open').dialog('setTitle','修改基本信息');
            url = 'update.php?id='+row.id;
            currentTabletModule = 'tablet';
            if(row.avatar_url && row.avatar_url != '') {
                $("#avatar_url").show();
                $("#avatar_url").attr("src",'<?php echo $attachment_url; ?>' + row.avatar_url);
                $("#avatar_url").attr("width","80px");
                $("#avatar_url").attr("height","120px");
            } else {
                $("#avatar_url").hide();
            }

            if(row.video_url && row.video_url != '') {
                $("#video_url").show();
                $("#video_url").attr("src",'<?php echo $attachment_url; ?>' + row.video_url);
                $("#video_url").attr("width","120px");
                $("#video_url").attr("height","80px");
            } else {
                $("#video_url").hide();
            }
            $('#fm').form('load',row);
        }
    }
    function destroyTablet(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                if (r){
                    $.post('destroy.php',{id:row.id},function(result){
                        if (result.success){
                            $('#dg').datagrid('reload');	// reload the user data
                        } else {
                            $.messager.alert({	// show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    },'json');
                }
            });
        }
    }
    function viewTablet(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            url = '../../detail.php?realname=&tablet_number=&idcard=&id='+row.id;
            window.open(url);
        }
    }
    /******************************************** 牌位基本信息 ********************************************/

    /******************************************** 视频 ********************************************/
    function deleteAttachment(id, attachment_id) {
        var attachmentDiv = $("#"+attachment_id).parent();
        $.get('destroy_attachment.php',{id:id},function(result){
            attachmentDiv.fadeOut(500);
        },'json');
        $("#dlgTabletSecond").dialog('open');
        return false;
    }
    function editVideo(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlgVideo').dialog('open').dialog('setTitle','视频管理');
            $.get('get_attachment.php',{attachment_type:'video',tablet_id:row.id},function(result){
                var rows = result.rows;
                $("#video_div").html('');
                for(var i = 0; i < rows.length; i ++) {
                    var video_url = '<?php echo $attachment_url; ?>' + rows[i].attachment_path;
                    $("#video_div").append('\
							<div style="float:left;margin-left:10px;">\
							<video controls="controls" src="'+video_url+'" width="150px;">\
							your browser does not support the video tag\
							</video><br/>\
							<a href="#" id="attachment_'+rows[i].id+'" onclick="javascript:return editAttachmentMemo('+rows[i].id+');">修改描述</a>\
							<a href="#" style="float:right;" id="attachment_'+rows[i].id+'" onclick="javascript:return deleteAttachment('+rows[i].id+',\'attachment_' + rows[i].id + '\');">删除</a>&nbsp&nbsp\
							</div>\
						');
                }
            },'json');
            url = 'update.php?id='+row.id;
            $('#fmVideo').form('load',row);
        }
    }
    function saveVideo(){
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            url = 'save_attachment.php?attachment_type=video&tablet_id=' + row.id;
            $('#dlgVideo').dialog('open').dialog('setTitle','视频管理');
            $('#fmVideo').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.errorMsg) {
                        $.messager.alert({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#fmVideo')[0].reset();
                        editVideo();
                    }
                }
            });
        }
    }
    /******************************************** 视频 ********************************************/

    /******************************************** 图片 ********************************************/
    function editImage(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlgImage').dialog('open').dialog('setTitle','相册管理');
            $.get('get_attachment.php',{attachment_type:'image',tablet_id:row.id},function(result){
                var rows = result.rows;
                $("#image_div").html('');
                for(var i = 0; i < rows.length; i ++) {
                    var image_url = '<?php echo $attachment_url; ?>' + rows[i].attachment_path;
                    $("#image_div").append('<div style="float:left;margin-left:10px;">\
							<image src="'+image_url+'" height="100px;"/><br/>\
							<a href="#" id="attachment_'+rows[i].id+'" onclick="javascript:return editAttachmentMemo('+rows[i].id+');">修改描述</a>\
							<a href="#" style="float:right;" id="attachment_'+rows[i].id+'" onclick="javascript:return deleteAttachment('+rows[i].id+',\'attachment_' + rows[i].id + '\');">删除</a>\
							</div>\
						');
                }
            },'json');
            url = 'update.php?id='+row.id;
            $('#fmImage').form('load',row);
        }
    }
    function saveImage(){
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            url = 'save_attachment.php?attachment_type=image&tablet_id=' + row.id;
            $('#dlgImage').dialog('open').dialog('setTitle','相册管理');
            $('#fmImage').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.errorMsg) {
                        $.messager.alert({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#fmImage')[0].reset();
                        editImage();
                    }
                }
            });
        }
    }
    /******************************************** 图片 ********************************************/

    /******************************************** 附件描述 ********************************************/
    function editAttachmentMemo(id){
        $('#dlgAttachmentMemo').dialog('open').dialog('setTitle','修改描述');
        $('#memo_attachment_text').val('');
        $.post('get_attachment.php',{id:id},function(result){
            $('#memo_attachment_text').val(result.memo);
        },'json');
        $('#memo_attachment_id').val(id);
    }

    function saveAttachmentMemo(){
        var id = $('#memo_attachment_id').val();
        url = 'save_attachment_memo.php?id='+id;
        $('#fmAttachmentMemo').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (result) {
                var result = eval('(' + result + ')');
                if (result.errorMsg) {
                    $.messager.alert({
                        title: 'Error',
                        msg: result.errorMsg
                    });
                } else {
                    $('#dlgAttachmentMemo').dialog('close');
                }
            }
        });
    }
    /******************************************** 附件描述 ********************************************/

    // 亮灯
    function lighten(flag){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $.post('../../lighten.php',{id:row.id, flag:'on',closeDelayTime:60000},function(result){
                if (result.error == 0){
                    $('#dg').datagrid('reload');	// reload the user data
                } else {
                    $.messager.alert({	// show error message
                        title: 'Error',
                        msg: result.message
                    });
                }
            },'json');
        }
    }
</script>