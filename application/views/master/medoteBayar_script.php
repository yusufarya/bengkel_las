<script>
    function deleteData(kode, nama, level) {
        if (level > 1) {
            alert('Anda tidak mempunyai akses ini')
        } else {
            $('#deleteDataLabel').text('Hapus Data ' + nama + ' ?')
            $('#kode_del').val(kode)
            $('#deleteData').modal('show')
        }
    }

    function editData(kode, nama, norek, level) {
        if (level > 1) {
            alert('Anda tidak mempunyai akses ini')
        } else {
            $('#editDataLabel').text('Ubah Data ' + nama + ' ?')
            $('#kode_edit').val(kode)
            $('#nama_bank_edit').val(nama)
            $('#norek_edit').val(norek)
            $('#editData').modal('show')
        }
    }
</script>