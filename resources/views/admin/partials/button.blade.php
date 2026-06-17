@if (isset($route))
    @set(list($route, $params) = $route)
    @set($param = [])
    @if(is_array($params))
        @set($routeParams = explode('.', $route))
        @for($i = 0, $limit = count($routeParams); $i < $limit; ++$i)
            @if(isset($params[$i]))
                @set($param[$route[$i]] = $params[$i])
            @endif
        @endfor
    @else
        @set($param = [$route => $params])
    @endif
    @set($route = 'admin.'.$route)

    {{-- a => add --}}
    @if (Route::has($route.'.create') && false !== strpos($action, 'a'))
    <a class="btn btn-primary" href="{{ route($route.'.create') }}" title="{{ trans('button.add') }}"><i class="fa fa-plus"></i> {{ trans('button.add') }}</a>
    @endif

    @if (Route::has($route.'.edit') && false !== strpos($action, 'e'))
    <a class="btn btn-info" href="{{ route($route.'.edit', $param) }}" title="{{ trans('button.edit') }}"><i class="fa fa-edit"></i> {{ trans('button.edit') }}</a>
    @endif

    @if(false !== strpos($action, 'c'))
    <a class="btn btn-warning" href="{{ route($route.'.index', $param) }}" title="{{ trans('button.cancel') }}"><i class="fa fa-times-circle-o"></i> {{ trans('button.cancel') }}</a>
    @endif
@endif

{{-- b => back --}}
@if (false !== strpos($action, 'b'))
<a class="btn btn-primary" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> {{ trans('button.back') }}</a>
@endif