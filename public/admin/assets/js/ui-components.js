// Button JS here
$(document).ready(function () {
    $(".amd-action-btn").each(function () {
        var $button = $(this);
        var defaultIconClass = $button.data("default-icon");
        var defaultText = $button.data("default-text");
        var loadingIconClass = $button.data("loading-icon");
        var loadingText = $button.data("loading-text");
        var successIconClass = $button.data("success-icon");
        var successText = $button.data("success-text");
        var errorIconClass = $button.data("error-icon");
        var errorText = $button.data("error-text");

        $button.on("click", function () {
            if ($button.hasClass("is-loading") || $button.prop("disabled")) {
                return;
            }

            var originalContent = $button.html();

            $button
                .addClass("is-loading")
                .html(`<i class="${loadingIconClass}"></i> ${loadingText}`)
                .prop("disabled", true);

            var simulateSuccess = Math.random() > 0.3; // 70% success rate
            var randomDelay = Math.random() * 1500 + 1000;

            setTimeout(function () {
                $button.removeClass("is-loading");
                if (simulateSuccess) {
                    $button
                        .addClass("is-success")
                        .html(
                            `<i class="${successIconClass}"></i> ${successText}`
                        );
                    setTimeout(function () {
                        $button
                            .removeClass("is-success")
                            .html(originalContent)
                            .prop("disabled", false);
                    }, 1500);
                } else {
                    $button
                        .addClass("is-error")
                        .html(`<i class="${errorIconClass}"></i> ${errorText}`);
                    setTimeout(function () {
                        $button
                            .removeClass("is-error")
                            .html(originalContent)
                            .prop("disabled", false);
                    }, 2000);
                }
            }, randomDelay);
        });
    });

    $(".amd-btn-animated-svg").on("click", function () {
        console.log("Animated SVG Icon Button clicked!");
    });
});

// Accordions JS page
$(document).ready(function () {
    $(".amd-accordion").each(function () {
        var $accordion = $(this);
        var isAlwaysOpen = $accordion.hasClass("amd-accordion-always-open");
        var $headers = $accordion.find(".amd-accordion-header");

        $headers.on("click", function () {
            var $header = $(this);
            var $item = $header.closest(".amd-accordion-item");
            var $body = $item.find(".amd-accordion-body");
            var $content = $item.find(".amd-accordion-content");
            var $icon = $header.find(".amd-accordion-icon");
            var isActive = $item.hasClass("active");

            if (!isAlwaysOpen) {
                // Close all other active items first
                $accordion
                    .find(".amd-accordion-item.active")
                    .not($item)
                    .each(function () {
                        var $otherItem = $(this);
                        $otherItem.removeClass("active");
                        var $otherBody = $otherItem.find(".amd-accordion-body");
                        var $otherContent = $otherItem.find(
                            ".amd-accordion-content"
                        );
                        var $otherIcon = $otherItem.find(
                            ".amd-accordion-header .amd-accordion-icon"
                        );
                        $otherBody.css("max-height", "0px");
                        if ($otherContent.length) {
                            $otherContent.css("opacity", 0);
                        }
                        $otherIcon.removeClass("rotated");
                    });
            }

            if (isActive) {
                // Close current item
                $item.removeClass("active");
                $content.css({ opacity: 0, transform: "scale(0.98)" });
                $body.css("max-height", "0px");
                $icon.removeClass("rotated");
            } else {
                // Open current item
                $item.addClass("active");
                $body.css("max-height", $body[0].scrollHeight + "px");
                setTimeout(function () {
                    $content.css({ opacity: 1, transform: "scale(1)" });
                }, 50);
                $icon.addClass("rotated");
            }
        });

        // Set initial open state for items with .active
        $accordion.find(".amd-accordion-item.active").each(function () {
            var $item = $(this);
            var $body = $item.find(".amd-accordion-body");
            var $content = $item.find(".amd-accordion-content");
            var $icon = $item.find(".amd-accordion-header .amd-accordion-icon");
            $body.css("max-height", $body[0].scrollHeight + "px");
            $content.css({ opacity: 1, transform: "scale(1)" });
            $icon.addClass("rotated");
        });
    });
});

// Alerts page js here
$(document).ready(function () {
    $(".amd-close-btn").on("click", function () {
        var $alert = $(this).closest(".amd-alert");
        if ($alert.length) {
            if (
                $alert.hasClass("amd-fade") ||
                $alert.hasClass("amd-alert-slide-in") ||
                $alert.hasClass("amd-alert-border-bounce") ||
                $alert.hasClass("amd-alert-glow") ||
                $alert.hasClass("amd-alert-solid-shadow") ||
                $alert.hasClass("amd-alert-pulse-icon")
            ) {
                $alert.css({
                    opacity: "0",
                    transform: "translateY(10px) scale(0.98)",
                    height: "0",
                    paddingTop: "0",
                    paddingBottom: "0",
                    marginTop: "0",
                    marginBottom: "0",
                    borderWidth: "0",
                    boxShadow: "none",
                });
                $alert.one("transitionend", function () {
                    $alert.remove();
                });
            } else {
                $alert.remove();
            }
        }
    });

    // Trigger slide-in animation for modern alerts on load
    $(".amd-alert.amd-alert-slide-in").each(function () {
        var $alert = $(this);
        void $alert[0].offsetWidth; // force reflow
        $alert.css({ opacity: "1", transform: "translateY(0)" });
    });
});

