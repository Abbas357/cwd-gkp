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
                alert(result.success || successMessage);
                return true;
            }
        } else {
            alert(
                result.error || errorMessage || "An unexpected error occurred",
                "error"
            );
            return false;
        }
    } catch (error) {
        alert(
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
    modalHeight = "70vh"
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
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Closse">Cancel</button>
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
            const urlParams = new URLSearchParams(window.location.search);
            const recordId = urlParams.get("id");
            const type = urlParams.get("type");

            if (recordId && type === calcModalType) {
                openModal(recordId);
            }
        }

        $(document).on("click", btnSelector, function () {
            const recordId = $(this).data("id");
            const currentUrl = new URL(window.location);

            const newUrl = `${currentUrl.pathname}?id=${recordId}&type=${calcModalType}${window.location.hash}`;
            history.pushState(null, null, newUrl);
            openModal(recordId, calcModalType);
        });

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

        openModalFromUrl();

        if (modalId.length) {
            resolve(modalId);
        }
    });
}

(function ($) {
    "use strict";

    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);

   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 100, 'easeInOutExpo');
        return false;
    }); 

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

})(jQuery);

(() => {
    const buttons = document.querySelectorAll(".cw-btn");

    buttons.forEach(button => {
        const iconClass = button.getAttribute("data-icon");
        if (iconClass) {
            button.innerHTML = `<i class="${iconClass}"></i>${button.textContent.trim()}`;
        }
    });
})();

