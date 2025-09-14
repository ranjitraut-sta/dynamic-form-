/*
|------------------------------------------------------------------
| File Upload Wrapper
|------------------------------------------------------------------
| - Image Preview Functionality
| - Return Image File If Validation Error
*/
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".file-upload-wrapper").forEach((wrapper) => {
        const previewImg = wrapper.querySelector(".preview-img");
        const pdfPreviewLink = wrapper.querySelector(".pdf-preview-link");
        const deleteBtn = wrapper.querySelector(".delete-btn");
        const placeholder = wrapper.querySelector(".upload-placeholder");
        const input = wrapper.querySelector(".file-input");

        // Initialize UI state
        function updateUI() {
            if (
                previewImg &&
                previewImg.src &&
                previewImg.style &&
                previewImg.style.display !== "none"
            ) {
                deleteBtn.style.display = "block";
                placeholder.style.display = "none";
                if (pdfPreviewLink && pdfPreviewLink.style)
                    pdfPreviewLink.style.display = "none";
                previewImg.style.display = "block";
            } else if (
                pdfPreviewLink &&
                pdfPreviewLink.style &&
                pdfPreviewLink.style.display !== "none"
            ) {
                deleteBtn.style.display = "block";
                placeholder.style.display = "none";
                if (previewImg && previewImg.style)
                    previewImg.style.display = "none";
                pdfPreviewLink.style.display = "block";
            } else {
                deleteBtn.style.display = "none";
                placeholder.style.display = "block";
                if (previewImg && previewImg.style)
                    previewImg.style.display = "none";
                if (pdfPreviewLink && pdfPreviewLink.style)
                    pdfPreviewLink.style.display = "none";
            }
        }
        updateUI();

        input.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) {
                updateUI();
                return;
            }

            const fileType = file.type;

            if (fileType === "application/pdf") {
                // Remove image preview
                if (previewImg) previewImg.style.display = "none";

                // Remove existing PDF preview link if any
                if (pdfPreviewLink) pdfPreviewLink.remove();

                // Create new pdf preview link
                const newPdfLink = document.createElement("a");
                newPdfLink.href = URL.createObjectURL(file);
                newPdfLink.target = "_blank";
                newPdfLink.className = "pdf-preview-link";
                newPdfLink.style.cssText =
                    "display: block; width: 100%; height: 100%; text-align: center; padding-top: 80px; font-weight: bold; text-decoration: none; color: #555; background: #f7f7f7;";
                newPdfLink.textContent = "📄 View PDF";

                wrapper.insertBefore(newPdfLink, deleteBtn);

                placeholder.style.display = "none";
                deleteBtn.style.display = "block";
            } else if (fileType.startsWith("image/")) {
                // Remove PDF preview link if exists
                if (pdfPreviewLink) pdfPreviewLink.remove();

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = "block";
                    }
                };
                reader.readAsDataURL(file);

                placeholder.style.display = "none";
                deleteBtn.style.display = "block";
            } else {
                alert("Only JPG, PNG, or PDF files are allowed.");
                this.value = "";
                updateUI();
                return;
            }
        });

        deleteBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            input.value = "";
            // Remove PDF preview if any
            const pdfLink = wrapper.querySelector(".pdf-preview-link");
            if (pdfLink) pdfLink.remove();

            // Hide image preview
            if (previewImg) {
                previewImg.src = "#";
                previewImg.style.display = "none";
            }
            deleteBtn.style.display = "none";
            placeholder.style.display = "block";
        });
    });
});
/*
|------------------------------------------------------------------
| Global Reset Button
|------------------------------------------------------------------
| - Reset button ko click gareko bhane, form ma clear garcha
| - URL ko query params ma clear garcha
*/
document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("#globalResetBtn, .globalResetBtn")
        .forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();

                const form = btn.closest("form");
                if (!form) return;

                form.reset();

                form.querySelectorAll("input, select, textarea").forEach(
                    (input) => {
                        if (input.type !== "hidden") input.value = "";
                    }
                );

                // Clean URL (remove query params)
                history.replaceState(
                    {},
                    "",
                    window.location.origin + window.location.pathname
                );

                // Fetch and update result
                fetch(
                    form.action + "?" + new URLSearchParams(new FormData(form)),
                    {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                    }
                )
                    .then((res) => res.text())
                    .then((html) => {
                        document.getElementById("resultArea").innerHTML = html;
                    });
            });
        });
});

