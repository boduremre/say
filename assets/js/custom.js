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
        let $data_url = $(this).data("url");
        swal({
            title: 'Emin misiniz?',
            text: 'Bir ögeyi silmek üzeresiniz. Bu işlem geri alınamaz!',
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: {
                    text: "İptal", // Cancel butonunun yazısı değiştirildi
                    value: null,
                    visible: true,
                    className: "btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "Evet, Sil!", // Confirm butonu da özelleştirilebilir
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true,
                }
            }
        }).then((result) => {
            if (result) {
                window.location.href = $data_url;
            }
        });
    });

    $("body").on('click', '.logout-btn', function () {
        let data_url = $(this).data("url");
        swal({
            title: 'Çıkış',
            text: 'Çıkış yapmak istiyor musunuz?',
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: {
                    text: "İptal", // Cancel butonunun yazısı değiştirildi
                    value: null,
                    visible: true,
                    className: "btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "Evet, Çıkış Yap!", // Confirm butonu da özelleştirilebilir
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true,
                }
            }
        }).then((result) => {
            if (result) {
                window.location.href = data_url;
            }
        });
    });

    // Clipboard.js ile div içeriğini kopyalama
    let clipboard = new ClipboardJS('.btn-copy');

    // Başarı mesajı göster
    clipboard.on('success', function (e) {
        swal("Bilgi", "İçerik başarıyla kopyalandı! Word’e yapıştırabilirsiniz.", "success");
        e.clearSelection(); // Seçimi temizle
    });

    // Hata yakalama
    clipboard.on('error', function (e) {
        swal("Hata", "Kopyalama başarısız! Tarayıcı izinlerini kontrol edin!", "error");
    });
});
