@extends('layouts.app')
@section('title', 'Giới thiệu')

@push('styles')
<style>
	.about-page {
		--text-main: #1a1a1a;
		--text-soft: #4f4f4f;
		--line: #e4e4e4;
		--panel: #f7f7f7;
		--accent: #e8d4c0;
		color: var(--text-main);
	}

	.about-block {
		background: #fff;
		border: 1px solid var(--line);
		border-radius: 20px;
		padding: 1.6rem;
		margin-bottom: 1.35rem;
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
		animation: riseIn 0.72s ease both;
	}

	.story-grid {
		display: grid;
		grid-template-columns: 1.08fr 0.92fr;
		gap: 1.3rem;
		align-items: stretch;
	}

	.story-content h1 {
		font-size: clamp(1.9rem, 2.5vw, 2.9rem);
		margin-bottom: 0.7rem;
	}

	.story-content p {
		color: var(--text-soft);
		line-height: 1.82;
		margin-bottom: 0;
	}

	.story-media {
		min-height: 260px;
		border-radius: 16px;
		overflow: hidden;
		position: relative;
	}

	.story-media img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transform: scale(1.01);
	}

	.story-media::after {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(180deg, rgba(0, 0, 0, 0.04), rgba(0, 0, 0, 0.2));
	}

	.section-title {
		font-size: 1.35rem;
		margin-bottom: 0.9rem;
	}

	.value-grid,
	.team-grid,
	.quote-grid {
		display: grid;
		gap: 1rem;
	}

	.value-grid {
		grid-template-columns: repeat(4, minmax(0, 1fr));
	}

	.value-card {
		background: var(--panel);
		border: 1px solid #ececec;
		border-radius: 14px;
		padding: 1rem;
		transition: transform 0.22s ease, box-shadow 0.22s ease;
	}

	.value-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
	}

	.value-card i {
		display: inline-grid;
		place-items: center;
		width: 38px;
		height: 38px;
		border-radius: 10px;
		margin-bottom: 0.6rem;
		background: #fff;
	}

	.value-card h3 {
		font-size: 1.02rem;
		margin-bottom: 0.35rem;
	}

	.value-card p {
		color: var(--text-soft);
		margin-bottom: 0;
		font-size: 0.92rem;
	}

	.team-grid {
		grid-template-columns: repeat(3, minmax(0, 1fr));
	}

	.member-card {
		text-align: center;
		border: 1px solid #e7e7e7;
		border-radius: 14px;
		padding: 1.1rem;
		background: #fff;
		transition: transform 0.22s ease, box-shadow 0.22s ease;
	}

	.member-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
	}

	.member-card img {
		width: 74px;
		height: 74px;
		border-radius: 50%;
		object-fit: cover;
		margin-bottom: 0.65rem;
	}

	.member-card p {
		color: var(--text-soft);
		margin-bottom: 0;
		font-size: 0.92rem;
	}

	.quote-grid {
		grid-template-columns: repeat(3, minmax(0, 1fr));
	}

	.quote-card {
		background: #fafafa;
		border: 1px solid #e9e9e9;
		border-radius: 12px;
		padding: 1rem;
		font-style: italic;
	}

	.quote-card p {
		color: #3f3f3f;
		line-height: 1.72;
	}

	.quote-author {
		display: flex;
		align-items: center;
		gap: 0.65rem;
		margin-top: 0.9rem;
		font-style: normal;
	}

	.quote-author img {
		width: 36px;
		height: 36px;
		border-radius: 50%;
		object-fit: cover;
	}

	.cta-banner {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 1rem;
		background: linear-gradient(90deg, #1a1a1a 0%, #3a302b 100%);
		border-radius: 18px;
		padding: 1.25rem 1.4rem;
		color: #fff;
	}

	.cta-banner h3 {
		margin-bottom: 0.25rem;
	}

	.cta-banner a {
		background: #fff;
		color: #1a1a1a;
		border-radius: 999px;
		text-decoration: none;
		font-weight: 600;
		padding: 0.6rem 1.2rem;
		transition: transform 0.22s ease, box-shadow 0.22s ease;
	}

	.cta-banner a:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 18px rgba(255, 255, 255, 0.22);
	}

	@keyframes riseIn {
		from {
			opacity: 0;
			transform: translateY(12px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	@media (max-width: 991px) {
		.value-grid,
		.team-grid,
		.quote-grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 767px) {
		.story-grid,
		.value-grid,
		.team-grid,
		.quote-grid,
		.cta-banner {
			grid-template-columns: 1fr;
		}

		.cta-banner {
			flex-direction: column;
			align-items: flex-start;
		}
	}
</style>
@endpush

@section('content')
<section class="about-page">
	<section class="about-block story-grid">
		<article class="story-content">
			<h1>Về AllainStore</h1>
			<p>AllainStore được tạo ra với mong muốn giúp thời trang đẹp trở nên gần gũi và dễ tiếp cận hơn. Chúng tôi bắt đầu từ một studio nhỏ, tập trung vào chất liệu bền, phom dáng tôn dáng và thiết kế tinh giản để bạn có thể mặc đẹp mỗi ngày.</p>
			<p>Với mỗi bộ sưu tập, AllainStore ưu tiên sự chỉn chu trong từng đường may, dịch vụ giao hàng nhanh và chăm sóc khách hàng tận tâm để mọi trải nghiệm mua sắm đều nhẹ nhàng, đáng tin cậy.</p>
		</article>
		<div class="story-media">
			<img src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1200&q=80" alt="Fashion studio" loading="lazy">
		</div>
	</section>

	<section class="about-block">
		<h2 class="section-title">Giá trị cốt lõi</h2>
		<div class="value-grid">
			<article class="value-card">
				<i class="bi bi-patch-check"></i>
				<h3>Quality</h3>
				<p>Chất liệu chọn lọc kỹ, hoàn thiện chỉn chu trong từng chi tiết.</p>
			</article>
			<article class="value-card">
				<i class="bi bi-cash-coin"></i>
				<h3>Affordable</h3>
				<p>Giá hợp lý để thời trang đẹp luôn trong tầm tay.</p>
			</article>
			<article class="value-card">
				<i class="bi bi-truck"></i>
				<h3>Fast Shipping</h3>
				<p>Đóng gói nhanh, giao hàng linh hoạt trên toàn quốc.</p>
			</article>
			<article class="value-card">
				<i class="bi bi-headset"></i>
				<h3>Support 24/7</h3>
				<p>Đội ngũ hỗ trợ nhiệt tình bất cứ khi nào bạn cần.</p>
			</article>
		</div>
	</section>

	<section class="about-block">
		<h2 class="section-title">Đội ngũ của chúng tôi</h2>
		<div class="team-grid">
			<article class="member-card">
				<img src="https://i.pravatar.cc/150?img=15" alt="Team member Minh Anh" loading="lazy">
				<h3>Lê Nho Dương</h3>
				<p>Founder & Creative Director</p>
			</article>
			<article class="member-card">
				<img src="https://i.pravatar.cc/150?img=15" alt="Team member Hoang Nam" loading="lazy">
				<h3>Hà Quang Nhuận</h3>
				<p>Product & Sourcing Lead</p>
			</article>
			<article class="member-card">
				<img src="https://i.pravatar.cc/150?img=15" alt="Team member Bao Tram" loading="lazy">
				<h3>Đặng Văn Minh</h3>
				<p>Customer Experience Manager</p>
			</article>
            <article class="member-card">
				<img src="https://i.pravatar.cc/150?img=15" alt="Team member Bao Tram" loading="lazy">
				<h3>Mai Đức Long</h3>
				<p>Customer Experience Manager</p>
			</article>
		</div>
	</section>

	<section class="about-block">
		<h2 class="section-title">Khách hàng nói gì về AllainStore</h2>
		<div class="quote-grid">
			<article class="quote-card">
				<p>"Mình rất ưng chất vải và form dáng. Mặc lên vừa thoải mái vừa sang."</p>
				<div class="quote-author">
					<img src="https://i.pravatar.cc/100?img=47" alt="Khách hàng Thu Ha" loading="lazy">
					<strong>Thu Hà</strong>
				</div>
			</article>
			<article class="quote-card">
				<p>"Đặt hàng tối hôm trước, hôm sau đã nhận được. Đóng gói cũng rất chỉn chu."</p>
				<div class="quote-author">
					<img src="https://i.pravatar.cc/100?img=58" alt="Khách hàng Duc Long" loading="lazy">
					<strong>Đức Long</strong>
				</div>
			</article>
			<article class="quote-card">
				<p>"Nhân viên hỗ trợ đổi size nhanh và dễ chịu. Trải nghiệm mua hàng rất tốt."</p>
				<div class="quote-author">
					<img src="https://i.pravatar.cc/100?img=21" alt="Khách hàng Ngoc Lan" loading="lazy">
					<strong>Ngọc Lan</strong>
				</div>
			</article>
		</div>
	</section>

	<section class="cta-banner">
		<div>
			<h3>Khám phá bộ sưu tập mới</h3>
			<p class="mb-0">Những thiết kế mới nhất đã sẵn sàng tại AllainStore.</p>
		</div>
		<a href="{{ route('products.index') }}">Shop Now</a>
	</section>
</section>
@endsection
