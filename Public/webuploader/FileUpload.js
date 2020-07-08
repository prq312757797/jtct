/**
 * Created by Administrator on 2015/8/4.
 */
// 文件上传

jQuery(function() {
    /* 图片预览 */
    $('#image_preview').click(function () {
        if ($('#image').val() == '') {
            alert('没有发现已上传图片！');
        } else {
            //   window.open("http://localhost/onehl/Uploads/"+$('#image').val());//本地测试
			window.open("http://"+window.location.hostname+"/Uploads/"+$('#image').val());//上线
        }
        return;
    });

    // 创建上传
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf:  'Uploader.swf',

        // 文件接收服务端。
        //    server: 'http://localhost/onehl/admin.php/common/uploads',//本地测试
		server: 'http://'+window.location.hostname+'/admin.php/common/uploads',//上线

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#image_upload',

        // 只允许选择图片文件。
        accept: {
            title: '指定格式文件',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    //上传开始
    uploader.on('uploadStart', function (file) {
        $(this).attr('disabled', true);
        $(this).find('.webuploader-pick span').text(' 等待');
    });

    // 上传成功
    uploader.on('uploadSuccess', function (file, data) {
        $('#image').val(file.name);
        $(this).attr('disabled', false);
        $(this).find('.webuploader-pick span').text(' 上传');
        if (data.status) {
            $('#image').val(data.path);
            //options.complete(data.data);
        } else {
            alert(data.info);
        }
    });

    // 上传失败
    uploader.on('uploadError', function (file) {
        alert('文件上传失败');
    });
});