@if(env('NOCAPTCHA_SITEKEY'))
<div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>

@section('styles')
@parent
{!! Html::script('https://www.google.com/recaptcha/api.js') !!}
@endsection
@endif