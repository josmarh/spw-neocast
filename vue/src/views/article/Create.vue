<template>
    <page-component title="New Article" class="bg-gray-100">
        <Notification />
        <form @submit.prevent="save">
            <div class="relative z-0">
                <input type="text" 
                    v-model="model.title"
                    id="floating_standard" 
                    class="block py-2.5 px-0 w-full 
                    text-sm text-gray-900 bg-transparent 
                    border-0 border-b-2 border-gray-300 
                    appearance-none dark:text-white 
                    dark:border-gray-600 dark:focus:border-blue-500 
                    focus:outline-none focus:ring-0 
                    focus:border-blue-600 peer" 
                    placeholder=" " required="" />
                <label for="floating_standard" 
                    class="absolute text-sm text-gray-500 
                    dark:text-gray-400 duration-300 transform 
                    -translate-y-6 scale-75 top-3 -z-10 origin-[0] 
                    peer-focus:left-0 peer-focus:text-blue-600 
                    peer-focus:dark:text-blue-500 
                    peer-placeholder-shown:scale-100 
                    peer-placeholder-shown:translate-y-0 
                    peer-focus:scale-75 peer-focus:-translate-y-6">
                    Article Title
                </label>
            </div>
            <div class="mt-6">
                <label for="content" class="font-medium">Content</label>
                <vue-editor v-model="model.content" class="bg-white"></vue-editor>
            </div>
            <div class="flex space-x-3 mt-6">
                <div>
                    <button type="submit"
                        class="group relative flex justify-center
                        py-2 px-6 border border-transparent
                        text-sm font-medium text-white
                        bg-indigo-600 hover:bg-indigo-700
                        focus:outline-none">
                        Save
                    </button>
                </div>
                <div>
                    <router-link 
                        :to="{ name: 'Articles' }"
                        role="button"
                        class="group relative flex justify-center
                        py-2 px-6 border border-transparent
                        text-sm font-medium text-white
                        bg-gray-600 hover:bg-gray-700
                        focus:outline-none">
                        Cancel
                    </router-link>
                </div>
            </div>
        </form>
    </page-component>
</template>

<script setup>
import { getCurrentInstance } from 'vue'
import { useRouter } from 'vue-router'
import { VueEditor } from "vue3-editor";
import PageComponent from '../../components/PageComponent.vue';
import Notification from '../../components/Notification.vue';
import store from '../../store';

const router = useRouter()
const internalInstance = getCurrentInstance()

let model = {
    title: '',
    content: ''
}

function save() {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    store
        .dispatch('storeArticle', model)
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            setTimeout(() => {
                store.dispatch("setSuccessNotification", "");
            }, 3000)
            router.push({name: 'Articles'})
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
</script>

<style>

</style>