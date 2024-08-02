<template>
    <PageComponent title="Ai Video Generator" >
        <NotificationCard/>
        <div class="ml-[26rem]" style="">
            <form @submit.prevent="generateVideoScript" class="">
                <div class="md:flex gap-4">
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
                        placeholder=" "
                        required />
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
        <div v-if="model.contentLoader == 0">
            <p class="text-center mt-28">
                <font-awesome-icon icon="fa-solid fa-lightbulb" class="mr-1 text-yellow-300"/>
                Use the search field to generate post for your Idea.
            </p>
        </div>
        <div v-else-if="model.contentLoader == 2" class="mt-8">
            <div class="lg:mx-72">
                <label for="video-script" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video script</label>
                <textarea v-model="model.scriptContent" id="video-script" rows="7" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
            </div>
            <div class="mt-6 flex justify-center">
                <button @click="getAiActors"
                    type="button"
                    class="group flex justify-center
                    py-3 px-4 border border-transparent
                    text-sm font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700
                    focus:outline-none"
                    :disabled="model.actorLoader == 1"
                >
                    Generate video
                </button>
            </div>
            <div class="mt-10 lg:mx-72" v-if="actors.items.length">
                <div class="flex justify-between">
                    <label for="video-actors" class="block text-sm font-medium text-gray-900 dark:text-white pt-2">Select actor</label>
                    <div>
                        <el-tooltip
                            class="box-item"
                            effect="dark"
                            content="Previous"
                            placement="top"
                        >
                            <button class="bg-gray-600 hover:bg-gray-700 py-1 px-2 text-white mr-1"
                                @click="paginateActor(actors.prevPage)" 
                                :disabled="!actors.prevPage"
                            >
                                <font-awesome-icon icon="fa-solid fa-arrow-left"/>
                            </button>
                        </el-tooltip>
                        <el-tooltip
                            class="box-item"
                            effect="dark"
                            content="Next"
                            placement="top"
                        >
                            <button class="bg-gray-600 hover:bg-gray-700 py-1 px-2 text-white"
                                @click="paginateActor(actors.nextPage)" 
                                :disabled="!actors.nextPage"
                            >
                                <font-awesome-icon icon="fa-solid fa-arrow-right"/>
                            </button>
                        </el-tooltip>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="grid grid-cols-10 space-x-2 border border-2 p-3 rounded-md">
                        <div class="col-span-2 mb-2 cursor-pointer" v-for="(item,i) in actors.items" :key="i">
                            <div @click="selectActor(item)">
                            <img
                                class="w-30 h-30 rounded border" 
                                :class="[item.id == actorModel.id ? 'border-indigo-500 border-2':'hover:border-indigo-500 hover:border-2']"
                                :src="item.thumbnailImagePath" 
                                alt="Video avatar"
                            >
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex justify-between">
                        <div class="w-[12rem]">
                            <label for="actor-language" class="text-sm sr-only">
                                Select language
                            </label>
                            <select 
                                id="actor-language"
                                class="block py-2 px-0 w-full text-sm 
                                text-gray-500 bg-transparent border-0 
                                border-b-2 border-gray-300 appearance-none 
                                dark:text-gray-400 dark:border-gray-600 focus:outline-none 
                                focus:ring-0 focus:border-gray-200 peer"
                            >
                                <option selected value="">All Media types</option>
                                <option value="hosted video">Hosted Videos</option>
                                <option value="external links">External Links</option>
                            </select>
                        </div>
                        <div class="text-center w-full" v-if="actorModel.id">
                            <h6 style="font-size: 0.7rem;">Name: {{ actorModel.name }}</h6>
                            <h6 style="font-size: 0.7rem;">Gender: {{ actorModel.gender }}</h6>
                            <h6 style="font-size: 0.7rem;">Age: {{ actorModel.age }}</h6>
                            <h6 style="font-size: 0.7rem;">Ethnicity: {{ actorModel.ethnicity }}</h6>
                            <button @click="toogleActorPreview"
                                type="button"
                                class="group 
                                py-2 px-6 border border-transparent
                                text-sm font-medium text-white
                                bg-gray-600 hover:bg-gray-700
                                focus:outline-none mt-3"
                            >
                                Preview 
                            </button>
                        </div>
                        <div>
                            <button @click="generateVideo"
                                type="button"
                                class="group flex justify-center
                                py-3 px-4 border border-transparent
                                text-sm font-medium text-white
                                bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none"
                            >
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="model.contentLoader == 3">
            <p class="text-center mt-28">
                <font-awesome-icon icon="fa-solid fa-circle-exclamation" class="mr-1 text-red-400"/>
                Post could not be generated, please try again.
            </p>
        </div>

        <PreviewAIActor 
            :actorInfo="actorModel" 
            :show="model.showActorPreview" 
            @updateShow="toogleActorPreview" 
        />
    </PageComponent>
</template>

<script setup>
import { reactive, ref, getCurrentInstance, computed } from 'vue';
import PageComponent from '../../components/PageComponent.vue';
import NotificationCard from '../../components/Notification.vue';
import PreviewAIActor from '../../components/video/PreviewAIActor.vue';
import videoScheduleStore from '../../store/videoSchedule-store';
import store from '../../store';
import notify from '../../includes/notify';

const internalInstance = getCurrentInstance();
const actors = computed(() => videoScheduleStore.state.aiActors)

let model = reactive({
    topic: '',
    scriptContent: '',
    pageNumber: 1,
    pageSize: 10,
    contentLoader: 0,
    actorLoader: 0,
    videoLoader: 0,
    showActorPreview: false
})
let actorModel = ref({
    id: null,
    name: '',
    gender: '',
    age: null,
    ethnicity: '',
    previewVideoPath: null
})

const selectActor = actor => {
    actorModel.value = actor
}

const paginateActor = (pageNumber) => {
    model.pageNumber = pageNumber
    getAiActors()
}

const toogleActorPreview = () => {
    model.showActorPreview = !model.showActorPreview
}

const generateVideoScript = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    model.contentLoader = 1
    videoScheduleStore
        .dispatch('generateAiScript', model)
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.content && res.words > 0){
                model.contentLoader = 2
                model.scriptContent = res.content
            }else{
                model.contentLoader = 3
            }
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            model.contentLoader = 3
            notify.notifyError(err)
        })
}

const getAiActors = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    model.actorLoader = 1
    videoScheduleStore
        .dispatch('getAiActors', {
            pageNumber: model.pageNumber,
            pageSize: model.pageSize
        })
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.items.length){
                model.actorLoader = 2
            }else{
                model.actorLoader = 3
            }
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            model.actorLoader = 3
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        auth.value = err.response.data.message;
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                    setTimeout(() => {
                        store.dispatch("setErrorNotification", "");
                    }, 3000);
                }
            }
        })
}
</script>

<style>

</style>