function previewImage(event, previewId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}

function showMessage(type, message, options = {}) {
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
        const response = await fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: method !== "GET" ? JSON.stringify(data) : null,
        });

        const result = await response.json();

        if (result.success) {
            if (method === "GET") {
                return result.data;
            } else {
                showMessage("success", result.success || successMessage);
                return true;
            }
        } else {
            showMessage(
                "error",
                result.error || errorMessage || "An unexpected error occurred"
            );
            return false;
        }
    } catch (error) {
        showMessage(
            "error",
            errorMessage || "There was an error processing your request"
        );
        return false;
    }
}


function initDataTable(selector, options = {}) {
    const exportButtons = [
        {
            extend: "copy",
            text: `<span class="symbol-container">
                    <i class="material-symbols-outlined">content_copy</i>
                    &nbsp; Copy
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
            },
        },
        {
            extend: "csv",
            text: `<span class="symbol-container">
                    <i class="material-symbols-outlined">csv</i>
                    &nbsp; CSV
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
            },
        },
        {
            extend: "excel",
            text: `<span class="symbol-container">
                    <i class="material-symbols-outlined">grid_on</i>
                    &nbsp; Excel
                </span>`,
            exportOptions: {
                columns: ":visible:not(:last-child)",
            },
        },
        {
            extend: "print",
            text: `<span class="symbol-container">
                    <i class="material-symbols-outlined">print</i>
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
                $(selector).removeClass("data-table-loading");
                console.log(
                    "An error occurred while loading data: " + errorThrown
                );
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
                    0: "Custom Filteration",
                    _: "Custom Filteration (%d)",
                },
                clearAll: "Clear All Filters",
                button: `<span class="symbol-container">
                            <i class="material-symbols-outlined">filter_alt</i>
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
                                <i class="material-symbols-outlined">share</i>
                                &nbsp; Export
                            </span>`,
                        autoClose: true,
                        buttons: exportButtons,
                    },
                    {
                        extend: "colvis",
                        collectionLayout: "two-column",
                        text: `<span class="symbol-container">
                                <i class="material-symbols-outlined">visibility</i>
                                &nbsp; Columns
                            </span>`,
                    },
                    {
                        extend: "searchBuilder",
                        config: {
                            depthLimit: 2,
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
                                <i class="material-symbols-outlined">refresh</i>
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
            $(selector).addClass("data-table-loading");
        },
        drawCallback() {
            $(selector).removeClass("data-table-loading");
        },
    };

    const finalOptions = $.extend(true, {}, defaultOptions, options);
    return $(selector).DataTable(finalOptions);
}

function tabHashNavigation(config) {
    const { table, dataTableUrl, hashToParamsMap, tabToHashMap, defaultHash } =
        config;

    function buildQueryParams(params) {
        if (!params) return "";
        const queryParams = Object.entries(params)
            .filter(([key, value]) => value !== undefined)
            .map(
                ([key, value]) =>
                    `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
            )
            .join("&");
        return queryParams ? "?" + queryParams : "";
    }

    function updateDataTableURL(params) {
        let queryParams = buildQueryParams(params);
        let tableData = dataTableUrl + queryParams;
        table.ajax.url(tableData).load();
    }

    function activateTab(tabId) {
        $('.nav-tabs a[href="' + tabId + '"]').tab("show");
        $(".tab-pane").removeClass("active show");
        $(tabId).addClass("active show");
    }

    $(".nav-tabs a").on("click", function () {
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
