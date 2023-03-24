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
    {label:'Add Video', imgSrc:'https://i.vimeocdn.com/video/1501177829-a1c747670ed9abb8b2cd4752f221db6b28c03b60165149b9f31b702cc102baab-d_236x133', href:'https://vimeo.com/746360339'},
    {label:'Ondemand Channel', imgSrc:'https://i.vimeocdn.com/video/1501179111-1b948a5290bc5c4a109d4561de15534f0a7247beafad371adf246a271eef1240-d_236x133', href:'https://vimeo.com/746360853'},
    {label:'Linear Channel', imgSrc:'https://i.vimeocdn.com/video/1496332396-644eff175ca1e54e3c26eb3877b1020342841e437f6d3ce8dcfe7c1bff7aaadc-d_236x133', href:'https://vimeo.com/743799816'},
    {label:'Live Stream', imgSrc:'https://i.vimeocdn.com/video/1496340797-29930ef781287f16a3648a0989f49d91bc5c43008483c752407b2d418993e539-d_236x133', href:'https://vimeo.com/743802614'},
    {label:'Website', imgSrc:'https://i.vimeocdn.com/video/1501183684-8ef4168104a7b42a49061646ecc3c82f53513d538b0ed9acf6962de86c2152a3-d_236x133', href:'https://vimeo.com/746362936'},
    {label:'Publish to Roku', imgSrc:'https://i.vimeocdn.com/video/1501183568-0d612b79145d1d6692e153c1e8f98e79313e0b7c2d86d433101ec13f2d26020a-d_236x133', href:'https://vimeo.com/746362908'},
    {label:'Publish to Amazon FireTv', imgSrc:'https://i.vimeocdn.com/video/1501192972-f0c17dcf5368f1d337a058416bbc2776c7417089639a7fd21d38121090cf456d-d_236x133', href:'https://vimeo.com/746366689'},
    {label:'Ads Monetization', imgSrc:'https://i.vimeocdn.com/video/1501193120-906772c4f809d23a48476930a7356627f8e829d418de9dc950bc3f75c17658e6-d_236x133', href:'https://vimeo.com/746366745'}
]
</script>