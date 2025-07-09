function showNotification(message, type = 'success', options = {}) {
    Swal.fire({
        icon: type
        , title: type === 'success' ? 'Success' : 'Error'
        , text: message
        , toast: true
        , position: 'top-end'
        , showConfirmButton: options.showConfirmButton || false
        , timer: options.timer || 3000
        , timerProgressBar: true
    });
}

async function confirmAction(
    text = "You won't be able to revert this!",
    type = "warning"
) {
    return await Swal.fire({
        title: "Are you sure?",
        text: text,
        icon: type,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "No, cancel",
    });
}

async function confirmWithInput({
    text = "Please provide your input",
    inputValidator = null,
    inputType = "text",
    inputPlaceholder = "",
    confirmButtonText = "Submit",
    cancelButtonText = "Cancel",
} = {}) {
    const options = {
        title: text,
        input: inputType === 'textarea' ? 'textarea' : inputType,
        inputPlaceholder: inputPlaceholder,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    };

    if (inputValidator) {
        options.inputValidator = inputValidator;
    }

    return await Swal.fire(options);
}

async function fetchRequest(
    url,
    method = "GET",
    data = {},
    successMessage = "Operation successful",
    errorMessage = "There was an error processing your request"
) {
    try {
        let headers = {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        };

        if (!(data instanceof FormData)) {
            headers["Content-Type"] = "application/json";
        }

        const options = {
            method: method,
            headers: headers,
            body: null,
        };

        if (method !== "GET") {
            options.body =
                data instanceof FormData ? data : JSON.stringify(data);
        }

        const response = await fetch(url, options);

        if (!response.ok) {
            if (response.status === 422) {
                const result = await response.json();
                handleValidationErrors(result.errors);
                return false;
            } else {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
        }
        const result = await response.json();
        if (result.success) {
            if (method === "GET") {
                return result.data;
            } else {
                showNotification(result.success || successMessage);
                return true;
            }
        } else {
            showNotification(
                result.error || errorMessage || "An unexpected error occurred",
                "error"
            );
            return false;
        }
    } catch (error) {
        showNotification(
            errorMessage || "There was an error processing your request",
            "error"
        );
        return false;
    }
}

function handleValidationErrors(errors) {
    $(".form-error").remove();
    setButtonLoading($('button[type="submit"]'), false);

    for (const field in errors) {
        const errorMessages = errors[field];
        const input = $(`[name="${field}"]`);

        errorMessages.forEach((message) => {
            const errorElement = `<span class="form-error text-danger">${message}</span>`;
            input.after(errorElement);
        });
    }
}

function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

function initDataTable(selector, options = {}) {

    const $table = $(selector);
    if (!$table.hasClass('datatable-loading-container')) {
        $table.wrap('<div class="datatable-loading-container"></div>');
        
        $table.append(`
            <div class="datatable-loading-progress"></div>
            <div class="datatable-content-dimmer"></div>
        `);
    }
    
    const $loadingProgress = $table.find('.datatable-loading-progress');
    const $contentDimmer = $table.find('.datatable-content-dimmer');

    const exportButtons = [
        {
            extend: "copy",
            text: `<span class="symbol-container">
                    <i class="bi-copy"></i>
                    &nbsp; Copy
                </span>`,
            exportOptions: {
                columns: ':visible:not(.action-column)',
            },
        },
        {
            extend: "csv",
            text: `<span class="symbol-container">
                    <i class="bi-filetype-csv"></i>
                    &nbsp; CSV
                </span>`,
            exportOptions: {
                columns: ':visible:not(.action-column)',
            },
        },
        {
            extend: "excel",
            text: `<span class="symbol-container">
                    <i class="bi-file-spreadsheet"></i>
                    &nbsp; Excel
                </span>`,
            exportOptions: {
                columns: ':visible:not(.action-column)',
            },
        },
        {
            extend: "print",
            text: `<span class="symbol-container">
                    <i class="bi-printer"></i>
                    &nbsp; Print
                </span>`,
            autoPrint: false,
            exportOptions: {
                columns: ':visible:not(.action-column)',
            },
        },
    ];

    const customButtons = [];
    
    if (options.customButton) {
        customButtons.push(options.customButton);
    }
    
    if (options.customButtons && Array.isArray(options.customButtons)) {
        customButtons.push(...options.customButtons);
    }

    const defaultOptions = {
        processing: true,
        stateSave: true,
        autoWidth: true,
        serverSide: true,
        colReorder: {
            columns: ":not(:first-child, :last-child)",
        },
        ajax: {
            url: options.ajaxUrl || "",
            error(jqXHR, textStatus, errorThrown) {
                $(selector).removeClass("card-loading");
                if (textStatus === "timeout" || textStatus === "abort") {
                    $(selector).DataTable().ajax.reload();
                }
            },
        },
        order: [
            [
                options.defaultOrderColumn || "created_at",
                options.defaultOrderDirection || "desc",
            ],
        ],
        columns: options.columns || [],
        language: {
            searchBuilder: {
                title: {
                    0: "Conditions",
                    _: "Conditions (%d)",
                },
                clearAll: "Clear All Filters",
                button: `<span class="symbol-container">
                            <i class="bi-funnel"></i>
                            &nbsp; Filter
                        </span>`,
            },
        },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: "collection",
                        text: `<span class="symbol-container">
                                <i class="bi-share"></i>
                                &nbsp; Export
                            </span>`,
                        autoClose: true,
                        buttons: exportButtons,
                    },
                    {
                        extend: "colvis",
                        collectionLayout: "two-column",
                        text: `<span class="symbol-container">
                                <i class="bi-eye"></i>
                                &nbsp; Columns
                            </span>`,
                    },
                    {
                        extend: "searchBuilder",
                        config: {
                            depthLimit: 3,
                            preDefined: {
                                criteria: [
                                    {
                                        origData: "id",
                                        data: "id",
                                    },
                                ],
                            },
                        },
                    },
                    {
                        text: `<span class="symbol-container">
                                <i class="bi-arrow-clockwise"></i>
                                &nbsp; Reset
                            </span>`,
                        action: function (e, dt, node, config) {
                            confirmAction(
                                "Resetting will clear all saved settings"
                            ).then((res) => {
                                if (res.isConfirmed) {
                                    dt.state.clear();
                                    localStorage.removeItem(
                                        selector.replace("#", "")
                                    );
                                    window.location.reload();
                                }
                            });
                        },
                    },
                    ...customButtons,
                ],
            },
            top1Start: {
                pageLength: {
                    menu: options.pageLengthMenu || [
                        [5, 10, 25, 50, 100, 500, -1],
                        [5, 10, 25, 50, 100, 500, "All"],
                    ],
                },
            },
            topEnd: {
                search: {
                    placeholder:
                        options.searchPlaceholder || "Type search here...",
                },
            },
        },
        columnDefs: options.columnDefs || [],
        preDrawCallback() {
            $table.addClass('loading');
            $loadingProgress.addClass('active');
            $contentDimmer.addClass('active');
        },
        drawCallback() {
            $table.removeClass('loading');
            $loadingProgress.removeClass('active');
            $contentDimmer.removeClass('active');
        },
    };

    $.fn.dataTable.ext.errMode = "throw";
    const finalOptions = $.extend(true, {}, defaultOptions, options);
    const table = $(selector).DataTable(finalOptions);
    return table;
}

