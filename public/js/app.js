$(document).ready(function () {
    $('input.category_selector').change(function () {

        let category_id = $(this).val();

        $('#item_category_id').val(category_id);

        $('#item_sub_category_id option').remove();
        $('#item_sub_category_id').prepend($("<option />").val('').text('Loading sub categories....'));

        $.getJSON(
            '/sub-categories' + '/' + category_id,
            function (data) {
                let select = $('#item_sub_category_id');
                $.each(data, function () {
                    select.append($("<option />").val(this.id).text(this.name));
                });
                $('#item_sub_category_id option:first-child').remove();
            }
        );
    });

    $('a.set-allocation').click(function () {
        $('#item_allocation').val($(this).data("allocation"));
        return false;
    });
});