/*
|------------------------------------------------------------------
| Global Short By
|------------------------------------------------------------------
| - Sort button ko click gareko bhane
| - URL ko query params ma sort garcha
*/
document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    let currentSortBy = urlParams.get("sortBy") || "";
    let currentSortDir = urlParams.get("sortDir") || "asc";

    // Update sort arrow on page load
    document
        .querySelectorAll("thead.sortable-headers th[data-sort]")
        .forEach((th) => {
            const sortField = th.dataset.sort;
            if (sortField === currentSortBy) {
                th.classList.add(
                    currentSortDir === "asc" ? "sort-asc" : "sort-desc"
                );
            }
        });

    // Add click event to each sortable header
    document
        .querySelectorAll("thead.sortable-headers th[data-sort]")
        .forEach((th) => {
            th.addEventListener("click", () => {
                const sortField = th.dataset.sort;
                let newSortDir = "asc";

                if (currentSortBy === sortField) {
                    newSortDir = currentSortDir === "asc" ? "desc" : "asc";
                }

                urlParams.set("sortBy", sortField);
                urlParams.set("sortDir", newSortDir);
                urlParams.set("page", 1); // reset to page 1 on sort

                window.location.search = urlParams.toString();
            });
        });
});

/*
|------------------------------------------------------------------
| Global column Manage
|------------------------------------------------------------------
| - Column manage button ko click gareko bhane
| - URL ko check box ra drag gareko
| - URL ko query params ma column garcha
| - checked garera saved garyo vani tyo part hide hunxa
| - reset click garro vani purano abastha ma aauxa
| - tyo user le unchecked na gare samma field dekhidain

*/
$(document).ready(function () {
    let currentTableId = null;
    let columnsState = [];
    let draggedItem = null;

    const modal = $("#columnModal");
    const columnList = $("#columnList");

    function getStorageKey() {
        return `${currentTableId}_columnPreferences`;
    }

    function loadPreferences() {
        const saved = localStorage.getItem(getStorageKey());
        if (saved) {
            try {
                return JSON.parse(saved);
            } catch {
                return null;
            }
        }
        return null;
    }

    function savePreferences() {
        localStorage.setItem(getStorageKey(), JSON.stringify(columnsState));
    }

    function initializeColumnsState(table) {
        columnsState = [];

        const savedPreferences = loadPreferences();

        table.find("thead th").each(function () {
            let key = $(this).attr("data-sort");
            if (!key) {
                key = $(this).text().trim().toLowerCase().replace(/\s+/g, "_");
            }
            if (!key) return;

            let visible = true;

            if (savedPreferences) {
                const matched = savedPreferences.find((c) => c.key === key);
                if (matched) {
                    visible = matched.visible;
                }
            }

            columnsState.push({
                key: key,
                label: $(this).text().trim(),
                visible: visible,
            });
        });

        // reorder if saved preferences exist
        if (savedPreferences) {
            const ordered = [];
            savedPreferences.forEach((pref) => {
                const match = columnsState.find((c) => c.key === pref.key);
                if (match) ordered.push(match);
            });
            if (ordered.length) columnsState = ordered;
        }
    }

    function generateColumnList() {
        columnList.empty();
        columnsState.forEach((col) => {
            const li = $(`<li class="amd-table8-column-item" data-column-key="${
                col.key
            }" draggable="true"
                    style="cursor: move; padding: 8px; border: 1px solid #ddd; margin-bottom: 4px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex-grow:1;">
                        <input type="checkbox" class="amd-table8-column-checkbox" id="col-${
                            col.key
                        }" ${col.visible ? "checked" : ""}>
                        <label for="col-${
                            col.key
                        }" style="margin-left: 8px; user-select:none;">${
                col.label
            }</label>
                    </div>
                    <div class="amd-table8-drag-handle" style="cursor: grab; padding-left: 10px;">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                </li>`);

            li.find('input[type="checkbox"]').on("change", function () {
                updateColumnVisibilityInState(col.key, this.checked);
                toggleColumnVisibility(col.key, this.checked);
            });

            columnList.append(li);
        });
    }

    function updateColumnVisibilityInState(key, visible) {
        const col = columnsState.find((c) => c.key === key);
        if (col) col.visible = visible;
    }

    function toggleColumnVisibility(key, visible) {
        const table = $(`#${currentTableId}`);
        const index = getColumnIndexByKey(key, table);
        if (index === -1) return;

        table.find("thead tr").each(function () {
            $(this).find("th").eq(index).toggle(visible);
        });

        table.find("tbody tr").each(function () {
            $(this).find("td").eq(index).toggle(visible);
        });
    }

    function getColumnIndexByKey(key, table) {
        let index = -1;
        table.find("thead th").each(function (i) {
            let colKey = $(this).attr("data-sort");
            if (!colKey) {
                colKey = $(this)
                    .text()
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, "_");
            }
            if (colKey === key) {
                index = i;
                return false;
            }
        });
        return index;
    }

    function reorderTableColumns(order) {
        const table = $(`#${currentTableId}`);
        const keyIndexMap = {};

        table.find("thead th").each(function (index) {
            let key = $(this).attr("data-sort");
            if (!key) {
                key = $(this).text().trim().toLowerCase().replace(/\s+/g, "_");
            }
            keyIndexMap[key] = index;
        });

        table.find("thead tr, tbody tr").each(function () {
            const row = $(this);
            const cols = row.children("th, td").toArray();

            const newRow = [];
            order.forEach((key) => {
                const colIndex = keyIndexMap[key];
                if (colIndex !== undefined) {
                    newRow.push(cols[colIndex]);
                }
            });

            row.empty().append(newRow);
        });
    }

    window.applyColumnChanges = function () {
        const newOrder = [];
        const newVisibility = {};

        columnList.find(".amd-table8-column-item").each(function () {
            const key = $(this).data("column-key");
            newOrder.push(key);
            newVisibility[key] = $(this)
                .find('input[type="checkbox"]')
                .prop("checked");
        });

        columnsState = newOrder.map((key) => {
            const oldCol = columnsState.find((c) => c.key === key);
            return {
                key: key,
                label: oldCol ? oldCol.label : "",
                visible: newVisibility[key],
            };
        });

        reorderTableColumns(newOrder);
        columnsState.forEach((col) =>
            toggleColumnVisibility(col.key, col.visible)
        );

        savePreferences();
        closeColumnModal();
    };

    window.resetColumns = function () {
        localStorage.removeItem(getStorageKey());
        const table = $(`#${currentTableId}`);
        initializeColumnsState(table);
        generateColumnList();
        table.find("thead th, tbody td").show();
        const defaultOrder = columnsState.map((c) => c.key);
        reorderTableColumns(defaultOrder);
    };

    window.closeColumnModal = function () {
        modal.fadeOut();
    };

    $(".columnsBtn").on("click", function () {
        currentTableId = $(this).data("table-id");
        const table = $(`#${currentTableId}`);
        initializeColumnsState(table);
        generateColumnList();
        modal.css("display", "").addClass("show"); // 👈 fix
    });

    window.closeColumnModal = function () {
        modal.removeClass("show").css("display", ""); // 👈 fix
    };

    // Drag and Drop
    // Drag and Drop
    columnList.on("dragstart", ".amd-table8-column-item", function () {
        draggedItem = this;
        $(this).css("opacity", "0.4").addClass("dragging");
    });

    columnList.on("dragend", ".amd-table8-column-item", function () {
        $(this).css("opacity", "1");
        updateStateOrderFromUI();
        handleDragEnd(); // ✅ Call cleanup
    });

    columnList.on("dragover", ".amd-table8-column-item", function (e) {
        e.preventDefault();
        $(this).addClass("drag-over");
    });

    columnList.on("dragleave", ".amd-table8-column-item", function () {
        $(this).removeClass("drag-over");
    });

    columnList.on("drop", ".amd-table8-column-item", function (e) {
        e.preventDefault();
        $(this).removeClass("drag-over");

        if (draggedItem !== this) {
            if ($(draggedItem).index() < $(this).index()) {
                $(this).after(draggedItem);
            } else {
                $(this).before(draggedItem);
            }
        }
    });

    // 👇 This cleans up all leftover dragging classes (called on dragend)
    function handleDragEnd() {
        document.querySelectorAll(".amd-table8-column-item").forEach((item) => {
            item.classList.remove("dragging", "drag-over");
        });
    }

    function updateStateOrderFromUI() {
        const newOrder = [];
        columnList.find(".amd-table8-column-item").each(function () {
            newOrder.push($(this).data("column-key"));
        });
        columnsState = newOrder.map((key) =>
            columnsState.find((c) => c.key === key)
        );
        savePreferences();
    }

    // ** NEW: Apply saved preferences on page load automatically **
    $("[data-column-manage='true']").each(function () {
        const table = $(this);
        const tableId = table.attr("id");
        if (!tableId) return;

        currentTableId = tableId;
        initializeColumnsState(table);
        reorderTableColumns(columnsState.map((c) => c.key));
        columnsState.forEach((col) =>
            toggleColumnVisibility(col.key, col.visible)
        );
    });
});

