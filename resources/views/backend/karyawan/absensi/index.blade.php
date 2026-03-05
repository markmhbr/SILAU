@extends('layouts.backend')

@section('title', 'Absensi Karyawan')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Absensi Harian</h1>
            <p class="text-slate-500 mt-2">Catat kehadiran Anda setiap hari kerja.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Card Absen Masuk -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 text-center">
                <h2 class="text-xl font-bold mb-4">Absen Masuk</h2>
                @if ($absensiHariIni)
                    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-4">
                        <i class="fas fa-check-circle text-2xl mb-2 block"></i>
                        <p class="font-bold">Sudah Absen Masuk</p>
                        <p class="text-sm">Pukul: {{ $absensiHariIni->waktu_masuk }}</p>
                    </div>
                @else
                    <form action="{{ route('karyawan.absensi.masuk') }}" method="POST" id="form-masuk">
                        @csrf
                        <input type="hidden" name="latitude" id="lat-masuk">
                        <input type="hidden" name="longitude" id="lng-masuk">
                        <button type="button" onclick="getLocationAndSubmit('form-masuk')"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i> Klik Untuk Absen Masuk
                        </button>
                    </form>
                @endif
            </div>

            <!-- Card Absen Keluar -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 text-center">
                <h2 class="text-xl font-bold mb-4">Absen Keluar</h2>
                @if (!$absensiHariIni)
                    <div class="bg-slate-50 text-slate-500 p-4 rounded-xl mb-4">
                        <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                        <p>Silakan absen masuk terlebih dahulu.</p>
                    </div>
                @elseif($absensiHariIni->waktu_keluar)
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl mb-4">
                        <i class="fas fa-check-circle text-2xl mb-2 block"></i>
                        <p class="font-bold">Sudah Absen Keluar</p>
                        <p class="text-sm">Pukul: {{ $absensiHariIni->waktu_keluar }}</p>
                    </div>
                @else
                    <form action="{{ route('karyawan.absensi.keluar') }}" method="POST" id="form-keluar">
                        @csrf
                        <button type="submit"
                            class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i> Klik Untuk Absen Keluar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Riwayat Absensi -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold">Riwayat Kehadiran (30 Hari Terakhir)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Waktu Masuk</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Waktu Keluar</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($riwayatAbsensi as $absen)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                                <td class="px-6 py-4">{{ $absen->waktu_masuk ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $absen->waktu_keluar ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $absen->status == 'hadir'
                                    ? 'bg-green-100 text-green-700'
                                    : ($absen->status == 'izin'
                                        ? 'bg-blue-100 text-blue-700'
                                        : ($absen->status == 'sakit'
                                            ? 'bg-amber-100 text-amber-700'
                                            : 'bg-red-100 text-red-700')) }}">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function getLocationAndSubmit(formId) {
                if (navigator.geolocation) {
                    // Tampilkan loading state
                    const btn = document.querySelector(`#${formId} button`);
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mendapatkan Lokasi...';
                    btn.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            document.getElementById('lat-masuk').value = position.coords.latitude;
                            document.getElementById('lng-masuk').value = position.coords.longitude;
                            document.getElementById(formId).submit();
                        },
                        function(error) {
                            alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan pada browser Anda.');
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }, {
                            enableHighAccuracy: true
                        }
                    );
                } else {
                    alert("Geolocation tidak didukung oleh browser ini.");
                    document.getElementById(formId).submit(); // Submit tanpa lokasi
                }
            }
        </script>
    @endpush
@endsection
