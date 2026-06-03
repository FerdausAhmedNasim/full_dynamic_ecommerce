@php
    function getYouTubeVideoId($url) {
        $parsedUrl = parse_url($url);
        
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            
            if (isset($queryParams['v'])) {
                return $queryParams['v'];
            }
        }
        if (isset($parsedUrl['host']) && $parsedUrl['host'] === 'youtu.be') {
            return ltrim($parsedUrl['path'], '/');
        }

        if (isset($parsedUrl['path'])) {
            $pathParts = explode('/', $parsedUrl['path']);
            return end($pathParts);
        }

        return null;
    }
    $videoId = getYouTubeVideoId($video?->link);
@endphp
@if (isset($video))
 <section class="">
    <div class="">
        <div class="video-box">
            <div class="video">
                <iframe 
                    data-src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}" 
                    title="YouTube video player"
                    class="lazyload" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin">
                </iframe>
            </div>
        </div>     
    </div>
</section>
@endif
