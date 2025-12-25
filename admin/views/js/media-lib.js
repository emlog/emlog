// 资源管理
function insert_media_img(fileurl) {
    var filename = fileurl.split('/').pop();
    Editor.insertValue('![' + filename + '](' + fileurl + ')\n\n');
}

function insert_media_video(fileurl) {
    Editor.insertValue('<video class=\"video-js\" controls preload=\"auto\" width=\"100%\" data-setup=\'{"aspectRatio":"16:9"}\'> <source src="' + fileurl + '" type=\'video/mp4\' > </video>');
}

function insert_media_audio(fileurl) {
    Editor.insertValue('<audio src="' + fileurl + '" preload="none" controls loop></audio>');
}

function insert_media(fileurl, filename) {
    Editor.insertValue('[' + filename + '](' + fileurl + ')\n\n');
}

function insert_cover(imgsrc) {
    $('#cover_image').attr('src', imgsrc);
    $('#cover').val(imgsrc);
    $('#cover_rm').show();
}

function delete_media(id) {
    layer.confirm(emlog_lang.confirm_delete_media, {
        icon: 3,
        btn: [emlog_lang.delete, emlog_lang.cancel]
    }, function (index) {
        $.post('./media.php?action=delete_async', {aid: id}, function () {
            $('#image-list').html('');
            page = 1;
            loadImages();
        });
        layer.close(index);
    });
}

// 插入资源列表
let page = 1;
let sid = 0;

function loadImages() {
    $.ajax({
        type: 'GET',
        url: './media.php?action=lib',
        data: {
            page: page,
            sid: sid
        },
        success: function (resp) {
            $.each(resp.data.images, function (i, image) {
                let insertBtnHtml = '';
                if (image.media_type === 'image') {
                    insertBtnHtml = '<a href="javascript:insert_media_img(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.insert_to_article + '</a>' +
                        '<a href="javascript:insert_cover(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-image"></i> ' + emlog_lang.set_as_cover + '</a>';
                } else if (image.media_type === 'video') {
                    insertBtnHtml = '<a href="javascript:insert_media_video(\'' + image.media_url + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.insert_to_article + '</a>';
                } else if (image.media_type === 'audio') {
                    insertBtnHtml = '<a href="javascript:insert_media_audio(\'' + image.media_url + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.insert_to_article + '</a>';
                } else if (image.media_type === 'zip') {
                    insertBtnHtml = '<a href="javascript:insert_media(\'' + image.media_down_url_pub + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.public_download + '</a>';
                    insertBtnHtml += '<a href="javascript:insert_media(\'' + image.media_down_url + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.login_download + '</a>';
                } else {
                    insertBtnHtml = '<a href="javascript:insert_media(\'' + image.media_url + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + emlog_lang.insert_to_article + '</a>';
                }
                insertBtnHtml += '<a href="javascript:delete_media(\'' + image.media_id + '\')" class="btn btn-sm text-danger"><i class="icofont-trash"></i></a>';
                var cardHtml = '<div class="col-md-4">' +
                    '<div class="card mb-2 shadow-sm">' +
                    '<a href="' + image.media_url + '" target="_blank"><img class="card-img-top" src="' + image.media_icon + '"/></a>' +
                    '<div class="card-body">' +
                    '<div class="card-text text-muted small">' + image.media_name + '<br>' + emlog_lang.file_size + image.attsize + '</div>' +
                    '<p class="card-text d-flex mt-2 justify-content-between">' + insertBtnHtml + '</p>' +
                    '</div></div></div>';
                $('#image-list').append(cardHtml);
            });
            if (resp.data.hasMore) {
                page++;
                $('#load-more').show();
            } else {
                $('#load-more').hide();
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

$('#mediaModal').on('show.bs.modal', function () {
    page = 1;
    $('#image-list').empty();
    loadImages();
    $('#load-more').show();
});
$('#media-sort-select').change(function () {
    sid = $(this).val();
    page = 1;
    $('#image-list').empty();
    loadImages();
    $('#load-more').show();
});
$('#load-more').click(function () {
    loadImages();
});

// 上传资源
Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("#mediaAdd", {
    url: "./media.php?action=upload",
    addRemoveLinks: false,
    method: 'post',
    maxFilesize: 20480, // 20G
    filesizeBase: 1024,
    timeout: 3600000,// milliseconds
    previewsContainer: ".dropzone-previews",
    sending: function (file, xhr, formData) {
        formData.append("filesize", file.size);
        $('#mediaAdd').html(emlog_lang.uploading);
    },
    init: function () {
        this.on("error", function (file, response) {
            alert(response);
        });
        this.on("queuecomplete", function (file) {
            page = 1;
            sid = 0;
            $('#image-list').empty();
            loadImages();
            $('#load-more').show();
            $('#mediaAdd').html(emlog_lang.upload_media);
        });
    }
});