/*
|------------------------------------------------------------------
| Global 1 Step Back Button
|------------------------------------------------------------------
| - Back button ko click gareko bhane
| - U1 step back hunxa
*/
$(document).ready(function () {
    $(".back-button").on("click", function (e) {
        debugger;
        e.preventDefault();
        window.history.back();
    });
});

/*
|------------------------------------------------------------------
| Global Validation Error Remove
|------------------------------------------------------------------
| - input field ko click gareko bhane
| - tesma kunai data field garepaxi red border hunxa tyo hataune
*/
$(document).ready(function () {
    // Input, Textarea, Select, Checkbox, Radio — sabai field ma kam garxa
    $(document).on("input change", "input, textarea, select", function () {
        const $field = $(this);

        // Remove is-invalid class if exists
        $field.removeClass("is-invalid");

        // Remove nearest error message with .text-danger
        const $formGroup = $field.closest(
            ".form-group, .form-check, .form-floating, .mb-3"
        ); // support diff wrappers
        $formGroup.find(".text-danger").fadeOut(200, function () {
            $(this).remove();
        });
    });
});

/*
|------------------------------------------------------------------
| Global Drag and Drop Reorder Table
|------------------------------------------------------------------
| - drag and drop anusar tesko position change gareko
| - tesma position change hunxa
*/
$(function () {
    $(".sortable-table").each(function () {
        const $tableBody = $(this);
        const updateUrl = $tableBody.data("sort-url");

        $tableBody
            .sortable({
                axis: "y",
                helper: function (e, tr) {
                    const $originals = tr.children();
                    const $helper = tr.clone();

                    $helper.children().each(function (index) {
                        $(this).width($originals.eq(index).width());
                    });

                    $helper.css({
                        background: "rgba(255, 255, 255, 0.2)",
                        "backdrop-filter": "blur(3px)",
                        "box-shadow": "0 8px 16px rgba(0,0,0,0.25)",
                        transform: "rotate(1deg)",
                        "border-radius": "8px",
                        "z-index": 1000,
                    });

                    return $helper;
                },
                cursor: "move",
                containment: "parent",
                update: function () {
                    const orderData = [];

                    $tableBody.find("tr").each(function (index) {
                        const id = $(this).data("id");
                        if (id !== undefined) {
                            orderData.push({
                                id: id,
                                display_order: index + 1,
                            });
                        }
                        // Realtime update of iteration number
                       $(this).find("td.serial-number").text(index + 1);
                    });

                    $.ajax({
                        url: updateUrl,
                        method: "GET", // If you want to update DB, POST/PUT is better
                        data: {
                            order: orderData,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            console.log("✅ Order updated successfully", res);
                        },
                        error: function (err) {
                            console.error("❌ Failed to update order", err);
                        },
                    });
                },
            })
            .disableSelection();
    });
});

