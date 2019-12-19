$(".rapletModelTogle").click(function () {
    var model_id = $(this).data('model_id');
    $('#'+model_id).toggleClass('model-toggle-in-out', 2000);
});