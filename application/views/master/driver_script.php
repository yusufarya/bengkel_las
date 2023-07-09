<script>
    function deleteData(id, nama, level) {
        if (level > 1) {
            alert('Anda tidak mempunyai akses ini')
        } else {
            $('#deleteDataLabel').text('Hapus Data ' + nama + ' ?')
            $('#id_del').val(id)
            $('#deleteData').modal('show')
        }
    }

    function editData(id, nama, email, alamat, level) {
        if (level > 1) {
            alert('Anda tidak mempunyai akses ini')
        } else {
            $('#editDataLabel').text('Ubah Data ?')
            $('#id_edit').val(id)
            $('#nama_edit').val(nama)
            $('#email_edit').val(email)
            $('#alamat_edit').val(alamat)
            $('#alamat_edit').val(alamat)
            $('#editData').modal('show')
        }
    }
</script>