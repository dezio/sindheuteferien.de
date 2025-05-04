{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($statesSitemap as $state)
    <url>
        <loc>{{$state['loc']}}</loc>
        <lastmod>{{ $state['lastmod'] }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
@endforeach