(() => {
    function loadZuckLibraries(callback) {
        if (!document.getElementById('zuck-css')) {
            let cssLink = document.createElement('link');
            cssLink.id = 'zuck-css';
            cssLink.rel = 'stylesheet';
            cssLink.href = "/site/lib/zuck/css/zuck.min.css";
            document.head.appendChild(cssLink);
        }

        if (!document.getElementById('zuck-js')) {
            let scriptTag = document.createElement('script');
            scriptTag.id = 'zuck-js';
            scriptTag.src = "/site/lib/zuck/js/zuck.min.js";
            scriptTag.onload = callback;
            document.body.appendChild(scriptTag);
        } else {
            callback();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        let btn = document.querySelector('#view-stories');
        let contentSeenItems = JSON.parse(localStorage.getItem('zuck-stories-content-seenItems') || '{}');
        let seenUserIds = Object.keys(contentSeenItems);

        fetch("/stories", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ seenUserIds })
            })
            .then(response => {
                if (!response.ok) {
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    btn.classList.remove('stories-indicator');
                    return;
                }

                if (data.success && Array.isArray(data.data?.result)) {
                    let storiesData = data.data.result;

                    if (Array.isArray(data.expiredUsers) && data.expiredUsers.length > 0) {
                        data.expiredUsers.forEach(userId => {
                            delete contentSeenItems[userId];
                        });
                        localStorage.setItem('zuck-stories-content-seenItems', JSON.stringify(contentSeenItems));
                    }

                    let unviewedSeenItems = JSON.parse(localStorage.getItem('zuck-unviewed-stories-seenItems') || '{}');

                    storiesData.sort((a, b) => {
                        let aViewed = unviewedSeenItems[a.id] || contentSeenItems[a.id] || false;
                        let bViewed = unviewedSeenItems[b.id] || contentSeenItems[b.id] || false;

                        return aViewed === bViewed ? 0 : aViewed ? 1 : -1;
                    });

                    if (storiesData.some(story => !contentSeenItems[story.id])) {
                        btn.classList.add('stories-indicator');
                    } else {
                        btn.classList.remove('stories-indicator');
                    }
                } else {
                    btn.classList.remove('stories-indicator');
                }
            })
            .catch(error => {
                console.warn('No stories or server error occurred:', error);
                btn.classList.remove('stories-indicator');
            });
    });

    document.querySelector('#view-stories').addEventListener('click', function(e) {
        let btn = document.querySelector('#view-stories');
        if (btn.classList.contains('stories-indicator')) {
            btn.classList.remove('stories-indicator');
        }
        let storiesContent = document.querySelector('#stories-content');
        let spinner = document.querySelector('#stories-spinner');
        let errorMessage = "<div class='alert alert-warning' role='alert' style='margin-bottom:0px'>There are currently no stories</div>";

        loadZuckLibraries(function() {
            storiesContent.classList.remove('d-none');
            spinner.classList.add('show');

            let contentSeenItems = localStorage.getItem('zuck-stories-content-seenItems');
            contentSeenItems = contentSeenItems ? JSON.parse(contentSeenItems) : {};

            let seenUserIds = Object.keys(contentSeenItems);

            fetch("/stories", {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                    , body: JSON.stringify({
                        seenUserIds: seenUserIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    spinner.classList.remove('show');
                    if (data.success) {
                        let storiesData = data.data.result;

                        if (data.expiredUsers && data.expiredUsers.length > 0) {
                            data.expiredUsers.forEach(userId => {
                                delete contentSeenItems[userId];
                            });
                            localStorage.setItem('zuck-stories-content-seenItems', JSON.stringify(contentSeenItems));
                        }

                        storiesContent.innerHTML = '';

                        let unviewedSeenItems = localStorage.getItem('zuck-unviewed-stories-seenItems');
                        contentSeenItems = localStorage.getItem('zuck-stories-content-seenItems');

                        unviewedSeenItems = unviewedSeenItems ? JSON.parse(unviewedSeenItems) : {};
                        contentSeenItems = contentSeenItems ? JSON.parse(contentSeenItems) : {};

                        storiesData.sort((a, b) => {
                            let aViewed = unviewedSeenItems[a.id] || contentSeenItems[a.id] || false;
                            let bViewed = unviewedSeenItems[b.id] || contentSeenItems[b.id] || false;

                            if (aViewed && !bViewed) return 1;
                            if (!aViewed && bViewed) return -1;
                            return 0;
                        });
                        const zuckInstance = new Zuck(storiesContent, {
                            backNative: true
                            , autoFullScreen: false
                            , skin: 'snapgram'
                            , avatars: true
                            , list: false
                            , cubeEffect: true
                            , localStorage: true
                            , reactive: false
                            , stories: storiesData
                            , callbacks: {
                                onView: function(storyId, callback) {
                                    incrementViewCount(storyId);
                                    if (typeof callback === 'function') {
                                        callback();
                                    }
                                }
                                , onClose: function(storyId, callback) {
                                    callback();
                                }
                                , onOpen: function(storyId, callback) {
                                    callback();
                                }
                                , onNextItem: function(storyId, currentItem, callback) {
                                    callback();
                                }
                                , onEnd: function(storyId, callback) {
                                    callback();
                                }
                                , onNavigateItem: function(storyId, direction, callback) {
                                    callback();
                                }
                                , onDataUpdate: function(storyId, callback) {
                                    callback();
                                }
                            }
                        });

                        storiesContent.zuckInstance = zuckInstance;

                        function incrementViewCount(storyId) {
                            fetch(`/stories/viewed/${storyId}`, {
                                    method: 'PATCH'
                                    , headers: {
                                        'Content-Type': 'application/json'
                                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                        }

                    } else {
                        storiesContent.innerHTML = errorMessage;
                    }
                })
                .catch(error => {
                    spinner.classList.remove('show');
                    storiesContent.innerHTML = errorMessage;
                });
        });
    });

    document.querySelector('#storiesCanvas').addEventListener('hidden.bs.offcanvas', function() {
        let storiesContent = document.querySelector('#stories-content');

        storiesContent.innerHTML = `
        <div id="stories-spinner" class="show bg-white d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
        storiesContent.classList.add('d-none');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modalContainer = document.getElementById('modal-container');
        let currentPage = 1;
        let isLoading = false;
        let hasMorePages = true;

        const announcementSeen = sessionStorage.getItem('announcement_seen');
        const notificationsSeen = sessionStorage.getItem('notifications_seen');

        modalContainer.innerHTML = `
            <div id="news-modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background: #ffffffdd">
                        <div class="modal-header" style="background-color: #ff660010 !important">
                            <h5 class="modal-title"><i class="bi-megaphone"></i> &nbsp; Notifications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-between align-items-center mb-1" style="margin-top:-4px">
                                <div class="flex-grow-1 me-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" id="search-notifications" class="form-control" style="border-radius: 3px; padding: .4rem .8rem" placeholder="Search..." />
                                    </div>
                                </div>
                                <div>
                                    <select id="filter-notifications" class="form-select" style="border-radius: 3px; padding: .4rem .8rem; min-width: 150px;">
                                        <option value="">All</option>
                                        <option value="Tender">Tenders</option>
                                        <option value="Gallery">Galleries</option>
                                        <option value="Event">Events</option>
                                        <option value="News">News</option>
                                        <option value="Seniority">Seniorities</option>
                                    </select>
                                </div>
                            </div>
                            <div id="modal-body-content" class="custom-scrollbar" style="height: 400px; overflow-y: auto;">
                                <div id="notification-list"></div>
                                <div id="loading-indicator" class="d-flex justify-content-center my-3">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center w-100" style="padding: 2px !important; background-color: #ff660010 !important">
                            <div><a href="/notifications/all">All Notifications</a></div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.addEventListener('DOMContentLoaded', ()=> {
            const scrollableElements = document.querySelectorAll('.custom-scrollbar');
        
            scrollableElements.forEach(element => {
                let timeout;
                
                element.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                element.style.scrollbarWidth = 'thin';
                element.style.scrollbarColor = 'rgba(0, 0, 0, 0.2) transparent';
                });
                
                element.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    element.style.scrollbarWidth = 'none';
                    element.style.scrollbarColor = 'transparent transparent';
                }, 1000);
                });
                
                const contentWidth = element.offsetWidth;
                element.style.width = `${contentWidth}px`;
            });
        });

        const newsModal = new bootstrap.Modal(document.getElementById('news-modal'));
        const notificationList = document.getElementById('notification-list');
        const loadingIndicator = document.getElementById('loading-indicator');
        const modalBodyContent = document.getElementById('modal-body-content');
        const searchInput = document.getElementById('search-notifications');
        const filterDropdown = document.getElementById('filter-notifications');
        
        searchInput.addEventListener('input', handleSearchOrFilter);
        filterDropdown.addEventListener('change', handleSearchOrFilter);

        function handleSearchOrFilter() {
            currentPage = 1; 
            notificationList.innerHTML = '';
            loadingIndicator.innerHTML = `<div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>`;
            hasMorePages = true;
            fetchNotifications(currentPage);
        }

        if (!notificationsSeen) {
            fetchNotifications(currentPage);
            newsModal.show();
        }

        if (!announcementSeen) {
            fetchAnnouncement();
        }

        function fetchAnnouncement() {
            fetch('/notifications')
                .then(response => response.json())
                .then(data => {
                    const { announcement } = data;

                    if (announcement) {
                        modalContainer.innerHTML += `
                            <div id="announcement-modal" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">${announcement.title}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <a href="/pages/Announcement">
                                                <img src="${announcement.image}" style="width:100%" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        sessionStorage.setItem('announcement_seen', true);
                        const announcementModal = new bootstrap.Modal(document.getElementById('announcement-modal'));
                        announcementModal.show();
                    }
                });
        }

        function fetchNotifications(page) {
            if (isLoading || !hasMorePages) return;

            isLoading = true;
            const searchQuery = searchInput.value.trim();
            const selectedType = filterDropdown.value;
            showLoadingIndicator(true);

            fetch(`/notifications?page=${page}&search=${encodeURIComponent(searchQuery)}&type=${selectedType}`)
                .then(response => response.json())
                .then(data => {
                    const { notifications, nextPage, hasMore } = data;

                    if (notifications.length) {
                        appendNotifications(notifications);
                    }

                    currentPage = nextPage || currentPage;
                    hasMorePages = hasMore;
                    isLoading = false;
                    sessionStorage.setItem('notifications_seen', true);

                    if (!hasMore) {
                        showLoadingIndicator(false);
                        displayEndOfNotificationsMessage();
                    }
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                    isLoading = false;
                    showLoadingIndicator(false);
                });
        }

        function appendNotifications(notifications) {
            const notificationItems = notifications.map(item => `
                <div class="d-flex align-items-center p-2 notification-item">
                    <i class="bi ${item.info[0]} ${item.recentNotification ? 'notification-icon' : ''} me-3 fs-3 px-2 py-0 rounded" style="background: ${item.info[2]}"></i>
                    <div>
                        <a href="${item.url}">${item.title}</a>
                    </div>
                    <small class="news-date text-muted d-flex flex-column align-items-end" style="margin-left:auto">
                        <div class="mb-1">
                            <a href="${item.info[3]}" class="badge text-bg-primary" style="font-size: 10px; display: inline-block">${item.info[1]}</a>
                        </div>
                        <span class="fw-bold" style="font-size:.7rem">${item.created_at}</span>
                    </small>
                </div>
            `).join('');

            notificationList.innerHTML += notificationItems;
        }

        function showLoadingIndicator(show) {
            loadingIndicator.style.display = show ? 'flex' : 'none';
        }

        function displayEndOfNotificationsMessage() {
            loadingIndicator.innerHTML = `
                <span class="text-muted">No more notifications</span>
            `;
        }

        modalBodyContent.addEventListener('scroll', () => {
            if (modalBodyContent.scrollTop + modalBodyContent.clientHeight >= modalBodyContent.scrollHeight - 50) {
                fetchNotifications(currentPage);
            }
        });
    });

})();

document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.createElement('button');
    themeToggle.id = 'theme-toggle';
    themeToggle.className = 'position-fixed';
    themeToggle.style.cssText = 'right: 0; top: 33vh; z-index: 1040; color: white; border: none; padding: .3rem .5rem; border-radius: 5px; cursor: pointer;';

    const icon = document.createElement('i');
    icon.className = 'bi bi-palette';
    icon.style.fontSize = '1.5rem';
    themeToggle.appendChild(icon);

    const offcanvas = document.createElement('div');
    offcanvas.className = 'offcanvas offcanvas-end';
    offcanvas.id = 'themeCanvas';
    offcanvas.setAttribute('tabindex', '-1');
    offcanvas.setAttribute('aria-labelledby', 'themeCanvasLabel');

    const themeOptions = [
        {
            name: 'default',
            color: '#0b7240',
            title: 'Default Theme',
            description: 'Original green color theme'
        },
        {
            name: 'brown',
            color: '#855723',
            title: 'Brown Theme',
            description: 'Warm brown theme'
        },
        {
            name: 'blue',
            color: '#1e4d8c',
            title: 'Blue Theme',
            description: 'Dark blue theme'
        },
        {
            name: 'violet',
            color: '#8f2bbc',
            title: 'Violet Theme',
            description: 'Amazing Violet theme'
        },
        {
            name: 'darkred',
            color: '#af0606',
            title: 'Dark Red Theme',
            description: 'Pure Dark Red theme'
        }
    ];

    offcanvas.innerHTML = `
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="themeCanvasLabel">Choose Theme</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex flex-column gap-3">
                ${themeOptions.map(theme => `
                    <div class="theme-option p-3 rounded" onclick="applyTheme('${theme.name}')" 
                        style="cursor: pointer; border: 1px solid #ddd;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div style="width: 25px; height: 25px; background-color: ${theme.color}; border-radius: 50%;"></div>
                            <h6 class="mb-0">${theme.title}</h6>
                        </div>
                        <small class="text-muted">${theme.description}</small>
                    </div>
                `).join('')}
            </div>
        </div>
    `;

    document.body.appendChild(themeToggle);
    document.body.appendChild(offcanvas);

    window.applyTheme = function(themeName) {
        let themeLink = document.getElementById('theme-stylesheet');
        
        if (themeName === 'default') {
            if (themeLink) {
                themeLink.remove();
            }
        } else {
            if (!themeLink) {
                themeLink = document.createElement('link');
                themeLink.id = 'theme-stylesheet';
                themeLink.rel = 'stylesheet';
                const styleSheet = document.querySelector('link[href*="style.min.css"]');
                if (styleSheet) {
                    styleSheet.parentNode.insertBefore(themeLink, styleSheet.nextSibling);
                } else {
                    document.head.appendChild(themeLink);
                }
            }
            themeLink.href = `/site/css/themes/${themeName}.css`;
        }

        localStorage.setItem('selectedTheme', themeName);
        window.themeCanvas.hide();
        applyThemeColorToButton();
    };

    function applyThemeColorToButton() {
        const button = document.getElementById('theme-toggle');
        const selectedTheme = localStorage.getItem('selectedTheme') || 'default';
        const themeOption = themeOptions.find(t => t.name === selectedTheme);
        if (button && themeOption) {
            button.style.backgroundColor = themeOption.color;
        }
    }

    window.themeCanvas = new bootstrap.Offcanvas(document.getElementById('themeCanvas'));

    themeToggle.addEventListener('click', () => {
        window.themeCanvas.show();
    });

    applyThemeColorToButton();
});