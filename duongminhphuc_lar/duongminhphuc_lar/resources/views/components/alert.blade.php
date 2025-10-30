<script>
    @if(session('success'))
        toastr.success('{{ session('success') }}', "Thông báo");
    @endif
    
    @if(session('error'))
        toastr.error('{{ session('error') }}', "Báo lỗi")
    @endif
    
    // Tương tự các loại thông báo khác
</script>
