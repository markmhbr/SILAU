<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryKu - Layanan Laundry Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* CSS Tambahan untuk Bagian Baru */
        
        /* Profil Perusahaan Section */
        .profile {
            padding: 5rem 0;
            background: var(--bg-light);
        }
        
        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .profile-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .profile-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .profile-text h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .profile-text h4 {
            font-size: 1.3rem;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .profile-text p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }
        
        .profile-text ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        .profile-text ul li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
            color: var(--text-light);
        }
        
        .profile-text ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        /* Kontak Section */
        .contact {
            padding: 5rem 0;
            background: var(--white);
        }
        
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .contact-item i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-top: 0.5rem;
        }
        
        .contact-item h4 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .contact-item p {
            color: var(--text-light);
            margin: 0;
        }
        
        /* Testimoni Form Section */
        .testimonial-form {
            padding: 5rem 0;
            background: var(--bg-light);
        }
        
        .testimonial-form-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }
        
        /* Responsive untuk bagian baru */
        @media (max-width: 768px) {
            .profile-content,
            .contact-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <i class="fas fa-tshirt"></i>
                <span>LaundryKu</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#calculator">Kalkulator</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
                <li><a href="#profile">Profil</a></li>
                <li><a href="#contact">Kontak</a></li>
                <li><a href="#testimonial-form">Testimoni Form</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>
    
    <main>     
        @yield('interface')
    </main>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="gradient-text">Laundry Premium</span>
                <br> dengan Layanan Terbaik
            </h1>
            <p class="hero-subtitle">Pakaian bersih, wangi, dan rapi dalam sekejap</p>
            <div class="hero-buttons">
                <button class="btn-primary">Mulai Sekarang</button>
                <button class="btn-secondary">Pelajari Lebih Lanjut</button>
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
                        <i class="fas fa-iron"></i>
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
    
    <!-- Profile Perusahaan Section -->
    <section id="profile" class="profile">
        <div class="container">
            <h2 class="section-title">Profil Perusahaan</h2>
            <div class="profile-content">
                <div class="profile-image">
                    <img src="https://picsum.photos/seed/laundryku/600/400.jpg" alt="LaundryKu">
                </div>
                <div class="profile-text">
                    <h3>Tentang LaundryKu</h3>
                    <p>LaundryKu adalah layanan laundry premium yang telah berdiri sejak tahun 2010. Kami berkomitmen untuk memberikan pelayanan terbaik dengan kualitas yang terjamin.</p>
                    <p>Dengan pengalaman lebih dari 10 tahun, kami telah melayani ribuan pelanggan di seluruh Indonesia. Tim kami terdiri dari para profesional yang ahli dalam perawatan pakaian.</p>
                    <h4>Visi & Misi</h4>
                    <p><strong>Visi:</strong> Menjadi layanan laundry terdepan di Indonesia dengan kualitas internasional.</p>
                    <p><strong>Misi:</strong> Memberikan pelayanan laundry yang cepat, berkualitas, dan terjangkau dengan teknologi modern.</p>
                    <h4>Nilai-Nilai Kami</h4>
                    <ul>
                        <li>Kualitas: Selalu memberikan hasil terbaik</li>
                        <li>Kepercayaan: Menjaga kepercayaan pelanggan</li>
                        <li>Inovasi: Terus mengembangkan teknologi dan metode</li>
                        <li>Kepuasan Pelanggan: Prioritas utama kami</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Kontak Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Hubungi Kami</h2>
            <div class="contact-container">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Alamat</h4>
                            <p>Jl. Sudirman No. 123, Jakarta Pusat</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Telepon</h4>
                            <p>+62 812-3456-7890</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@laundryku.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Jam Operasional</h4>
                            <p>Senin - Sabtu: 08:00 - 20:00</p>
                            <p>Minggu: 09:00 - 18:00</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="contact-name">Nama Lengkap</label>
                            <input type="text" id="contact-name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">Email</label>
                            <input type="email" id="contact-email" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-subject">Subjek</label>
                            <input type="text" id="contact-subject" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-message">Pesan</label>
                            <textarea id="contact-message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimoni Form Section -->
    <section id="testimonial-form" class="testimonial-form">
        <div class="container">
            <h2 class="section-title">Beri Testimoni</h2>
            <div class="testimonial-form-container">
                <form id="testimonialForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="testimonial-name">Nama Lengkap</label>
                            <input type="text" id="testimonial-name" required>
                        </div>
                        <div class="form-group">
                            <label for="testimonial-email">Email</label>
                            <input type="email" id="testimonial-email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="testimonial-rating">Rating</label>
                        <select id="testimonial-rating" required>
                            <option value="">Pilih Rating</option>
                            <option value="5">5 - Sangat Puas</option>
                            <option value="4">4 - Puas</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Tidak Puas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="testimonial-message">Testimoni</label>
                        <textarea id="testimonial-message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Testimoni</button>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>LaundryKu</h3>
                    <p>Solusi laundry terpercaya untuk kebutuhan harian Anda.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Cuci Reguler</a></li>
                        <li><a href="#">Cuci Express</a></li>
                        <li><a href="#">Setrika Saja</a></li>
                        <li><a href="#">Premium Care</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-envelope"></i> info@laundryku.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Sudirman No. 123</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Jam Operasional</h4>
                    <ul>
                        <li>Senin - Sabtu: 08:00 - 20:00</li>
                        <li>Minggu: 09:00 - 18:00</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 LaundryKu. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile Menu Toggle
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
        
        // Price Calculator
        function calculatePrice() {
            const serviceType = document.getElementById('service-type').value;
            const weight = document.getElementById('weight').value;
            const discountCode = document.getElementById('discount').value.toUpperCase();
            
            let basePrice = parseInt(serviceType);
            let subtotal = basePrice * weight;
            let discount = 0;
            
            // Check discount codes
            if (discountCode === 'LAUNDRY10') {
                discount = subtotal * 0.1;
            } else if (discountCode === 'NEWUSER') {
                discount = subtotal * 0.15;
            } else if (discountCode === 'VIP20') {
                discount = subtotal * 0.2;
            }
            
            const total = subtotal - discount;
            
            // Update display
            document.getElementById('total-price').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            const serviceName = document.getElementById('service-type').selectedOptions[0].text.split(' - ')[0];
            const pricePerKg = basePrice.toLocaleString('id-ID');
            
            document.getElementById('price-breakdown').innerHTML = `
                <p>${serviceName}: ${weight} kg × Rp ${pricePerKg}</p>
                <p>Diskon: Rp ${discount.toLocaleString('id-ID')}</p>
                <p class="total">Total: <span>Rp ${total.toLocaleString('id-ID')}</span></p>
            `;
            
            // Add animation
            const totalPriceElement = document.getElementById('total-price');
            totalPriceElement.style.animation = 'none';
            setTimeout(() => {
                totalPriceElement.style.animation = 'pulse 0.5s ease';
            }, 10);
        }
        
        // Contact Form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'success-message';
            successMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <h3>Pesan Terkirim!</h3>
                <p>Terima kasih telah menghubungi kami. Kami akan segera merespons pesan Anda.</p>
            `;
            successMessage.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                text-align: center;
                z-index: 10000;
                animation: fadeInUp 0.5s ease;
            `;
            
            document.body.appendChild(successMessage);
            
            // Remove success message after 3 seconds
            setTimeout(() => {
                successMessage.remove();
                document.getElementById('contactForm').reset();
            }, 3000);
        });
        
        // Testimonial Form submission
        document.getElementById('testimonialForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'success-message';
            successMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <h3>Testimoni Terkirim!</h3>
                <p>Terima kasih atas testimoni Anda. Kami sangat menghargai masukan Anda.</p>
            `;
            successMessage.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                text-align: center;
                z-index: 10000;
                animation: fadeInUp 0.5s ease;
            `;
            
            document.body.appendChild(successMessage);
            
            // Remove success message after 3 seconds
            setTimeout(() => {
                successMessage.remove();
                document.getElementById('testimonialForm').reset();
            }, 3000);
        });
        
        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(50px)';
            section.style.transition = 'all 0.8s ease';
            observer.observe(section);
        });
    </script>
</body>
</html>