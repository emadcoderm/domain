jQuery(document).ready(function($) {
	$(".headroom").headroom({
		"tolerance": 20,
		"offset": 50,
		"classes": {
			"initial": "animated",
			"pinned": "slideDown",
			"unpinned": "slideUp"
		}
	});

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