<template>
    <div class="mb-6 w-52 flex justify-end gap-3">
        <label for="select_category" class="sr- text-gray-700 text-sm mt-2">Category:</label>
        <select v-model="categoryFilter" id="select_category"
            class="block py-2 px-0 w-full text-sm text-gray-500
            bg-transparent border-0 border-b-2 border-gray-300
            appearance-none dark:text-gray-400 dark:border-gray-600
            focus:outline-none focus:ring-0 focus:border-gray-200 peer">
            <option v-for="(item, i) in categories" :key="i" :value="item.category">
                {{ item.category }}
            </option>
        </select>
    </div>
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
    <!-- pagination -->
    <div class="flex justify-center mt-5 mb-5">
        <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm" aria-label="Pagination">
        <a 
            v-for="(link, i) of meta.links" 
            :key="i"
            :disabled="!link.url"
            href="#"
            @click="paginate($event,link)"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm
            font-medium whitespace-nowrap"
            :class="[
            link.active 
            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            i === 0 ? 'rounded-l-md' : '',
            i === meta.links.length - 1 ? 'rounded-r-md' : '',
            ]"
            v-html="link.label"
        >
        </a>
        </nav>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: Array,
    meta: Object,
    categories: Array
})
const emit = defineEmits(['paginate','categoryFilter'])
const categoryFilter = ref('')

watch(categoryFilter, (newVal,oldVal) => {
    emit('categoryFilter', newVal)
})

const paginate = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    emit("paginate", {url: link.url})
}
</script>

<style>

</style>