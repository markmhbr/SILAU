@extends('layouts.backend')

@section('title', 'Kelola Akun')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        {{-- HEADER --}}
        <div>
            <nav class="flex text-[10px] uppercase tracking-widest text-slate-400 mb-2 space-x-2 font-bold">
                <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="hover:text-brand transition">Home</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">Kelola Akun</span>
            </nav>
            <div class="flex items-center gap-4">
                <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                    Pengaturan Akun
                </h2>
                <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase 
                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : '' }}
                    {{ $user->role === 'owner' ? 'bg-emerald-100 text-emerald-600' : '' }}
                    {{ $user->role === 'karyawan' ? 'bg-blue-100 text-blue-600' : '' }}
                    {{ $user->role === 'pelanggan' ? 'bg-orange-100 text-orange-600' : '' }}">
                    {{ $user->role }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- FORM EMAIL --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-200 dark:border-slate-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <h3 class="text-lg font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3 italic">
                    <span class="p-2 bg-blue-500 text-white rounded-lg shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </span>
                    Update Email
                </h3>

                <form action="{{ route('akun.email', ['role' => auth()->user()->role]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama User</label>
                        <input type="text" value="{{ $user->name }}" disabled class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 dark:bg-slate-800/50 dark:border-slate-800 text-slate-400 font-semibold cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Aktif</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="nama@email.com"
                            class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-4 focus:ring-blue-500/10 font-semibold transition-all">
                        @error('email') <p class="text-rose-500 text-[10px] font-bold mt-2 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-sm transition-all">
                        Simpan Email Baru
                    </button>
                </form>
            </div>

            {{-- FORM PASSWORD --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-200 dark:border-slate-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <h3 class="text-lg font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3 italic">
                    <span class="p-2 bg-rose-500 text-white rounded-lg shadow-lg shadow-rose-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    Ganti Password
                </h3>

                <form action="{{ route('akun.password', ['role' => auth()->user()->role]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    @php $fields = [
                        ['name' => 'current_password', 'label' => 'Password Lama', 'placeholder' => '••••••••'],
                        ['name' => 'password', 'label' => 'Password Baru', 'placeholder' => 'Minimal 8 karakter'],
                        ['name' => 'password_confirmation', 'label' => 'Ulangi Password', 'placeholder' => 'Ketik ulang password']
                    ]; @endphp

                    @foreach($fields as $field)
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">{{ $field['label'] }}</label>
                        <div class="relative group">
                            <input type="password" name="{{ $field['name'] }}" required placeholder="{{ $field['placeholder'] }}"
                                class="password-field w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-4 focus:ring-rose-500/10 font-semibold transition-all">
                            <button type="button" class="toggle-password absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error($field['name']) <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                    </div>
                    @endforeach

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-900 dark:bg-rose-500 hover:bg-black text-white px-8 py-4 rounded-2xl font-black text-sm transition-all shadow-lg shadow-rose-500/20">
                            Update Keamanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.password-field');
                input.type = input.type === 'password' ? 'text' : 'password';
                this.classList.toggle('text-rose-500');
            });
        });
    </script>
@endsection