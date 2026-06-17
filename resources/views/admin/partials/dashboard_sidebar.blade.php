@foreach($menu_admin_dashboard->roots() as $item)
    <li {!! $item->attributes() !!} @if($item->hasChildren()) class="treeview" @endif>
        <a @if($item->hasChildren()) href="#" @else href="{{ $item->url() }}" @endif>
            {!! $item->icon !!}
            <span>{{ $item->title }}</span>
            @if($item->data('label') && 2 === count($item->data('label')))
            <small class="label pull-right bg-{{ $item->data('label')[0] }}">{{ $item->data('label')[1] }}</small>
            @endif
            @if($item->hasChildren())
              <i class="fa fa-angle-left pull-right"></i>
            @endif
        </a>
        @if($item->hasChildren())
            <ul class="treeview-menu">
                @foreach($item->children() as $child)
                    <li {!! $child->attributes() !!}>
                      <a href="{{ $child->url() }}">
                        @if($child->icon)
                        {!! $child->icon !!}
                        @else
                        <i class="fa fa-circle-o"></i>
                        @endif
                        {{ $child->title }}
                      </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach