// 资源管理
var MediaLib = {
    page: 1,
    sid: 0,
    images: {}, // Cache images by ID
    options: {
        mode: 'article', // article, cover, category, custom
        buttons: [], // Custom buttons configuration
        onLoad: null,
    },

    init: function (options) {
        this.options = $.extend({}, {
            mode: 'article',
            buttons: []
        }, options);

        this.page = 1;
        this.sid = 0;
        this.images = {};

        $('#image-list').empty();
        this.load();
        $('#load-more').show();
        
        // Unbind previous generic click handlers to prevent duplicates
        $('#image-list').off('click', '.media-lib-custom-btn');
        // Bind new handler
        var self = this;
        $('#image-list').on('click', '.media-lib-custom-btn', function() {
            var id = $(this).data('id');
            var idx = $(this).data('btn-index');
            var image = self.images[id];
            var btnConfig = self.options.buttons[idx];
            if (btnConfig && typeof btnConfig.action === 'function') {
                btnConfig.action(image);
            }
        });
    },

    load: function () {
        var self = this;
        // Show loading state if needed
        $('#load-more').html('<i class="icofont-spinner icofont-spin"></i> ' + _langJS.loading);
        
        $.ajax({
            type: 'GET',
            url: './media.php?action=lib',
            data: {
                page: self.page,
                sid: self.sid
            },
            success: function (resp) {
                $('#load-more').html(_langJS.load_more);
                if (resp.data.images && resp.data.images.length > 0) {
                    self.render(resp.data.images);
                } else if (self.page === 1) {
                    // Empty state
                    var noImgText = (typeof _langJS.no_images !== 'undefined') ? _langJS.no_images : '暂无图片';
                    $('#image-list').html('<div class="col-12 text-center text-muted p-5">' + noImgText + '</div>');
                }
                
                if (resp.data.hasMore) {
                    self.page++;
                    $('#load-more').show();
                } else {
                    $('#load-more').hide();
                }
            },
            error: function (xhr, status, error) {
                $('#load-more').html(_langJS.load_failed);
                console.error(error);
            }
        });
    },

    render: function (images) {
        var self = this;
        $.each(images, function (i, image) {
            self.images[image.media_id] = image; // Cache image
            var insertBtnHtml = self.getButtonsHtml(image);
            
            // Delete button is always present
            insertBtnHtml += '<a href="javascript:delete_media(\'' + image.media_id + '\')" class="btn btn-sm text-danger"><i class="icofont-trash"></i></a>';

            var cardHtml = '<div class="col-md-4">' +
                '<div class="card mb-2 shadow-sm">' +
                '<a href="' + image.media_url + '" target="_blank"><img class="card-img-top" src="' + image.media_icon + '"/></a>' +
                '<div class="card-body">' +
                '<div class="card-text text-muted small">' + image.media_name + '<br>' + _langJS.file_size + image.attsize + '</div>' +
                '<p class="card-text d-flex mt-2 justify-content-between">' + insertBtnHtml + '</p>' +
                '</div></div></div>';
            $('#image-list').append(cardHtml);
        });
    },

    getButtonsHtml: function (image) {
        var self = this;
        var html = '';
        var mode = this.options.mode;

        // Custom buttons passed via options
        if (this.options.buttons && this.options.buttons.length > 0) {
            $.each(this.options.buttons, function(idx, btn) {
                html += '<a href="javascript:void(0)" class="btn btn-sm media-lib-custom-btn" data-id="' + image.media_id + '" data-btn-index="' + idx + '"><i class="' + (btn.icon || 'icofont-plus') + '"></i> ' + (btn.text || 'Action') + '</a>';
            });
            return html;
        }

        // Default logic based on mode
        if (mode === 'cover') {
            if (image.media_type === 'image') {
                html = '<a href="javascript:insert_cover(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-image"></i> ' + _langJS.set_as_cover + '</a>';
            }
        } else if (mode === 'category') {
             if (image.media_type === 'image') {
                var btnText = (typeof _langJS.set_as_sort_image !== 'undefined') ? _langJS.set_as_sort_image : '设为分类图像';
                // Using global function insert_sort_img which must be defined in the page
                html = '<a href="javascript:insert_sort_img(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-image"></i> ' + btnText + '</a>';
             }
        } else { // 'article' or default
            if (image.media_type === 'image') {
                html = '<a href="javascript:insert_media_img(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.insert_to_article + '</a>' +
                    '<a href="javascript:insert_cover(\'' + image.media_icon + '\')" class="btn btn-sm"><i class="icofont-image"></i> ' + _langJS.set_as_cover + '</a>';
            } else if (image.media_type === 'video') {
                html = '<a href="javascript:insert_media_video(\'' + image.media_url + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.insert_to_article + '</a>';
            } else if (image.media_type === 'audio') {
                html = '<a href="javascript:insert_media_audio(\'' + image.media_url + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.insert_to_article + '</a>';
            } else if (image.media_type === 'zip') {
                html = '<a href="javascript:insert_media(\'' + image.media_down_url_pub + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.public_download + '</a>';
                html += '<a href="javascript:insert_media(\'' + image.media_down_url + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.login_download + '</a>';
            } else {
                html = '<a href="javascript:insert_media(\'' + image.media_url + '\', \'' + image.media_name + '\')" class="btn btn-sm"><i class="icofont-plus"></i> ' + _langJS.insert_to_article + '</a>';
            }
        }
        return html;
    }
};

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

