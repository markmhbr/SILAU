@extends('layouts.backend')

@section('title', 'Input Transaksi Baru')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Kasir Laundry</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Input pesanan masuk dari pelanggan (Member/Guest).</p>
        </div>
    </div>

    <form action="{{ route('karyawan.kasir.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- SISI KIRI: FORM INPUT --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- SECTION: DATA PELANGGAN --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="p-2 bg-brand/10 text-brand rounded-lg text-xl">👤</span>
                        <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-wider text-sm">Data Pelanggan</h3>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Cari Member (Email)</label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="emailSearch" 
                                class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-brand outline-none transition text-sm"
                                placeholder="Masukkan email pelanggan (Kosongkan jika Guest)..."
                            >
                            <button 
                                type="button" 
                                id="btnCekMember" 
                                class="absolute right-2 top-2 bottom-2 px-4 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-brand transition"
                            >
                                Cek
                            </button>
                        </div>
                        
                        <div id="memberInfo" class="hidden p-4 rounded-2xl border border-emerald-100 bg-emerald-50 dark:bg-emerald-500/10 dark:border-emerald-500/20">
                            <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400">
                                ✅ Member Ditemukan: <span id="memberName" class="uppercase"></span>
                            </p>
                        </div>

                        <div id="guestInfo" class="p-4 rounded-2xl border border-slate-100 bg-slate-50 dark:bg-slate-800/50">
                            <p class="text-xs font-bold text-slate-500 italic">Transaksi diproses sebagai Pelanggan Guest (Tanpa Member)</p>
                        </div>
                    </div>
                </div>

                {{-- SECTION: DETAIL CUCIAN --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Layanan</label>
                            <select name="layanan_id" id="layananSelect" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none text-sm" required>
                                <option value="">- Pilih -</option>
                                @foreach($layanan as $l)
                                    <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}">
                                        {{ $l->nama_layanan }} (Rp {{ number_format($l->harga_perkilo) }}/kg)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Estimasi Berat</label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="estimasi_berat" 
                                    id="beratInput" 
                                    class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none text-sm" 
                                    placeholder="0.0" 
                                    required
                                >
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">KG</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Diskon</label>
                            <select name="diskon_id" id="diskonSelect" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none text-sm">
                                <option value="">- Tanpa Diskon -</option>
                                @foreach($diskon as $d)
                                    <option value="{{ $d->id }}" data-tipe="{{ $d->tipe }}" data-nilai="{{ $d->nilai }}" data-min="{{ $d->minimal_transaksi }}">
                                        {{ $d->nama_diskon }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Metode Bayar</label>
                            <select name="metode_pembayaran" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none text-sm" required>
                                <option value="tunai">Tunai / Cash</option>
                                <option value="qris">QRIS / E-Wallet</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold mb-2 text-slate-700 dark:text-slate-300">Catatan Pesanan (Opsional)</label>
                        <textarea name="catatan" rows="2" class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 outline-none text-sm" placeholder="Contoh: Baju putih jangan dicampur..."></textarea>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN: RINGKASAN --}}
            <div class="lg:col-span-1">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl sticky top-24">
                    <h4 class="font-black text-xl mb-6">Estimasi Nota</h4>
                    <div class="space-y-4 border-b border-white/10 pb-6 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-white/60">Subtotal</span>
                            <span id="label-subtotal" class="font-bold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-white/60">Diskon</span>
                            <span id="label-diskon" class="text-emerald-400 font-bold">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm pt-2 border-t border-white/5">
                            <span class="text-white/60">Estimasi Poin</span>
                            <span id="label-poin" class="text-amber-400 font-bold">+ 0</span>
                        </div>
                    </div>
                    <div class="mb-8">
                        <span class="text-[10px] text-white/50 uppercase font-black tracking-widest">Total Estimasi</span>
                        <h2 id="label-total" class="text-4xl font-black tracking-tighter">Rp 0</h2>
                    </div>

                    <button type="submit" class="w-full py-4 bg-brand hover:bg-brandDark text-white rounded-2xl font-black transition-all active:scale-95 uppercase tracking-widest text-sm">
                        Simpan & Proses
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Logic hitung otomatis tetap sama, hanya ganti label ID ke estimasi_berat jika perlu
    const layananSelect = document.getElementById('layananSelect');
    const beratInput = document.getElementById('beratInput');
    const diskonSelect = document.getElementById('diskonSelect');
    const labelSubtotal = document.getElementById('label-subtotal');
    const labelDiskon = document.getElementById('label-diskon');
    const labelTotal = document.getElementById('label-total');
    const labelPoin = document.getElementById('label-poin');

    function hitung() {
        const harga = parseFloat(layananSelect.options[layananSelect.selectedIndex]?.dataset.harga || 0);
        const beratVal = parseFloat(beratInput.value || 0);
        const subtotal = harga * beratVal;

        const diskonOpt = diskonSelect.options[diskonSelect.selectedIndex];
        const minTrans = parseFloat(diskonOpt?.dataset.min || 0);
        
        let potongan = 0;
        if (subtotal >= minTrans) {
            const diskonTipe = diskonOpt?.dataset.tipe || '';
            const diskonNilai = parseFloat(diskonOpt?.dataset.nilai || 0);
            potongan = diskonTipe === 'persentase' ? (subtotal * diskonNilai / 100) : diskonNilai;
        }
        
        const totalTagihan = Math.max(0, subtotal - potongan);
        const poin = Math.floor(totalTagihan / 1000); // Contoh: 1 poin tiap Rp 1.000

        labelSubtotal.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        labelDiskon.textContent = `- Rp ${potongan.toLocaleString('id-ID')}`;
        labelTotal.textContent = `Rp ${totalTagihan.toLocaleString('id-ID')}`;
        labelPoin.textContent = `+ ${poin.toLocaleString('id-ID')}`;
    }

    [layananSelect, beratInput, diskonSelect].forEach(e => {
        e.addEventListener('input', hitung);
        e.addEventListener('change', hitung);
    });

    // Ajax cek member
    document.getElementById('btnCekMember').onclick = async () => {
        const email = document.getElementById('emailSearch').value;
        if (!email) return alert('Masukkan email');

        try {
            const res = await fetch(`/karyawan/cek-member?email=${email}`);
            const data = await res.json();

            if (data.success) {
                document.getElementById('memberInfo').classList.remove('hidden');
                document.getElementById('guestInfo').classList.add('hidden');
                document.getElementById('memberName').textContent = data.nama;
            } else {
                alert('Member tidak ditemukan');
                document.getElementById('memberInfo').classList.add('hidden');
                document.getElementById('guestInfo').classList.remove('hidden');
            }
        } catch (error) { console.error(error); }
    };
</script>
@endsection