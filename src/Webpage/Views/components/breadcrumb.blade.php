@if (isset($seed))
<div class="breadcrumb">
    <ul class="breadcrumb__group" itemscope itemtype="http://schema.org/BreadcrumbList">
        @foreach (Maxfactor::bake($seed, isset($timetravel) ? $timetravel : true) as $crumb)
            @if ($crumb['status'] === 'enabled')
                <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemtype="http://schema.org/WebPage" itemprop="item" href="{{ $crumb['url'] }}">
                        <span itemprop="name">{{ $crumb['name'] }}</span>
                    </a>
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @elseif ($crumb['status'] === 'current')
                <li class="breadcrumb__item breadcrumb__item--current" aria-current="true" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemtype="http://schema.org/WebPage" itemprop="item" href="{{ $crumb['url'] }}">
                        <span itemprop="name">{{ $crumb['name'] }}</span>
                    </a>
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @elseif ($crumb['status'] === 'disabled')
                <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span itemtype="http://schema.org/Thing" itemprop="item"><span itemprop="name">{{ $crumb['name'] }}</span></span>
                    <meta itemprop="position" content="{{ $loop->iteration }}" />
                </li>
            @endif
        @endforeach
    </ul>
</div>
@endif
