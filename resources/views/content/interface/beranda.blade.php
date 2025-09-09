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
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3>Cuci Reguler</h3>
                    <p>Cuci bersih dengan deterjen premium dan pengeringan sempurna</p>
                    <div class="price">Rp 7.000/kg</div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Cuci Express</h3>
                    <p>Selesai dalam 6 jam dengan prioritas khusus</p>
                    <div class="price">Rp 12.000/kg</div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-spray-can"></i>
                    </div>
                    <h3>Setrika Saja</h3>
                    <p>Setrika rapi dan profesional untuk pakaian Anda</p>
                    <div class="price">Rp 5.000/kg</div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3>Premium Care</h3>
                    <p>Perawatan khusus untuk pakaian berharga dan delicate</p>
                    <div class="price">Rp 15.000/kg</div>
                </div>
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
                            <option value="7000">Cuci Reguler - Rp 7.000/kg</option>
                            <option value="12000">Cuci Express - Rp 12.000/kg</option>
                            <option value="5000">Setrika Saja - Rp 5.000/kg</option>
                            <option value="15000">Premium Care - Rp 15.000/kg</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="weight">Berat (kg)</label>
                        <input type="number" id="weight" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label for="discount">Kode Promo (opsional)</label>
                        <input type="text" id="discount" placeholder="Masukkan kode promo">
                    </div>
                    <button class="btn-calculate" onclick="calculatePrice()">Hitung Harga</button>
                </div>
                <div class="calculator-result">
                    <h3>Total Harga</h3>
                    <div class="total-price" id="total-price">Rp 7.000</div>
                    <div class="price-breakdown" id="price-breakdown">
                        <p>Cuci Reguler: 1 kg × Rp 7.000</p>
                        <p>Diskon: Rp 0</p>
                        <p class="total">Total: <span>Rp 7.000</span></p>
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

@endsection