@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'mt-1.5 text-xs text-rose-600 font-semibold']) }}>
        @foreach ((array) $messages as $message)
            <p class="flex items-center gap-1">
                <span>⚠️</span> {{ $message }}
            </p>
        @endforeach
    </div>
@endif