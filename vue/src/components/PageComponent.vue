<template>
    <div>
        <header class="bg-white drop-shadow-xl ">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
                <h4 class="text-2xl font-bold text-gray-900">
                    {{ title }}
                </h4>
                <div v-if="title === 'Dashboard'" class="text-2xl font-bold text-gray-900 flex space-x-3">
                    <button @click="updateView('youtube')"
                        class="inline-flex items-center px-3 
                        py-2 text-sm font-medium text-center 
                        text-white bg-blue-700 
                        hover:bg-blue-800 focus:ring-0 
                        focus:outline-none focus:ring-blue-300 
                        dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800">
                        Youtube
                    </button>
                    <button @click="updateView('iptv')"
                        class="inline-flex items-center px-5 
                        py-2 text-sm font-medium text-center 
                        text-white bg-blue-700 
                        hover:bg-blue-800 focus:ring-0 
                        focus:outline-none focus:ring-blue-300 
                        dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800">
                        Live TV
                    </button>
                </div>
            </div>
        </header>
        <main class="bg-gray-100">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="min-h-screen">
                        <slot></slot>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
});
const emit = defineEmits(['updateView'])

function updateView(view){
    emit('updateView',view)
}
</script>

<style>

</style>