// Card page js
$(document).ready(function () {
    $(".amd-cards.amd-cards-slide-in").each(function () {
        var $cards = $(this);
        void $cards[0].offsetWidth; // force reflow
        $cards.css({ opacity: "1", transform: "translateY(0)" });
    });

    $(".amd-cards-animated-pop").each(function () {
        var $card = $(this);
        $card.on("mouseenter", function () {
            $card.addClass("amd-cards-pop-active");
        });
        $card.on("mouseleave", function () {
            $card.removeClass("amd-cards-pop-active");
        });
    });
});

// Modals page js
function openModal(id) {
    var $modal = $("#" + id);
    if ($modal.length) {
        $modal.addClass("amd-modal-show");
        $("body").addClass("amd-modal-open");
    }
}

function closeModal(id) {
    var $modal = $("#" + id);
    if ($modal.length) {
        $modal.removeClass("amd-modal-show");
        var openModals = $(".amd-modal-backdrop.amd-modal-show");
        if (openModals.length === 0) {
            $("body").removeClass("amd-modal-open");
        }
    }
}

$(document).ready(function () {
    $(".amd-modal-backdrop").on("click", function (event) {
        if (event.target === this) {
            closeModal(this.id);
        }
    });

    $(document).on("keydown", function (event) {
        if (event.key === "Escape") {
            var openModals = $(".amd-modal-backdrop.amd-modal-show");
            if (openModals.length > 0) {
                closeModal(openModals.last().attr("id"));
            }
        }
    });

    $(".amd-modal-side").on("click", function (event) {
        event.stopPropagation();
    });

    $(".modal-demo-static .amd-modal-close, .modal-demo-static .amd-btn").on(
        "click",
        function (event) {
            event.preventDefault();
            console.log(
                "Button clicked in static modal example (no actual action)."
            );
        }
    );
});

//Toast Js
function showToast(options) {
    // Default options and merge with provided options
    const defaultOptions = {
        type: "info",
        message: "A notification message.",
        title: null,
        duration: 5000,
        position: "top-right",
        avatarSrc: null,
        avatarAlt: "User",
        showProgressBar: false,
        actions: [],
        onShowCallback: null,
        onHideCallback: null,
    };
    const opts = $.extend({}, defaultOptions, options);

    // Get or create the toast container for the specified position
    let $toastContainer = $(`#amdToastContainer-${opts.position}`);
    if ($toastContainer.length === 0) {
        $toastContainer = $("<div></div>")
            .attr("id", `amdToastContainer-${opts.position}`)
            .addClass("amd-toast-container")
            .addClass(`amd-toast-container-${opts.position}`)
            .appendTo("body");
    }

    const $toast = $("<div></div>")
        .addClass("amd-toast")
        .addClass(`amd-toast-${opts.type}`);

    // Determine icon or avatar
    let iconHtml = "";
    let avatarHtml = "";

    if (opts.avatarSrc) {
        avatarHtml = `<img class="amd-avatar" src="${opts.avatarSrc}" alt="${opts.avatarAlt}">`;
        $toast.addClass("amd-toast-avatar");
    } else {
        let iconClass = "";
        switch (opts.type) {
            case "success":
                iconClass = "fas fa-check-circle";
                break;
            case "error":
                iconClass = "fas fa-times-circle";
                break;
            case "info":
                iconClass = "fas fa-info-circle";
                break;
            case "warning":
                iconClass = "fas fa-exclamation-triangle";
                break;
            default:
                iconClass = "fas fa-bell";
                break;
        }
        iconHtml = `<i class="amd-icon ${iconClass}"></i>`;
    }

    // Build content HTML
    let contentHtml = "";
    if (opts.title) {
        contentHtml += `<div class="amd-toast-title">${opts.title}</div>`;
    }
    contentHtml += `<div class="amd-toast-message">${opts.message}</div>`;

    // Build actions HTML
    let actionsHtml = "";
    if (opts.actions && opts.actions.length > 0) {
        actionsHtml = `<div class="amd-toast-actions">`;
        opts.actions.forEach((action, index) => {
            actionsHtml += `<button type="button" class="amd-btn-toast-action" data-action-index="${index}">${action.text}</button>`;
        });
        actionsHtml += `</div>`;
    }

    const progressBarHtml =
        opts.showProgressBar && opts.duration > 0
            ? '<div class="amd-toast-progress-bar"></div>'
            : "";

    $toast.html(`
        ${avatarHtml || iconHtml}
        <div class="amd-toast-content">
            ${contentHtml}
            ${actionsHtml}
        </div>
        <button type="button" class="amd-toast-close" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        ${progressBarHtml}
    `);

    // Prepend toast to container (newest on top)
    $toastContainer.prepend($toast);

    // Show animation trigger
    setTimeout(() => {
        $toast.addClass("show");
        if (typeof opts.onShowCallback === "function") {
            opts.onShowCallback();
        }

        // Start progress bar animation
        if (opts.showProgressBar && opts.duration > 0) {
            const $progressBar = $toast.find(".amd-toast-progress-bar");
            if ($progressBar.length) {
                $progressBar.css({
                    transition: `width ${opts.duration / 1000}s linear`,
                    width: "0%",
                });
                void $progressBar[0].offsetWidth; // force reflow
                $progressBar.css("width", "100%");
            }
        }
    }, 10);

    let hideTimeout;

    function hideToast() {
        $toast.removeClass("show").addClass("hide");
        // Remove after animation ends (~300ms assumed)
        setTimeout(() => {
            $toast.remove();
            if (typeof opts.onHideCallback === "function") {
                opts.onHideCallback();
            }
        }, 300);
    }

    // Auto-hide logic
    if (opts.duration > 0) {
        hideTimeout = setTimeout(hideToast, opts.duration);
    }

    // Close button click
    $toast.find(".amd-toast-close").on("click", function () {
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }
        hideToast();
    });

    // Action buttons click
    $toast.find(".amd-btn-toast-action").each(function () {
        const $btn = $(this);
        $btn.on("click", function () {
            const index = parseInt($btn.data("action-index"), 10);
            if (
                opts.actions &&
                opts.actions[index] &&
                typeof opts.actions[index].onClick === "function"
            ) {
                opts.actions[index].onClick();
            }
            if (hideTimeout) {
                clearTimeout(hideTimeout);
            }
            hideToast();
        });
    });

    // Pause auto-hide on hover
    $toast.on("mouseenter", function () {
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }
        const $progressBar = $toast.find(".amd-toast-progress-bar");
        if ($progressBar.length) {
            $progressBar.css("transition", "none");
            const computedWidth = window.getComputedStyle(
                $progressBar[0]
            ).width;
            $progressBar.css("width", computedWidth);
        }
    });

    // Resume auto-hide on mouse leave
    $toast.on("mouseleave", function () {
        if (opts.duration > 0 && !$toast.hasClass("hide")) {
            const $progressBar = $toast.find(".amd-toast-progress-bar");
            let remainingDuration = opts.duration;

            if (
                $progressBar.length &&
                $progressBar.css("width") !== "0px" &&
                $progressBar.css("width") !== "100%"
            ) {
                const totalWidth = $toast.outerWidth();
                const currentWidth = parseFloat($progressBar.css("width"));
                if (totalWidth > 0) {
                    const progressPercentage = currentWidth / totalWidth;
                    remainingDuration =
                        opts.duration * (1 - progressPercentage);
                }
            }

            hideTimeout = setTimeout(hideToast, remainingDuration);

            if ($progressBar.length) {
                $progressBar.css({
                    transition: `width ${remainingDuration / 1000}s linear`,
                    width: "0%",
                });
                void $progressBar[0].offsetWidth;
                $progressBar.css("width", "100%");
            }
        }
    });
}

