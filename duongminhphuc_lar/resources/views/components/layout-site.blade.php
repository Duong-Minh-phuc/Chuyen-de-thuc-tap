<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tiêu đề mặc định' }}</title>
    {{-- CSS từ slot header --}}
    {{ $header ?? '' }}
</head>
<body>
    <header>
        @include('frontend.header')


    </header>
    <main>
        {{ $slot }}
    </main>
   
    
            <footer>
                @include('frontend.footer')

    </footer>
    {{-- JS từ slot footer --}}
    {{ $footer ?? '' }}
   
</body>
</html>