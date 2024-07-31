document.addEventListener('DOMContentLoaded', (event) => {
    var downloadBtn = document.getElementById('downloadBtn');

    if (downloadBtn) {
        downloadBtn.addEventListener('click', function () {
            // Array to hold the photo URLs
            var photos = [];

            // Collect all image URLs
            document.querySelectorAll('#surat').forEach(function (img) {
                photos.push({
                    url: img.src,
                    type: 'image'
                });
            });

            // Collect all PDF URLs
            document.querySelectorAll('#pdfreadersurat').forEach(function (btn) {
                console.log(2,btn);
                photos.push({
                    url: btn.getAttribute('data-pdf'),
                    type: 'pdf'
                });
            });

            // Function to trigger download for each photo
            photos.forEach(function (file, index) {
                var link = document.createElement('a');
                link.href = file.url;
                if (file.type === 'image') {
                    link.download = 'Suratrth' + (index + 1) + '.jpg';
                } else if (file.type === 'pdf') {
                    link.download = 'Suratrth' + (index + 1) + '.pdf';
                }
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
    }
});


var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
});

document.addEventListener('DOMContentLoaded', (event) => {
    var pdfModal = document.getElementById('pdfModal');
    pdfModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var pdfUrl = button.getAttribute('data-pdf'); // Extract info from data-* attributes

        // Update the modal's content.
        var modalTitle = pdfModal.querySelector('.modal-title');
        var pdfEmbed = pdfModal.querySelector('#pdfEmbed');

        modalTitle.textContent = 'PDF Preview';
        pdfEmbed.src = pdfUrl;
    });
});