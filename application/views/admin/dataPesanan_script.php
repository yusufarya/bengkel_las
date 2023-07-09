<script>
    function detail_tr(kode, bayar) {
        $('.idTR').modal('show')
        if (bayar == 'Y') {
            $('#btn-acc').hide()
        }
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/checkPaymentDetail') ?>",
            data: {
                nomor: kode,
                table: 'pembayaran'
            },
            success: (result) => {
                console.log(result)
                let gambar = result['gambar']
                let harga = result['harga']
                let no_rek = result['no_rek']
                let tanggal = result['tanggal']

                var img = '<?= base_url('assets/img/pembayaran/') ?>' + gambar

                $('#img-tr').attr('src', img);
                $('#metode_bayar').text(no_rek);
                $('#tgl').text(tanggal);
                $('#hrg').text(harga);
                $('#kode_pesanan').val(result['kode_pesan']);

                $('#btn-acc').on('click', function() {
                    let kodePesanan = $('#kode_pesanan').val()
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "<?= base_url('Transaksi/updateStatusBayar') ?>",
                        data: {
                            kode: kodePesanan,
                        },
                        success: function() {
                            window.location.reload()
                        }
                    })
                })
            }
        })
    }

    function prosesPesanan(kode) {
        alert("TELAH BAYAR")
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/updateStatusPesanan') ?>",
            data: {
                kode: kode,
                status: 'P'
            },
            success: (result) => {
                if (result) {
                    window.location.reload()
                }
            }
        })
    }

    function kirimPesanan(kode) {
        // alert(kode)
        bootbox.confirm('Proses Produksi Telah Selesai, Lanjutkan Proses Pengiriman ?', function(res) {
            if (res) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Transaksi/updateStatusPesanan') ?>",
                    data: {
                        kode: kode,
                        status: 'K'
                    },
                    success: (result) => {
                        if (result) {
                            window.location.reload()
                        }
                    }
                })
            }
        })
    }

    function pesananSelesai(kode) {
        bootbox.confirm('Pengiriman telah selesai ?', function(res) {
            if (res) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Transaksi/updateStatusPesanan') ?>",
                    data: {
                        kode: kode,
                        status: 'S'
                    },
                    success: (result) => {
                        if (result) {
                            window.location.reload()
                        }
                    }
                })
            }
        })
    }
</script>