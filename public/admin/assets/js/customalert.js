$(function () {
    // Delete Confirmation
    $(".delete-form").on("submit", function (e) {
        e.preventDefault();

        let form = this;

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Generic Confirmation Before Submit
    $(".confirm-before-submit").on("submit", function (e) {
        debugger;
        e.preventDefault();

        let form = this;
        let message = $(form).data("confirm-message") || "Are you sure you want to proceed?";

        Swal.fire({
            title: "Please Confirm",
            text: message,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#8898aa",
            confirmButtonText: "Yes, proceed!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