/*
|------------------------------------------------------------------
| Global Bulk Selection and Actions(Delete any type of bulk)
|------------------------------------------------------------------
| - Bulk select/deselect functionality
| - Dynamic bulk action buttons
| - Configurable bulk operations
| - Bulk delete functionality
*/
$(function() {
    // Initialize bulk functionality for tables with bulk-enabled class
    $('.bulk-enabled').each(function() {
        const $tableWrapper = $(this); // bulk-enabled wrapper
        const $table = $tableWrapper.find('table');
        const bulkDeleteUrl = $tableWrapper.data('bulk-delete-url');

        // Bulk actions HTML
        const bulkActionsHtml = `
            <div class="bulk-actions mb-3" style="display: none;">
                <div class="d-flex align-items-center gap-2">
                    <span class="selected-count">0 selected</span>
                    <button type="button" class="btn btn-danger btn-sm" id="bulk-delete-btn">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" id="clear-selection">
                        Clear Selection
                    </button>
                </div>
            </div>
        `;

        // Insert before table
        $tableWrapper.prepend(bulkActionsHtml);

        // Select All
        $table.find('.checkedAll').on('change', function() {
            $table.find('.row-select').prop('checked', this.checked);
            updateBulkSelection($tableWrapper);
        });

        // Individual selection
        $table.find('.row-select').on('change', function() {
            updateBulkSelection($tableWrapper);
        });

        // Clear selection
        $tableWrapper.find('#clear-selection').on('click', function() {
            $table.find('.row-select, .checkedAll').prop('checked', false);
            updateBulkSelection($tableWrapper);
        });

        // Bulk delete
        $tableWrapper.find('#bulk-delete-btn').on('click', function() {
            const selectedIds = getSelectedIds($tableWrapper);
            if (!selectedIds.length) return;

            if (confirm(`Are you sure you want to delete ${selectedIds.length} selected records?`)) {
                submitBulkAction(bulkDeleteUrl, selectedIds, 'DELETE');
            }
        });
    });

    function updateBulkSelection($tableWrapper) {
        const $table = $tableWrapper.find('table');
        const selectedIds = getSelectedIds($tableWrapper);
        const totalRows = $table.find('.row-select').length;

        $tableWrapper.find('.selected-count').text(`${selectedIds.length} selected`);

        if (selectedIds.length) {
            $tableWrapper.find('.bulk-actions').show();
            $table.find('tbody tr').each(function() {
                const $row = $(this);
                $row.find('[name="bstable-actions"] .btn-danger')
                    .toggle(!$row.find('.row-select').is(':checked'));
            });
        } else {
            $tableWrapper.find('.bulk-actions').hide();
            $table.find('[name="bstable-actions"] .btn-danger').show();
        }

        $table.find('.checkedAll').prop('checked', selectedIds.length === totalRows && totalRows > 0);
    }

    function getSelectedIds($tableWrapper) {
        return $tableWrapper.find('.row-select:checked').map(function() {
            return $(this).val();
        }).get();
    }

    function submitBulkAction(actionUrl, ids, method = 'POST') {
        const form = $('<form>', { method: 'POST', action: actionUrl });

        form.append($('<input>', { type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content') }));
        if (method !== 'POST') {
            form.append($('<input>', { type: 'hidden', name: '_method', value: method }));
        }

        ids.forEach(id => {
            form.append($('<input>', { type: 'hidden', name: 'ids[]', value: id }));
        });

        $('body').append(form);
        form.submit();
    }
});


