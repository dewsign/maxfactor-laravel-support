@if (isset($seed))
    <div class="list {{ $class ?? '' }}">
        <ul class="list__group">
            @foreach (Maxfactor::bake($seed, isset($timetravel) ? $timetravel : true) as $crumb)
                @if ($crumb['status'] === 'enabled')
                    <li class="list__item">
                        <a href="{{ $crumb['url'] }}">
                            {{ $crumb['name'] }}
                        </a>
                    </li>
                @elseif ($crumb['status'] === 'current')
                    <li class="list__item list__item--current" aria-current="true">
                        <a href="{{ $crumb['url'] }}">
                            {{ $crumb['name'] }}
                        </a>
                    </li>
                @elseif ($crumb['status'] === 'disabled')
                    <li class="list__item">
                        {{ $crumb['name'] }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
