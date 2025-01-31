$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    // datatable classına sahip tablolar
    // dataTable'a dönüştürülüyor.
    $('.datatable').DataTable({
        autoFill: true,
        order: [[$(".datatable").data("order-column") || 0, $(".datatable").data("order-direction") || "asc"]],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'Tümü']
        ],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Turkish.json"
        }
    });

    // sil butonlarına tıklandığında alert dialog çıkartarak
    // kullanıcının işlemi onaylamasını ister
    // kullanıcı silme işlemini onayladıktan sonra
    // ilgili öge silinir.
    $("body").on('click', '.remove-btn', function () {
        var $data_url = $(this).data("url");
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Bir ögeyi silmek üzeresiniz. Bu işlem geri alınamaz!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = $data_url;
            }
        });
    });

    $("body").on('click', '.logout-btn', function () {
        let data_url = $(this).data("url");
        Swal.fire({
            title: 'Çıkış',
            text: 'Çıkış yapmak istiyor musunuz?',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet',
            cancelButtonText: 'Hayır'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = data_url;
            }
        });
    });
});
