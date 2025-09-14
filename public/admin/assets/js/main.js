const scrollBtn = document.getElementById("scrollBtn");

window.addEventListener("scroll", () => {
    // if (window.scrollY > 200) {
    //     scrollBtn.classList.add("show");
    // }
    // else {
    //     scrollBtn.classList.remove("show");
    // }
});

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

const sidebar = document.getElementById("amdSidebar");
const toggleBtn = document.getElementById("toggleSidebar");
const closeBtn = document.getElementById("closeSidebar");
const overlay = document.getElementById("amdSidebarOverlay");

// Open sidebar on mobile
function openMobileSidebar() {
    sidebar.classList.add("mobile-open");
    overlay.classList.remove("d-none");
    document.body.style.overflow = "hidden";
}

// Close sidebar on mobile
function closeMobileSidebar() {
    sidebar.classList.remove("mobile-open");
    overlay.classList.add("d-none");
    document.body.style.overflow = "";
}

// Toggle button click
toggleBtn.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
        // Mobile toggle
        if (sidebar.classList.contains("mobile-open")) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    } else {
        // Desktop toggle: add collapsed class if expanded, and vice versa
        if (sidebar.classList.contains("collapsed")) {
            sidebar.classList.remove("collapsed");
            sidebar.classList.add("expanded");
        } else {
            sidebar.classList.add("collapsed");
            sidebar.classList.remove("expanded");
        }
    }
});

// Close sidebar if overlay or close button is clicked
closeBtn.addEventListener("click", closeMobileSidebar);
overlay.addEventListener("click", closeMobileSidebar);

// On page load: default expand on desktop
window.addEventListener("DOMContentLoaded", () => {
    if (window.innerWidth > 768) {
        sidebar.classList.add("expanded");
        sidebar.classList.remove("collapsed");
    }
});

// On window resize: adjust classes
window.addEventListener("resize", () => {
    if (window.innerWidth > 768) {
        // Remove mobile-open class if moving to desktop
        closeMobileSidebar();
        // Ensure expanded state on desktop
        if (
            !sidebar.classList.contains("expanded") &&
            !sidebar.classList.contains("collapsed")
        ) {
            sidebar.classList.add("expanded");
        }
    } else {
        // Remove desktop-specific classes on small screen
        sidebar.classList.remove("expanded");
        sidebar.classList.remove("collapsed");
    }
});

// notification js
$("#notifBell").on("click", function (e) {
    e.stopPropagation(); // Prevent event bubbling
    $("#notificationPanel").toggleClass("show");
});

// === CLOSE ON OUTSIDE CLICK ===
$(document).on("click", function (e) {
    const $notifPanel = $("#notificationPanel");
    const $notifBell = $("#notifBell");

    // If the click is outside both the bell and panel, close it
    if (
        !$notifPanel.is(e.target) &&
        $notifPanel.has(e.target).length === 0 &&
        !$notifBell.is(e.target) &&
        $notifBell.has(e.target).length === 0
    ) {
        $notifPanel.removeClass("show");
    }
});
