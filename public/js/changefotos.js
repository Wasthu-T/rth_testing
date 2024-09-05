// Deleted file
document.addEventListener("DOMContentLoaded", function () {
    // Menangani klik pada tombol "Hapus"
    document.querySelectorAll(".btn-delete1").forEach(function (button) {
        button.addEventListener("click", function () {
            // Dapatkan indeks foto yang akan dihapus
            var index = this.getAttribute("data-index-del");

            // Dapatkan elemen foto yang akan dihapus
            var fotoContainer = document.getElementById("fotoContainer");
            var fotoToRemove = fotoContainer.querySelector('[data-index="' + index + '"]');

            // Hapus foto dari tampilan
            fotoToRemove.parentNode.parentNode.remove();
            // Optional: Hapus input file terkait jika ada
            var inputToRemove = fotoContainer.querySelector('input[name="fotos[]"][data-index="' + index + '"]');
            if (inputToRemove) {
                inputToRemove.remove();
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Menangani klik pada tombol "Hapus"
    document.querySelectorAll(".btn-delete2").forEach(function (button) {
        button.addEventListener("click", function () {
            // Dapatkan indeks foto yang akan dihapus
            var index = this.getAttribute("data-index-del1");

            // Dapatkan elemen foto yang akan dihapus
            var fotoContainer1 = document.getElementById("fotoContainer1");
            var fotoToRemove2 = fotoContainer1.querySelector('[data-index1="' + index + '"]');

            // Hapus foto dari tampilan
            fotoToRemove2.parentNode.parentNode.remove();

            // Optional: Hapus input file terkait jika ada
            var inputToRemove1 = fotoContainer1.querySelector('input[name="lmrecs[]"][data-index1="' + index + '"]');
            if (inputToRemove1) {
                inputToRemove1.remove();
            }
        });
    });
});




// Edited
var fotoContainer = document.getElementById('fotoContainer');
var fotoContainer1 = document.getElementById('fotoContainer1');


if (fotoContainer && fotoContainer1) {
    var fotos = fotoContainer.querySelectorAll('.foto');
    var lmrecs = fotoContainer1.querySelectorAll('.lmrec');

    fotos.forEach(function (foto) {
        foto.addEventListener('click', function () {
            var index = this.getAttribute('data-index');
            var input = document.querySelector('input.selectedPhotos[data-index="' + index + '"]');
            input.click();
        });
    });

    lmrecs.forEach(function (lmrec) {
        lmrec.addEventListener('click', function () {
            var indexlm = this.getAttribute('data-index1');
            var inputlm = document.querySelector('input.selectedlmrecs[data-index1="' + indexlm + '"]');
            inputlm.click();
        });
    });

    var selectedPhotosInputs = fotoContainer.querySelectorAll('.selectedPhotos');
    selectedPhotosInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            var index = this.getAttribute('data-index');

            if (this.files && this.files.length > 0) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var foto = document.querySelector('.foto[data-index="' + index + '"]');

                    foto.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);

            }
        });
    });

    var selectedlmrecsInputs = fotoContainer1.querySelectorAll('.selectedlmrecs');
    selectedlmrecsInputs.forEach(function (inputlm) {
        inputlm.addEventListener('change', function () {
            var indexlm = this.getAttribute('data-index1');

            if (this.files && this.files.length > 0) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var lmrec = document.querySelector('.lmrec[data-index1="' + indexlm + '"]');

                    lmrec.src = e.target.result;
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    });
} else {
    // console.error('Elemen foto container tidak ditemukan.');
}

// Edited
var foto = document.getElementById('fotoktp');
var selectedPhotoInput = document.getElementById('selectedPhotoktp');
var editPdfBtn = document.getElementById('editPdfBtn');
var pdfContainer = document.getElementById('pdfContainer');
var showpdf = document.getElementById('showpdf');

function updateDisplay(fileType, dataUrl) {
    if (fileType.startsWith('image/')) {
        foto.style.display = 'block';
        foto.src = dataUrl;
        foto.classList.add('d-inline-flex');
        pdfContainer.style.display = 'none';
    } else if (fileType === 'application/pdf') {
        pdfContainer.style.display = 'block'
        showpdf.setAttribute('data-pdf', dataUrl);
        foto.classList.remove('d-inline-flex');
        foto.style.display = 'none';
    } else {
        // console.error('Unsupported file type:', fileType);
    }
}

if (foto && selectedPhotoInput) {
    foto.addEventListener('click', function () {
        selectedPhotoInput.click();
    });

    selectedPhotoInput.addEventListener('change', function () {
        if (selectedPhotoInput.files && selectedPhotoInput.files[0]) {
            var file = selectedPhotoInput.files[0];
            var fileType = file.type;
            var reader = new FileReader();

            reader.onload = function (e) {
                updateDisplay(fileType, e.target.result);
            }

            reader.readAsDataURL(file);
        }
    });
} else {
    // console.error('Elemen foto atau input tersembunyi tidak ditemukan.');
}

if (editPdfBtn && selectedPhotoInput) {
    editPdfBtn.addEventListener('click', function () {
        selectedPhotoInput.click();
    });

    selectedPhotoInput.addEventListener('change', function () {
        if (selectedPhotoInput.files && selectedPhotoInput.files[0]) {
            var file = selectedPhotoInput.files[0];
            var fileType = file.type;
            var reader = new FileReader();

            reader.onload = function (e) {
                updateDisplay(fileType, e.target.result);
            }

            reader.readAsDataURL(file);
        }
    });
} else {
    // console.error('Elemen foto atau input tersembunyi tidak ditemukan.');
}

