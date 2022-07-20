<template>
    <article-component>
        <div v-if="isArticleSet == 1">
            <div role="status" class="space-y-2.5 animate-pulse ">
                <div class="flex items-center space-x-2 w-full">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-80"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-32"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-80"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <div class="flex items-center space-x-2 w-full">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-80"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-32"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 ">
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-80"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-full"></div>
                </div>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-if="isArticleSet == 2" v-html="model.content"></div>
    </article-component>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ArticleComponent from '../../components/ArticleComponent.vue'
import store from "../../store";

const route = useRoute()

let model = ref({
    id: null,
    title: '',
    content: ''
})
let isArticleSet = ref(0)

function getArticle() {
    isArticleSet.value = 1
    store
        .dispatch('article', route.params.name)
        .then((res) => {
            isArticleSet.value = 2
            let data = res.data

            model.value.id = data.id
            model.value.title = data.title
            model.value.content = data.content
        })
        .catch((err) => {
            isArticleSet.value = 3
            console.log(err)
        })
}

onMounted(() => {
    getArticle()
})
</script>

<style>

</style>