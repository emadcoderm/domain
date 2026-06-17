$(document).ready(function () {
    $(".confirm-delete").confirm({
        text: "Are you sure you want to delete this item?",
        title: "Confirmation required",
        confirm: function(button) {
            button.parent('form').submit();
        },
        confirmButton: "Yes",
        cancelButton: "No",
        post: true
    });
});