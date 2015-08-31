@foreach($items as $item)
    <li @if($item->hasChildren()) class="dropdown" @endif>
        <a @if($item->hasChildren()) class="dropdown-toggle" data-toggle="dropdown" @endif href="{{ $item->url() }}">
        
        {!! $item->prependIcon()->title !!}
        @if($item->hasChildren()) 
            <i class="fa fa-caret-down"></i> 
        @endif
        </a>
        @if($item->hasChildren())
            <ul class="dropdown-menu">
                @foreach( $item->children() as $child )
                    <li>
                        <a href="{{ $child->url() }}">
                        @if( isset( $item->icon ) )
                            <i class="fa fa-{{ $item->icon }}"></i>
                        @endif
                        {{ $child->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
    @if($item->divider)
        <li{{\HTML::attributes($item->divider)}}></li>
    @endif
@endforeach