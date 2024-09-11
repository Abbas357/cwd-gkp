function previewImage(event, previewId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = "block";
        output.classList.add('previewImage')
    };
    reader.readAsDataURL(event.target.files[0]);
}

function showMessage(message, type = "success", options = {}) {
    Swal.fire({
        position: "top-end",
        icon: type,
        title: message,
        showConfirmButton: options.showConfirmButton || false,
        timer: options.timer || 2000,
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
            "Accept": "application/json",
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
            options.body = data instanceof FormData ? data : JSON.stringify(data);
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
    $('.form-error').remove();
    setButtonLoading($('button[type="submit"]'), false);

    for (const field in errors) {
        const errorMessages = errors[field];
        const input = $(`[name="${field}"]`);

        errorMessages.forEach(message => {
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

    const formElement = button.closest('form');
    const originalText = button.val() || button.html();
    console.log(originalText)

    if (isLoading) {
        if (formElement.length) {
            formElement.addClass('disabled-form');
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
            formElement.removeClass('disabled-form');
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
        resizeMode: 'overflow',
        postbackSafe: true,
        useLocalStorage: true,
        gripInnerHtml: "<div class='grip'></div>",
        draggingClass: "dragging"
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

$('div.modal').on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});