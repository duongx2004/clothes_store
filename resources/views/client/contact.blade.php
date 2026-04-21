@extends('layouts.app')
@section('title', 'Liên hệ')

@push('styles')
<style>
	.contact-page {
		--text-main: #1a1a1a;
		--text-soft: #545454;
		--line: #e2e2e2;
		--panel: #f5f5f5;
		--accent: #e8d4c0;
		color: var(--text-main);
	}

	.contact-hero {
		background: radial-gradient(circle at top right, #f3e6dc 0%, #f8f8f8 35%, #ffffff 100%);
		border: 1px solid #ececec;
		border-radius: 20px;
		padding: 2.4rem 2rem;
		margin-bottom: 2rem;
		animation: fadeInUp 0.7s ease both;
	}

	.contact-hero h1 {
		font-family: "Montserrat", sans-serif;
		font-size: clamp(1.8rem, 2.3vw, 2.5rem);
		margin-bottom: 0.6rem;
	}

	.contact-hero p {
		color: var(--text-soft);
		max-width: 700px;
		margin-bottom: 0;
	}

	.contact-layout {
		display: grid;
		grid-template-columns: 1.15fr 0.85fr;
		gap: 1.4rem;
	}

	.contact-card {
		background: #fff;
		border: 1px solid var(--line);
		border-radius: 18px;
		padding: 1.5rem;
		box-shadow: 0 10px 25px rgba(16, 16, 16, 0.04);
		animation: fadeInUp 0.75s ease both;
	}

	.contact-card h2 {
		font-family: "Montserrat", sans-serif;
		font-size: 1.35rem;
		margin-bottom: 1.1rem;
	}

	.contact-form {
		display: grid;
		gap: 0.9rem;
	}

	.contact-form label {
		font-size: 0.92rem;
		font-weight: 500;
		margin-bottom: 0.3rem;
	}

	.contact-form input,
	.contact-form textarea {
		width: 100%;
		border: 1px solid #d9d9d9;
		border-radius: 10px;
		padding: 0.72rem 0.85rem;
		font-size: 0.95rem;
		transition: border-color 0.25s ease, box-shadow 0.25s ease;
		background: #fff;
	}

	.contact-form input:focus,
	.contact-form textarea:focus {
		outline: none;
		border-color: #b8947b;
		box-shadow: 0 0 0 4px rgba(232, 212, 192, 0.34);
	}

	.contact-form textarea {
		min-height: 140px;
		resize: vertical;
	}

	.contact-form button {
		width: fit-content;
		border: none;
		border-radius: 10px;
		background: #1a1a1a;
		color: #fff;
		padding: 0.72rem 1.4rem;
		font-weight: 500;
		transition: transform 0.2s ease, box-shadow 0.2s ease;
	}

	.contact-form button:hover {
		transform: translateY(-2px);
		box-shadow: 0 12px 20px rgba(0, 0, 0, 0.18);
	}

	.contact-item {
		display: flex;
		gap: 0.7rem;
		margin-bottom: 1rem;
		color: var(--text-soft);
	}

	.contact-item i {
		color: #1a1a1a;
		font-size: 1rem;
		margin-top: 3px;
	}

	.map-wrap iframe,
	.map-wrap img {
		width: 100%;
		height: 220px;
		border: 0;
		border-radius: 12px;
	}

	.social-links {
		display: flex;
		gap: 0.7rem;
		flex-wrap: wrap;
		margin-top: 1rem;
	}

	.social-links a {
		display: inline-flex;
		align-items: center;
		gap: 0.45rem;
		padding: 0.48rem 0.72rem;
		border-radius: 999px;
		text-decoration: none;
		color: #2f2f2f;
		background: var(--panel);
		transition: all 0.25s ease;
	}

	.social-links a:hover {
		background: var(--accent);
		color: #1a1a1a;
	}

	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(14px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	@media (max-width: 767px) {
		.contact-layout {
			grid-template-columns: 1fr;
		}
	}
</style>
@endpush

@section('content')
<section class="contact-page">
	<section class="contact-hero">
		<h1>Liên hệ với chúng tôi</h1>
		<p>Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7. Nếu bạn cần tư vấn sản phẩm, hỗ trợ đơn hàng hoặc góp ý dịch vụ, AllainStore luôn lắng nghe.</p>
	</section>

	<div class="contact-layout">
		<article class="contact-card">
			<h2>Gửi lời nhắn cho AllainStore</h2>
			<form class="contact-form" action="#" method="POST">
				<div>
					<label for="full_name">Họ tên</label>
					<input type="text" id="full_name" name="full_name" placeholder="Nguyễn Văn A" required>
				</div>

				<div>
					<label for="email">Email</label>
					<input type="email" id="email" name="email" placeholder="name@example.com" required>
				</div>

				<div>
					<label for="phone">Số điện thoại</label>
					<input type="tel" id="phone" name="phone" placeholder="0909 3131 301" required>
				</div>

				<div>
					<label for="message">Lời nhắn</label>
					<textarea id="message" name="message" placeholder="Bạn cần chúng tôi hỗ trợ điều gì?" required></textarea>
				</div>

				<button type="submit">Gửi tin nhắn</button>
			</form>
		</article>

		<aside class="contact-card">
			<h2>Thông tin cửa hàng</h2>
			<div class="contact-item">
				<i class="bi bi-geo-alt"></i>
				<span>123 Ambatukam, Đường Fatmom, TP. YesKing</span>
			</div>
			<div class="contact-item">
				<i class="bi bi-envelope"></i>
				<span>support@allainstore.com</span>
			</div>
			<div class="contact-item">
				<i class="bi bi-telephone"></i>
				<span>0909 3131 301</span>
			</div>

			<div class="map-wrap mt-3">
				<iframe title="Google Maps placeholder"
					src="https://maps.google.com/maps?q=10.8231,106.6297&z=14&output=embed"
					loading="lazy"></iframe>
			</div>

			<div class="social-links">
				<a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i>Facebook</a>
				<a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i>Instagram</a>
				<a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i>TikTok</a>
			</div>
		</aside>
	</div>
</section>
@endsection
