{{-- The $canonicalLink variable is set in the Service Provider via View Composer --}}

@if(isset($canonicalLink) && !empty($canonicalLink))
    <link rel="canonical" href="{{ $canonicalLink }}" />
@endif
