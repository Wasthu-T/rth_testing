<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image and PDF Upload</title>
</head>
<body>
    <form id="upload-form" enctype="multipart/form-data">
        <input name="lmrec[]" class="check-input form-control image-field" type="file" id="lmrec" accept="image/*,application/pdf" multiple>
        <button id="submit" type="submit">Upload</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1"></script>
    <script>
        // Fungsi untuk mengompresi gambar
        const compressImage = async (file, { quality = 1, type = file.type }) => {
            // Mendapatkan data gambar
            const imageBitmap = await createImageBitmap(file);

            // Menggambar ke canvas
            const canvas = document.createElement('canvas');
            canvas.width = imageBitmap.width;
            canvas.height = imageBitmap.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(imageBitmap, 0, 0);

            // Mengubah menjadi Blob
            const blob = await new Promise((resolve) => canvas.toBlob(resolve, type, quality));

            // Mengubah Blob menjadi File
            return new File([blob], file.name, { type: blob.type });
        };

        // Fungsi untuk menginisialisasi kompresi gambar pada input field tertentu
        const initializeImageCompression = (selector, options) => {
            const inputs = document.querySelectorAll(selector);
            inputs.forEach((input) => {
                input.addEventListener('change', async (e) => {
                    const { files } = e.target;
                    if (!files.length) return;
                    const dataTransfer = new DataTransfer();
                    for (const file of files) {
                        if (file.type.startsWith('image')) {
                            const compressedFile = await compressImage(file, options);
                            dataTransfer.items.add(compressedFile);
                        } else if (file.type === 'application/pdf') {
                            dataTransfer.items.add(file);
                        }
                    }
                    e.target.files = dataTransfer.files;
                });
            });
        };

        // Inisialisasi fungsi untuk semua input field dengan kelas .image-field
        initializeImageCompression('.image-field', { quality: 0.5, type: 'image/jpeg' });
    </script>
</body>
</html>
