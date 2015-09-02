@foreach($items as $item)
    <li>
        <a href="{{ $item->url() }}">
       
        {!! $item->prependIcon()->title !!}
            @if($item->hasChildren()) 
                <span class="fa arrow"></span> 
            @endif
        </a>
        @if($item->hasChildren())
            <ul class="nav nav-second-level">
                @foreach( $item->children() as $child )
                    <li><a href="{{ $child->url() }}">{{ $child->title }}</a></li>
                @endforeach
            </ul>
        @endif
    </li>
    @if($item->divider)
        <li{{\HTML::attributes($item->divider)}}></li>
    @endif
@endforeach