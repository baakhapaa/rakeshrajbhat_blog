{{-- $items: label => count, $empty: message when there is no data --}}
@php
    $max = max(1, ...array_values($items ?: [0]));
    $sum = max(1, array_sum($items));
@endphp
@if(empty($items))
    <p class="analytics-empty">{{ $empty ?? 'No data yet.' }}</p>
@else
    <ul class="analytics-bars">
        @foreach($items as $label => $count)
            <li>
                <div class="analytics-bars__row">
                    <span class="analytics-bars__label">{{ $label }}</span>
                    <span class="analytics-bars__value">{{ number_format($count) }} <small>{{ round($count / $sum * 100) }}%</small></span>
                </div>
                <div class="analytics-bars__track"><span style="width: {{ round($count / $max * 100, 1) }}%"></span></div>
            </li>
        @endforeach
    </ul>
@endif