function hideToast(toastElement, position, onHideCallback = null) {
    const $toast =
        toastElement instanceof jQuery ? toastElement : $(toastElement);

    $toast.removeClass("show");

    // Apply specific hide animation based on position
    if (position === "top-left" || position === "bottom-left") {
        $toast.css("transform", "translateX(-100%) scale(0.95)");
    } else if (position === "top-center" || position === "bottom-center") {
        $toast.css("transform", "translateY(-100%) scale(0.95)");
    } else {
        // default top-right or bottom-right
        $toast.css("transform", "translateX(100%) scale(0.95)");
    }
    $toast.css("opacity", "0");

    // Wait for transitionend event once, then remove element and call callback
    $toast.one("transitionend", function () {
        const $parent = $toast.parent();
        $toast.remove();

        if (typeof onHideCallback === "function") {
            onHideCallback();
        }

        // Remove container if empty
        if ($parent.children().length === 0) {
            $parent.remove();
        }
    });
}

// off canvas page js
$(document).ready(function () {
    const $offCanvasToggles = $("[data-amd-off-canvas-target]");
    const $offCanvasDismissButtons = $("[data-amd-off-canvas-dismiss]");
    const $offCanvasNavLinkDismiss = $("[data-amd-off-canvas-link-dismiss]");
    const $offCanvasBackdrop = $("#amdOffCanvasBackdrop");
    const $body = $("body");
    const $mainContentWrapper = $("#amd-main-content-wrapper");

    let currentOpenOffCanvas = null; // Track the currently open off-canvas panel

    function openOffCanvas(targetId, $triggerElement) {
        const $targetPanel = $(targetId);
        if ($targetPanel.length) {
            if (
                currentOpenOffCanvas &&
                currentOpenOffCanvas[0] !== $targetPanel[0]
            ) {
                closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
            }

            $targetPanel.addClass("amd-off-canvas-open");
            $offCanvasBackdrop.addClass("amd-off-canvas-backdrop-show");
            $body.addClass("amd-off-canvas-open");

            const isPushOffCanvas =
                $triggerElement.data("amdOffCanvasPush") === true ||
                $triggerElement.data("amdOffCanvasPush") === "true";
            if (isPushOffCanvas && $mainContentWrapper.length) {
                if ($targetPanel.hasClass("amd-off-canvas-left")) {
                    $mainContentWrapper.addClass(
                        "amd-main-content-pushed-left"
                    );
                }
                // Additional push directions can be handled here if needed
                $body.addClass("amd-body-pushed");
            }

            currentOpenOffCanvas = $targetPanel;
        }
    }

    function closeOffCanvas(targetId) {
        const $targetPanel = $(targetId);
        if ($targetPanel.length) {
            $targetPanel.removeClass("amd-off-canvas-open");

            if ($mainContentWrapper.length) {
                $mainContentWrapper.removeClass("amd-main-content-pushed-left");
                $body.removeClass("amd-body-pushed");
            }

            if ($(".amd-off-canvas.amd-off-canvas-open").length === 0) {
                $offCanvasBackdrop.removeClass("amd-off-canvas-backdrop-show");
                $body.removeClass("amd-off-canvas-open");
            }

            if (
                currentOpenOffCanvas &&
                currentOpenOffCanvas[0] === $targetPanel[0]
            ) {
                currentOpenOffCanvas = null;
            }
        }
    }

    $offCanvasToggles.on("click", function () {
        const targetId = $(this).data("amdOffCanvasTarget");
        openOffCanvas(targetId, $(this));
    });

    $offCanvasDismissButtons.on("click", function () {
        const targetId = $(this).data("amdOffCanvasDismiss");
        closeOffCanvas(targetId);
    });

    $offCanvasNavLinkDismiss.on("click", function (e) {
        // e.preventDefault(); // Uncomment if needed to prevent navigation
        const targetId = $(this).data("amdOffCanvasLinkDismiss");
        closeOffCanvas(targetId);
    });

    if ($offCanvasBackdrop.length) {
        $offCanvasBackdrop.on("click", function () {
            if (currentOpenOffCanvas) {
                closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
            }
        });
    }

    $(document).on("keydown", function (event) {
        if (event.key === "Escape" && currentOpenOffCanvas) {
            closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
        }
    });

    // Nested submenu toggles
    $(".amd-off-canvas-nav .has-submenu > .submenu-toggle").on(
        "click",
        function (e) {
            e.preventDefault();
            const $parentLi = $(this).closest("li.has-submenu");
            if ($parentLi.length) {
                const $currentOffCanvas = $(this).closest(".amd-off-canvas");
                if ($currentOffCanvas.length) {
                    $currentOffCanvas
                        .find(".has-submenu.submenu-open")
                        .not($parentLi)
                        .removeClass("submenu-open");
                }
                $parentLi.toggleClass("submenu-open");
            }
        }
    );
});


