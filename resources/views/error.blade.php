@extends('layout')

@section('content')

    <div class="lone fruit">
        <img src="/images/error.jpg" width="320" height="320" alt="error">
    </div>

    <div class="months">
        That isn't a fruit
        @if (count($suggested) > 0)
            <p id="suggest">
                Did you mean
                @foreach ($suggested as $count => $fruit)
                    <a href="/{{ $fruit }}">{{ $fruit }}</a>@if ($count < count($suggested)-1) or
                    @endif
                @endforeach?
            </p>
        @endif
    </div>

    <div class="break"></div>

@endsection