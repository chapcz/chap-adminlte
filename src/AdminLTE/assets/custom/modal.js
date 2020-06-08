
function initModals() {
    $("[modal]").not(".modal-init").click(function(e) {
        e.preventDefault();
        $.nette.ajax({
            type: 'GET',
            url: $(this).attr("href"),
            data: {lte_no_layout: 1},
            success: function (r) {
                $("#modal .modal-content").html('<div class="mdl">'+r+'</div>');
                $("#modal").modal("show");
                initModals();
            }
        });
    });
    $("[modal]").not(".modal-init").addClass("modal-init");
}

initModals();
