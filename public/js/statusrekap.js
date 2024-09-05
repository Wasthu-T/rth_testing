$(document).ready(function() {
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var status = getUrlParameter('status'); // Mengambil nilai status dari URL
        fetch_data(page, status); // Mengirimkan page dan status ke fungsi fetch_data
    });

    function fetch_data(page, status) {
        $.ajax({
            url: "/dashboard/admin?page=" + page + "&status=" + status,
            success: function(data) {
                $('#data-container').html(data);
            }
        });
    }

    // Fungsi untuk mendapatkan nilai parameter dari URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
});
