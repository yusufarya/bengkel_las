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

    function editData(id, nama, no_telp, jns_kel, alamat, level) {
        if (level > 1) {
            alert('Anda tidak mempunyai akses ini')
        } else {
            $('#editDataLabel').text('Ubah Data ?')
            $('#kode_edit').val(id)
            $('#nama_edit').val(nama)
            $('#no_telp_edit').val(no_telp)
            $('#jns_kel_edit').val(jns_kel).change();
            $('#alamat_edit').val(alamat)
            $('#editData').modal('show')
        }
    }
</script>