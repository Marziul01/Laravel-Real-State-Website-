<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $property->name }} - Property Details</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.4; color: #333; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { max-width: 200px; }
        h1 { font-size: 24px; margin-bottom: 5px; }
        h2 { font-size: 18px; margin-bottom: 5px; }
        .section { margin-bottom: 20px; }
        .section h3 { font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; }
        .property-images { display: flex; flex-wrap: wrap; gap: 10px; }
        .property-images img { width: 100%; max-width: 200px; border: 1px solid #ccc; padding: 3px; }
        .tags span { display: inline-block; background: #eee; padding: 3px 6px; margin-right: 5px; border-radius: 3px; font-size: 12px; }
        .info p { margin: 3px 0; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ $companyLogo }}" alt="Company Logo">
    <h1>{{ $property->name }}</h1>
    <div class="tags">
        <span>{{ $property->propertyType->property_type }}</span>
        @if($property->property_listing)
            @foreach (explode(',', $property->property_listing) as $listing)
                <span>{{ trim($listing) }}</span>
            @endforeach
        @endif
    </div>
    <h3>Property Location</h3>
    <p>{{ $property->road }}, {{ $property->city }}, {{ $property->propertyarea->name ?? $property->state->name ?? '' }}, {{ $property->country->name }}</p>
</div>

<div class="section property-images">
    @if($property->featured_image)
        <img src="{{ public_path($property->featured_image) }}" alt="">
    @endif
    @if($property->images->isNotEmpty())
        @foreach($property->images as $img)
            <img src="{{ public_path($img->image) }}" alt="">
        @endforeach
    @endif
</div>

<div class="section info">
    <h3>Details</h3>
    <p><strong>Price:</strong> {{ $property->price }} BDT</p>
    <p><strong>Property Space:</strong> SFT {{ $property->space ?? '-' }}</p>
    <p><strong>Bedrooms:</strong> {{ $property->bedrooms ?? '-' }}</p>
    <p><strong>Bathrooms:</strong> {{ $property->bathrooms ?? '-' }}</p>
    <p><strong>Parking Space:</strong> {{ $property->parking_space ?? '-' }}</p>
    <p><strong>Decoration:</strong> {{ $property->decoration ?? '-' }}</p>
    @if($property->type == 'rent')
    <p><strong>Check In:</strong> {{ $property->check_in ?? '-' }}</p>
    <p><strong>Check Out:</strong> {{ $property->check_out ?? '-' }}</p>
    @endif
</div>

<div class="section">
    <h3>Description</h3>
    <p>{{ $property->description }}</p>
</div>

<div class="section">
    <h3>Features</h3>
    @if($property->features)
        @foreach($property->features as $feature)
            <p><strong>{{ $feature->feature_keys }}:</strong> {{ $feature->feature_values }}</p>
        @endforeach
    @endif
</div>

<div class="section">
    <h3>Amenities</h3>
    @if($property->amenities)
        @foreach($property->amenities as $amenity)
            <p>- {{ $amenity->amenities }}</p>
        @endforeach
    @endif
</div>

@if ($property->realtor)
    <div class="section">
        <h3>Realtor</h3>
        <p><strong>Name:</strong> {{ $property->realtor->name }}</p>
        <p><strong>Email:</strong> {{ $property->realtor->email }}</p>
        <p><strong>Phone:</strong> {{ $property->realtor->mobile }}</p>
    </div>
@endif



</body>
</html>