// pagination page js
$(document).ready(function () {
    const $pageDropdownToggle = $("#pageDropdownToggle");
    if ($pageDropdownToggle.length) {
        $pageDropdownToggle.on("click", function () {
            $(this).parent().toggleClass("open");
        });

        $(document).on("click", function (event) {
            if (
                !$pageDropdownToggle.parent().is(event.target) &&
                $pageDropdownToggle.parent().has(event.target).length === 0
            ) {
                $pageDropdownToggle.parent().removeClass("open");
            }
        });
    }

    const $viewMoreBtn = $("#viewMoreBtn");
    const $viewMoreContent = $("#viewMoreContent");
    const $viewMoreSpinner = $viewMoreBtn.find(".amd-loading-spinner");
    const $viewMoreText = $viewMoreBtn.find(".amd-btn-text");

    let currentItems = 10;
    const totalItems = 50;
    const itemsPerPage = 10;

    if ($viewMoreBtn.length) {
        $viewMoreBtn.on("click", function () {
            $viewMoreSpinner.show();
            $viewMoreText.hide();
            $viewMoreBtn.prop("disabled", true).addClass("loading");

            setTimeout(() => {
                currentItems += itemsPerPage;
                if (currentItems > totalItems) currentItems = totalItems;

                $viewMoreContent.html(
                    `Displaying 1-${currentItems} of ${totalItems} items.`
                );
                if (currentItems === totalItems) {
                    $viewMoreBtn.hide();
                } else {
                    const nextStart = currentItems + 1;
                    const nextEnd = Math.min(
                        currentItems + itemsPerPage,
                        totalItems
                    );
                    $viewMoreText.text(`View More (${nextStart}-${nextEnd})`);
                }

                $viewMoreSpinner.hide();
                $viewMoreText.show();
                $viewMoreBtn.prop("disabled", false).removeClass("loading");
            }, 1500);
        });
    }

    const $rippleLoadMoreBtn = $("#rippleLoadMoreBtn");
    const $rippleContent = $("#rippleContent");
    const $rippleSpinner = $rippleLoadMoreBtn.find(".amd-loading-spinner");
    const $rippleText = $rippleLoadMoreBtn.find(".amd-btn-text");

    if ($rippleLoadMoreBtn.length) {
        $rippleLoadMoreBtn.on("click", function (e) {
            const x = e.clientX - $(this).offset().left;
            const y = e.clientY - $(this).offset().top;

            const $ripple = $("<span></span>")
                .addClass("amd-ripple-effect")
                .css({
                    left: `${x}px`,
                    top: `${y}px`,
                });

            $(this).append($ripple);

            $ripple.on(
                "animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function () {
                    $(this).remove();
                }
            );

            $rippleSpinner.show();
            $rippleText.hide();
            $rippleLoadMoreBtn.prop("disabled", true).addClass("loading");

            setTimeout(() => {
                $rippleContent.append(
                    `<p style="margin-top:10px;">More awesome content loaded with a ripple! (${new Date().toLocaleTimeString()})</p>`
                );
                $rippleSpinner.hide();
                $rippleText.show();
                $rippleLoadMoreBtn
                    .prop("disabled", false)
                    .removeClass("loading")
                    .hide(); // Hide after one load
            }, 1800);
        });
    }
});

