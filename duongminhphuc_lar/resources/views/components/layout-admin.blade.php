<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Quản lý Admin' }}</title>
    @vite('resources/css/app.css')
    @include("components.alert")
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/ toastr.min.css ')}}"  />
<script src="{{asset('js/toastr.min.js')}}" ></script>

    <script src="https://kit.fontawesome.com/your-code.js"></script>
    {{-- Gọi CSS nếu có --}}
    {{ $header ?? "" }}
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        @include('backend.dashboard.navbar')
        
        <div class="flex">
            @include('backend.dashboard.sidebar')
            
            <div class="flex-1 p-8">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        {{ $slot }}  {{-- Đây là nơi nội dung các trang con sẽ được đưa vào --}}
                    </div>
                </div>
            </div>
        </div>

        @include('backend.dashboard.footer')
    </div>

    {{-- Gọi JS nếu có --}}
    {{ $footer ?? "" }}
</body>
</html>