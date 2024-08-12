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
    {
        label:'Add Video', 
        imgSrc:'https://i.vimeocdn.com/video/1913812212-fc971c004aa0e6b80986ff43708cce0a766721bfcd880df84137a93bdf955f50-d_640x360', 
        href:'https://vimeo.com/997685754'
    },
    {
        label:'Video Scheduling', 
        imgSrc:'https://i.vimeocdn.com/video/1913812023-012b1af26de9d40c9700e4a53b17495c896ce90260d2b0480a081cdf8c993521-d_640x360', 
        href:'https://vimeo.com/997685640'
    },
    {
        label:'Ondemand Channel',
        imgSrc:'https://i.vimeocdn.com/video/1913812212-fc971c004aa0e6b80986ff43708cce0a766721bfcd880df84137a93bdf955f50-d_640x360', 
        href:'https://vimeo.com/997685689'
    },
    {
        label:'Linear Channel', 
        imgSrc:'https://i.vimeocdn.com/video/1913811875-3b964205719f54f9ab9b34b355be37cf787be0d5835483e42f6d65dc3ff4725d-d_640x360', 
        href:'https://vimeo.com/997685456'
    },
    // {label:'Live Stream', imgSrc:'https://i.vimeocdn.com/video/1642148135-85b7197ca88ba6b61e9e6e33e0153d271894ec0261ec2084c66441f5603a162c-d_236x133', href:'https://vimeo.com/866329278'},
    {label:'Live Stream OBS Setup', imgSrc:'https://i.vimeocdn.com/video/1645364963-dd1b9a1b5e49410756f5b862f8bd0482bff79b6cc1b4a8f30f9cc3bacc986776-d_236x133', href:'https://vimeo.com/813598333'},
    {
        label:'Website', 
        imgSrc:'https://i.vimeocdn.com/video/1913811941-7bf252ced224afb44676dd4f5ba781444277f2d2b1868d04994b008960ce5cec-d_640x360', 
        href:'https://vimeo.com/997685554'
    },
    // {label:'Publish on Roku', imgSrc:'https://i.vimeocdn.com/video/1643109999-795068c41f06fe17b9786592f22c8bbc18805249ba7e5490a08b39a1de210caa-d_236x133', href:'https://vimeo.com/'},
    // {label:'Publish on Amazon FireTv', imgSrc:'https://i.vimeocdn.com/video/1643121500-89346cbd872c8efa7382bdeea97608ef14bc39a1549dfc12d1ff92ab4e431388-d_236x133', href:'https://vimeo.com/'},
    // {label:'Channel Ads Monetization', imgSrc:'https://i.vimeocdn.com/video/1726557798-7e299ed5a076012bfdba7b577756266c3d609583f0c252af103b099e929e8ee3-d_236x133', href:'https://vimeo.com/866329000'},
    {label:'Generate Video Ads Tag', imgSrc:'/ads_tag.png', href:'https://www.youtube.com/watch?v=ICh-g5w8yzY'}
]
</script>