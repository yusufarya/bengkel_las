<script>
    function lanjutkan(kode, harga) {
        let no_rek = $('#no_rek').val()
        if (no_rek == '') {
            bootbox.alert('<strong class="text-danger">Pilih metode bayar terlebih dahulu.</strong>')
        } else {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?= base_url('Pelanggan/insertBayar') ?>",
                data: {
                    kode: kode,
                    no_rek: no_rek,
                    harga: harga
                },
                success: function(res) {
                    location.reload()
                }
            })
        }
    }
</script>