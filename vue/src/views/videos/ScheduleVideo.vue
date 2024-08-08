<template>
    <PageComponent title="Video Schedule">
        <NotificationCard/>
        <div class="flex justify-between">
            <div class="flex gap-2">
                <label for="timezone" class="text-sm mt-2 text-gray-700">Timezone: </label>
                <select 
                    id="timezone"
                    class="block py-2 px-0 w-full text-sm 
                    text-gray-500 bg-transparent border-0 
                    border-b-2 border-gray-300 appearance-none 
                    dark:text-gray-400 dark:border-gray-600 focus:outline-none 
                    focus:ring-0 focus:border-gray-200 peer"
                    v-model="model.timezone"
                >
                    <option v-for="item in timezones" :key="item.country_code" :value="item.time_zone">
                        {{ item.time_zone }}
                    </option>
                </select>
            </div>
            <div class="flex gap-2">
                <el-tooltip
                    v-if="model.removeScheduleIds.length"
                    class="box-item"
                    effect="dark"
                    content="Remove schedule"
                    placement="top"
                >
                    <button @click="removeSchedule"
                        type="button"
                        class="group flex justify-center
                        py-3 px-4 border border-transparent
                        text-sm font-medium text-white
                        bg-red-600 hover:bg-red-700
                        focus:outline-none"
                    >
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </button>
                </el-tooltip>
                <el-tooltip
                    class="box-item"
                    effect="dark"
                    content="Add fields"
                    placement="top"
                >
                    <button @click="addSchedule"
                        type="button"
                        class="group flex justify-center
                        py-3 px-4 border border-transparent
                        text-sm font-medium text-white
                        bg-indigo-600 hover:bg-indigo-700
                        focus:outline-none"
                    >
                        <font-awesome-icon icon="fa-solid fa-plus"/>
                    </button>
                </el-tooltip>
            </div>
        </div>
        <div class="mt-5">
            <hr>
            <div class="mt-5">
                <div v-for="(item,i) in model.schedules" :key="i" class="mb-5 grid grid-cols-12 gap-2">
                    <div class="col-span-1 mx-0">
                        <div class="flex items-start mt-2">
                            <div class="flex items-center h-5">
                                <input type="checkbox" :value="i" v-model="model.removeScheduleIds" class="w-4 h-4 border border-gray-300 bg-gray-50 focus:ring-0 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                            </div>
                            <label :for="`remove-schedule-${i}`" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"></label>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <el-date-picker
                            v-model="model.schedules[i].datetime"
                            type="datetime"
                            placeholder="Select date and time"
                            size="large"
                            style="width: 100%"
                            value-format="YYYY-MM-DD HH:mm:ss"
                        />
                    </div>
                    <div class="col-span-3">
                        <el-select
                            v-model="model.schedules[i].channel"
                            placeholder="Select channel"
                            size="large"
                            style="width: 100%"
                        >
                            <el-option
                                v-for="item in channels"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id"
                            />
                        </el-select>
                    </div>
                    <div class="col-span-3">
                        <el-select
                            v-model="model.schedules[i].videoSource"
                            placeholder="Select video source"
                            size="large"
                            style="width: 100%"
                        >
                            <el-option
                                v-for="item in videoSource"
                                :key="item.id"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                        <div class="mt-2" v-if="model.schedules[i].content && model.schedules[i].videoSource == 'ai-content'">
                            <textarea v-model="model.schedules[i].content" id="video-script" rows="6" class="w-full block p-2.5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Video script..."></textarea>
                            <el-tooltip
                                class="box-item"
                                effect="dark"
                                content="Select actor for your video"
                                placement="top"
                            >
                                <button @click="getAiActors"
                                    type="button"
                                    class="group mt-2 flex justify-center
                                    py-1 px-2 border border-transparent
                                    text-sm font-medium text-white
                                    bg-indigo-600 hover:bg-indigo-700
                                    focus:outline-none"
                                >
                                    Select actor
                                </button>
                            </el-tooltip>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <el-select
                            v-if="model.schedules[i].videoSource == 'content'"
                            v-model="model.schedules[i].videos"
                            multiple
                            collapse-tags
                            collapse-tags-tooltip
                            placeholder="Select videos"
                            size="large"
                            style="width: 100%"
                        >
                            <el-option
                                v-for="item in videos"
                                :key="item.id"
                                :label="item.file_name"
                                :value="item.id"
                            />
                        </el-select>
                        <div v-else>
                            <div class="md:flex gap-4">
                                <div class="relative z-0 w-72">
                                    <input v-model="model.schedules[i].keyword"
                                        type="text"
                                        id="topic"
                                        class="block py-3 px-0 w-full text-sm 
                                        text-gray-900 bg-transparent border-0 
                                        border-b-2 border-gray-300 appearance-none
                                        dark:text-white dark:border-gray-600
                                        dark:focus:border-blue-500 focus:outline-none 
                                        focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" "
                                        required 
                                    />
                                    <label
                                        for="topic"
                                        class="absolute text-sm text-gray-500
                                        dark:text-gray-400 duration-300 transform
                                        -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                        peer-focus:left-0 peer-focus:text-blue-600
                                        peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                        peer-placeholder-shown:translate-y-0
                                        peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >
                                        Enter a topic to generate content...
                                    </label>
                                </div>
                                <div class="">
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Generate content"
                                        placement="top"
                                    >
                                        <button @click="generateVideoScript(i)"
                                            type="button"
                                            class="group flex justify-center
                                            py-3 px-4 border border-transparent
                                            text-sm font-medium text-white
                                            bg-indigo-600 hover:bg-indigo-700
                                            focus:outline-none"
                                        >
                                            <font-awesome-icon icon="fa-solid fa-arrow-right"/>
                                        </button>
                                    </el-tooltip>
                                </div>
                            </div>
                            <div class="mt-2 flex" v-if="actors.items.length">
                                <div class="grid grid-cols-10 space-x-2 border border-2 p-3 rounded-md w-full">
                                    <div class="col-span-2 mb-2 cursor-pointer" v-for="(actor,idx) in actors.items" :key="idx">
                                        <div @click="selectActor(i, actor)">
                                        <img
                                            class="w-30 h-30 rounded border" 
                                            :class="[actor.id == model.schedules[i].actorId ? 'border-indigo-500 border-2':'hover:border-indigo-500 hover:border-2']"
                                            :src="actor.thumbnailImagePath" 
                                            alt="Video avatar"
                                        >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Actor pagination -->
                            <div class="pt-1 flex justify-between" v-if="actors.items.length">
                                <div>
                                    <select 
                                        id="actor-language"
                                        class="block py-1 px-0 w-full text-xs 
                                        text-gray-500 bg-transparent border-0 
                                        border-b-2 border-gray-300 appearance-none 
                                        dark:text-gray-400 dark:border-gray-600 focus:outline-none 
                                        focus:ring-0 focus:border-gray-200 peer"
                                        v-model="model.schedules[i].language"
                                    >
                                        <option v-for="item in languages" :key="item.id" :value="item.code">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Previous actors"
                                        placement="top"
                                    >
                                        <button class="bg-gray-600 hover:bg-gray-700 px-1 text-white mr-1"
                                            @click="paginateActor(actors.prevPage)" 
                                            :disabled="!actors.prevPage"
                                        >
                                            <font-awesome-icon icon="fa-solid fa-arrow-left"/>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Next actors"
                                        placement="top"
                                    >
                                        <button class="bg-gray-600 hover:bg-gray-700 px-1 text-white"
                                            @click="paginateActor(actors.nextPage)" 
                                            :disabled="!actors.nextPage"
                                        >
                                            <font-awesome-icon icon="fa-solid fa-arrow-right"/>
                                        </button>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <hr>
            <div class="flex justify-end">
                <button @click="saveSchedule"
                    type="button"
                    class="group flex justify-center
                    py-3 px-4 border border-transparent
                    text-sm font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700
                    focus:outline-none mt-4 space-x-2"
                >
                    <font-awesome-icon icon="fa-solid fa-clock" class="mr-1 pt-1"/>
                    Schedule
                    <SpinnerMini v-if="model.saveDisabled"/>
                </button>
            </div>
        </div>
    </PageComponent>
