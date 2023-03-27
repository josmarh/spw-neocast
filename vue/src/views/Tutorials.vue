<template>
<page-component title="Tutorials">
    <div class="md:grid grid-cols-12 gap-10 mt-6">
        <div v-for="item in videos" :key="item.label"
            class="max-w-sm bg-white rounded-lg
            border border-gray-200 shadow-md 
            col-span-3 h-auto">
            <a :href="item.href" data-fancybox>
                <img v-if="item.imgSrc" 
                    class="rounded-t-lg w-full" 
                    :src="item.imgSrc" 
                    alt="">
                <img v-else class="rounded-t-lg" 
                    src="https://flowbite.com/docs/images/blog/image-1.jpg" 
                    alt="">
            </a>
            <div class="p-3">
                <a href="#">
                    <h5 class="text-lg font-semibold 
                        tracking-tight text-gray-900">
                        {{item.label}}
                    </h5>
                </a>
            </div>
        </div>
    </div>
</page-component>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue'
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

const videos = [
    {label:'Add Video', imgSrc:'#', href:'#'},
    {label:'Ondemand Channel', imgSrc:'#', href:'#'},
    {label:'Linear Channel', imgSrc:'#', href:'#'},
    {label:'Live Stream', imgSrc:'#', href:'#'},
    {label:'Website', imgSrc:'#', href:'#'},
    {label:'Publish to Roku', imgSrc:'#', href:'#'},
    {label:'Publish to Amazon FireTv', imgSrc:'#', href:'#'},
    {label:'Ads Monetization', imgSrc:'#', href:'#'}
]
</script>