// badges page js
$(document).ready(function () {
    const $badgeSearch = $("#badgeSearch");
    const $badgeCategoriesContainer = $("#badgeCategories");

    $badgeSearch.on("keyup", function () {
        const searchTerm = $badgeSearch.val().toLowerCase();
        const $badgeExamples = $(".badge-example");
        const $categoryHeadings = $("#badgeCategories h2");

        $badgeExamples.each(function () {
            const $example = $(this);
            const badgeText = $example.text().toLowerCase();
            const badgeCode = $example.find("code").text().toLowerCase() || "";
            const display =
                badgeText.includes(searchTerm) || badgeCode.includes(searchTerm)
                    ? "flex"
                    : "none";
            $example.css("display", display);
        });

        $categoryHeadings.each(function () {
            const $heading = $(this);
            const $categoryGrid = $heading.next(".badge-grid");
            const $descriptionParagraph = $categoryGrid.next("p");

            if ($categoryGrid.length) {
                const visibleBadges =
                    $categoryGrid.children().filter(function () {
                        return $(this).css("display") !== "none";
                    }).length > 0;

                $heading.css("display", visibleBadges ? "block" : "none");
                $categoryGrid.css("display", visibleBadges ? "grid" : "none");

                if (
                    $descriptionParagraph.length &&
                    $descriptionParagraph.css("margin-top") === "-15px"
                ) {
                    $descriptionParagraph.css(
                        "display",
                        visibleBadges ? "block" : "none"
                    );
                }
            }
        });
    });
});

// date picker page js
$(document).ready(function () {
    $("#date1").flatpickr({ dateFormat: "Y-m-d" });
    $("#date2").flatpickr({ dateFormat: "Y-m-d" });
    $("#date3").flatpickr({ mode: "range", dateFormat: "Y-m-d" });
    $("#date4").flatpickr({ enableTime: true, dateFormat: "Y-m-d H:i" });
    $("#date5").flatpickr({ inline: true, dateFormat: "Y-m-d" });
    $("#date6").flatpickr({ dateFormat: "Y-m-d" });

    // Button triggered date picker
    const date7Instance = flatpickr("#date7btn", {
        dateFormat: "Y-m-d",
        clickOpens: false,
        onReady: function (_, __, instance) {
            $("#date7btn").on("click", function () {
                instance.open();
            });
        },
    });

    $("#date8").flatpickr({ dateFormat: "Y-m-d" });
    $("#date9").flatpickr({ dateFormat: "Y-m-d" });
    $("#date10").flatpickr({ dateFormat: "Y-m-d", minDate: "today" });
});
//   date picker page js end

// new date picker page js
// 4. Advanced Bootstrap Datepicker Plugin
$(function () {
    $("#amd-datepicker4").datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
});


// progress bar page js

// JavaScript to set the progress bar widths with a slight delay for animation effect
document.addEventListener("DOMContentLoaded", function () {
    const progressBars = document.querySelectorAll(".amd-progress-bar");
    progressBars.forEach((bar, index) => {
        const targetWidth = bar.dataset.width; // Get target width from data-width attribute
        // Introduce a small delay for each bar to make the animation more noticeable
        setTimeout(() => {
            if (targetWidth) {
                bar.style.width = targetWidth + "%";
            }
        }, 100 * index); // Adjust delay as needed
    });
});
// progress bar page js end

// dialog page js
// Optional: Pause video when modal is hidden
document.addEventListener("DOMContentLoaded", function () {
    var videoModal = document.getElementById("videoModal");
    if (videoModal) {
        videoModal.addEventListener("hidden.bs.modal", function () {
            var iframe = this.querySelector("iframe");
            if (iframe) {
                // Reset src to stop playback
                var iframeSrc = iframe.src;
                iframe.src = iframeSrc;
            }
        });
    }
});

//   dialog page js end

// Button Group page js
$(document).ready(function () {
    // Toggle active state for Segmented Control
    var $segmentedControl = $(".amd-button-group-custom-segmented");
    if ($segmentedControl.length) {
        $segmentedControl.on("click", "button", function () {
            $segmentedControl.find(".btn").removeClass("active");
            $(this).addClass("active");
        });
    }

    // Toggle active state for Icon-Only Toggle Group
    var $iconToggleGroup = $(".amd-button-group-custom-icon-toggle");
    if ($iconToggleGroup.length) {
        $iconToggleGroup.on("click", "button", function () {
            $(this).toggleClass("active");
        });
    }
});

// button group page js end

