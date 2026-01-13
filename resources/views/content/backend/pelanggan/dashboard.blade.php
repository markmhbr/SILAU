@extends('layouts.pelanggan')

@section('pelanggan')
    <div class="">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center mb-8 md:mb-10">
            <div class="lg:col-span-2 text-left">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">
                    Halo, {{ Auth::user()->name }}! <span class="inline-block animate-bounce">👕</span>
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-base md:text-lg leading-relaxed">
                    {{ date('H') < 12 ? 'Selamat pagi!' : (date('H') < 18 ? 'Selamat siang!' : 'Selamat malam!') }} Pantau
                    cucianmu di sini.
                </p>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-brand dark:to-indigo-600 p-6 rounded-[2rem] flex justify-between items-center shadow-xl shadow-slate-200 dark:shadow-brand/20 relative overflow-hidden group">
    <div class="relative z-10">
        <p class="text-[10px] font-bold text-slate-400 dark:text-brand-50 uppercase tracking-[0.2em]">
            Poin Pelanggan
        </p>
        <p class="text-2xl font-black mt-1 text-white">
            {{ number_format($pelanggan->poin ?? 0, 0, ',', '.') }} pts
        </p>
    </div>
    <button class="relative z-10 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/20 text-xs font-bold px-5 py-2.5 rounded-2xl transition-all active:scale-90">
        Detail
    </button>
</div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            <div
                class="bg-indigo-50 dark:bg-indigo-950/30 p-5 md:p-6 rounded-[2rem] border border-indigo-100 dark:border-indigo-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-indigo-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-indigo-500/30">
                    🚚</div>
                <p class="text-indigo-600 dark:text-indigo-400 font-black text-sm md:text-base">{{ $totalProses }} Pesanan
                </p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">Sedang Aktif</p>
            </div>

            <div
                class="bg-emerald-50 dark:bg-emerald-950/30 p-5 md:p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-emerald-500/30">
                    ✅</div>
                <p class="text-emerald-600 dark:text-emerald-400 font-black text-sm md:text-base">{{ $totalSelesai }}
                    Selesai</p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium">Total Riwayat</p>
            </div>

            <div
                class="bg-orange-50 dark:bg-orange-950/30 p-5 md:p-6 rounded-[2rem] border border-orange-100 dark:border-orange-900/50">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white text-lg md:text-xl mb-4 shadow-lg shadow-orange-500/30">
                    💎</div>
                <p class="text-orange-600 dark:text-orange-400 font-black text-sm md:text-base">Status Akun</p>
                <p class="text-[11px] md:text-sm text-slate-500 font-medium italic uppercase">Regular</p>
            </div>

            <div
                class="bg-pink-50 dark:bg-pink-950/30 p-5 md:p-6 rounded-[2rem] border border-pink-100 dark:border-pink-900/50 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-pink-600 dark:text-pink-400 font-black text-sm md:text-base">Promo</p>
                    <p class="text-[11px] md:text-sm text-slate-500 font-medium">Cek Kupon Anda</p>
                </div>
                <span class="absolute right-[-5px] bottom-[-5px] text-4xl opacity-20">🔥</span>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-6 md:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">Aktivitas Terakhir</h2>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Status pesanan terbaru Anda.</p>
                </div>
                <a href="{{ route('pelanggan.pesanan') }}"
                    class="text-brand font-bold text-xs md:text-sm flex items-center gap-2 hover:translate-x-1 transition-all">
                    Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($transaksiAktif as $transaksi)
                    <div
                        class="flex flex-col md:flex-row md:items-center p-5 md:p-6 rounded-[2rem] bg-slate-50/50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 gap-6">
                        <div class="flex items-center gap-4 flex-1">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-sm text-xl shrink-0">
                                🧺
                            </div>
                            <div>
                                <p class="font-black text-slate-800 dark:text-white text-sm md:text-base capitalize">
                                    {{ $transaksi->layanan->nama_layanan }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest font-mono">ID:
                                    #INV-{{ $transaksi->id }}{{ date('dmY', strtotime($transaksi->tanggal_masuk)) }}</p>
                            </div>
                        </div>

                        <div class="flex flex-1 items-center gap-1.5 px-2">
                            <div class="h-1.5 flex-1 bg-brand rounded-full"></div>
                            <div
                                class="h-1.5 flex-1 {{ in_array($transaksi->status, ['proses', 'selesai']) ? 'bg-brand' : 'bg-slate-200 dark:bg-slate-700' }} rounded-full {{ $transaksi->status == 'proses' ? 'animate-pulse' : '' }}">
                            </div>
                            <div
                                class="h-1.5 flex-1 {{ $transaksi->status == 'selesai' ? 'bg-brand' : 'bg-slate-200 dark:bg-slate-700' }} rounded-full">
                            </div>
                        </div>

                        <div class="flex justify-between md:block md:text-right shrink-0">
                            <p class="text-xs md:text-sm font-black text-brand uppercase tracking-tighter">
                                {{ $transaksi->status }}</p>
                            <p class="text-[10px] md:text-xs text-slate-400 mt-0.5">{{ $transaksi->berat }} Kg • Rp
                                {{ number_format($transaksi->harga_setelah_diskon, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-slate-400 italic text-sm">Belum ada pesanan aktif.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
