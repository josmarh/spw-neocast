<template>
    <PageComponent title="Video Schedules">
        <Notification/>
        <ScheduleList :data="schedules.data" :meta="schedules.meta" @paginate="paginate"/>
    </PageComponent>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import PageComponent from '../../components/PageComponent.vue';
import Notification from '../../components/Notification.vue';
import ScheduleList from '../../components/video/ScheduleList.vue';
import videoScheduleStore from '../../store/videoSchedule-store';

const schedules = computed(()=> videoScheduleStore.state.videoSchedules)

const paginate = () => {
    videoScheduleStore.dispatch('paginateVideoSchedule', url)
}
onMounted(() => {
    videoScheduleStore.dispatch('getVideoSchedules')
})
</script>

<style>

</style>