@extends('layouts.interface')

@section('title', 'Beranda')

@section('interface')

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
    
@endsection