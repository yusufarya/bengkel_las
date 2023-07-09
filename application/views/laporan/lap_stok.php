<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<div class="content-wrapper" onload='window.open("", "rpt" , " width=180,height=650" )'>
    <style>
        section {
            padding: 8px 20px;
        }

        h1,
        h3 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 3px 7px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <button style="background-color: #DAA520; width: 52px; height:58px; border: 0px solid #DAA520; border-radius:9px;" data-title="PRINT" onclick="cetakRkp()">
            <img src="<?php echo base_url('assets/icon/printer.svg') ?>" alt="PRINT" width="38" style="display: block;">
            <p style="display: inline; font-family: 'Courier New', Courier, monospace; font-weight: 600; font-size: 13;">Print</p>
            <!-- <i class="bi bi-printer" style="width: 50px; height:50px; "></i> -->
        </button>

        <div class="cetak">
            <br>
            <h1>Laporan Stok Bahan Baku</h1>
            <div style="text-align: center; margin-top: 10px;">Tanggal <?= date('d-m-Y') ?></div>
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row" style="background: #eaeaea;">

                    <table style="margin: 20px auto 0; width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 12.5px;">

                        <thead style="background-color: #DAA520;">
                            <tr>
                                <th style="text-align: left; width: 4%;">No.</th>
                                <th style="text-align: left;">Kode</th>
                                <th style="text-align: left;">Nama Bahan Baku</th>
                                <th style="text-align: right;">Stok</th>
                                <th style="text-align: right;">Harga Beli</th>
                                <th style="text-align: right;">Harga Jual</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($dataLap as $row) { ?>
                                <tr>
                                    <td style="text-align: center;"> <?= $no += 1 ?> </td>
                                    <td> <?= $row['kode'] ?> </td>
                                    <td> <?= $row['nama'] ?> </td>
                                    <td style="text-align: right;"> <?= number_format($row['stok']) ?> </td>
                                    <td style="text-align: right;"> <?= number_format($row['harga_beli'], 2) ?> </td>
                                    <td style="text-align: right;"> <?= number_format($row['harga_jual'], 2) ?> </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    <!-- <br> -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function cetakRkp() {
        // alert('ok')
        var isi = document.querySelector('.cetak');
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'h1, h3 {' +
            'font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;' +
            'padding: 0;' +
            'margin: 0;' +
            'text-align: center;' +
            '}' +
            'table {' +
            'margin: 10px auto 0;' +
            'border-collapse: collapse;' +
            'margin-top: 20px;' +
            '}' +
            'table, td, th {' +
            'border: 1px solid black;' +
            'padding: 3px 7px;' +
            '}' +
            '</style>';

        // var htmlToPrint = '' +
        //     '<style type="text/css">' +
        //     'table th, table td {' +
        //     'border:1px solid #000;' +
        //     'padding;0.5em;' +
        //     '}' +
        //     '</style>';

        console.log(htmlToPrint);
        htmlToPrint += isi.innerHTML;
        newWin = window.open("");
        // newWin.document.write("<h3 align='center'>Print Page</h3>");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();
        // window.print()
    }
</script>