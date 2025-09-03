<!-- Load SweetAlert2 CDN -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Alert Success/Error -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    timer: 2500,
    showConfirmButton: false
});
</script>
@endif

<!-- Konfirmasi Hapus -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Data ini akan dihapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<!-- Konfirmasi Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusButtons = document.querySelectorAll('.btn-status');

    statusButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: "Ubah status transaksi?",
                text: "Pilih tindakan yang ingin dilakukan!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya, selesai!",
                denyButtonText: "Dibatalkan",
                cancelButtonText: "Batal",
                confirmButtonColor: "#28a745", 
                denyButtonColor: "#dc3545", // merah untuk dibatalkan
                cancelButtonColor: "#6c757d" // abu-abu untuk batal
            }).then((result) => {
                if (result.isConfirmed) {
                    // tombol "Selesai"
                    form.action = form.action + '/selesai'; // optional, atau handle di backend
                    form.submit();
                } else if (result.isDenied) {
                    // tombol "Dibatalkan"
                    form.action = form.action + '/dibatalkan'; // optional, atau handle di backend
                    form.submit();
                }
                // cancel tidak perlu action
            });
        });
    });
});
</script>


<!-- Konfirmasi LogOut -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.logout');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: "Apakah kamu yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