function insert_sort_img(url) {
    $('#sortimg').val(url);
    $('#mediaModal').modal('hide');
}

function delete_media(id) {
    layer.confirm(_langJS.confirm_delete_media, {
        icon: 3,
        btn: [_langJS.delete, _langJS.cancel]
    }, function (index) {
        $.post('./media.php?action=delete_async', {aid: id}, function () {
            // Reload using MediaLib
            MediaLib.page = 1;
            $('#image-list').html('');
            MediaLib.load();
        });
        layer.close(index);
    });
}

$('#mediaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    if (!button.length) {
        // If triggered programmatically without relatedTarget, default to current mode or article
        // Check if we already have a mode set?
        // But show.bs.modal triggers before shown, so usually we init here.
        if (Object.keys(MediaLib.options).length === 0) {
             MediaLib.init({ mode: 'article' });
        } else {
            // Already inited? Maybe just reload.
            // But we want to reset page usually.
            MediaLib.page = 1;
            $('#image-list').empty();
            MediaLib.load();
            $('#load-more').show();
        }
        return;
    }
    
    var mode = button.data('mode') || 'article';
    var initOptions = { mode: mode };
    
    // Check for custom button configuration via data attributes
    // Example: data-btn-text="Use This" data-callback="myFunc"
    var btnText = button.data('btn-text');
    var callbackName = button.data('callback');
    
    if (btnText && callbackName) {
        initOptions.mode = 'custom';
        initOptions.buttons = [{
            text: btnText,
            icon: button.data('btn-icon') || 'icofont-check',
            action: function(image) {
                // Call global function
                if (typeof window[callbackName] === 'function') {
                    window[callbackName](image.media_icon); // Assuming we pass URL or maybe image object?
                    // Standard functions like insert_cover take imgsrc.
                }
            }
        }];
    }
    
    MediaLib.init(initOptions);
});

$('#media-sort-select').change(function () {
    MediaLib.sid = $(this).val();
    MediaLib.page = 1;
    $('#image-list').empty();
    MediaLib.load();
    $('#load-more').show();
});

$('#load-more').click(function () {
    MediaLib.load();
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
        $('#mediaAdd').html(_langJS.uploading);
    },
    init: function () {
        this.on("error", function (file, response) {
            alert(response);
        });
        this.on("queuecomplete", function (file) {
            MediaLib.page = 1;
            MediaLib.sid = 0;
            $('#image-list').empty();
            MediaLib.load();
            $('#load-more').show();
            $('#mediaAdd').html(_langJS.upload_media);
        });
    }
});