// form-select page js
$(document).ready(function () {
    // Function to handle adding and removing basic tags (for existing multi-selects)
    function setupTagInput(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $tagInput = $container.find(".amd-form-select-tag-input");

        // Remove tag on 'X' click using event delegation
        $container.on("click", ".amd-form-select-remove-tag", function (event) {
            $(this).closest(".amd-form-select-selected-tag").remove();
        });

        // Add tag on Enter key press for basic multi-selects
        $tagInput.on("keydown", function (event) {
            if (event.key === "Enter" && $(this).val().trim() !== "") {
                event.preventDefault(); // Prevent form submission
                const tagText = $(this).val().trim();
                const $newTag = $("<span>")
                    .addClass("amd-form-select-selected-tag")
                    .attr(
                        "data-value",
                        tagText.toLowerCase().replace(/\s/g, "-")
                    )
                    .html(
                        `${tagText} <span class="amd-form-select-remove-tag">X</span>`
                    );

                if (containerId === "amdPassingOptionsMultiSelect") {
                    $newTag.addClass("amd-form-select-tag-blue");
                }
                $tagInput.before($newTag); // Insert before the input field
                $(this).val(""); // Clear input field
            }
        });
    }

    // Function to handle searchable multi-selects (with tags)
    function setupSearchableMultiSelect(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $multiInputDiv = $container.find(".amd-form-select-multi-input");
        const $tagInput = $multiInputDiv.find(".amd-form-select-tag-input");
        const $dropdownList = $container.find(".amd-form-select-dropdown-list");
        const $options = $dropdownList.children("li"); // Get all li elements

        let selectedValues = new Set(); // To keep track of selected items (data-value)

        // Function to render selected tags
        function renderTags() {
            // Remove existing tags, but keep the input field
            $multiInputDiv.find(".amd-form-select-selected-tag").remove();

            selectedValues.forEach((value) => {
                const $newTag = $("<span>")
                    .addClass("amd-form-select-selected-tag")
                    .attr("data-value", value);

                // Find the original text for the tag display
                const originalOptionText = $options
                    .filter(`[data-value="${value}"]`)
                    .text();
                $newTag.html(
                    `${originalOptionText} <span class="amd-form-select-remove-tag">X</span>`
                );
                $tagInput.before($newTag); // Insert before the input field
            });
        }

        // Handle clicking on an option in the dropdown list
        $dropdownList.on("click", "li", function (event) {
            const $target = $(this);
            const value = $target.attr("data-value");

            if (selectedValues.has(value)) {
                selectedValues.delete(value);
                $target.removeClass("selected");
            } else {
                selectedValues.add(value);
                $target.addClass("selected");
            }
            renderTags(); // Re-render tags to reflect changes
            $tagInput.val(""); // Clear search input
            filterOptions(""); // Reset filter after selection
            $tagInput.focus(); // Keep focus on input for continued interaction
        });

        // Handle removing a tag from the input area
        $multiInputDiv.on(
            "click",
            ".amd-form-select-remove-tag",
            function (event) {
                const $tag = $(this).closest(".amd-form-select-selected-tag");
                const valueToRemove = $tag.attr("data-value");
                selectedValues.delete(valueToRemove);
                $tag.remove();

                // Also update the dropdown list item's selected state
                $dropdownList
                    .find(`li[data-value="${valueToRemove}"]`)
                    .removeClass("selected");
                $tagInput.focus(); // Keep focus on input
            }
        );

        // Filter options based on input
        $tagInput.on("input", function () {
            const searchTerm = $(this).val().toLowerCase();
            filterOptions(searchTerm);
        });

        function filterOptions(searchTerm) {
            $options.each(function () {
                const $option = $(this);
                const optionText = $option.text().toLowerCase();
                if (optionText.includes(searchTerm)) {
                    $option.removeClass("hidden");
                } else {
                    $option.addClass("hidden");
                }
            });
        }

        // Show/hide dropdown on input focus/blur
        $tagInput.on("focus", function () {
            $dropdownList.addClass("show");
            filterOptions($(this).val().toLowerCase()); // Filter on focus too
        });

        // Hide dropdown when clicking outside
        $(document).on("click", function (event) {
            if (
                !$container.is(event.target) &&
                !$container.has(event.target).length
            ) {
                $dropdownList.removeClass("show");
                $tagInput.val(""); // Clear search input on blur
                filterOptions(""); // Reset filter
            }
        });

        // Prevent hiding dropdown when clicking inside the multi-input area but not on tags
        $multiInputDiv.on("click", function (event) {
            if (
                $(event.target).is($multiInputDiv) ||
                $(event.target).is($tagInput)
            ) {
                $tagInput.focus();
                $dropdownList.addClass("show");
            }
        });

        // Initialize selected state for options if they were pre-selected
        $options.each(function () {
            if ($(this).hasClass("selected")) {
                selectedValues.add($(this).attr("data-value"));
            }
        });
        renderTags();
    }

    // Function to handle the new Multi-Select with Checkboxes
    function setupCheckboxMultiSelect(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $displayBox = $container.find(".amd-form-select-display");
        const $dropdown = $container.find(".amd-form-select-checkbox-dropdown");
        const $checkboxes = $dropdown.find('input[type="checkbox"]');
        const $placeholderSpan = $displayBox.find(
            ".amd-form-select-placeholder"
        );

        let selectedItems = new Set(); // Stores values of selected checkboxes

        function updateDisplay() {
            if (selectedItems.size === 0) {
                $placeholderSpan
                    .text("Select items...")
                    .addClass("amd-form-select-placeholder");
            } else {
                $placeholderSpan.removeClass("amd-form-select-placeholder");
                const selectedLabels = Array.from(selectedItems).map(
                    (value) => {
                        // Find the label text corresponding to the value
                        const $checkbox = $dropdown.find(
                            `input[value="${value}"]`
                        );
                        return $checkbox.length
                            ? $checkbox.next("label").text()
                            : value;
                    }
                );
                $placeholderSpan.text(selectedLabels.join(", "));
            }
        }

        // Toggle dropdown visibility
        $displayBox.on("click", function () {
            $dropdown.toggleClass("show");
            $displayBox.toggleClass("focused", $dropdown.hasClass("show"));
            $displayBox.attr("aria-expanded", $dropdown.hasClass("show"));
        });

        // Handle checkbox changes using event delegation
        $dropdown.on("change", 'input[type="checkbox"]', function (event) {
            const value = $(this).val();
            if ($(this).is(":checked")) {
                selectedItems.add(value);
            } else {
                selectedItems.delete(value);
            }
            updateDisplay();
        });

        // Close dropdown when clicking outside
        $(document).on("click", function (event) {
            if (
                !$container.is(event.target) &&
                !$container.has(event.target).length
            ) {
                $dropdown.removeClass("show");
                $displayBox.removeClass("focused");
                $displayBox.attr("aria-expanded", "false");
            }
        });

        // Initial display update
        $checkboxes.each(function () {
            if ($(this).is(":checked")) {
                selectedItems.add($(this).val());
            }
        });
        updateDisplay();
    }

    // Apply basic tag interaction to relevant multi-select inputs
    setupTagInput("amdDefaultMultiSelect");
    setupTagInput("amdRemoveBtnMultiSelect");
    setupTagInput("amdPassingOptionsMultiSelect");
    setupTagInput("amdUniqueValuesMultiSelect");

    // Apply searchable multi-select interaction to the new components
    setupSearchableMultiSelect("searchableMultiSelect1");
    setupSearchableMultiSelect("searchableMultiSelect2");
    setupSearchableMultiSelect("searchableMultiSelect3");

    // Apply checkbox multi-select interaction
    setupCheckboxMultiSelect("checkboxMultiSelect");

    // Show Code Button (Dummy functionality)
    $(".amd-form-select-show-code-btn").on("click", function () {
        alert(
            "This would open a modal/section with the code for this component!"
        );
    });
});

