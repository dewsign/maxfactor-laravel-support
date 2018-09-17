@if (isset($seed))
<div class="breadcrumb">
    <ul class="breadcrumb__group" itemscope itemtype="http://schema.org/BreadcrumbList">
        @foreach (Maxfactor::bake($seed, isset($timetravel) ? $timetravel : true) as $crumb)
            @if ($crumb['status'] === 'enabled')
                <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @elseif ($crumb['status'] === 'current')
                <li class="breadcrumb__item breadcrumb__item--current" aria-current="true" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @elseif ($crumb['status'] === 'disabled')
                <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    {{ $crumb['name'] }}
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @endif
        @endforeach
    </ul>
</div>
@endif
