@extends('layout')

@section('content')

    @if ($_PAGE['id'] != 'all')
        <nav>
            <a href="/{{ $prev }}">&lsaquo; {{ substr(ucwords($prev), 0, 3) }}<span>{{ substr($prev, 3) }}</span></a>
            <a href="/all">All<span> Fruits</span></a>
            <a href="/{{ $next }}">{{  substr(ucwords($next), 0, 3) }}<span>{{ substr($next, 3) }}</span> &rsaquo;</a>

            <div class="break"></div>
        </nav>
    @endif

    @foreach ($fruits as $fruit)
        <a class="{{ $smaller ? 'small ' : '' }}fruit" href="/{{ $fruit['url'] }}">
            <img src="/images/fruits/{{ $smaller ? 'small/' : '' }}{{ $fruit['url'] }}.{{ $smaller ? 'png' : 'jpg' }}"
                 width="320"
                 height="320" alt="{{ $fruit['plural_name'] }}">

            <span>{{ $fruit['plural_name'] }}</span>
        </a>
        @if ($smaller)
            <div class="break"></div>
        @endif
    @endforeach

    <div class="break"></div>

@endsection