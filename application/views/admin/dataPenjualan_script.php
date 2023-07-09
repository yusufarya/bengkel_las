<script>
    function deleteTr(nomor) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/checkTransactionDetail') ?>",
            data: {
                nomor: nomor,
                table: 'penjualan_detail'
            },
            success: function(res) {
                if (res > 0) {
                    bootbox.alert('<b style="color:red;">Hapus detail terlebih dahulu</b>')
                } else {
                    $('.deleteTr').modal('show')
                    $('#hapus').html('Yakin ingin menghapus data Nomor <b>' + nomor + '</b> ?')
                    $('#del_kode').val(nomor)
                }
            }
        })
        // if (level < 2) {
        // } else {
        //     bootbox.alert('<b style="color:red;">Anda tidak memiliki akses ini</b>')
        // }
    }

    $('#btnDel').on('click', function() {
        var nomor = $('#del_kode').val()
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/deleteTrList') ?>",
            data: {
                nomor: nomor,
                table: 'penjualan'
            },
            success: function(res) {
                $('.deleteTr').modal('hide')
                bootbox.alert('1 Data Transaksi berhasil di hapus.. ✔️')
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        })
    })
</script>