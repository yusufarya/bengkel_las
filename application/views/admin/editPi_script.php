<script>
    $(function() {
        // $('#rowBarang').hide()
        // $('#rowDetail').hide()
        $('#addData').hide()

        getDataDetail()

        $('#addData').on('click', function() {
            var table = 'BL'
            var nomor = $('#nomor').val()
            var tanggal = $('#tanggal').val()
            var suplier = $('#suplier').val()
            var keterangan = $('#keterangan').val()

            if (suplier != '') {
                // GET NOMOR PEMBELIAN //
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Transaksi/getNomorHd'); ?>",
                    data: {
                        table: table,
                        nomor: nomor,
                        tanggal: tanggal,
                        suplier: suplier,
                        keterangan: keterangan
                    },
                    async: false,
                    success: function(result) {
                        $('#addData').hide()
                        // console.log(result)
                        $('#tanggal').prop('readonly', true)
                        $('#suplier').prop('readonly', true)
                        $('#keterangan').prop('readonly', true)

                        $('#nomor').val(result)
                        $('#rowBarang').show()
                        $('#rowDetail').show()
                    }
                })
            } else {
                bootbox.alert('<div class="text-danger">Pilih Suplier Terlebih dahulu</div>')
            }
        })

        var barangInfo = <?= json_encode($barangInfo) ?>;
        var optionVal = '';
        for (let index = 0; index < barangInfo.length; index++) {
            var dataBrg = barangInfo[index];
            // console.log(dataBrg)
            optionVal += `<option value="` + dataBrg['kode'] + `"> ` + dataBrg['nama'] + `</option>`
        }
        var nourut = 0;
        $('#addDetail').on('click', function() {
            nourut = +1;
            let kode_psn = $('#kode_pesanan').val()
            if (kode_psn != '') {
                let nomor = $('#nomor').val()
                $('#addDetail').prop('disabled', true)
                $('#kode_pesanan').attr('disabled', true)
                var html = `<tr id="myTableRow">` +
                    `<td></td>` +
                    `<td>` +
                    `<select name="bahan_baku" id="bahan_baku" class="form-select">` +
                    `<option value="">Pilih Barang</option>` +
                    optionVal +
                    `</select>` +
                    `</td>` +
                    `<td style="text-align: right;"><input class="form-control" type="text" id="qty" name="qty" placeholder="0" style="text-align: right; width: 100%;"></td>` +
                    `<td style="text-align: right;"><input class="form-control" type="text" id="harga" name="harga" placeholder="0" style="text-align: right;"></td>` +
                    `<td style="text-align: right;"><input class="form-control" type="text" id="jumlah" name="jumlah" readonly placeholder="0" style="text-align: right;"></td>` +
                    `<td style="text-align: center;">
                        <button type="button" class="btn btn-sm bg-primary px-2" onclick="add()"><i class="bi bi-plus-square-fill"></i></button> 
                        <button type="button" class="btn btn-sm bg-danger px-2" onclick="cancel()">&nbsp;X&nbsp;</button></td>` +
                    `</tr>`;

                $('#table-detail tbody').append(html)
            } else {
                bootbox.alert('<span style="color:red">Kode Pesanan Harus Dipilih.</span>')
            }

            $('select#bahan_baku').on('change', function() {
                let kodebr = $(this).val()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Master/getHargaBarang') ?>",
                    data: {
                        kode: kodebr
                    },
                    async: false,
                    success: (result) => {
                        console.log(result)
                        $('#harga').val(result['harga_beli'])
                    }
                })
            })

            $('#qty, #harga').on('change', function() {
                let harga = $('#harga').val()
                harga = harga ? parseFloat(harga) : 0
                let qty = $('#qty').val()
                qty = qty ? parseFloat(qty) : 0
                var jumlah = qty * harga
                $('#jumlah').val(jumlah)
            })
        })
        // end adddetail //
    })

    function cancel() {
        $('#myTableRow').remove();
        $('#addDetail').prop('disabled', false)
    }

    // button add //
    function add() {
        let nomor = $('#nomor').val()
        let nourut = $('#nourut').val()
        let tanggal = $('#tanggal').val()
        let kode_psn = $('#kode_pesanan').val()
        let bahan_baku = $('#bahan_baku').val()
        let qty = $('#qty').val()
        let harga = $('#harga').val()

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Pembelian/addDataPembelianDetail') ?>",
            data: {
                nomor: nomor,
                nourut: nourut,
                tanggal: tanggal,
                kode_psn: kode_psn,
                bahan_baku: bahan_baku,
                qty: qty,
                harga: harga,
            },
            async: false,
            success: function(result) {
                console.log(result)
                if (result.status == 'success') {
                    getDataDetail()
                }
            }
        })
    }

    function edit(nomor, nourut, bahan_baku, qty, harga) {
        $('#modal-edit').modal('show')
        $('#ebahan_baku').val(bahan_baku)
        $('#enourut').val(nourut)
        $('#eqty').val(qty)
        $('#eqty_old').val(qty)
        $('#ehrg').val(harga)
    }

    $('#simpanDt').on('click', function() {
        let bahan_baku = $('#ebahan_baku').val()
        let nomor = $('#nomor').val()
        let nourut = $('#enourut').val()
        let qty = $('#eqty').val()
        let qty_old = $('#eqty_old').val()
        let harga = $('#ehrg').val()
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/updateDetail') ?>",
            data: {
                nomor: nomor,
                nourut: nourut,
                qty: qty,
                qty_old: qty_old,
                harga: harga,
                bahan_baku: bahan_baku,
                table: 'pembelian_detail'
            },
            success: function(result) {
                if (result) {
                    $('#modal-edit').modal('hide')
                    getDataDetail()
                }
            }
        })
    })

    function del(nomor, nourut, bahan_baku, qty) {
        var rowCount = $('#table-detail tbody tr').length;
        bootbox.confirm('Hapus data ' + nourut + ' ? ', function(res) {
            if (res) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url('Transaksi/deleteDetail') ?>",
                    data: {
                        nomor: nomor,
                        nourut: nourut,
                        rowCountDT: rowCount,
                        qty: qty,
                        bahan_baku: bahan_baku,
                        table: 'pembelian_detail'
                    },
                    success: function(result) {
                        if (result) {
                            getDataDetail()
                            if (rowCount == 1) {
                                window.location.reload();
                            }
                        }
                    }
                })
            }
        })
    }

    function getDataDetail() {
        $('#addDetail').prop('disabled', false)
        let nomor = $('#nomor').val()
        let kode_psn = $('#kode_pesanan').val()
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/getDataDetail') ?>",
            data: {
                nomor: nomor,
                kode_psn: kode_psn,
                table: 'pembelian_detail'
            },
            success: function(result) {
                var html = '';
                $('#table-detail tbody').html('')
                if (result.length > 0) {
                    $('#kode_pesanan').prop('disabled', true)
                    for (let idx = 0; idx < result.length; idx++) {
                        let detailVal = result[idx];

                        html += `<tr>` +
                            `<td>` + detailVal['nourut'] + `</td>` +
                            `<td>` +
                            `<input readonly class="form-control" value="` + detailVal['bahan_baku'] + `">` +
                            `</td>` +
                            `<td style="text-align: right;"><input readonly class="form-control" type="text" placeholder="0" style="text-align: right; width: 100%;" value="` + detailVal['qty'] + `"></td>` +
                            `<td style="text-align: right;"><input readonly class="form-control" type="text" placeholder="0" style="text-align: right;" value="` + detailVal['harga'] + `"></td>` +
                            `<td style="text-align: right;"><input readonly class="form-control" type="text" readonly placeholder="0" style="text-align: right;"  value="` + parseFloat(detailVal['qty']) * parseFloat(detailVal['harga']) + `"></td>` +
                            `<td style="text-align: center">
                                <button type="button" class="btn btn-sm bg-primary" onclick="edit('` + detailVal['nomor'] + `','` + detailVal['nourut'] + `','` + detailVal['bahan_baku'] + `','` + detailVal['qty'] + `','` + detailVal['harga'] + `')"><i class="bi bi-pencil-square"></i></button> 
                                <button type="button" class="btn btn-sm bg-danger" onclick="del('` + detailVal['nomor'] + `','` + detailVal['nourut'] + `','` + detailVal['bahan_baku'] + `','` + detailVal['qty'] + `')"><i class="bi bi-trash3-fill"></i></button>
                            </td>` +
                            `</tr>`;
                    }

                    $('#table-detail tbody').append(html)
                } else {
                    $('#kode_pesanan').prop('disabled', false)
                }

            }
        })
    }

    function simpan() {

        var nomor = $('#nomor').val()
        var keterangan = $('#keterangan').val()

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Transaksi/simpanData') ?>",
            data: {
                nomor: nomor,
                keterangan: keterangan,
                kode: 'BL'
            },
            async: false,
            success: function(result) {
                if (result) {
                    window.location.href = "<?= base_url('piList') ?>";
                }
            }
        })
    }
</script>