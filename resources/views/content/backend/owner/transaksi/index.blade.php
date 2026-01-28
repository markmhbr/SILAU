@extends('layouts.backend')

@section('title', 'Transaksi Owner')

@section('content')
    <div class="">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Data Transaksi 🧾
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Monitoring seluruh transaksi bisnis
                </p>
            </div>

            {{-- ACTION --}}
            <div class="flex gap-3">
                <a href="{{ route('owner.transaksi.export.excel', request()->query()) }}"
                    class="px-5 py-3 rounded-[1.5rem] bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20">
                    ⬇ Export Excel
                </a>
                <a href="{{ route('owner.transaksi.export.pdf') }}"
                    class="px-5 py-3 rounded-[1.5rem] bg-red-500 text-white text-sm font-bold shadow-lg shadow-red-500/20">
                    ⬇ Export PDF
                </a>
            </div>
        </div>

        {{-- ================= SUMMARY ================= --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">

            <div class="bg-blue-50 dark:bg-blue-950/30 p-6 rounded-[2rem] border">
                <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg">
                    🧾
                </div>
                <p class="text-xl font-black text-blue-600 dark:text-blue-400">
                    {{ $transaksi->total() }}
                </p>
                <p class="text-xs text-slate-500">Total Transaksi</p>
            </div>

            <div class="bg-emerald-50 dark:bg-emerald-950/30 p-6 rounded-[2rem] border">
                <div
                    class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg">
                    💰
                </div>
                <p class="text-xl font-black text-emerald-600 dark:text-emerald-400">
                    Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-slate-500">Total Omzet</p>
            </div>

            <div class="bg-amber-50 dark:bg-amber-950/30 p-6 rounded-[2rem] border">
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg">
                    ⏳
                </div>
                <p class="text-xl font-black text-amber-600 dark:text-amber-400">
                    {{ $proses ?? 0 }}
                </p>
                <p class="text-xs text-slate-500">Proses</p>
            </div>

            <div class="bg-purple-50 dark:bg-purple-950/30 p-6 rounded-[2rem] border">
                <div class="w-12 h-12 bg-purple-500 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg">
                    ✅
                </div>
                <p class="text-xl font-black text-purple-600 dark:text-purple-400">
                    {{ $selesai ?? 0 }}
                </p>
                <p class="text-xs text-slate-500">Selesai</p>
            </div>

        </div>

        {{-- ================= FILTER ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 mb-10 shadow-sm">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                {{-- FROM DATE --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Dari Tanggal
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📅</span>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">
                    </div>
                </div>

                {{-- TO DATE --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Sampai Tanggal
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📅</span>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">
                    </div>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-2 block">
                        Status
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">⚙️</span>
                        <select name="status"
                            class="w-full pl-11 pr-4 py-3 rounded-[1.5rem] border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-brand focus:border-brand">
                            <option value="">Semua Status</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                {{-- FILTER BUTTON --}}
                <div>
                    <button
                        class="w-full py-3 rounded-[1.5rem] bg-slate-800 dark:bg-white dark:text-slate-900 text-white font-black flex items-center justify-center gap-2 hover:scale-[1.02] transition">
                        🔍 Filter
                    </button>
                </div>

                {{-- RESET --}}
                <div>
                    <a href="{{ route('owner.transaksi.index') }}"
                        class="w-full py-3 rounded-[1.5rem] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center gap-2 hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                        ♻ Reset
                    </a>
                </div>

            </form>
        </div>


        {{-- ================= TABLE ================= --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border p-6 shadow-sm">
            <h2 class="text-xl font-bold mb-6">Daftar Transaksi</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-separate border-spacing-y-3 text-sm">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">Layanan</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksi as $item)
                            <tr class="bg-slate-50/70 dark:bg-slate-800/40">
                                <td class="px-4 py-4">{{ $item->tanggal_masuk?->format('d M Y') }}</td>
                                <td class="px-4 py-4 font-bold">{{ $item->pelanggan->user->name ?? 'Guest' }}</td>
                                <td class="px-4 py-4">{{ $item->layanan->nama_layanan ?? '-' }}</td>
                                <td class="px-4 py-4 font-black text-emerald-600">
                                    Rp {{ number_format($item->hargaSetelahDiskon(), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                    {{ $item->status == 'selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="openModal({{ $item->id }})"
                                        class="px-3 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-400">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $transaksi->withQueryString()->links() }}
            </div>
        </div>

    </div>

    {{-- ================= MODAL ================= --}}
    <div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 w-full max-w-lg">
            <h3 class="text-xl font-black mb-6">Detail Transaksi</h3>

            <div class="space-y-3 text-sm">
                <p><b>Tanggal:</b> <span id="d-tanggal"></span></p>
                <p><b>Pelanggan:</b> <span id="d-pelanggan"></span></p>
                <p><b>Karyawan:</b> <span id="d-karyawan"></span></p>
                <p><b>Layanan:</b> <span id="d-layanan"></span></p>
                <p><b>Berat:</b> <span id="d-berat"></span> Kg</p>
                <p><b>Status:</b> <span id="d-status"></span></p>
                <p><b>Total:</b> Rp <span id="d-total"></span></p>
                <p><b>Setelah Diskon:</b> Rp <span id="d-final"></span></p>
                <p><b>Catatan:</b> <span id="d-catatan"></span></p>
            </div>

            <div class="text-right mt-6">
                <button onclick="closeModal()" class="px-5 py-2 rounded-xl bg-slate-800 text-white font-bold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            fetch(`/owner/transaksi/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('d-tanggal').innerText = data.tanggal;
                    document.getElementById('d-pelanggan').innerText = data.pelanggan;
                    document.getElementById('d-karyawan').innerText = data.karyawan;
                    document.getElementById('d-layanan').innerText = data.layanan;
                    document.getElementById('d-berat').innerText = data.berat;
                    document.getElementById('d-status').innerText = data.status;
                    document.getElementById('d-total').innerText = data.total;
                    document.getElementById('d-final').innerText = data.final;
                    document.getElementById('d-catatan').innerText = data.catatan;

                    document.getElementById('modal').classList.remove('hidden');
                    document.getElementById('modal').classList.add('flex');
                });
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }
    </script>

@endsection