function hashTabsNavigator(config) {
    const { table, dataTableUrl, tabToHashMap, hashToParamsMap, defaultHash } =
        config;

    function buildQueryParams(params) {
        if (!params) return "";
        const queryParams = Object.entries(params)
            .filter(([key, value]) => value !== undefined)
            .flatMap(([key, value]) =>
                Array.isArray(value)
                    ? value.map(
                          (val) =>
                              `${encodeURIComponent(
                                  key
                              )}[]=${encodeURIComponent(val)}`
                      )
                    : `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
            )
            .join("&");
        return queryParams ? "?" + queryParams : "";
    }

    function updateDataTableURL(params) {
        let queryParams = buildQueryParams(params);
        let tableFullUrl = dataTableUrl + queryParams;
        table.ajax.url(tableFullUrl).load();
    }

    function activateTab(tabId) {
        $('.nav-tabs-table a[href="' + tabId + '"]').tab("show");
        $(".tab-pane-table").removeClass("active show");
        $(tabId).addClass("active show");
    }

    $(".nav-tabs-table a").on("click", function () {
        let href = $(this).attr("href");
        window.location.hash = href;
    });

    let initialTab = window.location.hash || defaultHash;
    let initialParams = hashToParamsMap[initialTab] || {};

    updateDataTableURL(initialParams);
    activateTab(initialTab);

    Object.keys(tabToHashMap).forEach(function (tabSelector) {
        $(tabSelector).on("click", function () {
            let hash = tabToHashMap[tabSelector];
            let params = hashToParamsMap[hash] || {};
            updateDataTableURL(params);
        });
    });
}

function setButtonLoading(
    buttonSelector,
    isLoading = true,
    loadingText = "Please wait..."
) {
    if (!buttonSelector) return;
    const button = $(buttonSelector);
    if (!button.length) return;

    const formElement = button.closest("form");
    const originalText = button.val() || button.html();

    if (isLoading) {
        if (formElement.length) {
            formElement.addClass("disabled-form");
        }

        button.data("original-text", originalText);
        document.documentElement.classList.add("card-loading");

        if (button.is("button")) {
            button.html(`
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">${loadingText}</span>
            `);
        } else if (button.is("input")) {
            button.val(loadingText);
        }

        button.prop("disabled", true);
    } else {
        if (formElement.length) {
            formElement.removeClass("disabled-form");
        }

        document.documentElement.classList.remove("card-loading");

        if (button.is("button")) {
            button.html(button.data("original-text"));
        } else if (button.is("input")) {
            button.val(button.data("original-text"));
        }

        button.prop("disabled", false);
    }
}

function resizableTable(selector, options = {}) {
    const defaultOptions = {
        liveDrag: true,
        resizeMode: "overflow",
        postbackSafe: true,
        useLocalStorage: true,
        gripInnerHtml: "<div class='grip'></div>",
        draggingClass: "dragging",
    };
    const finalOptions = Object.assign({}, defaultOptions, options);
    $(selector).colResizable(finalOptions);
}

document.addEventListener("DOMContentLoaded", (e) => {
    var forms = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener(
            "submit",
            function (event) {
                if (form.checkValidity()) {
                    setButtonLoading(
                        form.querySelector(
                            'button[type="submit"], input[type="submit"]'
                        )
                    );
                } else {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            },
            false
        );
    });
});

function uniqId(amount) {
    const chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    let uniqueID = "";
    for (let i = 0; i < amount; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        uniqueID += chars[randomIndex];
    }
    return uniqueID;
}

function imageCropper(options) {
    var defaults = {
        fileInput: "#image",
        inputLabelPreview: "#image-label-preview",
        aspectRatio: 1 / 1,
        viewMode: 2,
        imageType: "image/jpeg",
        quality: 0.7,
        minFileSizeInKB: 150, // 150 KB
        maxFileSizeInKB: 200, // 200 KB
        maxQualityAttempts: 10,
        onComplete: null,
    };

    options = $.extend({}, defaults, options);

    var $fileInput = $(options.fileInput);
    var $inputLabelPreview = $(options.inputLabelPreview);
    var processedImages = [];
    var currentImageIndex = 0;
    var totalImages = 0;
    var minFileSize = options.minFileSizeInKB * 1024;
    var maxFileSize = options.maxFileSizeInKB * 1024;

    $fileInput.on("change", function (e) {
        var files = e.target.files;
        var imageFiles = Array.from(files).filter(file => file.type.startsWith("image/"));
        
        if (imageFiles.length === 0) {
            if (typeof options.onComplete === "function") {
                options.onComplete(files[0], this);
            }
            return;
        }

        totalImages = imageFiles.length;
        processedImages = [];
        currentImageIndex = 0;

        // Process images one by one
        processNextImage(imageFiles, this);
    });

    function processNextImage(imageFiles, fileInput) {
        if (currentImageIndex >= imageFiles.length) {
            // All images processed, update file input and call onComplete
            updateFileInput(processedImages, fileInput);
            if (typeof options.onComplete === "function") {
                options.onComplete(processedImages, fileInput);
            }
            return;
        }

        var file = imageFiles[currentImageIndex];
        var uniqueId = uniqId(6);
        
        var modalId = `#crop-modal-${uniqueId}`;
        var cropBoxImageId = `#cropbox-image-${uniqueId}`;
        var cropButtonId = `#apply-crop-${uniqueId}`;
        var aspectRatioSelectId = `#aspect-ratio-select-${uniqueId}`;
        var actionsContainerId = `#action-buttons-${uniqueId}`;

        // Generate and append modal HTML
        $("body").append(generateModalHtml(uniqueId));

        var $cropBoxImage = $(cropBoxImageId);
        var $cropModal = $(modalId);
        var $aspectRatioSelect = $(aspectRatioSelectId);
        var $cropButton = $(cropButtonId);
        var $actionsContainer = $(actionsContainerId);

        var cropper;

        var done = function (url) {
            $cropBoxImage.attr("src", url);
            $cropModal.modal({ backdrop: "static", keyboard: false });
            $cropModal.modal("show");
        };

        // Load the image
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            var reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }

        // Modal click handler (shake effect)
        $cropModal.on("click", function (e) {
            if ($(e.target).is($cropModal)) {
                $cropModal.addClass("shake");
                setTimeout(function () {
                    $cropModal.removeClass("shake");
                }, 500);
            }
        });

        // Modal show/hide handlers
        $cropModal
            .on("shown.bs.modal", function () {
                var selectedAspectRatio = parseFloat($aspectRatioSelect.val()) || options.aspectRatio;
                cropper = new Cropper($cropBoxImage[0], {
                    aspectRatio: selectedAspectRatio,
                    viewMode: options.viewMode,
                    ready: function () {
                        if ($actionsContainer) {
                            loadActionButtons($actionsContainer, uniqueId, cropper);
                        }
                    },
                });
            })
            .on("hidden.bs.modal", function () {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                // Remove modal from DOM after hiding
                setTimeout(function() {
                    $cropModal.remove();
                }, 300);
            });

        function generateLoadingModalHtml(uniqueId) {
            var loadingTitle = totalImages > 1 ? 
                `Processing image ${currentImageIndex + 1} of ${totalImages}...` : 
                'Processing image...';
        
            return `
            <div class="modal modal fade" id="loading-modal-${uniqueId}" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center py-4">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="modal-title" id="loadingModalLabel">${loadingTitle}</h6>
                            <p class="text-muted small mb-0">Please wait while we prepare the next image...</p>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }
        // Crop button handler
        $cropButton.on("click", function () {
            var canvas;
            $cropModal.modal("hide");
        
            if (cropper) {
                canvas = cropper.getCroppedCanvas();
                
                // Update preview only for single image or last image
                if (totalImages === 1 || currentImageIndex === totalImages - 1) {
                    $inputLabelPreview.attr(
                        "src",
                        canvas.toDataURL(options.imageType, options.quality)
                    );
                }
        
                // Function to adjust quality based on file size
                function createOptimizedBlob(canvas, callback) {
                    var quality = options.quality;
                    var maxAttempts = options.maxQualityAttempts;
                    var attempt = 0;
        
                    function tryQuality(q) {
                        canvas.toBlob(function(blob) {
                            attempt++;
                            var size = blob.size;
                            
                            if (size >= minFileSize && size <= maxFileSize) {
                                // Perfect size range
                                callback(blob);
                            } else if (attempt >= maxAttempts) {
                                // Max attempts reached, use current blob
                                callback(blob);
                            } else if (size > maxFileSize) {
                                // Too large, reduce quality
                                var newQuality = Math.max(0.1, q - 0.1);
                                tryQuality(newQuality);
                            } else {
                                // Too small, increase quality
                                var newQuality = Math.min(1.0, q + 0.1);
                                tryQuality(newQuality);
                            }
                        }, options.imageType, q);
                    }
        
                    tryQuality(quality);
                }
        
                createOptimizedBlob(canvas, function(blob) {
                    var fileName = file.name.replace(/\.[^/.]+$/, "");
                    var croppedFile = new File([blob], `${fileName}-cropped.jpg`, {
                        type: options.imageType,
                    });
        
                    processedImages.push(croppedFile);
                    currentImageIndex++;
                    
                    // If all images processed, update file input
                    if (currentImageIndex >= imageFiles.length) {
                        updateFileInput(processedImages, fileInput);
                        if (typeof options.onComplete === "function") {
                            options.onComplete(processedImages, fileInput);
                        }
                        
                        // Close loading modal after everything is done
                        if (window.currentLoadingModal) {
                            window.currentLoadingModal.modal("hide");
                            setTimeout(function() {
                                window.currentLoadingModal.remove();
                                window.currentLoadingModal = null;
                            }, 300);
                        }
                    } else {
                        // Show loading indicator for next image (only once)
                        if (!window.currentLoadingModal) {
                            var loadingUniqueId = uniqId(6);
                            $("body").append(generateLoadingModalHtml(loadingUniqueId));
                            window.currentLoadingModal = $(`#loading-modal-${loadingUniqueId}`);
                            window.currentLoadingModal.modal({ backdrop: "static", keyboard: false });
                            window.currentLoadingModal.modal("show");
                        } else {
                            // Update loading modal text
                            var loadingTitle = `Processing image ${currentImageIndex + 1} of ${totalImages}...`;
                            window.currentLoadingModal.find('.modal-title').text(loadingTitle);
                        }
                        
                        // Process next image after a brief delay
                        setTimeout(function() {
                            processNextImage(imageFiles, fileInput);
                        }, 100);
                    }
                });
            }
        });

        // Action buttons handler
        $actionsContainer.on("click", function (event) {
            var target = event.target;
            if (!cropper) {
                return;
            }

            while (target !== this) {
                if (target.getAttribute("data-method")) {
                    break;
                }
                target = target.parentNode;
            }

            if (
                target === this ||
                target.disabled ||
                target.className.indexOf("disabled") > -1
            ) {
                return;
            }

            var data = {
                method: target.getAttribute("data-method"),
                option: target.getAttribute("data-option"),
                secondOption: target.getAttribute("data-second-option"),
            };

            if (data.method) {
                cropper[data.method](data.option, data.secondOption);
                if (data.method === "scaleX" || data.method === "scaleY") {
                    target.setAttribute("data-option", -data.option);
                }
            }
        });
    }

    function loadActionButtons($container, uniqueId, cropperInstance) {
        var buttonsHTML = `
        <select id="aspect-ratio-select-${uniqueId}" class="select-aspect-ratio form-control">
            <option value="">Choose Size</option>
            <option value="1">1:1 (Square)</option>
            <option value="1.7777777777777777">16:9 (Widescreen)</option>
            <option value="0.5625">9:16 (Vertical)</option>
            <option value="2.3333333333333335">21:9 (Ultra-wide)</option>
            <option value="1.3333333333333333">4:3 (Old TV)</option>
            <option value="1.5">3:2 (DSLR)</option>
            <option value="0.7728706624605679">1:1.294 (Letter)</option>
            <option value="0.6070287539936102">1:1.6471 (Legal)</option>
            <option value="NaN">Free (Whatever you want)</option>
        </select>
        <button type="button" class="btn-mode-move btn btn-light btn-sm" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                <span class="text-xs bi-arrows-move"></span>
            </span>
        </button>
        <button type="button" class="btn-mode-crop btn btn-light btn-sm" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                <span class="text-xs bi-crop"></span>
            </span>
        </button>
        <button type="button" class="btn-zoom-in btn btn-light btn-sm" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                <i class="bi bi-zoom-in"></i>
            </span>
        </button>
        <button type="button" class="btn-zoom-out btn btn-light btn-sm" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                <i class="bi bi-zoom-out"></i>
            </span>
        </button>
        <button type="button" class="btn-arrow-left btn btn-light btn-sm" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                <span class="text-xs bi-arrow-left"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-right btn btn-light btn-sm" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                <span class="text-xs bi-arrow-right"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-up btn btn-light btn-sm" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                <span class="text-xs bi-arrow-up"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-down btn btn-light btn-sm" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                <span class="text-xs bi-arrow-down"></span>
            </span>
        </button>
        <button type="button" class="btn-flip-vr btn btn-light btn-sm" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                <i class="bi-vr"></i>
            </span>
        </button>
        <button type="button" class="btn-flip-hr btn btn-light btn-sm" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                <i class="bi-hr"></i>
            </span>
        </button>
        <button type="button" class="btn-add-crop btn btn-light btn-sm" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
                <span class="text-xs bi-check-lg"></span>
            </span>
        </button>
        <button type="button" class="btn-remove-crop btn btn-light btn-sm" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
                <i class="bi-x"></i>
            </span>
        </button>
        <button type="button" class="btn-lock btn btn-light btn-sm" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                <span class="text-xs bi-lock"></span>
            </span>
        </button>
        <button type="button" class="btn-unlock btn btn-light btn-sm" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                <span class="text-xs bi-unlock"></span>
            </span>
        </button>
        `;
        $container.html(buttonsHTML);

        // Fixed aspect ratio change handler
        $container.find(`#aspect-ratio-select-${uniqueId}`).on("change", function () {
            var selectedValue = $(this).val();
            var aspectRatio;
            
            if (selectedValue === "" || selectedValue === "NaN") {
                aspectRatio = NaN; // Free aspect ratio
            } else {
                aspectRatio = parseFloat(selectedValue);
                if (isNaN(aspectRatio)) {
                    console.error('Invalid aspect ratio:', selectedValue);
                    aspectRatio = NaN; // Fallback to free aspect ratio
                }
            }
            
            // Use the cropper instance passed to this function
            if (cropperInstance) {
                cropperInstance.setAspectRatio(aspectRatio);
            }
        });
    }

    function updateFileInput(files, fileInput) {
        var dataTransfer = new DataTransfer();
        files.forEach(function(file) {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }

    function generateModalHtml(uniqueId) {
        var modalTitle = totalImages > 1 ? 
            `Crop image ${currentImageIndex + 1} of ${totalImages}` : 
            'Crop the image';

        return `
        <div class="modal modal fade" id="crop-modal-${uniqueId}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">${modalTitle}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="cropbox-image-${uniqueId}" style="display:block; max-height:300px; max-width:100%">
                        </div>
                        <div id="action-buttons-${uniqueId}"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cw-btn bg-light text-dark" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="cw-btn bg-primary" id="apply-crop-${uniqueId}">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        `;
    }
}

function pushStateModal({
    title = "Title",
    fetchUrl,
    btnSelector,
    loadingSpinner = "loading-spinner",
    actionButtonName,
    modalSize = "md",
    modalType,
    includeForm = false,
    formAction,
    modalHeight = null,
    hash = true,
    tableToRefresh = null,
    formType = 'create'
}) {
    return new Promise((resolve) => {
        const calcModalType = modalType ?? btnSelector.replace(/^[.#]/, '').split('-')[0];
        let modalId = `modal-${calcModalType}`;
        const modalContentClass = `detail-${calcModalType}`;
        const heightStyle = modalHeight === "auto" ? 
            "max-height: 75vh; height: auto;" : 
            `max-height: 75vh; height: ${modalHeight};`;
        const actionBtnId = actionButtonName && actionButtonName.replace(/\s+/g, '-').toLowerCase()+'-'+calcModalType;

        const formTagOpen = includeForm ? `<form id="form-${calcModalType}" method="POST" enctype="multipart/form-data">` : '';
        const formTagClose = includeForm ? `</form>` : '';

        if ($(`#${modalId}`).length) {
            $(`#${modalId}`).remove();
        }

        const modalTemplate = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${modalSize} modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    ${formTagOpen}
                    <div class="modal-body" style="${heightStyle}">
                        <div class="${loadingSpinner} text-center mt-2">
                            <form-skeleton
                                tabs="3"
                                input-rows="2"
                                input-columns="3"
                                textareas="1"
                                show-footer="false"
                                show-loading-text="false">
                            </form-skeleton>
                        </div>
                        <div class="${modalContentClass} p-1"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        ${actionButtonName ? `<button type="submit" id="${actionBtnId}" class="btn btn-primary px-3">${actionButtonName}</button>` : ''}    
                    </div>
                    ${formTagClose}
                </div>
            </div>
        </div>`;

        $('body').append(modalTemplate);

        async function openModal(recordId) {
            const url = fetchUrl.replace(":id", recordId);

            if (includeForm) {
                $(`#form-${calcModalType}`).attr('action', formAction.replace(":id", recordId));
            }

            $(`#${modalId}`).modal("show");
            $(`#${modalId} .${loadingSpinner}`).show();
            $(`#${modalId} .${modalContentClass}`).hide();

            try {
                const response = await fetchRequest(url);
                const result = response['result'];

                if (result) {
                    $(`#${modalId} .modal-title`).text(title);
                    $(`#${modalId} .${modalContentClass}`).html(result);
                } else {
                    $(`#${modalId} .modal-title`).text("Error");
                    $(`#${modalId} .${modalContentClass}`).html(
                        '<p class="pb-0 pt-3 p-4">Unable to load content.</p>'
                    );
                }
            } catch (error) {
                console.error("Error fetching modal content:", error);
                $(`#${modalId} .modal-title`).text("Error");
                $(`#${modalId} .${modalContentClass}`).html(
                    '<p class="pb-0 pt-3 p-4">Unable to load content.</p>'
                );
            } finally {
                $(`#${modalId} .${loadingSpinner}`).hide();
                $(`#${modalId} .${modalContentClass}`).show();
            }
        }

        function resetModal() {
            $(`#${modalId} .${modalContentClass}`).empty();
            if (tableToRefresh) tableToRefresh.ajax.reload();
            if (includeForm) {
                $(`#form-${calcModalType}`)[0].reset();
            }
        }

        function openModalFromUrl() {
            if (!hash) return;
            
            const urlParams = new URLSearchParams(window.location.search);
            const recordId = urlParams.get("id");
            const type = urlParams.get("type");

            if (recordId && type === calcModalType) {
                openModal(recordId);
            }
        }

        $(document).off("click", btnSelector);
        
        $(document).on("click", btnSelector, function () {
            const recordId = $(this).data("id");
            
            if (hash) {
                const currentUrl = new URL(window.location);
                const newUrl = `${currentUrl.pathname}?id=${recordId}&type=${calcModalType}${window.location.hash}`;
                history.pushState(null, null, newUrl);
            }
            
            openModal(recordId, calcModalType);
        });

        if (hash) {
            const popstateEvent = `popstate.${modalId}`;
            $(window).off(popstateEvent).on(popstateEvent, function () {
                openModalFromUrl();
            });

            $(`#${modalId}`).on("hidden.bs.modal", function () {
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.delete("id");
                currentUrl.searchParams.delete("type");

                const newUrl = `${currentUrl.pathname}${currentUrl.search}${window.location.hash}`;
                history.pushState(null, null, newUrl);
                
                resetModal();
            });
        }

        openModalFromUrl();
        
        if (includeForm) {
            const modalElement = $(`#${modalId}`);
            const submitBtn = modalElement.find('button[type="submit"]');
            
            modalElement.find('form').off('submit').on('submit', async function(e) {
                e.preventDefault();
                const form = this;
                
                if (form.isSubmitting) {
                    return false;
                }
                
                form.isSubmitting = true;
                const formData = new FormData(form);
                formType === 'edit' && formData.append('_method', 'PATCH');
                const url = $(this).attr('action');
                
                setButtonLoading(submitBtn, true);
                 
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {
                        setButtonLoading(submitBtn, false);
                        modalElement.modal('hide');
                        if (tableToRefresh) tableToRefresh.ajax.reload();
                    }
                } catch (error) {
                    console.error('Error submitting form: ', error);
                } finally {
                    form.isSubmitting = false;
                    setButtonLoading(submitBtn, false);
                    submitBtn.prop('disabled', false);
                    submitBtn.text(actionButtonName);
                }
            });
        }

        resolve(modalId);
    });
}

