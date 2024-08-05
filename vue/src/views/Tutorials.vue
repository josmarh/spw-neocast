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
    {label:'Add Video', imgSrc:'https://i.vimeocdn.com/video/1726557798-7e299ed5a076012bfdba7b577756266c3d609583f0c252af103b099e929e8ee3-d_236x133', href:'https://vimeo.com/866327918'},
    {label:'Ondemand Channel', imgSrc:'https://i.vimeocdn.com/video/1726559505-946dba20e8a1a52b4fd3b13b7592831135feeacc4132efadccc21be8fe0de5de-d_236x133', href:'https://vimeo.com/866329340'},
    {label:'Linear Channel', imgSrc:'https://i.vimeocdn.com/video/1726560829-98592a245ec9200c45f89d2e360691d1ad200c6cbf7ae538d7a4676128767934-d_236x133', href:'https://vimeo.com/866329030'},
    {label:'Live Stream', imgSrc:'https://i.vimeocdn.com/video/1642148135-85b7197ca88ba6b61e9e6e33e0153d271894ec0261ec2084c66441f5603a162c-d_236x133', href:'https://vimeo.com/866329278'},
    {label:'Live Stream OBS Setup', imgSrc:'https://i.vimeocdn.com/video/1645364963-dd1b9a1b5e49410756f5b862f8bd0482bff79b6cc1b4a8f30f9cc3bacc986776-d_236x133', href:'https://vimeo.com/813598333'},
    {label:'Website', imgSrc:'https://i.vimeocdn.com/video/1726559505-946dba20e8a1a52b4fd3b13b7592831135feeacc4132efadccc21be8fe0de5de-d_236x133', href:'https://vimeo.com/866329434'},
    // {label:'Publish on Roku', imgSrc:'https://i.vimeocdn.com/video/1643109999-795068c41f06fe17b9786592f22c8bbc18805249ba7e5490a08b39a1de210caa-d_236x133', href:'https://vimeo.com/'},
    // {label:'Publish on Amazon FireTv', imgSrc:'https://i.vimeocdn.com/video/1643121500-89346cbd872c8efa7382bdeea97608ef14bc39a1549dfc12d1ff92ab4e431388-d_236x133', href:'https://vimeo.com/'},
    {label:'Channel Ads Monetization', imgSrc:'https://i.vimeocdn.com/video/1726557798-7e299ed5a076012bfdba7b577756266c3d609583f0c252af103b099e929e8ee3-d_236x133', href:'https://vimeo.com/866329000'},
    {label:'Generate Video Ads Tag', imgSrc:'/ads_tag.png', href:'https://www.youtube.com/watch?v=ICh-g5w8yzY'}
]
</script>