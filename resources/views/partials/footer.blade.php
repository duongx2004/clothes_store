<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h3>AllainStore</h3>
            <p>Thời trang chỉn chu cho phong cách hiện đại. Chúng tôi tập trung vào chất liệu bền đẹp, thiết kế tinh giản và trải nghiệm mua sắm dễ chịu.</p>
        </div>

        <div>
            <h4>Thông tin liên kết</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        <div>
            <h4>Hỗ trợ</h4>
            <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Vận chuyển</a></li>
                <li><a href="#">Đổi trả</a></li>
            </ul>
        </div>

        <div>
            <h4>Đăng ký nhận tin</h4>
            <form action="#" method="POST" class="footer-newsletter">
                <label for="newsletter-email" class="visually-hidden">Email của bạn</label>
                <input type="email" id="newsletter-email" placeholder="Nhập email của bạn" required>
                <button type="submit">Đăng ký</button>
            </form>
        </div>
    </div>

    <div class="container footer-bottom">
        <p>&copy; {{ date('Y') }} AllainStore. All rights reserved.</p>
    </div>
</footer>

<style>
    .site-footer {
        margin-top: 5rem;
        background: #f5f5f5;
        border-top: 1px solid #e2e2e2;
        padding: 3.5rem 0 1.2rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.4fr;
        gap: 1.6rem;
    }

    .site-footer h3,
    .site-footer h4 {
        color: #1a1a1a;
        margin-bottom: 0.85rem;
    }

    .site-footer p,
    .site-footer li,
    .site-footer a {
        color: #4b4b4b;
        line-height: 1.7;
        text-decoration: none;
    }

    .site-footer ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .site-footer a:hover {
        color: #1a1a1a;
        text-decoration: underline;
    }

    .footer-newsletter {
        display: flex;
        gap: 0.55rem;
    }

    .footer-newsletter input {
        flex: 1;
        border: 1px solid #d3d3d3;
        background: #fff;
        border-radius: 8px;
        padding: 0.6rem 0.75rem;
    }

    .footer-newsletter input:focus {
        outline: none;
        border-color: #bca08e;
        box-shadow: 0 0 0 3px rgba(232, 212, 192, 0.35);
    }

    .footer-newsletter button {
        border: none;
        background: #1a1a1a;
        color: #fff;
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .footer-newsletter button:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.17);
    }

    .footer-bottom {
        border-top: 1px solid #dddddd;
        margin-top: 2rem;
        padding-top: 1rem;
        text-align: center;
    }

    .footer-bottom p {
        margin-bottom: 0;
        color: #666;
    }

    @media (max-width: 991px) {
        .footer-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>