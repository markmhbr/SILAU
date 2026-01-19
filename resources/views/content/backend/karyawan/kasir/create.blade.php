@extends('layouts.backend')

@section('title', 'Kasir - Input Transaksi')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-black text-slate-800">Kasir: Input Pesanan</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border p-8">
                <form action="{{ route('kasir.transaksi.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="p-6 bg-brand/5 border border-brand/20 rounded-3xl">
                            <label class="block text-sm font-bold mb-2">Cari Member (Email)</label>
                            <div class="flex gap-3">
                                <input type="email" id="emailSearch" class="flex-1 px-5 py-3 rounded-2xl border focus:ring-2 focus:ring-brand outline-none text-sm" placeholder="Masukkan email pelanggan...">
                                <button type="button" id="btnCekMember" class="px-6 py-3 bg-brand text-white rounded-2xl font-bold text-xs uppercase tracking-widest">Cek Member</button>
                            </div>
                            <div id="memberInfo" class="mt-4 hidden">
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-emerald-200">
                                    <span class="text-emerald-500">✅</span>
                                    <div>
                                        <p id="memberName" class="font-bold text-sm text-slate-800"></p>
                                        <p id="memberPhone" class="text-xs text-slate-500"></p>
                                        <input type="hidden" name="pelanggan_id" id="pelangganId">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Layanan</label>
                                <select name="layanan_id" id="layananSelect" class="w-full px-5 py-3.5 rounded-2xl border appearance-none cursor-pointer text-sm" required>
                                    <option value="" disabled selected>- Pilih Layanan -</option>
                                    @foreach ($layanan as $l)
                                        <option value="{{ $l->id }}" data-harga="{{ $l->harga_perkilo }}">{{ $l->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Berat (KG)</label>
                                <input type="number" step="0.1" name="berat" id="beratInput" class="w-full px-5 py-3.5 rounded-2xl border text-sm" placeholder="0.0" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-slate-800 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-black transition-all">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white sticky top-24">
                <h4 class="font-black text-xl mb-6">Ringkasan Kasir</h4>
                <div class="space-y-4 border-b border-white/10 pb-6 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-white/60">Total Harga</span>
                        <span id="label-total" class="font-bold text-2xl text-brand">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic AJax Cari Member
    document.getElementById('btnCekMember').addEventListener('click', function() {
        const email = document.getElementById('emailSearch').value;
        const infoDiv = document.getElementById('memberInfo');
        
        fetch(`{{ route('kasir.get-pelanggan') }}?email=${email}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    infoDiv.classList.remove('hidden');
                    document.getElementById('memberName').textContent = data.user.name;
                    document.getElementById('memberPhone').textContent = data.pelanggan.no_hp;
                    document.getElementById('pelangganId').value = data.pelanggan.id;
                } else {
                    alert('Member tidak ditemukan!');
                    infoDiv.classList.add('hidden');
                    document.getElementById('pelangganId').value = '';
                }
            });
    });

    // Reuse Logic Kalkulasi dari form.blade.php Anda
    const layananSelect = document.getElementById('layananSelect');
    const beratInput = document.getElementById('beratInput');
    const labelTotal = document.getElementById('label-total');

    function calculate() {
        const harga = parseFloat(layananSelect.options[layananSelect.selectedIndex]?.dataset.harga || 0);
        const berat = parseFloat(beratInput.value || 0);
        labelTotal.textContent = `Rp ${(harga * berat).toLocaleString('id-ID')}`;
    }

    layananSelect.addEventListener('change', calculate);
    beratInput.addEventListener('input', calculate);
</script>
@endsection