var stt = document.getElementById('status');
if (stt) {
    stt.addEventListener('click', function () {
        var stt1 = document.getElementById('status-1');
        var rec = document.getElementById('recrth');
        console.log(stt.value);
        if (stt.value == 2) {
            stt1.innerHTML = `<div class="form-floating mt-3">
            <textarea name="alasan" class="form-control" placeholder="Menghalangi rambu lalu lintas" id="alasan" style="height: 100px"></textarea>
            <label for="alasan">Keterangan</label>
            </div>`;
            rec.disabled = true;

        } else if (stt.value == 1) {
            stt1.innerHTML = ``;
            rec.disabled = false;
        } else {
            rec.disabled = false;
            stt1.innerHTML = ``;
        }

    })
}