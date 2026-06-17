@foreach($menu_user_dashboard->roots() as $item)
    <li {!! $item->attributes() !!}>
        @if($item->link)
        <a href="{{ $item->url() }}">
            {!! $item->icon !!}
            {{ $item->title }}
        </a>
        @else
            {{$item->title}}
        @endif
    </li>
@endforeach