import './bootstrap';

// 1. AlpineJS (Pengganti script alpine di CDN)
import Alpine from 'alpinejs';
document.addEventListener('fullscreenchange', () => {
    // Cari elemen html yang punya x-data untuk sinkronisasi isFull
    const root = document.querySelector('html');
    if (root && root._x_dataStack) {
        root._x_dataStack[0].isFull = !!document.fullscreenElement;
    }
});

window.Alpine = Alpine;
Alpine.start();

// 2. jQuery (Pengganti script jquery di CDN)
import $ from 'jquery';
window.$ = window.jQuery = $;

// 3. DataTables
import DataTable from 'datatables.net-dt';
window.DataTable = DataTable;

// 4. Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
window.L = L;