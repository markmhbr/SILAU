<script>
    document.addEventListener('fullscreenchange', () => {
        // Mengupdate Alpine.js variable isFull ketika status fullscreen berubah (termasuk via ESC)
        const alpineData = document.querySelector('[x-data]').__x.$data;
        alpineData.isFull = !!document.fullscreenElement;
    });
</script>

@include('partials.dataTables')
@include('partials._sweetalert')
