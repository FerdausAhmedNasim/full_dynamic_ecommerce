(function ($) {

    $.fn.imageUploader = function (options) {

        // Default settings
        let defaults = {
            preloaded: [],
            imagesInputName: 'images',
            preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse',
            extensions: ['.webp', '.jpg', '.jpeg', '.png', '.gif', '.svg'],
            mimes: ['image/webp','image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
            maxSize: undefined,
            maxFiles: undefined,
        };

        // Get instance
        let dropMePlugin = this;

        // Will keep the files
        let dataTransfer = new DataTransfer();

        // The file input
        let $input;

        // Set empty settings
        dropMePlugin.settings = {};

        // Drop Me Plugin constructor
        dropMePlugin.init = function () {

            // Define settings
            dropMePlugin.settings = $.extend(dropMePlugin.settings, defaults, options);

            // Run through the elements
            dropMePlugin.each(function (i, wrapper) {

                // Create the container
                let $container = createContainer();

                // Append the container to the wrapper
                $(wrapper).append($container);

                // Set some bindings
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));

                // If there are preloaded images
                if (dropMePlugin.settings.preloaded.length) {

                    // Change style
                    $container.addClass('has-files');

                    // Get the upload images container
                    let $uploadedContainer = $container.find('.preview');

                    // Set preloaded images preview
                    for (let i = 0; i < dropMePlugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(dropMePlugin.settings.preloaded[i].src, dropMePlugin.settings.preloaded[i].id, true));
                    }

                }

            });

        };

        let createContainer = function () {

            // Create the image uploader container
            let $container = $('<div>', {class: 'dropMeUploader'});

            // Create the input type file and append it to the container
            $input = $('<input>', {
                type: 'file',
                id: dropMePlugin.settings.imagesInputName + '-' + random(),
                name: dropMePlugin.settings.imagesInputName + '[]',
                accept: dropMePlugin.settings.extensions.join(','),
                multiple: ''
            }).appendTo($container);

            // Create the uploaded images container and append it to the container
            let $uploadedContainer = $('<div>', {class: 'preview'}).appendTo($container),

                // Create the text container and append it to the container
                $textContainer = $('<div>', {
                    class: 'upload-text'
                }).appendTo($container),

                // Create the icon and append it to the text container
                $i = $('<i>', {class: 'fa-solid fa-cloud-arrow-up'}).appendTo($textContainer),

                // Create the text and append it to the text container
                $span = $('<span>', {text: dropMePlugin.settings.label}).appendTo($textContainer);


            // Listen to container click and trigger input file click
            $container.on('click', function (e) {
                // Prevent browser default event and stop propagation
                prevent(e);

                // Trigger input click
                $input.trigger('click');
            });

            // Stop propagation on input click
            $input.on("click", function (e) {
                e.stopPropagation();
            });

            // Listen to input files changed
            $input.on('change', fileSelectHandler.bind($container));

            return $container;
        };


        let prevent = function (e) {
            // Prevent browser default event and stop propagation
            e.preventDefault();
            e.stopPropagation();
        };

        let createImg = function (src, id, preloaded) {
            // Create the upladed image container
            let $container = $('<div>', {class: 'previewImage'}),

                // Create the img tag
                $img = $('<img>', {src: src}).appendTo($container),

                // Create the delete button
                $button = $('<button>', {class: 'delete-image'}).appendTo($container),

                // Create the delete icon
                $i = $('<i>', {class: 'fa-solid fa-xmark'}).appendTo($button);


            // If the image is preloaded
            if (preloaded) {

                // Set a identifier
                $container.attr('data-preloaded', true);

                // Create the preloaded input and append it to the container
                let $preloaded = $('<input>', {
                    type: 'hidden',
                    name: dropMePlugin.settings.preloadedInputName + '[]',
                    value: id
                }).appendTo($container)

            } else {
                // Set the index
                $container.attr('data-index', id);
            }

            // Stop propagation on click
            $container.on("click", function (e) {
                // Prevent browser default event and stop propagation
                prevent(e);
            });

            // Set delete action
            $button.on("click", function (e) {

                // Prevent browser default event and stop propagation
                prevent(e);

                // Get the parent element
                let $parent = $container.parent();

                // If is not a preloaded image
                if ($container.data('preloaded') === true) {

                    // Remove from preloaded array
                    dropMePlugin.settings.preloaded = dropMePlugin.settings.preloaded.filter(function (p) {
                        return p.id !== id;
                    });

                } else {

                    // Get the image index
                    let index = parseInt($container.data('index'));

                    // Update other indexes
                    $parent.find('.previewImage[data-index]').each(function (i, cont) {
                        if (i > index) {
                            $(cont).attr('data-index', i - 1);
                        }
                    });

                    // Remove the file from input
                    dataTransfer.items.remove(index);

                    // Update input files
                    $input.prop('files', dataTransfer.files);
                }

                // Remove this image from the container
                $container.remove();

                // If there is no more uploaded files
                if (!$parent.children().length) {

                    // Remove the 'has-files' class
                    $parent.parent().removeClass('has-files');

                }

            });

            return $container;
        };

        let fileDragHover = function (e) {

            // Prevent browser default event and stop propagation
            prevent(e);

            // Change the container style
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };

        let fileSelectHandler = function (e) {

            // Prevent browser default event and stop propagation
            prevent(e);

            // Get the jQuery element instance
            let $container = $(this);

            // Get the files as an array of files
            let files = Array.from(e.target.files || e.originalEvent.dataTransfer.files);

            // Will keep only the valid files
            let validFiles = [];

            // Run through the files
            $(files).each(function (i, file) {
                // Run the validations
                if (dropMePlugin.settings.extensions && !validateExtension(file)) {
                    return;
                }
                if (dropMePlugin.settings.mimes && !validateMIME(file)) {
                    return;
                }
                if (dropMePlugin.settings.maxSize && !validateMaxSize(file)) {
                    return;
                }
                if (dropMePlugin.settings.maxFiles && !validateMaxFiles(validFiles.length, file)) {
                    return;
                }
                validFiles.push(file);
            });

            // If there is at least one valid file
            if (validFiles.length) {
                // Change the container style
                $container.removeClass('drag-over');

                // Makes the upload
                setPreview($container, validFiles);
            } else {

                // Update input files (it is now empty due to a default browser action)
                $input.prop('files', dataTransfer.files);

            }
        };

        let validateExtension = function (file) {

            if (dropMePlugin.settings.extensions.indexOf(file.name.replace(new RegExp('^.*\\.'), '.')) < 0) {

                toastr.error(`The file "${file.name}" does not match with the accepted file extensions: "${dropMePlugin.settings.extensions.join('", "')}"`, {
                    "timeOut": "3500",
                });
                
                return false;
            }

            return true;
        };

        let validateMIME = function (file) {

            if (dropMePlugin.settings.mimes.indexOf(file.type) < 0) {

                toastr.error(`The file "${file.name}" does not match with the accepted mime types: "${dropMePlugin.settings.mimes.join('", "')}"`, {
                    "timeOut": "3500",
                });

                return false;
            }

            return true;
        };

        let validateMaxSize = function (file) {

            if (file.size > dropMePlugin.settings.maxSize) {

                toastr.error(`The file "${file.name}" exceeds the maximum size of ${dropMePlugin.settings.maxSize / 1024 / 1024}MB`, {
                    "timeOut": "3500",
                });

                return false;
            }

            return true;

        };

        let validateMaxFiles = function (index, file) {

            if ((index + dataTransfer.items.length + dropMePlugin.settings.preloaded.length) >= dropMePlugin.settings.maxFiles) {

                toastr.error(`The file "${file.name}" could not be added because the limit of ${dropMePlugin.settings.maxFiles} files was reached`, {
                    "timeOut": "3500",
                });

                return false;
            }

            return true;

        };

        let setPreview = function ($container, files) {

            // Add the 'has-files' class
            $container.addClass('has-files');

            // Get the upload images container
            let $uploadedContainer = $container.find('.preview'),

                // Get the files input
                $input = $container.find('input[type="file"]');

            // Run through the files
            $(files).each(function (i, file) {

                // Add it to data transfer
                dataTransfer.items.add(file);

                // Set preview
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1), false);

            });

            // Update input files
            $input.prop('files', dataTransfer.files);

        };

        // Generate a random id
        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };

        this.init();

        // Return the instance
        return this;
    };

}(jQuery));