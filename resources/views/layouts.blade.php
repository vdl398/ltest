<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf" content="{{ csrf_token() }}">
		<link href="//fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="preconnect" href="//fonts.googleapis.com">
        <link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
        <link href="//fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<script src="https://cdn.tailwindcss.com"></script>
		@vite(['resources/css/app.css'])
</head>
<body>
    <nav style="width: 100%; display: flex; justify-content: center; margin-top: 20px;">
        <ul style="width: 60%; display: flex; align-items: center; justify-content: space-between;">
			<li>
				<a href="{{ URL('/') }}">Home</a>
			</li>
			<li>
				<a href="{{ URL('/basket') }}">Корзина</a>
			</li>
			<li>
				<a href="{{ URL('/admin/product') }}">Управление товарами</a>
			</li>
			<li>
				<a href="{{ URL('/admin/order') }}">Управление заказами</a>
			</li>
        </ul>
    </nav>	
    <div class="container">
        @yield('content')
    </div>   
</body>
</html>