@props(['title' => config('app.name'), 'description' => '', 'image' => asset('images/logo.png'), 'canonical' => url()->current()])

<!-- Primary Meta Tags -->
<title>{{ $title }} - {{ config('app.name') }}</title>
<meta name="title" content="{{ $title }} - {{ config('app.name') }}">
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $title }} - {{ config('app.name') }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $canonical }}">
<meta property="twitter:title" content="{{ $title }} - {{ config('app.name') }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">

<!-- Structured Data (JSON-LD) -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "{{ config('services.business.name') }}",
  "image": "{{ asset('images/logo.png') }}",
  "@@id": "{{ url('/') }}",
  "url": "{{ url('/') }}",
  "telephone": "{{ config('services.business.phone') }}",
  "email": "{{ config('services.business.email') }}",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "{{ config('services.business.address') }}",
    "addressLocality": "{{ config('services.business.city') }}",
    "postalCode": "{{ config('services.business.postal_code') }}",
    "addressCountry": "HU"
  },
  "geo": {
    "@@type": "GeoCoordinates",
    "latitude": {{ config('services.business.latitude') }},
    "longitude": {{ config('services.business.longitude') }}
  },
  "openingHoursSpecification": [
    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
      @php
        $hours = config('services.business.opening_hours.' . strtolower($day));
      @endphp
      @if($hours !== 'Closed')
      {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": "{{ $day }}",
        "opens": "{{ explode('-', $hours)[0] ?? '09:00' }}",
        "closes": "{{ explode('-', $hours)[1] ?? '17:00' }}"
      }{{ !$loop->last ? ',' : '' }}
      @endif
    @endforeach
  ],
  "priceRange": "$$"
}
</script>
