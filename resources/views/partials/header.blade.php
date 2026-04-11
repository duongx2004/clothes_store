<header>
    <div class="px-3 py-2 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('home') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                    <img src="{{ asset('images/logo/allainstore.jpg') }}" width="50" class="rounded-circle me-2" alt="Logo">
                    AllainStore
                </a>
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li><a href="{{ route('home') }}" class="nav-link text-white"><i class="bi bi-house d-block mx-auto mb-1"></i>Home</a></li>
                    <li><a href="{{ route('cart.index') }}" class="nav-link text-white"><i class="bi bi-cart d-block mx-auto mb-1"></i>Cart</a></li>
                    <li><a href="{{ route('products.index') }}" class="nav-link text-white"><i class="bi bi-shop d-block mx-auto mb-1"></i>Products</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link text-white"><i class="bi bi-person-vcard d-block mx-auto mb-1"></i>Contact</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link text-white"><i class="bi bi-info-circle d-block mx-auto mb-1"></i>About</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center position-relative">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto position-relative" action="{{ route('products.index') }}" method="GET">
                <input type="search" name="search" class="form-control" id="searchInput" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                <div id="searchSuggestions" class="search-suggestions"></div>
            </form>
            <div class="text-end">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Thông tin tài khoản</a></li>
                            <li><a class="dropdown-item" href="{{ route('change.password.form') }}">Đổi mật khẩu</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.orders') }}">Đơn hàng của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light text-dark me-2">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</header>
<style>
    .search-suggestions {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }
    .search-suggestions a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
    }
    .search-suggestions a:hover {
        background: #f5f5f5;
    }
</style>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.trim();
        const suggestionsDiv = document.getElementById('searchSuggestions');
        if (query.length < 1) {
            suggestionsDiv.style.display = 'none';
            return;
        }
        fetch('{{ route("search.suggestions") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ query: query })
        })
        .then(response => response.json())
        .then(data => {
            suggestionsDiv.innerHTML = '';
            if (data.length > 0) {
                data.forEach(item => {
                    const link = document.createElement('a');
                    link.href = '{{ url("/products") }}/' + item.slug;
                    link.textContent = item.name;
                    suggestionsDiv.appendChild(link);
                });
                suggestionsDiv.style.display = 'block';
            } else {
                suggestionsDiv.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            suggestionsDiv.style.display = 'none';
        });
    });
    document.addEventListener('click', function(event) {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('searchSuggestions');
        if (!searchInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
</script>