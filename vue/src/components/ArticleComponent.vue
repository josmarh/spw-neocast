<template>
    <div class="relative flex min-h-screen">
        <!-- sidebar -->
        <div class="bg-white text-black w-64 space-y-6 px-2 py-4 
            absolute insert-y-0 left-0 md:relative md:-translate-x-0 
            transform -translate-x-full duration-200 ease-in-out
            shadow-lg"
            :class="{'relative -translate-x-0' : showSidebar}">
            <a href="#" class="flex items-center justify-center">
                <div class="flex-shrink-0">
                    <img class="h-8 " :src="appUrl + '/smatflix-brand-logo.png'" alt="Workflow" />
                </div>
                <!-- <span class="text-1xl font-extrabold text-bl ml-3">TubeAdsInsights</span> -->
            </a>
            <nav>
                <a
                    v-for="item in navigation" 
                    :key="item.name" 
                    :href="item.href" 
                    class="block px-12 py-2 rounded-md text-base 
                    hover:text-extrabold hover:font-medium flex 
                    mb-3"
                    active-class="font-medium"
                    :class="[ this.$router.name === item.href.name 
                    ? 'text-extrabold font-medium' : '']">
                    {{ item.name }}
                </a>
            </nav>
        </div>
        <!-- main content -->
        <div class="flex-1">
            <!-- header -->
            <div class="bg-white shadow px-2 py-4">
                <button @click="showSidebar = !showSidebar" class="text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>
            <!-- content -->
            <div class="p-8">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

const appUrl = import.meta.env.VITE_APP_URI
const navigation = [
    // { name: 'Getting Started', href: '2-App-TV'},
    { name: 'TV App', href: '1-App-TV'},
    { name: 'Generate Youtube API Key', href: '2-Generate-Youtube-API-Key'},
]

export default {
    setup() {
        const showSidebar = ref(false);

        return {
            showSidebar,
            navigation
        }
    }
}
</script>

<style>

</style>