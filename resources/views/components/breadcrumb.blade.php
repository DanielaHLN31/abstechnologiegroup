{{-- <div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div> --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($links as $index => $link)
            @if($index < count($links) - 1)
                <li class="breadcrumb-item {{ isset($link['url']) ? '' : 'text-muted' }}">
                    @if(isset($link['url']))
                        <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                    @else
                        {{ $link['title'] }}
                    @endif
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $link['title'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>

