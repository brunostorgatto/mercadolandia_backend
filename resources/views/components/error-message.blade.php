@props(['message' => null])

<!-- Se um dia quiser mudar o espaçamento, você altera SÓ AQUI -->
<div class="min-h-[24px] pt-1.5">
    @if ($message)
        <p {{ $attributes->merge(['class' => 'text-xs text-rose-500 font-medium']) }}>
            {{ $message }}
        </p>
    @endif
</div>