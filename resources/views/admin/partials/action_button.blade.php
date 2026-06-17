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
@set($hasDestroy = Route::has($route.'.destroy'))

@if($hasDestroy)
{!! Form::open([
    'class' => 'form-inline',
    'method' => 'DELETE',
    'url' => route($route.'.destroy', $param)
]) !!}
@endif
{{-- s => show --}}
@if (Route::has($route.'.show') && false !== strpos($action, 's'))
<a class="btn btn-info" href="{{ route($route.'.show', $param) }}" title="{{ trans('button.show') }}"><i class="fa fa-eye"></i></a>
@endif
{{-- e => edit --}}
@if (Route::has($route.'.edit') && false !== strpos($action, 'e'))
<a class="btn btn-warning" href="{{ route($route.'.edit', $param) }}" title="{{ trans('button.edit') }}"><i class="fa fa-edit"></i></a>
@endif
{{-- d => destroy --}}
@if ($hasDestroy && false !== strpos($action, 'd'))
<button type="submit" class="btn btn-danger confirm-delete"><i title="{{ trans('button.delete') }}" class="fa fa-trash-o"></i></button>
@endif
@if($hasDestroy)
{!! Form::close() !!}
@endif