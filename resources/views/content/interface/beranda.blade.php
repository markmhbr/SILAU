@extends('layouts.interface')

@section('title', 'Beranda')

@section('interface')


    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="gradient-text">Laundry Premium</span>
                <br> dengan Layanan Terbaik
            </h1>
            <p class="hero-subtitle">Pakaian bersih, wangi, dan rapi dalam sekejap</p>
            <div class="hero-buttons">
                <button class="btn-primary" type="button" onclick="window.location='{{ route('login') }}'">Mulai Sekarang</button>
                <button class="btn-secondary" type="button" onclick="window.location='{{ route('testimonial-form') }}'">Testimoni form</button>
            </div>
        </div>
        <div class="hero-animation">
            <div class="floating-item">
                <i class="fas fa-tshirt"></i>
            </div>
            <div class="floating-item">
                <i class="fas fa-soap"></i>
            </div>
            <div class="floating-item">
                <i class="fas fa-wind"></i>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="services-grid">
            @foreach ($layanans as $item)
                <div class="service-card">
                    <div class="service-icon">
                        <i class="
                            @if ($item->nama_layanan == 'Cuci Biasa') fas fa-gem 
                            @elseif ($item->nama_layanan == 'Cuci Regular') fas fa-tshirt 
                            @elseif ($item->nama_layanan == 'Cuci Express') fas fa-star 
                            @elseif ($item->nama_layanan == 'Setrikas Saja') fas fa-spray-can 
                            @endif
                        "></i>
                    </div>
                    <h3>{{ $item->nama_layanan }}</h3>
                    <p>{{ $item->deskripsi }}</p>
                    <div class="price">Rp {{ number_format($item->harga_perkilo, 0, ',', '.') }}/kg</div>
                </div>
            @endforeach

            </div>
        </div>
    </section>
    
    <!-- Calculator Section -->
    <section id="calculator" class="calculator">
        <div class="container">
            <h2 class="section-title">Kalkulator Harga</h2>
            <div class="calculator-container">
                <div class="calculator-form">
                    <div class="form-group">
                        <label for="service-type">Jenis Layanan</label>
                        <select id="service-type">
                            @foreach ( $layanans as $items)
                                
                            <option value="{{ $items ->harga_perkilo }}">{{ $items -> nama_layanan }} - Rp {{ number_format($items->harga_perkilo, 0, ',', '.') }}/kg</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="weight">Berat (kg)</label>
                        <input type="number" id="weight" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label for="discount">Kode Promo (opsional)</label>
                        <select id="discount">
                            <option value="">-- Pilih Promo --</option>
                            @foreach ($diskons as $diskon)
                                <option value="{{ $diskon->id }}" 
                                    data-tipe="{{ $diskon->tipe }}" 
                                    data-nilai="{{ $diskon->nilai }}">
                                    {{ $diskon->kode }} 
                                    ({{ $diskon->tipe == 'persentase' ? $diskon->nilai . '%' : 'Rp ' . number_format($diskon->nilai, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn-calculate" onclick="calculatePrice()">Hitung Harga</button>
                </div>
                <div class="calculator-result">
                    <h3>Total Harga</h3>
                    <div class="total-price" id="total-price">Rp 0</div>
                    <div class="price-breakdown" id="price-breakdown">
                        <!-- Akan diisi JS -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <h2 class="section-title">Apa Kata Mereka</h2>
            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Pelayanan sangat memuaskan! Pakaian bersih, wangi, dan rapi. Pengiriman tepat waktu.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://picsum.photos/seed/user1/50/50.jpg" alt="User">
                        <div>
                            <h4>Siti Nurhaliza</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>LaundryKu sangat membantu aktivitas saya. Harga terjangkau dengan kualitas premium.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://picsum.photos/seed/user2/50/50.jpg" alt="User">
                        <div>
                            <h4>Budi Santoso</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Sangat recommended! Staff ramah dan pakaian saya selalu terawat dengan baik.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://picsum.photos/seed/user3/50/50.jpg" alt="User">
                        <div>
                            <h4>Maya Putri</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
function calculatePrice() {
    let hargaPerKilo = parseInt(document.getElementById("service-type").value);
    let berat = parseInt(document.getElementById("weight").value);
    let subtotal = hargaPerKilo * berat;

    // Ambil diskon dari select
    let discountSelect = document.getElementById("discount");
    let selectedOption = discountSelect.options[discountSelect.selectedIndex];
    let tipe = selectedOption ? selectedOption.getAttribute("data-tipe") : null;
    let nilai = selectedOption ? parseInt(selectedOption.getAttribute("data-nilai")) || 0 : 0;

    let diskon = 0;
    if (tipe === "persentase") {
        diskon = subtotal * (nilai / 100);
    } else if (tipe === "nominal") {
        diskon = nilai;
    }

    let total = subtotal - diskon;
    if (total < 0) total = 0; // jangan sampai minus

    // Update tampilan total
    document.getElementById("total-price").innerText =
        "Rp " + total.toLocaleString("id-ID");

    // Update breakdown
    document.getElementById("price-breakdown").innerHTML = `
        <p>Harga: ${berat} kg × Rp ${hargaPerKilo.toLocaleString("id-ID")}</p>
        <p>Diskon: Rp ${diskon.toLocaleString("id-ID")}</p>
        <p class="total">Total: <span>Rp ${total.toLocaleString("id-ID")}</span></p>
    `;
}
</script>

@endsection