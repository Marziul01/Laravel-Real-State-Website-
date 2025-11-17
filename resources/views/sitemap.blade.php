<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<url><loc>{{ url('/') }}</loc><priority>1.00</priority></url>

@foreach($rents as $product)
<url><loc>{{ route('view.rent.property', $product->slug) }}</loc></url>
@endforeach

@foreach($sells as $product)
<url><loc>{{ route('view.sell.property', $product->slug) }}</loc></url>
@endforeach

@foreach($blogs as $blog)
<url><loc>{{ route('blog.details', $blog->slug) }}</loc></url>
@endforeach

</urlset>