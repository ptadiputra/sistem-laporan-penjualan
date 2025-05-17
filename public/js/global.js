// -- delete single data
function deleteData(e, element) {
    e.preventDefault();
    const url = element.attr('href');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    swal({
        title: 'Apakah anda yakin ingin menghapus data?',
        text: 'Ketika menghapus data ini akan berdampak pada data terkait.',
        type: "warning",
        iconColor: "#F1416C",
        background: "#FFF5F8",
        showCancelButton: !0,
        showCloseButton: true,
        confirmButtonText: "<i class='fas fa-check right'></i> Ok",
        cancelButtonText: "<i class='fas fa-crosshairs right'></i> Batal",
        reverseButtons: !0,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
    }).then(function (e) {
        if (e.value === true) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    "_token": csrfToken,
                },
                success: function(response) {
                    window.location.reload()
                },
                error: function(xhr) {
                    window.location.reload()
                }
            });
        }
    });
}

// -- set integer to rupiah format
document.querySelectorAll('.to-currency').forEach(function(element) {
    let value = parseFloat(element.innerText); // Ambil angka dari span
    if (isNaN(value)) {
        element.innerText = '';
    } else {
        element.innerText = value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    }
});