function formWizardModal({
    title = "Title",
    fetchUrl,
    btnSelector,
    loadingSpinner = "loading-spinner",
    actionButtonName = "Submit",
    modalSize = "lg",
    formAction,
    modalHeight = "auto",
    wizardSteps = [],
    onModalLoaded = null,
    onStepShown = null,
    formSubmitted = null,
    formType = 'create',
    tableToRefresh = null,
}) {
    return new Promise((resolve) => {
        const modalType = btnSelector.replace(/^[.#]/, '').split('-')[0];
        let modalId = `modal-${modalType}`;
        const modalContentClass = `detail-${modalType}`;
        const heightStyle = modalHeight === "auto" ? 
            "max-height: 75vh; height: auto;" : 
            `max-height: 75vh; height: ${modalHeight};`;

        const modalTemplate = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${modalSize} modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content" id="cw-wizard">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="cw-wizard-navigation">
                        <ul class="nav nav-pills nav-justified cw-wizard-steps">
                            ${wizardSteps.map((step, index) => `
                                <li class="nav-item cw-wizard-step-item">
                                    <button type="button" class="nav-link ${index === 0 ? 'active' : 'disabled'}" data-step="${index}">
                                        <div class="cw-wizard-step-circle">
                                            <span class="cw-wizard-step-number">${index + 1}</span>
                                            <span class="cw-wizard-step-check"><i class="bi bi-check-lg"></i></span>
                                        </div>
                                        <span class="cw-wizard-step-text">${step.title}</span>
                                        ${index < wizardSteps.length - 1 ? '<span class="cw-wizard-step-connector"></span>' : ''}
                                    </button>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                    <div class="cw-wizard-step-indicator">
                        <div class="progress progress-container">
                            <div class="progress-bar bg-success custom-progress-bar" 
                                role="progressbar" 
                                style="width: ${100 / wizardSteps.length}%">
                                <div class="progress-shine"></div>
                            </div>
                        </div>
                    </div>
                    <div id="error-indicator"></div>
                    <form id="form-${modalType}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body" style="${heightStyle}">
                            <div class="${loadingSpinner} text-center mt-2">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="${modalContentClass} p-1"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="button" class="btn btn-outline-primary cw-wizard-prev me-2" style="display: none;">Previous</button>
                            <button type="button" class="btn btn-primary cw-wizard-next" disabled>Next</button>
                            <button type="button" class="btn btn-success cw-wizard-submit" style="display: none;" disabled>${actionButtonName}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;

        const existingModal = $(`#${modalId}`);
        if (existingModal.length) {
            try {
                const modalInstance = bootstrap.Modal.getInstance(existingModal[0]);
                if (modalInstance) {
                    modalInstance.dispose();
                }
            } catch (e) {
                console.error("Error disposing existing modal:", e);
            }
            existingModal.off().removeData().remove();
        }

        $('body').append(modalTemplate);

        async function openModal(recordId) {
            const url = fetchUrl.replace(":id", recordId);
            $(`#form-${modalType}`).attr('action', formAction.replace(":id", recordId));
            
            $(`#${modalId}`).modal("show");
            $(`#${modalId} .${loadingSpinner}`).show();
            $(`#${modalId} .${modalContentClass}`).hide();

            const response = await fetchRequest(url);
            const result = response['result'];

            if (result) {
                $(`#${modalId} .modal-title`).text(title);
                $(`#${modalId} .${modalContentClass}`).html(result);
                initWizard(modalId, wizardSteps);
                
                adjustModalHeight();
                
                if (typeof onModalLoaded === 'function') {
                    onModalLoaded();
                }
            } else {
                $(`#${modalId} .modal-title`).text("Error");
                $(`#${modalId} .${modalContentClass}`).html(
                    '<p class="pb-0 pt-3 p-4">Unable to load content.</p>'
                );
            }

            $(`#${modalId} .${loadingSpinner}`).hide();
            $(`#${modalId} .${modalContentClass}`).show();
        }
        
        function adjustModalHeight() {
            const $modalBody = $(`#${modalId} .modal-body`);
            
            $modalBody.css({
                'max-height': '50vh',
                'height': 'auto',
            });
            
            $(`#${modalId} .modal-dialog`).addClass('modal-dialog-centered');
        }

        function clearModal() {
            const $modal = $(`#${modalId}`);
            
            $modal.find('.cw-wizard-next, .cw-wizard-prev, .cw-wizard-submit').off();
            $modal.find('.cw-wizard-steps .nav-link').off();
            $modal.find('input, select, textarea').off('input change blur');
            
            $(document).off("click", btnSelector);
            
            $modal.off();
            $modal.find('form').off();
            
            $modal.removeData();
            
            try {
                const modalInstance = bootstrap.Modal.getInstance($modal[0]);
                if (modalInstance) {
                    modalInstance.dispose();
                }
            } catch (e) {
                console.error("Error disposing modal:", e);
            }
            
            $modal.remove();
            
            modalId = null;
        }

        function initWizard(modalId, steps) {
            const $modal = $(`#${modalId}`);
            const $content = $modal.find(`.${modalContentClass}`);
            let currentStep = 0;
            let completedSteps = new Set();
            
            organizeWizardSteps($content, steps);
            showWizardStep(currentStep);
            
            function isFieldCompleted(field) {
                const $field = $(field);
                
                if ($field.is('select')) {
                    return $field.val() !== null && $field.val() !== '';
                } else if ($field.is('input[type="checkbox"], input[type="radio"]')) {
                    const name = $field.attr('name');
                    return $modal.find(`input[name="${name}"]:checked`).length > 0;
                } else if ($field.is('input[type="file"]')) {
                    return $field.get(0).files.length > 0 || !$field.prop('required');
                } else {
                    return $field.val() !== '';
                }
            }
            
            function isStepCompleted(stepIndex) {
                const $step = $modal.find(`.cw-wizard-step[data-step="${stepIndex}"]`);
                const $requiredFields = $step.find('[required]');
                
                if ($requiredFields.length === 0) {
                    return true;
                }
                
                let isCompleted = true;
                $requiredFields.each(function() {
                    if (!isFieldCompleted(this)) {
                        isCompleted = false;
                        return false;
                    }
                });
                
                return isCompleted;
            }
            
            function canAccessStep(targetStepIndex) {
                let allStepsCompleted = true;
                for (let i = 0; i < steps.length; i++) {
                    if (!isStepCompleted(i)) {
                        allStepsCompleted = false;
                        break;
                    }
                }
                
                if (allStepsCompleted) {
                    return true;
                }
                
                if (targetStepIndex === 0) return true;
                if (targetStepIndex === currentStep) return true;
                if (targetStepIndex === currentStep - 1) return true;
                if (targetStepIndex === currentStep + 1 && isStepCompleted(currentStep)) {
                    return true;
                }
                return false;
            }
            
            function updateWizardState() {
                const currentStepCompleted = isStepCompleted(currentStep);
                
                if (currentStepCompleted) {
                    completedSteps.add(currentStep);
                } else {
                    completedSteps.delete(currentStep);
                }
                
                let allStepsCompleted = true;
                for (let i = 0; i < steps.length; i++) {
                    if (!isStepCompleted(i)) {
                        allStepsCompleted = false;
                        break;
                    }
                }
                
                $modal.find('.cw-wizard-next').prop('disabled', !currentStepCompleted);
                $modal.find('.cw-wizard-submit').prop('disabled', !allStepsCompleted);
                
                $modal.find('.cw-wizard-steps .nav-link').each(function() {
                    const stepIndex = parseInt($(this).data('step'));
                    
                    $(this).removeClass('active completed disabled cw-tab-alert');
                    
                    if (stepIndex === currentStep) {
                        $(this).addClass('active');
                    } 
                    else if (completedSteps.has(stepIndex)) {
                        $(this).addClass('completed');
                        
                        if (!canAccessStep(stepIndex)) {
                            $(this).addClass('disabled');
                        }
                    }
                    else {
                        if (!canAccessStep(stepIndex)) {
                            $(this).addClass('disabled');
                        }
                    }
                });
                
                updateProgressBar();
                updateStepConnectors();
            }
            
            $modal.find('.cw-wizard-next').on('click', function() {
                if (isStepCompleted(currentStep)) {
                    const nextStep = currentStep + 1;
                    if (nextStep < steps.length) {
                        completedSteps.add(currentStep);
                        
                        currentStep = nextStep;
                        showWizardStep(currentStep);
                        updateWizardState();
                        
                        $modal.find('.modal-body').scrollTop(0);
                        
                        adjustModalHeight();
                    }
                } else {
                    highlightMissingFields(currentStep);
                    
                    $(this).addClass('cw-btn-shake');
                    setTimeout(() => $(this).removeClass('cw-btn-shake'), 500);
                }
            });
            
            $modal.find('.cw-wizard-prev').on('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showWizardStep(currentStep);
                    updateWizardState();
                    
                    $modal.find('.modal-body').scrollTop(0);
                    
                    adjustModalHeight();
                }
            });
            
            $modal.find('.cw-wizard-submit').on('click', function() {
                let allStepsCompleted = true;
                let firstIncompleteStep = -1;
                
                for (let i = 0; i < steps.length; i++) {
                    if (!isStepCompleted(i)) {
                        allStepsCompleted = false;
                        if (firstIncompleteStep === -1) {
                            firstIncompleteStep = i;
                        }
                        
                        const $tab = $modal.find(`.cw-wizard-steps .nav-link[data-step="${i}"]`);
                        $tab.addClass('cw-tab-alert');
                        setTimeout(() => $tab.removeClass('cw-tab-alert'), 1500);
                    }
                }
                
                if (allStepsCompleted) {
                    const $btn = $(this);
                    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
                    $btn.prop('disabled', true);
                    
                    $modal.find('form').submit();
                } else {
                    if (firstIncompleteStep !== -1) {
                        currentStep = firstIncompleteStep;
                        showWizardStep(currentStep);
                        updateWizardState();
                        
                        highlightMissingFields(currentStep);
                        
                        $modal.find('.modal-body').scrollTop(0);
                        
                        adjustModalHeight();
                    }
                    
                    $(this).addClass('cw-btn-shake');
                    setTimeout(() => $(this).removeClass('cw-btn-shake'), 500);
                }
            });
            
            function highlightMissingFields(stepIndex) {
                const $step = $modal.find(`.cw-wizard-step[data-step="${stepIndex}"]`);
                const $requiredFields = $step.find('[required]');
                
                $requiredFields.each(function() {
                    if (!isFieldCompleted(this)) {
                        $(this).addClass('is-invalid');
                        $(this).addClass('cw-field-shake');
                        setTimeout(() => $(this).removeClass('cw-field-shake'), 600);
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
            }
            
            $modal.find('.cw-wizard-steps .nav-link').on('click', function() {
                const stepIndex = parseInt($(this).data('step'));
                
                if (canAccessStep(stepIndex)) {
                    currentStep = stepIndex;
                    showWizardStep(currentStep);
                    updateWizardState();
                    
                    $modal.find('.modal-body').scrollTop(0);
                    
                    adjustModalHeight();
                } else {
                    $(this).addClass('cw-nav-link-shake');
                    setTimeout(() => $(this).removeClass('cw-nav-link-shake'), 500);
                }
            });
            
            function updateProgressBar() {
                const totalSteps = steps.length;
                const completedCount = completedSteps.size;
                const progress = Math.max(((currentStep + 1) / totalSteps) * 100, (completedCount / totalSteps) * 100);
                
                $modal.find('.progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
            }
            
            function updateStepConnectors() {
                $modal.find('.cw-wizard-steps .nav-link').each(function() {
                    const stepIndex = parseInt($(this).data('step'));
                    const $connector = $(this).find('.cw-wizard-step-connector');
                    
                    if ($connector.length && completedSteps.has(stepIndex)) {
                        $connector.addClass('completed');
                    } else if ($connector.length) {
                        $connector.removeClass('completed');
                    }
                });
            }
            
            function attachFieldListeners() {
                $modal.find('input, select, textarea').on('input change blur', function() {
                    $(this).removeClass('is-invalid');
                    updateWizardState();
                });
            }
            
            function organizeWizardSteps($content, steps) {
                steps.forEach((step, index) => {
                    const $stepContainer = $(`<div class="cw-wizard-step" data-step="${index}" style="display: none;"></div>`);
                                        
                    if (step.fields && step.fields.length) {
                        step.fields.forEach(fieldSelector => {
                            const $field = $content.find(fieldSelector).closest('.form-group, .col-md-12, .col-md-8, .col-md-6, .col-md-4, .col-md-3, [class*="col-"]');
                            
                            if ($field.length) {
                                $stepContainer.append($field);
                            } else {
                                const $directField = $content.find(fieldSelector);
                                if ($directField.length) {
                                    $stepContainer.append($directField);
                                }
                            }
                        });
                    } else if (step.selector) {
                        const $fields = $content.find(step.selector);
                        $stepContainer.append($fields);
                    }
                    
                    $content.append($stepContainer);
                });
            }
            
            function showWizardStep(stepIndex) {
                $modal.find('.cw-wizard-step').hide();
                $modal.find(`.cw-wizard-step[data-step="${stepIndex}"]`).fadeIn(200);
                
                $modal.find('.cw-wizard-prev').toggle(stepIndex > 0);
                $modal.find('.cw-wizard-next').toggle(stepIndex < steps.length - 1);
                $modal.find('.cw-wizard-submit').toggle(stepIndex === steps.length - 1);
                
                const currentStepTitle = steps[stepIndex].title;
                $modal.find('.modal-title').text(`${title} - ${currentStepTitle}`);
                
                adjustModalHeight();
                
                if (typeof onStepShown === 'function') {
                    onStepShown(stepIndex, steps[stepIndex]);
                }
            }
            
            attachFieldListeners();
            updateWizardState();
        }

        $(document).on("click", btnSelector, function () {
            const recordId = $(this).data("id");
            openModal(recordId);
        });

        const modalElement = $(`#${modalId}`);
        const submitBtn = modalElement.find('.cw-wizard-submit');

        modalElement.data('form-submitted', false);
        modalElement.on('hide.bs.modal', async function(e) {
            if (modalElement.data('confirmed-close') || modalElement.data('form-submitted')) {
                modalElement.data('confirmed-close', false);
                return true;
            }
            
            e.preventDefault();
            const result = await confirmAction("Are you sure you want to exit? Any unsaved changes will be lost.");
            if (result.isConfirmed) {
                modalElement.data('confirmed-close', true);
                modalElement.modal('hide');
            }
        });

        modalElement.on('hidden.bs.modal', async function(e) {
            clearModal();
        });
        
        modalElement.find('form').on('submit', async function(e) {
            e.preventDefault();
            const form = this;
            
            if (form.isSubmitting) {
                return false;
            }
            
            form.isSubmitting = true;
            const formData = new FormData(form);
            formType === 'edit' && formData.append('_method', 'PATCH');
            const url = $(this).attr('action');
            
            setButtonLoading(submitBtn, true);
            
            try {
                const result = await fetchRequest(url, 'POST', formData);
                if (result) {
                    setButtonLoading(submitBtn, false);
                    modalElement.data('form-submitted', true);
                    modalElement.modal('hide');
                    if (tableToRefresh) tableToRefresh.ajax.reload();
                    if (typeof formSubmitted === 'function') {
                        formSubmitted();
                    }
                } else {
                    document.querySelector('#error-indicator').innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" style="position: relative; max-width: 600px; margin: 7px auto; border-radius: 3px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        Oops! Some fields need your attention. Please review and try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; right: 5px;"></button>
                    </div>
                    `;
                }
            } catch (error) {
                setButtonLoading(submitBtn, false);
            } finally {
                form.isSubmitting = false;
                setButtonLoading(submitBtn, false);
                submitBtn.prop('disabled', false);
                submitBtn.text(actionButtonName);
            }
        });

        if (modalId.length) {
            resolve(modalId);
        }
    });
}

function select2Ajax(selector, url, options = {}) {
    const $select = typeof selector === 'string' ? $(selector) : selector;
    const config = {
        theme: "bootstrap-5",
        placeholder: options.placeholder || "Select an option",
        allowClear: options.allowClear !== false,
        dropdownParent: options.dropdownParent || $select.parent(),
        width: options.width || '100%',
        multiple: options.multiple || false,
        ajax: {
            url: url,
            dataType: 'json',
            delay: options.delay || 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    ...options.params
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        templateResult: options.templateResult || function(data) {
            if (data.loading) return 'Loading...';
            return data.text;
        },
        templateSelection: options.templateSelection || function(data) {
            return data.text || options.placeholder || "Select an option";
        }
    };
    
    const select2Instance = $select.select2(config);
        
    if (options.onSelect) {
        select2Instance.on('select2:select', options.onSelect);
    }
    
    if (options.onChange) {
        select2Instance.on('change', options.onChange);
    }
    
    return select2Instance;
}