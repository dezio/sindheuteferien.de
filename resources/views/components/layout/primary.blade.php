@php
    use App\Facades\Page;
@endphp<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @if(filled(Page::getDescription()))
        <meta name="description"
              content="{!! Page::getDescription() !!}"/>
    @endif
    @if(filled(Page::getKeywords()))
        <meta name="keywords"
              content="{{Page::getKeywords()}}"/>
    @endif
    <meta name="author" content="SindHeuteFerien.de"/>
    @if(!app()->isProduction())
        <meta name="robots" content="noindex, nofollow"/>
    @else
        <meta name="robots" content="index, follow"/>
    @endif
    <title>
        @if(Page::hasTitle())
            {!! Page::getTitle() !!} - {{ Page::getAppName() }}
        @else
            {{ Page::getAppName() }}
        @endif
    </title>
    <x-parts.style/>
</head>
<body>
@if(!app()->isProduction())
    <div class="top-alert">
        <strong>DEV-Modus ist aktiv</strong>
    </div>
@endif
@if(isset($header))
    <header>
        @if(!Request::is("/"))
            <div class="top-bar">
                <a href="{{ route('home') }}" class="hidden-md-block">
                    Übersicht aller Bundesländer
                </a>
                <a href="{{ route('home') }}" class="block-md-none">
                    Übersicht
                </a>
            </div>
        @endif
        <div class="header-container">
            {!! $header !!}
        </div>
    </header>
@endif
{!! $slot !!}
<x-parts.footer/>
</body>
</html>
