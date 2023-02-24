<div x-data="{ count: {{ $slot }}, }" x-cloak {{ $attributes }}>
    <div
        x-show="count"
        x-transition
        x-text="count"
        class="absolute top-2 right-5 md:-right-5 text-xs py-1 px-2 flex items-center justify-center text-white bg-slate-500 rounded-full">
    </div>
</div>
