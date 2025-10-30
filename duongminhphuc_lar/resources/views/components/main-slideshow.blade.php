<div class="relative">
    <!-- Slideshow container -->
    <div class="overflow-hidden relative">
        <div class="flex transition-transform duration-500 ease-in-out" id="slider">
            @foreach($banners as $banner)
                <div class="min-w-full">
                    <img src="{{ asset('images/banner/' . $banner->image) }}" 
                         alt="{{ $banner->name }}"
                         class="w-full h-[620px] object-cover">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Navigation buttons -->
    <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 p-2 rounded-full" 
            onclick="moveSlide(-1)">
        <i class="fas fa-chevron-left text-white text-xl"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 p-2 rounded-full"
            onclick="moveSlide(1)">
        <i class="fas fa-chevron-right text-white text-xl"></i>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
        @foreach($banners as $key => $banner)
            <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors duration-200 indicator"
                    onclick="currentSlide({{ $key }})"></button>
        @endforeach
    </div>
</div>

<script>
let currentIndex = 0;
const slides = document.querySelectorAll('#slider > div');
const slider = document.getElementById('slider');
const indicators = document.querySelectorAll('.indicator');
const totalSlides = slides.length;

function updateSlider() {
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    // Update indicators
    indicators.forEach((ind, idx) => {
        ind.classList.toggle('bg-white', idx === currentIndex);
        ind.classList.toggle('bg-white/50', idx !== currentIndex);
    });
}

function moveSlide(direction) {
    currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
    updateSlider();
}

function currentSlide(index) {
    currentIndex = index;
    updateSlider();
}

// Auto slide
setInterval(() => moveSlide(1), 5000);

// Initial state
updateSlider();
</script> 