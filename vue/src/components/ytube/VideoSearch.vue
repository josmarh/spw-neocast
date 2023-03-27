<template>
    <div class="mb-8 block p-6 bg-white border border-gray-200 
        rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 
        dark:hover:bg-gray-700 md:mx-20">
        <form @submit.prevent="searchVideo" class="px-6">
            <div class="md:flex gap-4">
                <div class="relative z-0 w-full">
                    <input v-model="model.videoUrl"
                    type="url"
                    id="video-url"
                    class="block py-3 px-0 w-full text-sm 
                    text-gray-900 bg-transparent border-0 
                    border-b-2 border-gray-300 appearance-none
                    dark:text-white dark:border-gray-600
                    dark:focus:border-blue-500 focus:outline-none 
                    focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "/>
                    <label
                    for="video-url"
                    class="absolute text-sm text-gray-500
                    dark:text-gray-400 duration-300 transform
                    -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    peer-focus:left-0 peer-focus:text-blue-600
                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                    peer-placeholder-shown:translate-y-0
                    peer-focus:scale-75 peer-focus:-translate-y-6">
                        Search Youtube Video URL
                    </label>
                </div>
                <div class="relative z-0 w-full mb-2">
                    <input v-model="model.keyword"
                    type="text"
                    id="keyword"
                    class="block py-3 px-0 w-full text-sm 
                    text-gray-900 bg-transparent border-0 
                    border-b-2 border-gray-300 appearance-none
                    dark:text-white dark:border-gray-600
                    dark:focus:border-blue-500 focus:outline-none 
                    focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "/>
                    <label
                    for="keyword"
                    class="absolute text-sm text-gray-500
                    dark:text-gray-400 duration-300 transform
                    -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    peer-focus:left-0 peer-focus:text-blue-600
                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                    peer-placeholder-shown:translate-y-0
                    peer-focus:scale-75 peer-focus:-translate-y-6">
                    Search keyword
                    </label>
                </div>
                <div class="w-72">
                    <button
                    type="submit"
                    class="group flex justify-center
                    py-3 px-4 border border-transparent
                    text-sm font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700
                    focus:outline-none">
                        Search Video
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const emit = defineEmits(['searchVideo','getVideos'])

let model = ref({
    videoUrl: '',
    searchType: '',
    keyword: ''
})

watch(model, (newVal,oldVal) => {
    if(!newVal.videoUrl || !newVal.keyword)
        emit('getVideos')
}, {deep:true})

function searchVideo() {
    let video = model.value.videoUrl

    if(model.value.videoUrl) {
        model.value.searchType = 'link'

        if(video.includes('https://youtube.com/watch?v=')) {
            video = video.replace("https://youtube.com/watch?v=","");
        }else if(video.includes('https://www.youtube.com/watch?v=')) {
            video = video.replace("https://www.youtube.com/watch?v=","");
        }else if(video.includes('https://youtu.be')) {
            video = video.replace("https://youtu.be/","");
        }else if(video.includes('https://www.youtu.be')) {
            video = video.replace("https://www.youtu.be/","");
        }else {
            video = video
        }
    }else if(model.value.keyword) {
        model.value.searchType = 'keyword'
        video = model.value.keyword
    }else if(!model.value.keyword && !model.value.videoUrl) {
        return;
    }
    
    emit('searchVideo', {
        video: video,
        type: model.value.searchType
    })
}
</script>

<style>

</style>