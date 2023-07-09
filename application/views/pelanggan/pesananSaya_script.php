<script>
    function batalkanPesanan(kode) {
        $('#cancelKode').val(kode)
        $('#cancelModal').modal('show')
        $('h1#cancelModalLabel').text('Batalkan Pesanan ' + kode)
    }

    function hapusPesanan(kode) {
        $('#hapusKode').val(kode)
        $('#hapusModal').modal('show')
        $('h1#hapusModalLabel').text('Hapus Pesanan ' + kode)
    }
</script>

<script>
    $(function() {})

    function infoPesanan(kode) {
        $('.modal-body #content tbody').html('')

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Pelanggan/getInfoPesanan') ?>",
            data: {
                kode: kode
            },
            async: false,
            success: function(data) {
                var row_tr = '';
                if (data.length > 0) {
                    var total = 0;
                    var netto = 0;
                    for (let i = 0; i < data.length; i++) {
                        var rowData = data[i];
                        // console.log(rowData)
                        var jumlah = parseFloat(rowData.qtyp) * parseFloat(rowData.harga_jual)
                        var biaya = parseFloat(rowData.biaya)
                        total += parseFloat(jumlah)
                        // console.log(total)
                        netto = parseFloat(total) + biaya
                        row_tr += `
                            <tr>
                                <td style="text-align: left;">` + rowData.bahanbaku + `</td>
                                <td style="text-align: right;">` + rowData.qtyp + `</td>
                                <td style="text-align: right;">` + rowData.harga_jual.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + `</td>
                                <td style="text-align: right;">` + jumlah.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + `</td>
                            </tr>`;
                    }
                    row_tr += `<tr>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"><strong>Jumlah</strong> &nbsp; :</td>
                                <td style="text-align: right;">` + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + `</td>
                                </tr>
                                <tr>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"><strong>Biaya Jasa</strong> &nbsp; :</td>
                                <td style="text-align: right;">` + biaya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + `</td>
                                </tr>
                                <tr>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"> </td>
                                <td style="text-align: right;"><strong>Total Netto</strong> &nbsp; :</td>
                                <td style="text-align: right;">` + netto.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + `</td>
                            </tr>`;
                    $('.modal-body #content tbody').append(row_tr)
                    $('#detailModal').modal('show')
                } else {
                    bootbox.alert('<div class="alert alert-warning">Pesanan Anda Dalam Pengecekan</div>')
                }
            }
        })

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Pelanggan/cekPembayaran') ?>",
            data: {
                kodePsn: kode
            },
            async: false,
            success: function(data) {
                if (data) {
                    $('#pembayaran').text('Sedang Diproses')
                    $('#pembayaran').removeClass('btn btn-success')
                    $('#pembayaran').addClass('btn btn-info')
                    $('#pembayaran').prop('disabled', false)
                } else {
                    $('#pembayaran').text('Pembayaran')
                    $('#pembayaran').removeClass('btn btn-info')
                    $('#pembayaran').addClass('btn btn-success')
                    $('#pembayaran').prop('disabled', false)
                }
            }
        })

        $('#pembayaran').on('click', function() {
            window.location.href = "<?= base_url('pembayaran/') ?>" + kode;
        })
    }

    function accPsn(kode) {
        bootbox.confirm('Terima Pesanan ?', function(res) {
            if (res) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Transaksi/updateStatusPesanan') ?>",
                    data: {
                        kode: kode,
                        status: 'A'
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