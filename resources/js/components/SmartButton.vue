<template>
    <button v-bind="$attrs" class="cursor-pointer rounded-full px-4 py-2 border border-cyan-500 transition-colors text-cyan-500 hover:bg-cyan-500 hover:text-black">
        <slot />
    </button>
</template>