</template>

<script setup>
import { reactive, computed, onMounted, getCurrentInstance } from 'vue';
import { useRouter } from 'vue-router'
import videoScheduleStore from '../../store/videoSchedule-store';
import PageComponent from '../../components/PageComponent.vue';
import NotificationCard from '../../components/Notification.vue';
import SpinnerMini from '../../components/SpinnerMini.vue'
import notify from '../../includes/notify';
import helper from '../../includes/helper';

const router = useRouter()
const internalInstance = getCurrentInstance();
const actors = computed(() => videoScheduleStore.state.aiActors)
const languages = computed(() => videoScheduleStore.state.aiVideoLanguages)
const timezones = computed(() => videoScheduleStore.state.timezones)
const channels = computed(() => videoScheduleStore.state.channels)
const videos = computed(() => videoScheduleStore.state.videos)
const currentTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone

const videoSource = [
    {value: 'content', label: 'Contents'},
    {value: 'ai-content', label: 'New ai video content'},
]

let model = reactive({
    batchId: helper.randomString(6),
    timezone: currentTimeZone,
    schedules: [
        {
            datetime: '',
            channel: null,
            videoSource: 'content',
            videos: [],
            keyword: '',
            content: '',
            actorId: null,
            language: 'en-US'
        }
    ],
    removeScheduleIds: [],
    saveDisabled: false,
    pageNumber: 1,
    pageSize: 10,
})

