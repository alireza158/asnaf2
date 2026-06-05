(function () {
    'use strict';

    function csrfToken() {
        var tag = document.querySelector('meta[name="csrf-token"]');
        return tag ? tag.getAttribute('content') : '';
    }

    function uploadRichTextFile(file, type, progress) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', type || (file.type && file.type.indexOf('image/') === 0 ? 'image' : 'file'));

        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', window.adminRichTextUploadUrl || '/admin/rich-text/upload');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken());
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.upload.onprogress = function (event) {
                if (event.lengthComputable && typeof progress === 'function') {
                    progress(event.loaded / event.total * 100);
                }
            };

            xhr.onload = function () {
                var json;

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('آپلود فایل با خطا مواجه شد.');
                    return;
                }

                try {
                    json = JSON.parse(xhr.responseText);
                } catch (error) {
                    reject('پاسخ آپلود معتبر نیست.');
                    return;
                }

                if (!json || typeof json.location !== 'string') {
                    reject('آدرس فایل آپلود شده دریافت نشد.');
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = function () {
                reject('ارتباط با سرور آپلود برقرار نشد.');
            };

            xhr.send(formData);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (!window.tinymce || !document.querySelector('textarea.js-rich-editor')) {
            return;
        }

        window.tinymce.init({
            selector: 'textarea.js-rich-editor',
            directionality: 'rtl',
            height: 360,
            menubar: false,
            branding: false,
            promotion: false,
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'advlist autolink link image lists charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount directionality',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignright aligncenter alignleft alignjustify | bullist numlist outdent indent | link image media table | ltr rtl | removeformat code fullscreen',
            valid_elements: 'p,br,strong/b,em/i,u,s,ul,ol,li,a[href|target|rel|title],img[src|alt|title|width|height],blockquote,pre,code,h1,h2,h3,h4,h5,h6,hr,table,thead,tbody,tfoot,tr,th[colspan|rowspan],td[colspan|rowspan],figure,figcaption,span[class],div[class],sub,sup',
            extended_valid_elements: 'a[href|target|rel|title],img[src|alt|title|width|height]',
            link_default_target: '_blank',
            link_rel_list: [
                { title: 'بدون مقدار', value: '' },
                { title: 'noopener noreferrer', value: 'noopener noreferrer' }
            ],
            images_upload_handler: function (blobInfo, progress) {
                return uploadRichTextFile(blobInfo.blob(), 'image', progress);
            },
            file_picker_types: 'image file media',
            file_picker_callback: function (callback, value, meta) {
                var input = document.createElement('input');
                input.type = 'file';
                input.accept = meta.filetype === 'image' ? 'image/*' : '.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt,image/*';

                input.onchange = function () {
                    var file = input.files && input.files[0];
                    if (!file) {
                        return;
                    }

                    uploadRichTextFile(file, meta.filetype === 'image' ? 'image' : 'file').then(function (url) {
                        callback(url, { title: file.name, text: file.name, alt: file.name });
                    }).catch(function (message) {
                        window.alert(message);
                    });
                };

                input.click();
            },
            setup: function (editor) {
                editor.on('change keyup undo redo', function () {
                    editor.save();
                });
            }
        });
    });
})();
