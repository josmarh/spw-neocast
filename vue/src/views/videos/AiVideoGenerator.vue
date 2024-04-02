<template>
    <PageComponent title="Ai Video Generator" >
        <div>
            <form @submit.prevent="generateVideoScript" class="px-6">
                <div class="md:flex justify-center gap-4">
                    <div class="relative z-0 w-72">
                        <input v-model="model.topic"
                        type="text"
                        id="topic"
                        class="block py-3 px-0 w-full text-sm 
                        text-gray-900 bg-transparent border-0 
                        border-b-2 border-gray-300 appearance-none
                        dark:text-white dark:border-gray-600
                        dark:focus:border-blue-500 focus:outline-none 
                        focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "/>
                        <label
                        for="topic"
                        class="absolute text-sm text-gray-500
                        dark:text-gray-400 duration-300 transform
                        -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                        peer-focus:left-0 peer-focus:text-blue-600
                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                        peer-placeholder-shown:translate-y-0
                        peer-focus:scale-75 peer-focus:-translate-y-6">
                            Enter a topic to generate content...
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
                            Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </PageComponent>
</template>

<script setup>
import { reactive, getCurrentInstance } from 'vue';
import PageComponent from '../../components/PageComponent.vue';

const internalInstance = getCurrentInstance();

let model = reactive({
    topic: ''
})

const generateVideoScript = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();

}
</script>

<style>

</style>