function addSchedule(){
    if(model.schedules.length == 30){
        notify.notifyError2('Can only schedule for 30days.')
        return;
    }
    model.schedules.push({
        datetime: '',
        channel: null,
        videoSource: 'content',
        videos: [],
        keyword: '',
        content: '',
        actorId: null,
        language: 'en-US'
    })
}

function removeSchedule(){
    const newArray = model.schedules.filter((item,i) => !model.removeScheduleIds.includes(i))
    model.schedules = newArray
    model.removeScheduleIds = []
}

function validateRequiredFields(){
    for(const [i, item] of model.schedules.entries()){
        console.log(model.schedules[i])
        if(!model.schedules[i].datetime) return;
        if(!model.schedules[i].channel) return;
        if(model.schedules[i].videoSource == 'content' && !model.schedules[i].videos.length) return;
        else if(model.schedules[i].videoSource == 'ai-content' && !model.schedules[i].actorId) return;
        
    }
}

const selectActor = (idx, actor) => {
    model.schedules[idx].actorId = actor.id
}

const paginateActor = (pageNumber) => {
    model.pageNumber = pageNumber
    getAiActors()
}

const generateVideoScript = (idx) => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    videoScheduleStore
        .dispatch('generateAiScript', {
            topic: model.schedules[idx].keyword
        })
        .then(res => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.content && res.words > 0){
                model.schedules[idx].content = res.content
            }else{
                notify.notifyError2('Could not generate content.')
            }
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            notify.notifyError(err)
        })
}

function getAiActors(){
    internalInstance.appContext.config.globalProperties.$Progress.start();
    videoScheduleStore
        .dispatch('getAiActors', {
            pageNumber: model.pageNumber,
            pageSize: model.pageSize
        })
        .then(() => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
        })
        .catch(err => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            notify.notifyError(err)
        })
}

async function saveSchedule(){
    // if(!validateRequiredFields()) {
    //     notify.notifyError2('All fields are required.');
    //     return;
    // }
    model.saveDisabled = true
    let scheduleLen = 0

    for(let item of model.schedules){
        await videoScheduleStore
            .dispatch('storeSchedule', {
                batchId: model.batchId,
                timezone: model.timezone,
                scheduleTime: item.datetime,
                scheduleChannel: item.channel,
                scheduleVideoSource: item.videoSource,
                scheduleVideos: JSON.stringify(item.videos),
                scheduleKeyword: item.keyword,
                scheduleContent: item.content,
                scheduleActorId: item.actorId,
                language: item.language
            })
            .then(res => {
                scheduleLen++;
                if(scheduleLen == model.schedules.length){
                    model.saveDisabled = false
                    notify.notifySuccess(res.message)
                    router.push({name: 'ScheduleVideoIndex'})
                }
            })
            .catch(err => {
                model.saveDisabled = false
                notify.notifyError(err)
            })

    }
}

onMounted(() => {
    videoScheduleStore.dispatch('getTimezones')
    videoScheduleStore.dispatch('getChannelSelect')
    videoScheduleStore.dispatch('getVideoSelect')
    videoScheduleStore.dispatch('getAiVideoLanguages')
})
</script>

<style>

</style>