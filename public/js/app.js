$(document).ready(function () {
    $('input.category_selector').change(function () {

        $('#item_sub_category_id option').remove();
        $('#item_sub_category_id').prepend($("<option />").val('').text('Loading....'));

        $.getJSON(
            '/sub-categories' + '/' + $(this).val(),
            function (data) {
                let select = $('#item_sub_category_id');
                $.each(data, function () {
                    select.append($("<option />").val(this.id).text(this.name));
                });
                $('#item_sub_category_id option:first-child').remove();
            }
        );
    });
});
