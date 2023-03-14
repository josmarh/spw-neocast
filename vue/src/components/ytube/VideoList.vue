<template>
    <div class="grid grid-cols-12 gap-4">
        <div v-for="(item, i) in data" :key="i"
            class="lg:col-span-4 md:col-span-6 col-span-12 
            bg-white border border-gray-200 rounded-lg mb-4
            shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <iframe :src="`https://www.youtube.com/embed/${item.id.videoId ? item.id.videoId : item.id}?rel=0&controls=1&showinfo=0`" frameborder="0" 
                webkitallowfullscreen 
                mozallowfullscreen 
                allowfullscreen="allowfullscreen"
                class="rounded-t-lg w-full h-52"></iframe>
            </a>
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ item.snippet.title.replace(/(.{80})..+/, "$1…") }}
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{ new Date(item.snippet.publishedAt).toLocaleDateString('en-us',{year:"numeric", month:"short", day:"numeric"}) }}
                </p>
                <a href="#" 
                    class="inline-flex items-center px-3 
                    py-2 text-sm font-medium text-center 
                    text-white bg-blue-700 
                    hover:bg-blue-800 focus:ring-0 
                    focus:outline-none focus:ring-blue-300 
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    dark:focus:ring-blue-800"
                    @click="saveVideo(item.id.videoId ? item.id.videoId : item.id, item.snippet.title)">
                    Save Video
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

</template>

<script setup>
const props = defineProps({
    data: Array
})
const emit = defineEmits(['saveVideo'])

function saveVideo(videoId, videoTitle) {
    emit('saveVideo', videoId, videoTitle)
}
</script>

<style>

</style>