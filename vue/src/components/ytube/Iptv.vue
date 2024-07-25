<template>
    <div class="grid grid-cols-12 gap-4">
        <div v-for="(item, i) in data" :key="i"
            class="lg:col-span-4 md:col-span-6 col-span-12
            bg-white border border-gray-200 rounded-lg mb-4
            shadow dark:bg-gray-800 dark:border-gray-700 h-46">
            <a href="#">
                <img :src="item.logo" alt="preview" class="rounded-t-lg w-auto h-40 mx-auto">
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ item.name.replace(/(.{80})..+/, "$1…") }}
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 flex flex-warp gap-2">
                    <span v-for="(cat, i) in item.categories" :key="i"
                    class="capitalize inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">
                        {{cat}}
                    </span>
                </p>
            </div>
        </div>
    </div>
    
</template>

<script setup>
const props = defineProps({
    data: Array,
    meta: Object
})
</script>

<style>

</style>