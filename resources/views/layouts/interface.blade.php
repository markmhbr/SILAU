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
                <li><a href="/#home">Beranda</a></li>
                <li><a href="/#services">Layanan</a></li>
                <li><a href="/#calculator">Kalkulator</a></li>
                <li><a href="/#testimonials">Testimoni</a></li>
                <li><a href="{{ route('profil') }}">Profil</a></li>
                <li><a href="{{ route('kontak') }}">Kontak</a></li>
                <li><a href="{{ route('testimonial-form') }}">Testimoni Form</a></li>
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