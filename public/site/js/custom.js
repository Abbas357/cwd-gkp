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

(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);

    // Sticky Navbar
    // $(window).scroll(function () {
    //     if ($(this).scrollTop() > 45) {
    //         $('.navbar').addClass('sticky-top shadow-sm');
    //     } else {
    //         $('.navbar').removeClass('sticky-top shadow-sm');
    //     }
    // });

    $(".module-carousel").owlCarousel({
        autoplay: false, 
        smartSpeed: 1000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2
            },
            576: {
                items: 3
            },
            768: {
                items: 4
            },
            992: {
                items: 5
            },
            1200: {
                items: 6
            }
        }
    });

    // team carousel
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            },
            1200:{
                items:5
            }
        }
    });

   // Back to top button
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