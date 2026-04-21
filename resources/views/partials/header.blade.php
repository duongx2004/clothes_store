<header class="site-header">
    <div class="site-header-wrap container">
        <a href="{{ route('home') }}" class="site-brand" aria-label="AllainStore Home">
            <img src="{{ asset('images/logo/allainstore.jpg') }}" alt="AllainStore Logo">
            <span>AllainStore</span>
        </a>

        <form class="site-search" action="{{ route('products.index') }}" method="GET" role="search">
            <i class="bi bi-search"></i>
            <input type="search" name="search" id="searchInput" placeholder="Tìm kiếm sản phẩm thời trang..." value="{{ request('search') }}" aria-label="Tìm kiếm sản phẩm">
            <div id="searchSuggestions" class="search-suggestions"></div>
        </form>

        <input type="checkbox" id="menu-toggle" class="menu-toggle" aria-label="Toggle menu">
        <label for="menu-toggle" class="menu-btn" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </label>

        <nav class="site-nav" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            @auth
                <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">Cart</a>
            @endauth
        </nav>

        <div class="header-auth">
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle auth-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
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
                <a href="{{ route('login') }}" class="btn btn-outline-dark auth-btn">Đăng nhập</a>
            @endauth
        </div>
    </div>
</header>

<style>
    :root {
        --neutral-900: #1a1a1a;
        --neutral-700: #3a3a3a;
        --neutral-200: #e9e9e9;
        --neutral-100: #f6f6f6;
        --accent: #e8d4c0;
    }

    body {
        font-family: "Poppins", "Segoe UI", sans-serif;
        color: var(--neutral-900);
        background: linear-gradient(180deg, #ffffff 0%, #fcf9f7 100%);
    }

    .site-header {
        position: sticky;
        top: 0;
        z-index: 1100;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid var(--neutral-200);
    }

    .site-header-wrap {
        display: grid;
        grid-template-columns: auto minmax(220px, 1fr) auto auto;
        align-items: center;
        gap: 1rem;
        min-height: 84px;
    }

    .site-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        text-decoration: none;
        color: var(--neutral-900);
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .site-brand img {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .site-search {
        position: relative;
        display: flex;
        align-items: center;
    }

    .site-search i {
        position: absolute;
        left: 14px;
        color: #6d6d6d;
        pointer-events: none;
    }

    .site-search input {
        width: 100%;
        border-radius: 999px;
        border: 1px solid #d8d8d8;
        padding: 0.65rem 1rem 0.65rem 2.2rem;
        background: #fff;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .site-search input:focus {
        outline: none;
        border-color: #bca08e;
        box-shadow: 0 0 0 4px rgba(232, 212, 192, 0.35);
    }

    .site-nav {
        display: inline-flex;
        gap: 0.35rem;
        align-items: center;
    }

    .site-nav a {
        text-decoration: none;
        color: var(--neutral-700);
        font-size: 0.95rem;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 999px;
        transition: all 0.25s ease;
    }

    .site-nav a:hover,
    .site-nav a.active {
        color: var(--neutral-900);
        background: var(--accent);
    }

    .header-auth {
        justify-self: end;
    }

    .auth-btn {
        border-radius: 999px;
        padding: 0.5rem 1rem;
    }

    .menu-toggle,
    .menu-btn {
        display: none;
    }

    .search-suggestions {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        max-height: 220px;
        overflow-y: auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        z-index: 1200;
        display: none;
    }

    .search-suggestions a {
        display: block;
        padding: 10px 12px;
        text-decoration: none;
        color: #333;
    }

    .search-suggestions a:hover {
        background: #f5f5f5;
    }

    @media (max-width: 991px) {
        .site-header-wrap {
            grid-template-columns: auto 1fr auto;
            grid-template-areas:
                "brand auth menu"
                "search search search"
                "nav nav nav";
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .site-brand {
            grid-area: brand;
        }

        .header-auth {
            grid-area: auth;
            justify-self: center;
        }

        .site-search {
            grid-area: search;
        }

        .menu-btn {
            grid-area: menu;
            justify-self: end;
            width: 42px;
            height: 42px;
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
            border-radius: 8px;
            border: 1px solid var(--neutral-200);
            padding: 8px;
            background: #fff;
        }

        .menu-btn span {
            height: 2px;
            width: 100%;
            background: #222;
            display: block;
            border-radius: 999px;
        }

        .site-nav {
            grid-area: nav;
            display: none;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            padding-top: 0.35rem;
        }

        .site-nav a {
            width: 100%;
        }

        .menu-toggle:checked ~ .site-nav {
            display: flex;
        }
    }

    @media (max-width: 576px) {
        .header-auth {
            display: none;
        }
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