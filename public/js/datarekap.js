$(document).ready(function() {
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/dashboard/admin/rekapitulasi?page=" + page,
            success: function(data) {
                $('#data-container').html(data);
            }
        });
    }
});