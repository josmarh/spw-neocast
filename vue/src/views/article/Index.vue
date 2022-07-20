<template>
    <page-component title="Articles" 
        :class="[isArticleSet == 0 || isArticleSet == 1 || articles.data.length  ? 'h-screen bg-gray-100' : '' ]">
        <notification />
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4">
                <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
                    <router-link
                        :to="{ name: 'ArticleCreate' }"
                        class="group relative flex justify-center
                        py-2 px-3 border border-transparent
                        text-sm font-medium text-white
                        bg-indigo-600 hover:bg-indigo-700
                        focus:outline-none"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create article
                    </router-link>
                </div>
            </div>
            <!-- table data  -->
            <div v-if="isArticleSet == 2">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Content
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in articles.data" :key="item.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{item.title}}
                            </th>
                            <td class="px-6 py-4">
                                {{item.content.replace(/(.{40})..+/, "$1…")}}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex">
                                    <!-- edit -->
                                    <div class="tooltip-delete">
                                        <button type="button" @click="edit(item.id)"
                                        class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                        focus:outline-none focus:ring-gray-100 
                                        font-medium text-sm px-5 py-2.5 text-center 
                                        inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                        <span class="tooltiptext">Edit</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        </button>
                                    </div>
                                    <!-- delete -->
                                    <div class="tooltip-delete">
                                        <button type="button" @click="deleteConfirm(item.id, item.title)"
                                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                            focus:outline-none focus:ring-gray-100 
                                            font-medium text-sm px-5 py-2.5 text-center 
                                            inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                            <span class="tooltiptext">Delete</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- pagination -->
                <div class="flex justify-center mt-5 mb-5">
                    <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm "
                    aria-label="Pagination"
                    >
                    <a 
                        v-for="(link, i) of articles.meta.links" 
                        :key="i"
                        :disabled="!link.url"
                        href="#"
                        @click="getForPage($event,link)"
                        aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 border text-sm
                        font-medium whitespace-nowrap"
                        :class="[
                        link.active 
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === articles.meta.links.length - 1 ? 'rounded-r-md' : '',
                        ]"
                        v-html="link.label"
                    >
                    </a>
                    </nav>
                </div>
            </div>
        </div>
        <div v-if="isArticleSet == 1" class="flex justify-center py-20">
            <!-- spinner state -->
            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
        </div>
        <!-- no data view -->
        <div v-if="isArticleSet == 3">
            <div class="flex justify-center items-center">
                <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="text-2xl text-gray-900 dark:text-white">No article available</h5>
                    <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <img src="../../assets/no_channel.png" class="xl:w-82 xl:h-82" />
                    </div>
                </div>
            </div>
        </div>
        <!-- delete modal -->
        <TransitionRoot as="template" :show="openDelete">
            <Dialog as="div" class="relative z-10" @close="openDelete = false">
            <TransitionChild as="template" 
                enter="ease-out duration-300" 
                enter-from="opacity-0" 
                enter-to="opacity-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100" 
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                <TransitionChild as="template" 
                    enter="ease-out duration-300" 
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    enter-to="opacity-100 translate-y-0 sm:scale-100" 
                    leave="ease-in duration-200" 
                    leave-from="opacity-100 translate-y-0 sm:scale-100" 
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Delete - {{model.name}} </DialogTitle>
                            <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this article? 
                                All of your data will be permanently removed. 
                                This action cannot be undone.
                            </p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                        class="w-full inline-flex justify-center border 
                        border-transparent shadow-sm px-4 py-2 bg-red-600 text-base 
                        font-medium text-white hover:bg-red-700 sm:ml-3 
                        sm:w-auto sm:text-sm" 
                        @click="_delete(model.id)">Delete
                        </button>
                        <button type="button" 
                        class="mt-3 w-full inline-flex justify-center 
                        border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                        font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                        sm:ml-3 sm:w-auto sm:text-sm" 
                        @click="openDelete = false" ref="cancelButtonRef">Cancel
                        </button>
                    </div>
                    </DialogPanel>
                </TransitionChild>
                </div>
            </div>
            </Dialog>
        </TransitionRoot>
    </page-component>
</template>

<script setup>
import { ref, onMounted, computed, getCurrentInstance } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { ExclamationIcon } from '@heroicons/vue/outline';
import PageComponent from "../../components/PageComponent.vue";
import Notification from "../../components/Notification.vue";
import store from "../../store";

const articles = computed(() => store.state.articles)
const route = useRoute()
const router = useRouter()
const internalInstance = getCurrentInstance()
const openDelete = ref(false)

let isArticleSet = ref(0)
let model = ref({
    id: null,
    name: ''
})

function index() {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isArticleSet.value = 1
    store
        .dispatch('getArticles')
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.data.length)
                isArticleSet.value = 2
            else
                isArticleSet.value = 3
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isArticleSet.value = 3
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                    setTimeout(() => {
                        store.dispatch("setErrorNotification", "");
                    }, 4000)
                }
            }
            console.log(err)
        })
}

function edit(id) {
    router.push({
        name: 'ArticleEdit', 
        params: {id: id}
    })
}

function _delete(id) {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    store
        .dispatch('deleteArticle', id)
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch('getArticles')
            store.dispatch("setSuccessNotification", res.message);
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                    setTimeout(() => {
                        store.dispatch("setErrorNotification", "");
                    }, 4000)
                }
            }
        })
}

function getForPage(ev,link) {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }
  store.dispatch("getArticles", {url: link.url})
}

function deleteConfirm(id, title) {
    model.value.id = id
    model.value.name = title
    openDelete.value = true
}

onMounted(() => {
    index()
})
</script>

<style>

</style>