// telephone dropdowns js
$(document).ready(function () {
    // Get all dropdown toggle buttons within amd-telephone components
    const amdTelephones = $(".amd-telephone");

    amdTelephones.each(function () {
        const $amdTelephone = $(this); // Cache the current .amd-telephone element as a jQuery object
        const $toggleButton = $amdTelephone.find(".dropdown-toggle-flag");
        const $dropdownMenu = $amdTelephone.find(".dropdown-menu-flag"); // Not used directly in this logic, but kept for consistency
        const $dropdownItems = $amdTelephone.find(".dropdown-item-flag");

        if ($toggleButton.length) {
            // Ensure the toggle button exists for this component
            $toggleButton.on("click", function (event) {
                event.preventDefault();
                const $parentDropdown = $(this).closest(
                    ".dropdown-flag-country"
                );
                if ($parentDropdown.length && !$(this).is(":disabled")) {
                    // Check if not disabled
                    $parentDropdown.toggleClass("show");
                }

                // Close other open dropdowns
                $(".dropdown-flag-country.show").each(function () {
                    if ($(this)[0] !== $parentDropdown[0]) {
                        // Compare native DOM elements
                        $(this).removeClass("show");
                    }
                });
            });
        }

        $dropdownItems.on("click", function (event) {
            event.preventDefault();
            const selectedCountry = $(this).data("country"); // Use .data() for data attributes
            const selectedCode = $(this).data("code");

            const $selectedFlagImg = $amdTelephone.find(
                'img.flag-icon[id^="selectedFlag"]'
            );
            const $selectedCodeSpan = $amdTelephone.find(
                'span[id^="selectedCode"]'
            );

            if ($selectedFlagImg.length) {
                $selectedFlagImg.attr(
                    "src",
                    `https://flagcdn.com/w20/${selectedCountry}.png`
                );
            }
            if ($selectedCodeSpan.length) {
                $selectedCodeSpan.text(selectedCode);
            }

            const $parentDropdown = $(this).closest(".dropdown-flag-country");
            if ($parentDropdown.length) {
                $parentDropdown.removeClass("show"); // Close the dropdown
            }
        });
    });

    // Close dropdowns when clicking outside
    $(document).on("click", function (event) {
        $(".amd-telephone .dropdown-flag-country.show").each(function () {
            if (!$(event.target).closest(this).length) {
                // Check if click is outside the dropdown
                $(this).removeClass("show");
            }
        });
    });
});

// form-select page end
// FAQ page start
$(document).ready(function () {
    // --- 1. "ChefKraft" - Custom List Group Accordion ---
    $(".amd-faq-style-tabs .list-group-item").on("click", function () {
        var $question = $(this).find(".list-group-item-question");
        var $answer = $(this).find(".list-group-item-answer");
        var $icon = $question.find("i");

        if ($question.hasClass("active")) {
            // If it's already active, close it
            $question.removeClass("active");
            $answer.slideUp(300).addClass("d-none");
            $icon.removeClass("bi-dash-lg").addClass("bi-plus-lg");
        } else {
            // Close any other open items in the same list
            $(this)
                .siblings()
                .find(".list-group-item-question.active")
                .each(function () {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".list-group-item-answer")
                        .slideUp(300)
                        .addClass("d-none");
                    $(this)
                        .find("i")
                        .removeClass("bi-dash-lg")
                        .addClass("bi-plus-lg");
                });
            // Open the clicked item
            $question.addClass("active");
            $answer.slideDown(300).removeClass("d-none");
            $icon.removeClass("bi-plus-lg").addClass("bi-dash-lg");
        }
    });

    // --- 4. "Marketplace" - Filtering Logic ---
    $("#marketplaceTab .nav-link").on("click", function () {
        // Update active state
        $("#marketplaceTab .nav-link").removeClass("active");
        $(this).addClass("active");

        var filter = $(this).data("filter");
        var $accordionItems = $("#marketplaceAccordion .accordion-item");

        if (filter === "*") {
            $accordionItems.show(400);
        } else {
            $accordionItems.not('[data-category="' + filter + '"]').hide(400);
            $accordionItems
                .filter('[data-category="' + filter + '"]')
                .show(400);
        }
    });
});

