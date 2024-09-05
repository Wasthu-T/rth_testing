document.querySelectorAll('.image-field').forEach(input => {
    input.addEventListener('change', function (event) {
        const files = event.target.files;
        const previewId = 'preview-images';
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ''; // Clear previous previews

        if (files) {
            Array.from(files).forEach(file => {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (fileExtension === 'pdf') {
                    // If the file is a PDF, add a button to view it in a modal
                    // <button data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="{{ asset('/' . $data->ftktp) }}" class="btn-success btn"><i class="bi bi-file-earmark-pdf-fill"></i>Lihat Pdf</button>

                    const button = document.createElement('button');
                    button.textContent = 'Lihat PDF';
                    button.classList.add('btn', 'btn-success');
                    button.type = "button";
                    button.style.marginRight = '10px'; // Space between elements
                    button.setAttribute('data-bs-toggle', 'modal');
                    button.setAttribute('data-bs-target', '#pdfModal');
                    button.setAttribute('data-pdf-url', URL.createObjectURL(file));
                    previewContainer.appendChild(button);
                } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'].includes(fileExtension)) {
                    // If the file is an image, display the image
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.maxWidth = '200px'; // Adjust size as needed
                        img.style.marginRight = '10px'; // Space between images
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Handle other file types if needed
                    console.log('Unsupported file type:', fileExtension);
                }
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    var pdfModal = document.getElementById('pdfModal');
    pdfModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var pdfUrl = button.getAttribute('data-pdf-url'); // Extract info from data-* attributes

        // Update the modal's content.
        var modalTitle = pdfModal.querySelector('.modal-title');
        var pdfEmbed = pdfModal.querySelector('#pdfEmbed');

        modalTitle.textContent = 'PDF Preview';
        pdfEmbed.src = pdfUrl;
    });
});