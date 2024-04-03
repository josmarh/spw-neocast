<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <font-awesome-icon icon="fa-solid fa-video"/>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Schedule video to channel</DialogTitle>
                        <div class="mt-4">
                            <div class="mb-3">
                                <h6 class="mb-3">Select channels to schedule your video</h6>
                                <div class="flex flex-wrap gap-3"
                                    v-for="item in channelList.data" :key="item.id">
                                    <div class="mb-1"
                                        v-if="item.channel_type == 'Playlist (On demand)'">
                                        <input 
                                        :id="item.title" 
                                        type="checkbox" 
                                        v-model="model.channels"
                                        :value="item.id"
                                        class="w-4 h-4 text-blue-600 bg-gray-100
                                        border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        <label :for="item.title" class="ml-2 text-sm text-gray-500">{{ item.title }}</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mt-3">
                                <h6 class="mb-3">Select timezone</h6>

                            </div>
                            <!-- <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p> -->
                        </div>
                    </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" 
                        class="inline-flex w-full justify-center bg-indigo-600 
                        px-3 py-2 text-sm font-semibold text-white shadow-sm 
                        hover:bg-indigo-500 sm:ml-3 sm:w-auto" @click="open = false">
                        <font-awesome-icon icon="fa-regular fa-calendar-days" class="mt-0.5 mr-1"/>
                        Schedule
                    </button>
                    <button type="button" 
                        class="mt-3 inline-flex w-full justify-center bg-white 
                        px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm 
                        ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 
                        sm:w-auto" @click="open = false" ref="cancelButtonRef">
                        Cancel
                    </button>
                </div>
                </DialogPanel>
            </TransitionChild>
            </div>
        </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { reactive, ref, watch, computed } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import videoScheduleStore from '../../store/videoSchedule-store'
import store from '../../store';

const channelList  = computed(() => store.state.channels);
const props = defineProps({
    data: Object,
    scheduleSetupState: Boolean
})

const emit = defineEmits(['updateScheduleState'])

let open = ref(props.scheduleSetupState)
let model = reactive({
    channels: [],
    timezone: '',
    days: [],
    saveDisabled: false
})

watch(() => props.scheduleSetupState, (newVal, oldVal) => {
    if(newVal)
        open.value = true
})

watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('updateScheduleState')
})

const save = () => {
    model.saveDisabled = true
    model.channels = JSON.stringify(model.channels)
    model.days = JSON.stringify(model.days)

    videoScheduleStore
        .dispatch('saveVideoSchedule', model)
        .then(res => {
            emit('updateScheduleState')
        })
        .catch(err => {

        })
}

const getVideoSchedule = () => {
    videoScheduleStore
        .dispatch('getVideoSchedule', props.data?.id)
        .then(res => {

        })
        .catch(err => {

        })
}
</script>

<style>

</style>