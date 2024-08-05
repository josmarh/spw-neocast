<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="p-4">
            <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
                <router-link
                :to="{ name: 'ScheduleVideo' }"
                class="group relative flex justify-center
                py-2 px-3 border border-transparent
                text-sm font-medium text-white
                bg-indigo-600 hover:bg-indigo-700
                focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    New Schedule
                </router-link>
            </div>
        </div>
        <div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Batch ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Timezone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Scheduled At
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Channel
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Videos
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap uppercase">
                            {{ item.batchId }}
                        </th>
                        <td class="px-6 py-4">
                            {{ item.timezone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.scheduledTime }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.channel.title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.videos }}
                        </td>
                        <td class="px-6 py-4">
                            <span v-if="item.status == 'scheduled'" class="capitalize inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                <font-awesome-icon icon="fa-solid fa-clock" class="mr-1" />{{ item.status }}
                            </span>
                            <span v-if="item.status == 'completed'" class="capitalize inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10">
                                <font-awesome-icon icon="fa-solid fa-circle-check" class="mr-1" />{{ item.status }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
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
    </div>
</template>

<script setup>
const props = defineProps({
    data: Array,
    meta: Object
})
const emit = defineEmits(['paginate'])

const paginate = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) return;
    emit('paginate', link.url)
}
</script>

<style>

</style>