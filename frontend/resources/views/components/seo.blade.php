@props([
    'title' => 'Padmabati Computer Academy',
    'description' => 'Leading computer training institute providing quality education in programming, web development, and digital skills.',
    'keywords' => 'computer academy, programming courses, web development, digital marketing, IT training',
    'image' => null,
    'url' => null
])

<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="Padmabati Computer Academy">

<!-- Open Graph Tags -->
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="website">
@if($url)
    <meta property="og:url" content="{{ $url }}">
@endif
@if($image)
    <meta property="og:image" content="{{ $image }}">
@endif
<meta property="og:site_name" content="Padmabati Computer Academy">

<!-- Twitter Card Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="/favicon.ico">

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "Padmabati Computer Academy",
    "description": "{{ $description }}",
    "url": "{{ config('app.url') }}",
    "logo": "{{ config('app.url') }}/logo.png",
    "sameAs": [
        "https://facebook.com/padmabatiacademy",
        "https://twitter.com/padmabatiacademy",
        "https://linkedin.com/company/padmabatiacademy"
    ],
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Tech Street",
        "addressLocality": "Digital City",
        "addressCountry": "India"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-98765-43210",
        "contactType": "customer service"
    }
}
</script>