<template>
    <PageComponent title="Video Schedule">
        <NotificationCard/>
        <div class="flex justify-between">
            <div class="flex gap-2">
                <label for="timezone" class="text-sm mt-2">Timezone: </label>
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
                <div v-for="(item,i) in model.schedules" :key="i" class="mb-3 grid grid-cols-12 gap-2">
                    <div class="col-span-1 mx-0">
                        <div class="flex items-start mt-2">
                            <div class="flex items-center h-5">
                                <input type="checkbox" :value="i" v-model="model.removeScheduleIds" class="w-4 h-4 border border-gray-300 bg-gray-50 focus:ring-0 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                            </div>
                            <label :for="`remove-schedule-${i}`" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"></label>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <el-date-picker
                            v-model="model.schedules[i].datetime"
                            type="datetime"
                            placeholder="Select date and time"
                            size="large"
                            value-format="YYYY-MM-DD HH:mm:ss"
                        />
                    </div>
                    <div class="col-span-3">
                        <el-select
                        v-model="model.schedules[i].channel"
                        placeholder="Select channel"
                        size="large"
                        style="width: 240px"
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
                        v-model="model.schedules[i].videos"
                        multiple
                        collapse-tags
                        collapse-tags-tooltip
                        placeholder="Select videos"
                        size="large"
                        style="width: 240px"
                        >
                        <el-option
                            v-for="item in videos"
                            :key="item.id"
                            :label="item.file_name"
                            :value="item.id"
                        />
                        </el-select>
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
                    focus:outline-none mt-4"
                >
                    <font-awesome-icon icon="fa-solid fa-clock" class="mr-1 pt-1"/>
                    Schedule
                </button>
            </div>
        </div>
    </PageComponent>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router'
import videoScheduleStore from '../../store/videoSchedule-store';
import PageComponent from '../../components/PageComponent.vue';
import NotificationCard from '../../components/Notification.vue';
import notify from '../../includes/notify';
import helper from '../../includes/helper';

const router = useRouter()
const timezones = computed(() => videoScheduleStore.state.timezones)
const channels = computed(() => videoScheduleStore.state.channels)
const videos = computed(() => videoScheduleStore.state.videos)
const currentTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone

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
            actorId: null
        }
    ],
    removeScheduleIds: [],
    saveDisabled: false
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
            actorId: null
    })
}

function removeSchedule(){
    for(let item of model.removeScheduleIds){
        model.schedules.splice(item, 1);
    }
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
})
</script>

<style>

</style>