<template>

    <div :style="{background: config.bgColor, color: config.fontColor}">
        <header v-if="config.showHeader == 'show'">
            <nav class="bg-white border-gray-200 px-10 sm:px-4 py-2.5 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center mx-auto"
                    :class="[config.pageLayout == 'fixed' ? 'container' : 'container-fluid']"
                >
                    <router-link :to="{name: 'WebPage', params: {str: $route.params.str}}" class="flex items-center">
                        <img v-if="config.logo != null" 
                            :src="config.logo"
                            class="mr-3 h-6 sm:h-9"
                            :alt="config.title">
                        <span v-else
                            class="self-center text-3xl font-semibold whitespace-nowrap dark:text-white">
                            {{config.title}}
                        </span>
                    </router-link>
                    <div v-if="config.channelCount > 1" class="flex items-center md:order-2">
                        <Menu as="div" class="relative">
                            <div>
                                <MenuButton 
                                    class="max-w-xs flex items-center 
                                    text-sm focus:outline-none focus:ring-offset-2 
                                    focus:ring-offset-gray-800 focus:ring-white">
                                    <span class="sr-only">Open user menu</span>
                                    <a
                                        class="group relative flex justify-center
                                        py-2 px-3 border border-transparent
                                        text-sm font-medium text-white
                                        focus:outline-none cursor-pointer"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                    </a>
                                </MenuButton>
                            </div>
                            <transition 
                                enter-active-class="transition ease-out duration-100" 
                                enter-from-class="transform opacity-0 scale-95" 
                                nter-to-class="transform opacity-100 scale-100" 
                                leave-active-class="transition ease-in duration-75" 
                                leave-from-class="transform opacity-100 scale-100" 
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems 
                                    class="origin-top-right absolute right-0 mt-2 w-48
                                    rounded-md shadow-lg py-1 bg-white ring-1 ring-black 
                                    ring-opacity-5 focus:outline-none z-10 cursor-pointer">
                                    <MenuItem v-for="item in config.menuNavigation" :key="item.name" v-slot="{  }">
                                        <a 
                                            :href="item.href" 
                                            :class="[
                                                item.href.split('channel/')[1] == $route.params.chash
                                                ? 'bg-gray-100' 
                                                : '', 
                                                'block px-4 py-2 text-sm text-gray-700'
                                            ]">
                                            {{ item.name }}
                                        </a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </nav>
        </header>
        <main :class="[config.pageLayout == 'fixed' ? 'container xl:m-10 sm:m-10' : 'container-fluid mt-5']">
            <slot></slot>
        </main>
        <footer class="p-4 mt-10 bg-white shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                <span v-if="config.footerText">
                    &copy; {{new Date().getFullYear()}} {{config.footerText}}
                </span>
            </span>
            <span class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                <p>Powered by NeoCast</p>
            </span>
            
        </footer>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { MenuIcon } from '@heroicons/vue/outline'

const props = defineProps({
    config: Object,
});



// const userNavigation = [
//   { name: 'Your Profile', href: '#' },
//   { name: 'Settings', href: '#' },
// ]
</script>

<style>

</style>