function showMessage(message, type = "success", options = {}) {
    Swal.fire({
        position: "top-end",
        icon: type,
        title: message,
        showConfirmButton: options.showConfirmButton || false,
        timer: options.timer || 3000,
        ...options,
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
                showMessage(result.success || successMessage);
                return true;
            }
        } else {
            showMessage(
                result.error || errorMessage || "An unexpected error occurred",
                "error"
            );
            return false;
        }
    } catch (error) {
        showMessage(
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

function initDataTable(selector, options = {}) {
    const exportButtons = [
        {
            extend: "copy",
            text: `<span class="symbol-container">
                    <i class="bi-copy"></i>
                    &nbsp; Copy
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
            },
        },
        {
            extend: "csv",
            text: `<span class="symbol-container">
                    <i class="bi-filetype-csv"></i>
                    &nbsp; CSV
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
            },
        },
        {
            extend: "excel",
            text: `<span class="symbol-container">
                    <i class="bi-file-spreadsheet"></i>
                    &nbsp; Excel
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
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
                columns: ":visible:not(:last-child)",
            },
        },
    ];

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
                    ...(options.customButton ? [options.customButton] : []),
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
            $(selector).addClass("card-loading");
        },
        drawCallback() {
            $(selector).removeClass("card-loading");
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
        onComplete: null,
    };

    options = $.extend({}, defaults, options);

    var uniqueId = uniqId(6);

    var modalId = `#crop-modal-${uniqueId}`,
        cropBoxImageId = `#cropbox-image-${uniqueId}`,
        cropButtonId = `#apply-crop-${uniqueId}`,
        aspectRatioSelectId = `#aspect-ratio-select`,
        actionsContainerId = `#action-buttons-${uniqueId}`;

    $("body").append(generateModalHtml(uniqueId));

    var $fileInput = $(options.fileInput),
        $inputLabelPreview = $(options.inputLabelPreview),
        $cropBoxImage = $(cropBoxImageId),
        $cropModal = $(modalId),
        $aspectRatioSelect = $(aspectRatioSelectId),
        $cropButton = $(cropButtonId),
        $actionsContainer = $(actionsContainerId);

    var cropper;

    $fileInput.on("change", function (e) {
        var files = e.target.files;
        if (files.length === 0 || !files[0].type.startsWith("image/")) {
            options.onComplete(files[0], this);
            return;
        }
        var done = function (url) {
            $cropBoxImage.attr("src", url);
            $cropModal.modal({ backdrop: "static", keyboard: false });
            $cropModal.modal("show");
        };

        var reader, file;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }

        $cropButton.data("input", this);
        $cropButton.data("preview", $inputLabelPreview);
    });

    $cropModal.on("click", function (e) {
        if ($(e.target).is($cropModal)) {
            $cropModal.addClass("shake");
            setTimeout(function () {
                $cropModal.removeClass("shake");
            }, 500);
        }
    });

    $cropModal
        .on("shown.bs.modal", function () {
            var selectedAspectRatio =
                parseFloat($aspectRatioSelect.val()) || options.aspectRatio;
            cropper = new Cropper($cropBoxImage[0], {
                aspectRatio: selectedAspectRatio,
                viewMode: options.viewMode,
                ready: function () {
                    if ($actionsContainer) {
                        loadActionButtons($actionsContainer);
                    }
                },
            });
        })
        .on("hidden.bs.modal", function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

    $cropButton.on("click", function () {
        var canvas;
        $cropModal.modal("hide");

        if (cropper) {
            canvas = cropper.getCroppedCanvas();
            var $inputLabelPreview = $(this).data("preview");
            $inputLabelPreview.attr(
                "src",
                canvas.toDataURL(options.imageType, options.quality)
            );

            var $fileInput = $(this).data("input");
            canvas.toBlob(
                function (blob) {
                    var file = new File([blob], `cropped-${uniqId(6)}.jpg`, {
                        type: options.imageType,
                    });

                    if (typeof options.onComplete === "function") {
                        options.onComplete(file, $fileInput);
                    }

                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    $fileInput.files = dataTransfer.files;
                },
                options.imageType,
                options.quality
            );
        }
    });

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

    function loadActionButtons($container) {
        var buttonsHTML = `
        <select id="aspect-ratio-select" class="select-aspect-ratio form-control">
            <option value="">Choose Size</option>
            <option value="1 / 1">1:1 (Square)</option>
            <option value="16 / 9">16:9 (Widescreen)</option>
            <option value="9 / 16">9:16 (Vertical)</option>
            <option value="21 / 9">21:9 (Ultra-wide)</option>
            <option value="4 / 3">4:3 (Old TV)</option>
            <option value="3 / 2">3:2 (DSLR)</option>
            <option value="1 / 1.294">1:1.294 (Letter)</option>
            <option value="1 / 1.6471">1:1.6471 (Legal)</option>
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

        $container.find("#aspect-ratio-select").on("change", function () {
            var aspectRatio = eval($(this).val());
            if (cropper) {
                cropper.setAspectRatio(aspectRatio);
            }
        });
    }

    function generateModalHtml(uniqueId) {
        return `
        <div class="modal modal fade" id="crop-modal-${uniqueId}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="cropbox-image-${uniqueId}" style="display:block; max-height:300px; max-width:100%">
                        </div>
                        <div id="action-buttons-${uniqueId}"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-sm" id="apply-crop-${uniqueId}">Crop</button>
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
    modalHeight = "70vh",
    hash = true,
    tableToRefresh = null
}) {
    return new Promise((resolve) => {
        const calcModalType = modalType ?? btnSelector.replace(/^[.#]/, '').split('-')[0];
        const modalId = `modal-${calcModalType}`;
        const modalContentClass = `detail-${calcModalType}`;
        const actionBtnId = actionButtonName && actionButtonName.replace(/\s+/g, '-').toLowerCase()+'-'+calcModalType;

        const formTagOpen = includeForm ? `<form id="form-${calcModalType}" method="POST" enctype="multipart/form-data">` : '';
        const formTagClose = includeForm ? `</form>` : '';

        const modalTemplate = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${modalSize} modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    ${formTagOpen}
                    <div class="modal-body" style="${includeForm && 'height:'+modalHeight}">
                        <div class="${loadingSpinner} text-center mt-2">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
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

        if (!$(`#${modalId}`).length) {
            $('body').append(modalTemplate);
        }

        async function openModal(recordId) {
            const url = fetchUrl.replace(":id", recordId);

            if (includeForm) {
                $(`#form-${calcModalType}`).attr('action', formAction.replace(":id", recordId));
            }

            $(`#${modalId}`).modal("show");
            $(`#${modalId} .${loadingSpinner}`).show();
            $(`#${modalId} .${modalContentClass}`).hide();

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

            $(`#${modalId} .${loadingSpinner}`).hide();
            $(`#${modalId} .${modalContentClass}`).show();
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
            $(window).on("popstate", function () {
                openModalFromUrl();
            });

            $(`#${modalId}`).on("hidden.bs.modal", function () {
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.delete("id");
                currentUrl.searchParams.delete("type");

                const newUrl = `${currentUrl.pathname}${currentUrl.search}${window.location.hash}`;
                history.pushState(null, null, newUrl);
            });
        }

        openModalFromUrl();

        if (includeForm) {
            const modalElement = $(`#${modalId}`);
            const submitBtn = modalElement.find('button[type="submit"]');
            
            modalElement.find('form').on('submit', async function(e) {
                e.preventDefault();
                const form = this;
                
                if (form.isSubmitting) {
                    return false;
                }
                
                form.isSubmitting = true;
                const formData = new FormData(form);
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
                }
            });
        }

        if (modalId.length) {
            resolve(modalId);
        }
    });
}

function pushStateWizardModal({
    title = "Title",
    fetchUrl,
    btnSelector,
    loadingSpinner = "loading-spinner",
    actionButtonName,
    modalSize = "xl",
    modalType,
    includeForm = true,
    formAction,
    modalHeight = "75vh",
    hash = false,
    tableToRefresh = null,
    isWizard = false, // New parameter
    wizardSteps = [] // New parameter: [{title: "Step 1", fields: ["field1", "field2"]}]
}) {
    return new Promise((resolve) => {
        const calcModalType = modalType ?? btnSelector.replace(/^[.#]/, '').split('-')[0];
        const modalId = `modal-${calcModalType}`;
        const modalContentClass = `detail-${calcModalType}`;
        const actionBtnId = actionButtonName && actionButtonName.replace(/\s+/g, '-').toLowerCase()+'-'+calcModalType;

        const formTagOpen = includeForm ? `<form id="form-${calcModalType}" method="POST" enctype="multipart/form-data">` : '';
        const formTagClose = includeForm ? `</form>` : '';

        // Wizard navigation template with more compact design
        const wizardNavigation = isWizard ? `
            <div class="wizard-navigation mb-3">
                <ul class="nav nav-pills nav-justified wizard-steps">
                    ${wizardSteps.map((step, index) => `
                        <li class="nav-item wizard-step-item">
                            <button type="button" class="nav-link ${index === 0 ? 'active' : ''}" data-step="${index}">
                                <div class="wizard-step-circle">
                                    <span class="wizard-step-number">${index + 1}</span>
                                </div>
                                <span class="wizard-step-text">${step.title}</span>
                                ${index < wizardSteps.length - 1 ? '<span class="wizard-step-connector"></span>' : ''}
                            </button>
                        </li>
                    `).join('')}
                </ul>
            </div>
        ` : '';

        // Step indicator template with enhanced design
        const wizardStepIndicator = isWizard ? `
            <div class="wizard-step-indicator mb-4">
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: ${100 / wizardSteps.length}%" aria-valuenow="${100 / wizardSteps.length}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        ` : '';

        // Removed - wizard controls now go in footer

        const modalTemplate = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${modalSize} modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    ${formTagOpen}
                    <div class="modal-body" style="${includeForm && 'height:'+modalHeight}">
                        ${isWizard ? wizardNavigation + wizardStepIndicator : ''}
                        <div class="${loadingSpinner} text-center mt-2">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="${modalContentClass} p-1"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        ${isWizard ? `
                            <button type="button" class="btn btn-outline-primary wizard-prev me-2" style="display: none;">Previous</button>
                            <button type="button" class="btn btn-primary wizard-next">Next</button>
                            <button type="button" class="btn btn-success wizard-submit" style="display: none;">${actionButtonName}</button>
                        ` : actionButtonName ? `<button type="submit" id="${actionBtnId}" class="btn btn-primary px-3">${actionButtonName}</button>` : ''}    
                    </div>
                    ${formTagClose}
                </div>
            </div>
        </div>`;

        if (!$(`#${modalId}`).length) {
            $('body').append(modalTemplate);
        }

        async function openModal(recordId) {
            const url = fetchUrl.replace(":id", recordId);

            if (includeForm) {
                $(`#form-${calcModalType}`).attr('action', formAction.replace(":id", recordId));
            }

            $(`#${modalId}`).modal("show");
            $(`#${modalId} .${loadingSpinner}`).show();
            $(`#${modalId} .${modalContentClass}`).hide();

            const response = await fetchRequest(url);
            const result = response['result'];

            if (result) {
                $(`#${modalId} .modal-title`).text(title);
                $(`#${modalId} .${modalContentClass}`).html(result);
                
                // Initialize wizard if enabled
                if (isWizard) {
                    initWizard(modalId, wizardSteps);
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

        // Function to initialize wizard functionality with strict step validation
        function initWizard(modalId, steps) {
            const $modal = $(`#${modalId}`);
            const $content = $modal.find(`.${modalContentClass}`);
            let currentStep = 0;
            
            // Track validated steps
            let validatedSteps = new Set([0]); // First step is considered accessible initially
            
            // Organize form fields into step containers
            organizeWizardSteps($content, steps);
            
            // Show only the first step initially
            showWizardStep(currentStep);
            
            // Function to check if a specific field is filled
            function isFieldCompleted(field) {
                const $field = $(field);
                // Different check based on field type
                if ($field.is('select')) {
                    return $field.val() !== null && $field.val() !== '';
                } else if ($field.is('input[type="checkbox"], input[type="radio"]')) {
                    return $field.is(':checked');
                } else {
                    return $field.val() !== '';
                }
            }
            
            // Function to check if all required fields in a step are filled
            function isStepCompleted(stepIndex) {
                const $step = $modal.find(`.wizard-step[data-step="${stepIndex}"]`);
                const $requiredFields = $step.find('[required]');
                
                // No required fields means step is complete by default
                if ($requiredFields.length === 0) {
                    return true;
                }
                
                // Check each required field
                let isCompleted = true;
                $requiredFields.each(function() {
                    if (!isFieldCompleted(this)) {
                        isCompleted = false;
                        return false; // break the loop
                    }
                });
                
                return isCompleted;
            }
            
            // Simple check - only allow accessing the current step or step 0
            // This forces linear navigation and prevents skipping steps
            function canAccessStep(stepIndex) {
                // Only allow access to current step or first step
                if (stepIndex === currentStep || stepIndex === 0) {
                    return true;
                }
                
                // Only allow access to next step if current step is completed
                if (stepIndex === currentStep + 1 && isStepCompleted(currentStep)) {
                    return true;
                }
                
                // Only allow access to previous step
                if (stepIndex === currentStep - 1) {
                    return true;
                }
                
                // Disallow all other navigation
                return false;
            }
            
            // Update the visual state of navigation tabs based on accessibility
            function updateNavigationState() {
                // Check completion status of current step
                const currentStepCompleted = isStepCompleted(currentStep);
                
                // Update the appearance of each navigation tab
                $modal.find('.wizard-navigation .nav-link').each(function() {
                    const stepIndex = parseInt($(this).data('step'));
                    
                    // Step indicators show completion status
                    if (stepIndex < currentStep) {
                        // Prior steps show as completed
                        $(this).addClass('completed').removeClass('active disabled');
                    } 
                    else if (stepIndex === currentStep) {
                        // Current step is active
                        $(this).addClass('active').removeClass('completed disabled');
                    }
                    else if (stepIndex === currentStep + 1 && currentStepCompleted) {
                        // Next step is enabled only if current step is complete
                        $(this).removeClass('disabled completed active');
                    }
                    else {
                        // All other steps are disabled
                        $(this).addClass('disabled').removeClass('completed active');
                    }
                });
                
                // Enable/disable the next button based on current step completion
                $modal.find('.wizard-next').prop('disabled', !currentStepCompleted);
                
                // Update the submit button on the final step
                if (currentStep === steps.length - 1) {
                    $modal.find('.wizard-submit').prop('disabled', !currentStepCompleted);
                }
            }
            
            // Initialize navigation buttons with strict linear progression
            $modal.find('.wizard-next').on('click', function() {
                // Only allow next if current step is completed
                if (isStepCompleted(currentStep)) {
                    const nextStep = currentStep + 1;
                    if (nextStep < steps.length) {
                        currentStep = nextStep;
                        showWizardStep(currentStep);
                        updateNavigationState();
                        // Scroll to top of form
                        $modal.find('.modal-body').scrollTop(0);
                    }
                } else {
                    // Highlight missing required fields
                    highlightMissingFields(currentStep);
                    // Visual feedback for validation failure
                    $(this).addClass('btn-shake');
                    setTimeout(() => $(this).removeClass('btn-shake'), 500);
                }
            });
            
            $modal.find('.wizard-prev').on('click', function() {
                // Simple previous step navigation
                const prevStep = currentStep - 1;
                if (prevStep >= 0) {
                    currentStep = prevStep;
                    showWizardStep(currentStep);
                    updateNavigationState();
                    // Scroll to top of form
                    $modal.find('.modal-body').scrollTop(0);
                }
            });
            
            $modal.find('.wizard-submit').on('click', function() {
                // Enforce that all steps must be completed before submission
                let allStepsCompleted = true;
                for (let i = 0; i < steps.length; i++) {
                    if (!isStepCompleted(i)) {
                        allStepsCompleted = false;
                        // Highlight incomplete steps
                        const $tab = $modal.find(`.wizard-navigation .nav-link[data-step="${i}"]`);
                        $tab.addClass('tab-alert');
                        setTimeout(() => $tab.removeClass('tab-alert'), 1500);
                    }
                }
                
                // Only allow submission if current step and all previous steps are completed
                if (allStepsCompleted) {
                    // Add loading state
                    const $btn = $(this);
                    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
                    $btn.prop('disabled', true);
                    
                    // Submit the form
                    $modal.find('form').submit();
                } else {
                    // Visual feedback for validation failure
                    $(this).addClass('btn-shake');
                    setTimeout(() => $(this).removeClass('btn-shake'), 500);
                    
                    // Highlight missing required fields on current step
                    highlightMissingFields(currentStep);
                }
            });
            
            // Highlight missing required fields in a step
            function highlightMissingFields(stepIndex) {
                const $step = $modal.find(`.wizard-step[data-step="${stepIndex}"]`);
                const $requiredFields = $step.find('[required]');
                
                $requiredFields.each(function() {
                    if (!isFieldCompleted(this)) {
                        $(this).addClass('is-invalid');
                        // Add a small shake to the field
                        $(this).addClass('field-shake');
                        setTimeout(() => $(this).removeClass('field-shake'), 600);
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
            }
            
            // Highlight missing required fields in a step
            function highlightMissingFields(stepIndex) {
                const $step = $modal.find(`.wizard-step[data-step="${stepIndex}"]`);
                const $requiredFields = $step.find('[required]');
                
                $requiredFields.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        // Add a small shake to the field
                        $(this).addClass('field-shake');
                        setTimeout(() => $(this).removeClass('field-shake'), 600);
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
            }
            
            // Step navigation tabs with strict linear progression
            $modal.find('.wizard-navigation .nav-link').on('click', function() {
                const stepIndex = parseInt($(this).data('step'));
                
                // Strict check: Only allow navigation to accessible steps
                if (canAccessStep(stepIndex)) {
                    currentStep = stepIndex;
                    showWizardStep(currentStep);
                    updateNavigationState();
                    // Scroll to top of form
                    $modal.find('.modal-body').scrollTop(0);
                } else {
                    // Visual feedback that step is not accessible
                    $(this).addClass('nav-link-shake');
                    setTimeout(() => $(this).removeClass('nav-link-shake'), 500);
                    
                    // For future steps, show a message about completing current step first
                    if (stepIndex > currentStep) {
                        // Show a message about completing the current step first
                        alert("Please complete the current step before proceeding.");
                    }
                }
            });
            
            // Attach listeners to form fields to update validation state in real-time
            function attachFieldListeners() {
                $modal.find('input, select, textarea').on('change input blur', function() {
                    // Update button states based on current step completion
                    updateNavigationState();
                    
                    // Remove invalid state when user interacts with the field
                    $(this).removeClass('is-invalid');
                });
            }
            
            // Initialize field listeners
            attachFieldListeners();
            
            // Initial update of navigation state
            updateNavigationState();
        }
        
        // Function to organize form fields into step containers
        function organizeWizardSteps($content, steps) {
            // Create step containers
            steps.forEach((step, index) => {
                const $stepContainer = $(`<div class="wizard-step" data-step="${index}" style="display: none;"></div>`);
                
                // Add step title
                $stepContainer.append(`<h4>${step.title}</h4>`);
                
                // Find and move fields to this step
                if (step.fields && step.fields.length) {
                    step.fields.forEach(fieldSelector => {
                        // Find the field container (usually a div.col-*)
                        const $field = $content.find(fieldSelector).closest('.col-md-12, .col-md-8, .col-md-6, .col-md-4, .col-md-3');
                        if ($field.length) {
                            $stepContainer.append($field);
                        }
                    });
                } else if (step.selector) {
                    // Alternative: use a CSS selector to find elements
                    const $fields = $content.find(step.selector);
                    $stepContainer.append($fields);
                }
                
                $content.append($stepContainer);
            });
        }
        
        // Function to show a specific wizard step with enhanced UI updates
        function showWizardStep(stepIndex) {
            const $modal = $(`#${modalId}`);
            const totalSteps = wizardSteps.length;
            
            // Hide all steps
            $modal.find('.wizard-step').hide();
            
            // Show current step
            $modal.find(`.wizard-step[data-step="${stepIndex}"]`).show().addClass('active');
            
            // Update navigation buttons
            $modal.find('.wizard-prev').toggle(stepIndex > 0);
            $modal.find('.wizard-next').toggle(stepIndex < totalSteps - 1);
            $modal.find('.wizard-submit').toggle(stepIndex === totalSteps - 1);
            
            // Update progress bar with animation
            const progress = ((stepIndex + 1) / totalSteps) * 100;
            $modal.find('.progress-bar')
                .css('width', `${progress}%`)
                .attr('aria-valuenow', progress);
            
            // Update navigation pills and mark completed steps
            $modal.find('.wizard-navigation .nav-link').removeClass('active completed');
            
            // Mark all previous steps as completed
            for (let i = 0; i < stepIndex; i++) {
                $modal.find(`.wizard-navigation .nav-link[data-step="${i}"]`).addClass('completed');
            }
            
            // Mark current step as active
            $modal.find(`.wizard-navigation .nav-link[data-step="${stepIndex}"]`).addClass('active');
            
            // Update document title with current step
            const stepTitle = wizardSteps[stepIndex].title;
            $modal.find('.modal-title').text(`${title} - ${stepTitle}`);
            
            // Make sure numbers are always visible (fix for completed steps)
            $modal.find('.wizard-step-number').show();
            
            // Update connectors for completed steps
            updateStepConnectors();
        }
        
        // Function to update step connectors based on completed steps
        function updateStepConnectors() {
            const $modal = $(`#${modalId}`);
            const $completedLinks = $modal.find('.wizard-navigation .nav-link.completed');
            
            $completedLinks.each(function() {
                const $connector = $(this).find('.wizard-step-connector');
                if ($connector.length) {
                    $connector.css('background-color', '#0d6efd');
                }
            });
        }
        
        // Function to validate a specific step
        function validateStep(stepIndex) {
            const $modal = $(`#${modalId}`);
            const $step = $modal.find(`.wizard-step[data-step="${stepIndex}"]`);
            const $requiredFields = $step.find('[required]');
            let isValid = true;
            
            $requiredFields.each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            return isValid;
        }

        // Rest of the original function...
        function openModalFromUrl() {
            if (!hash) return;
            
            const urlParams = new URLSearchParams(window.location.search);
            const recordId = urlParams.get("id");
            const type = urlParams.get("type");

            if (recordId && type === calcModalType) {
                openModal(recordId);
            }
        }

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
            $(window).on("popstate", function () {
                openModalFromUrl();
            });

            $(`#${modalId}`).on("hidden.bs.modal", function () {
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.delete("id");
                currentUrl.searchParams.delete("type");

                const newUrl = `${currentUrl.pathname}${currentUrl.search}${window.location.hash}`;
                history.pushState(null, null, newUrl);
            });
        }

        openModalFromUrl();

        if (includeForm) {
            const modalElement = $(`#${modalId}`);
            const submitBtn = isWizard ? modalElement.find('.wizard-submit') : modalElement.find('button[type="submit"]');
            
            // CSS will be added manually in the header
            
            modalElement.find('form').on('submit', async function(e) {
                e.preventDefault();
                const form = this;
                
                if (form.isSubmitting) {
                    return false;
                }
                
                form.isSubmitting = true;
                const formData = new FormData(form);
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
                }
            });
        }

        if (modalId.length) {
            resolve(modalId);
        }
    });
}