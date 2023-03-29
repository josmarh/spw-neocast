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
    {label:'Add Video', imgSrc:'https://i.vimeocdn.com/video/1642142356-ab0203a7c12a1fb1edc6d18084286a51fb071db4b67490cd5e8eff5bab0672a8-d_236x133', href:'https://vimeo.com/812185811'},
    {label:'Ondemand Channel', imgSrc:'https://i.vimeocdn.com/video/1642148135-85b7197ca88ba6b61e9e6e33e0153d271894ec0261ec2084c66441f5603a162c-d_236x133', href:'https://vimeo.com/812188214'},
    {label:'Linear Channel', imgSrc:'https://i.vimeocdn.com/video/1642146032-04460ef3f52fa5f9e787ebcfcde5e021cdd7274d95c92ee0178f419a5b009a9d-d_236x133', href:'https://vimeo.com/812187671'},
    {label:'Live Stream', imgSrc:'#', href:'#'},
    {label:'Website', imgSrc:'https://i.vimeocdn.com/video/1642148135-85b7197ca88ba6b61e9e6e33e0153d271894ec0261ec2084c66441f5603a162c-d_236x133', href:'https://vimeo.com/812188776'},
    {label:'Publish to Roku', imgSrc:'https://i.vimeocdn.com/video/1643109999-795068c41f06fe17b9786592f22c8bbc18805249ba7e5490a08b39a1de210caa-d_236x133', href:'https://vimeo.com/812619591'},
    {label:'Publish to Amazon FireTv', imgSrc:'https://i.vimeocdn.com/video/1643121500-89346cbd872c8efa7382bdeea97608ef14bc39a1549dfc12d1ff92ab4e431388-d_236x133', href:'https://vimeo.com/812624131'},
    {label:'Channel Ads Monetization', imgSrc:'https://i.vimeocdn.com/video/1643108362-3e255867f3ac56e4b19112a4922be464375b6a4018d31afc988b5d8d9310f2d5-d_236x133', href:'https://vimeo.com/812619002'},
    {label:'Generate Video Ads Tag', imgSrc:'/ads_tag.png', href:'https://www.youtube.com/watch?v=ICh-g5w8yzY'}
]
</script>