$(document).ready(function () {
    // FAQ Question Toggle Logic
    $(".amd-faq5 .faq-question").on("click", function () {
        $(this).toggleClass("expanded");
        // Use slideToggle for animation, setting a duration for smoothness
        $(this).next(".faq-answer-text").slideToggle(200);

        const $icon = $(this).find(".toggle-icon");
        if ($(this).hasClass("expanded")) {
            $icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            $icon.removeClass("fa-minus").addClass("fa-plus");
        }
    });

    // Category Card Active State (visual only)
    $(".amd-faq5 .faq-category-card").on("click", function () {
        $(".amd-faq5 .faq-category-card").removeClass("active");
        $(this).addClass("active");
    });

    // Load More FAQ Items Logic
    const $faqItemList = $("#faqItemList");
    const $loadMoreBtn = $("#loadMoreBtn");
    const itemsPerLoad = 3; // Number of items to show each time "Load More" is clicked

    // Initial setup function
    function initializeFaqItems() {
        // Ensure the one specific answer from the image remains visible and expanded
        const $specificItem = $(".amd-faq5 .faq-item-list li:nth-child(3)");
        if ($specificItem.length) {
            $specificItem.find(".faq-question").addClass("expanded");
            // Ensure the answer is displayed and override any inline 'display: none'
            $specificItem
                .find(".faq-answer-text")
                .addClass("show")
                .css("display", "block");
            $specificItem
                .find(".toggle-icon")
                .removeClass("fa-plus")
                .addClass("fa-minus");
        }

        // Initially hide all items that are meant to be hidden
        // This targets items that might not have 'display: none' inline due to Bootstrap or other reasons
        $faqItemList.find("li.hidden").hide(); // CRITICAL FIX: Ensure hidden items are actually hidden with jQuery's .hide()

        // Check if "Load More" button is needed on initial load
        if ($faqItemList.find("li.hidden").length === 0) {
            $loadMoreBtn.hide(); // Hide if all are visible already
        }
    }

    // Function to show more items
    function showMoreItems() {
        // Re-select hidden items each time
        const $currentHiddenItems = $faqItemList.find("li.hidden");
        const $itemsToShow = $currentHiddenItems.slice(0, itemsPerLoad);

        // Instead of just removing 'hidden', use .show() to ensure they become visible
        // and potentially remove any inline 'display: none' that might be lingering.
        $itemsToShow.removeClass("hidden").show(); // CRITICAL FIX: Use .show() here

        // After revealing, check the count of remaining hidden items
        if ($faqItemList.find("li.hidden").length === 0) {
            $loadMoreBtn.hide(); // Hide button if no more hidden items
        }
    }

    // Call initial setup on document ready
    initializeFaqItems();

    // Attach click handler to Load More button
    $loadMoreBtn.on("click", showMoreItems);
});

// FAQ page end

// subscription plan page start
$(document).ready(function () {
    // --- General Pricing Toggle Logic ---
    function handlePricingToggle(toggleId, scopeClass) {
        $(toggleId).on("change", function () {
            var isAnnual = $(this).is(":checked");
            $(scopeClass + " .plan-price").each(function () {
                var monthlyPrice = $(this).data("monthly");
                var annuallyPrice = $(this).data("annually");
                var periodText = isAnnual ? "/year" : "/month";

                if (isAnnual) {
                    $(this).html(
                        annuallyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                } else {
                    $(this).html(
                        monthlyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                }
            });
        });
    }

    // --- "Modern Pill" Toggle Logic ---
    var $pillBox = $(".pricing-toggle-pill-box");
    if ($pillBox.length > 0) {
        var $movingPill = $pillBox.find(".moving-pill");
        var $monthlyBtn = $pillBox.find('button[data-period="monthly"]');
        var $yearlyBtn = $pillBox.find('button[data-period="yearly"]');

        // Set initial size of the moving pill
        $movingPill.width($monthlyBtn.outerWidth());
        $movingPill.height($monthlyBtn.outerHeight());

        $pillBox.on("click", "button", function () {
            var $this = $(this);
            if ($this.hasClass("active")) {
                return; // Do nothing if already active
            }

            $pillBox.find("button").removeClass("active");
            $this.addClass("active");

            // Animate the moving pill
            $movingPill.width($this.outerWidth());
            $movingPill.css("left", $this.position().left + 5); // +5 for the container padding

            // Update prices for the "Modern Pill" section
            var isAnnual = $this.data("period") === "yearly";
            $(".amd-plan-style-modern-pill .plan-price").each(function () {
                var monthlyPrice = $(this).data("monthly");
                var annuallyPrice = $(this).data("annually");
                var periodText = isAnnual ? "/year" : "/month";

                if (isAnnual) {
                    $(this).html(
                        annuallyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                } else {
                    $(this).html(
                        monthlyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                }
            });
        });
    }

    // --- Initialize Toggles ---
    handlePricingToggle("#saas-pricing-toggle", ".amd-plan-style-saas");
    handlePricingToggle(
        "#accordion-pricing-toggle",
        ".amd-plan-style-accordion"
    );
});
// subscription plan end
