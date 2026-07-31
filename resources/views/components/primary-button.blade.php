<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-brand-600 via-brand-500 to-brand-700 hover:from-brand-500 hover:to-brand-400 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-600/30 hover:shadow-brand-600/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transform active:scale-[0.99] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed'
]) }}>
    {{ $slot }}
</button>