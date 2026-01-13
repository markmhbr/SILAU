<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfigurasi global Toast (Notifikasi kecil di pojok)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Alert Success
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    // Alert Error
    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Konfirmasi Hapus (Universal)
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: "Hapus data ini?",
                    text: "Tindakan ini tidak dapat dibatalkan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#e11d48", // Rose 600 (Tailwind)
                    cancelButtonColor: "#64748b",  // Slate 500
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                    borderRadius: '15px'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // 2. Konfirmasi Status (Universal untuk 'btn-status' dan 'btn-pending')
        const statusButtons = document.querySelectorAll('.btn-status, .btn-pending');
        statusButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const isPending = this.classList.contains('btn-pending');
                
                // Dinamis pesan berdasarkan class
                const confirmText = isPending ? "Ya, Proses!" : "Ya, Selesai!";
                const targetStatus = isPending ? "proses" : "selesai";

                Swal.fire({
                    title: "Update Status?",
                    text: `Ubah transaksi menjadi status ${targetStatus}?`,
                    icon: "question",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: confirmText,
                    denyButtonText: "Batalkan Pesanan",
                    cancelButtonText: "Kembali",
                    confirmButtonColor: "#2563eb", // Blue 600
                    denyButtonColor: "#e11d48",    // Rose 600
                    cancelButtonColor: "#64748b"   // Slate 500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.action = `${form.action}/${targetStatus}`;
                        form.submit();
                    } else if (result.isDenied) {
                        form.action = `${form.action}/dibatalkan`;
                        form.submit();
                    }
                });
            });
        });

        // 3. Konfirmasi Logout
        const logoutButtons = document.querySelectorAll('.logout');
        logoutButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: "Ingin keluar?",
                    text: "Sesi Anda akan berakhir di sini.",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#e11d48",
                    cancelButtonColor: "#64748b",
                    confirmButtonText: "Logout sekarang",
                    cancelButtonText: "Tetap di sini"
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

    });
</script>

<style>
    /* Agar UI SweetAlert selaras dengan Tailwind */
    .swal2-popup {
        border-radius: 1.5rem !important;
        font-family: inherit !important;
        padding: 2rem !important;
    }
    .swal2-title {
        font-weight: 800 !important;
        color: #1e293b !important;
    }
    .swal2-html-container {
        color: #64748b !important;
    }
    .swal2-confirm, .swal2-cancel, .swal2-deny {
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.75rem 1.5rem !important;
    }
</style>