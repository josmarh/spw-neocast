<template>
    <div>
        <website-component>
            <notification />
            <form @submit.prevent="createWebsite">
                <div class="grid xl:grid-cols-12">
                    <div class="xl:col-span-6">
                        <div class="p-4 w-full bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="mb-2 text-2md font-bold text-gray-900 dark:text-white">Channels</h5>
                            <button type="button" @click="getChannelList"
                                class="group relative flex justify-center
                                py-2 px-3 border border-transparent
                                text-sm font-medium text-white
                                bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none mt-6"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Channel
                            </button>

                            <p class="text-sm mt-6" v-if="!model.channel.length"><em>No channel added yet</em></p>
                            <div class="mt-6" v-if="model.channel.length">
                                <ul class="w-auto text-sm text-gray-900 bg-white border border-gray-200  dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li v-for="c in tmpChannelModel" :key="c.id"
                                        class="w-full px-4 py-1 border-b border-gray-200 rounded-t-lg dark:border-gray-600 inline-flex justify-between">
                                        <p class="pt-1">{{c.title}}</p>
                                        <span class="content-right">
                                            <button type="button"
                                                @click="removeChannel(c.id)"
                                                class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                focus:outline-none focus:ring-gray-100 
                                                text-sm px-2 py-2 text-center 
                                                inline-flex items-center dark:focus:ring-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid xl:grid-cols-12 mt-10">
                    <div class="xl:col-span-6">
                        <div class="p-4 w-full bg-white border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="mb-2 text-2md font-bold text-gray-900 dark:text-white">Basics</h5>
                            <!-- website title -->
                            <div class="relative z-0 w-full mt-6 group">
                                <input 
                                    type="text" 
                                    name="website_name"
                                    v-model="model.title"
                                    class="block py-2.5 px-0 w-full text-sm 
                                    text-gray-900 bg-transparent border-0 
                                    border-b-2 border-gray-300 appearance-none 
                                    dark:text-white dark:border-gray-600 
                                    dark:focus:border-blue-500 focus:outline-none 
                                    focus:ring-0 focus:border-blue-600 peer" 
                                    placeholder=" " required="" 
                                >
                                <label 
                                    for="website_name" 
                                    class="peer-focus:font-medium absolute 
                                    text-sm text-gray-500 dark:text-gray-400 
                                    duration-300 transform -translate-y-6 scale-75 
                                    top-3 -z-10 origin-[0] peer-focus:left-0 
                                    peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                    peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Title
                                </label>
                            </div>
                            <!-- website urlPath -->
                            <div class="grid xl:grid-cols-12 mt-6">
                                <div class="xl:col-span-4 md:col-span-4">
                                    <p class="text-sm py-3">{{model.domain}}</p>
                                </div>
                                <div class="xl:col-span-8 md:col-span-8">
                                    <div class="relative z-0 w-full group">
                                        <input 
                                            type="text" 
                                            name="website_name"
                                            v-model="model.urlPath"
                                            class="block py-2.5 px-0 w-full text-sm 
                                            text-gray-900 bg-transparent border-0 
                                            border-b-2 border-gray-300 appearance-none 
                                            dark:text-white dark:border-gray-600 
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer" 
                                            placeholder=" " required="" 
                                        >
                                        <label 
                                            for="website_name" 
                                            class="peer-focus:font-medium absolute 
                                            text-sm text-gray-500 dark:text-gray-400 
                                            duration-300 transform -translate-y-6 scale-75 
                                            top-3 -z-10 origin-[0] peer-focus:left-4 
                                            peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                            peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                            peer-focus:scale-75 peer-focus:-translate-y-6"
                                        >Url path
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- design part -->
                            <div class="mt-6">
                                <h5 class="mb-4 text-2md font-bold text-gray-900 dark:text-white">Design</h5>
                                <div class="xl:flex">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Logo:</span>
                                        <div class="mt-3 flex items-center">
                                            <img v-if="model.logoUrl" 
                                                :src="model.logoUrl"
                                                class="w-24 h-20 object-cover"
                                            />
                                            <span v-else class="inline-block h-20 w-[6.3rem] overflow-hidden bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            </span>
                                        </div>
                                        <button type="button" 
                                            class="relative overflow-hidden bg-white py-2 px-5 border border-gray-300
                                            shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            <input 
                                                type="file" 
                                                class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                                @change="onLogoChoose"
                                            >
                                            Add logo
                                        </button>
                                    </div>
                                    <div class="xl:px-6">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Favicon:</span>
                                        <div class="mt-3 flex items-center">
                                            <img v-if="model.faviconUrl" 
                                                :src="model.faviconUrl"
                                                class="w-24 h-20 object-cover"
                                            />
                                            <span v-else class="inline-block h-20 w-[6.5rem] overflow-hidden bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            </span>
                                        </div>
                                        <button type="button" 
                                            class="relative overflow-hidden bg-white py-2 px-3 border border-gray-300
                                            shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            <input 
                                                type="file" 
                                                class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                                @change="onFaviconChoose"
                                            >
                                            Add favicon
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Header:</span>
                                    <div class="flex mt-4">
                                        <div class="flex items-center mr-4">
                                            <input id="show-header" type="radio" value="show" name="show_header" v-model="model.header"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="show-header" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Show header</label>
                                        </div>
                                        <div class="flex items-center mr-4">
                                            <input id="hide-header" type="radio" value="hide" name="hide_header" v-model="model.header"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="hide-header" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Hide header</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Page layout:</span>
                                    <div class="flex mt-4">
                                        <div class="flex items-center mr-4">
                                            <input id="fixed-layout" type="radio" value="fixed" name="fixed_layout" v-model="model.pageLayout"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="fixed-layout" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Fixed width</label>
                                        </div>
                                        <div class="flex items-center mr-4">
                                            <input id="full-layout" type="radio" value="full" name="full_layout" v-model="model.pageLayout"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="full-layout" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Full width</label>
                                        </div>
                                    </div>
                                    <div class="xl:flex mt-5">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Background color:</span>
                                            <div class="flex">
                                                <span
                                                    class="inline-flex items-center px-3
                                                    text-sm text-gray-900 bg-gray-200 
                                                    border border-gray-300 
                                                    dark:bg-gray-600 dark:text-gray-400 
                                                    dark:border-gray-600"
                                                    :style="{background: model.bgColor}"
                                                ></span>
                                                <input type="text" id="bg-color" 
                                                    class="rounded-none bg-gray-50
                                                    text-gray-900 block flex-1 min-w-0 
                                                    text-sm border-gray-300 p-2 border-0"
                                                    v-model="model.bgColor"
                                                    @click="bgPicker.show = true"
                                                    @blur="bgPicker.show = false"
                                                >
                                            </div>
                                            <ColorPicker
                                                class="z-50 absolute "
                                                theme="light"
                                                :color="model.bgColor"
                                                :sucker-hide="true"
                                                :sucker-canvas="bgPicker.suckerCanvas"
                                                :sucker-area="bgPicker.suckerArea"
                                                @changeColor="changeColor"
                                                @openSucker="openSucker"
                                                v-show="bgPicker.show == true"
                                            />
                                        </div>
                                        <div class="xl:px-5">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Font color:</span>
                                            <div class="flex">
                                                <span
                                                    class="inline-flex items-center px-3
                                                    text-sm text-gray-900 bg-gray-200 
                                                    border border-gray-300 
                                                    dark:bg-gray-600 dark:text-gray-400 
                                                    dark:border-gray-600"
                                                    :style="{background: model.fontColor}"
                                                ></span>
                                                <input type="text" id="font-color" 
                                                    class="rounded-none bg-gray-50 
                                                    text-gray-900 block flex-1 min-w-0 
                                                    text-sm border-gray-300 p-2 border-0"
                                                    v-model="model.fontColor"
                                                    @click="fontPicker.show = true"
                                                    @blur="fontPicker.show = false"
                                                >
                                            </div>
                                            <ColorPicker
                                                class="z-50 absolute"
                                                theme="light"
                                                :color="model.fontColor"
                                                :sucker-hide="true"
                                                :sucker-canvas="fontPicker.suckerCanvas"
                                                :sucker-area="fontPicker.suckerArea"
                                                @changeColor="changefColor"
                                                @openSucker="openfSucker"
                                                v-show="fontPicker.show == true"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- player options -->
                            <div class="mt-10">
                                <h5 class="mb-4 text-2md font-bold text-gray-900 dark:text-white">Player options</h5>
                                <div class="flex">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Playback options</span>
                                        <div class="flex items-center mt-5">
                                            <input id="autoplay" type="checkbox" v-model="model.autoplay" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 
                                                dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="autoplay" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Autoplay (if possible)</label>
                                        </div>
                                        <div class="flex items-center mt-3">
                                            <input id="volume" type="checkbox" v-model="model.volume"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                                focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="volume" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Volume</label>
                                        </div>
                                    </div>
                                    <div class="xl:px-12">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Display options</span>
                                        <div class="flex items-center mt-5">
                                            <input id="controls" type="checkbox" v-model="model.controls" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 
                                                dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                                                dark:border-gray-600">
                                            <label for="controls" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Show controls</label>
                                        </div>
                                        <div class="flex items-center mt-3">
                                            <input id="content-title" type="checkbox" v-model="model.contentTitle"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                                focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="content-title" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Show content title</label>
                                        </div>
                                        <div class="flex items-center mt-3">
                                            <input id="show-share-btn" type="checkbox" v-model="model.showShareBtn"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 
                                                focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="show-share-btn" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Show share buttons</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Site information -->
                            <div class="mt-10">
                                <h5 class="mb-4 text-2md font-bold text-gray-900 dark:text-white">Site information</h5>
                                <div class="relative z-0 w-full mt-6 group">
                                    <input 
                                        type="text" 
                                        name="website_name"
                                        v-model="model.footer"
                                        class="block py-2.5 px-0 w-full text-sm 
                                        text-gray-900 bg-transparent border-0 
                                        border-b-2 border-gray-300 appearance-none 
                                        dark:text-white dark:border-gray-600 
                                        dark:focus:border-blue-500 focus:outline-none 
                                        focus:ring-0 focus:border-blue-600 peer" 
                                        placeholder=" "
                                    >
                                    <label 
                                        for="website_name" 
                                        class="peer-focus:font-medium absolute 
                                        text-sm text-gray-500 dark:text-gray-400 
                                        duration-300 transform -translate-y-6 scale-75 
                                        top-3 -z-10 origin-[0] peer-focus:left-0 
                                        peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                        peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                        peer-focus:scale-75 peer-focus:-translate-y-6"
                                    >Footer text
                                    </label>
                                </div>
                                <div>
                                    <label for="message" 
                                        class="block mb-2 mt-5 text-sm font-medium 
                                        text-gray-900 dark:text-gray-400">
                                        Site meta description (for SEO):
                                    </label>
                                    <textarea id="site-meta" rows="4" v-model="model.siteMeta"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 
                                        rounded-lg border border-gray-300 focus:ring-blue-500 
                                        focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 
                                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                        dark:focus:border-blue-500">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" 
                        class="text-white bg-blue-700 hover:bg-blue-800 
                        focus:outline-none focus:ring-blue-300 
                        font-medium text-sm  sm:w-auto px-6 py-2.5 
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800" :disabled="isDisabled"
                    >Save</button>
                    <router-link :to="{name: 'Website'}"
                        class="ml-4 text-white bg-gray-400 hover:bg-gray-800 
                        focus:outline-none focus:ring-gray-300 
                        font-medium text-sm sm:w-auto px-5 py-2.5 
                        text-center dark:bg-gray-600 dark:hover:bg-gray-700 
                        dark:focus:ring-gray-800"
                    >Cancel</router-link>
                </div>
            </form>
            <TransitionRoot as="template" :show="openChannelList">
                <Dialog as="div" class="relative z-10" @close="openChannelList = false">
                <TransitionChild as="template" 
                    enter="ease-out duration-300" 
                    enter-from="opacity-0" 
                    enter-to="opacity-100" 
                    leave="ease-in duration-200" 
                    leave-from="opacity-100" 
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[50rem] sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                                        Add one or multiple channels to the website 
                                    </DialogTitle>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div v-if="isChannelSet == 1" class="flex justify-center py-20">
                                    <!-- spinner state -->
                                    <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" 
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                </div>
                                <div v-if="isChannelSet == 2">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="p-4">
                                                    <div class="flex items-center">
                                                        <input 
                                                        id="checkbox-all-channel" 
                                                        type="checkbox" 
                                                        v-model="checkboxAllChannel"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 
                                                        border-gray-300 rounded dark:bg-gray-700 
                                                        dark:border-gray-600">
                                                        <label for="checkbox-all-channel" class="ml-3">Select All</label>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="c in channelList.data" :key="c.id">
                                                <td class="p-4">
                                                    <div class="flex items-center">
                                                        <input type="checkbox" :value="c.id" v-model="checkedChannelToAdd" 
                                                        :id="`channel-${c.id}`"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100
                                                        border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                                        <label :for="`channel-${c.id}`" class="ml-3">{{c.title}}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" 
                                class="mt-3 w-full inline-flex justify-center border 
                                border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                                sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                                @click="openChannelList = false" ref="cancelButtonRef"
                            >Cancel</button>
                            <button type="button" @click="addChannel"
                                class="text-white bg-blue-700 hover:bg-blue-800 
                                focus:outline-none focus:ring-blue-300 
                                font-medium text-sm w-full sm:w-auto px-5 py-2.5 
                                text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                                dark:focus:ring-blue-800" :disabled="isDisabled"
                            >Accept</button>
                        </div>
                        </DialogPanel>
                    </TransitionChild>
                    </div>
                </div>
                </Dialog>
            </TransitionRoot>
        </website-component>
    </div>
</template>

<script setup>
import WebsiteComponent from '../../components/WebsiteComponent.vue';
import Notification from '../../components/Notification.vue';
import store from '../../store';
import { ref, getCurrentInstance, computed, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';

const router = useRouter();
const route = useRoute();
const internalInstance = getCurrentInstance();
const channelList  = computed(() => store.state.channels);
const isChannelSet = ref(0);
const openChannelList = ref(false);
const isDisabled = ref(false);

let bgPicker = ref({
  color: '#f3f3f3',
  colorHex: '#f3f3f3',
  suckerCanvas: null,
  suckerArea: [],
  isSucking: false,
  show: false
});

let fontPicker = ref({
  color: '#000000',
  colorHex: '#000000',
  suckerCanvas: null,
  suckerArea: [],
  isSucking: false,
  show: false
});

let model = ref({
    channel: [],
    title: 'Untitled website',
    urlPath: (Math.random() + 1).toString(36).substring(2),
    domain: `https://${window.location.host}/w/`, // for preview purpose
    logo: null,
    logoUrl: null, // for preview purpose
    favicon: null,
    faviconUrl: null, // for preview purpose
    header: 'show',
    pageLayout: 'fixed',
    bgColor: '#D2D2D2',
    fontColor: '#000000',
    autoplay: false,
    volume: true,
    controls: true,
    contentTitle: true,
    showShareBtn: true,
    footer: '',
    siteMeta: '',
});

const changeColor = (color) => {
  const { r, g, b, a } = color.rgba
  bgPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
  bgPicker.value.colorHex = color.hex
  model.value.bgColor = color.hex
}

const changefColor = (color) => {
    const { r, g, b, a } = color.rgba
    fontPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    fontPicker.value.colorHex = color.hex
    model.value.fontColor = color.hex
}

const openSucker = (isOpen) => {
  if (isOpen) {
    // ... canvas be created
    // bgPicker.value.suckerCanvas = canvas
    // bgPicker.value.suckerArea = [x1, y1, x2, y2]
  } else {
    // bgPicker.value.suckerCanvas && bgPicker.value.suckerCanvas.remove
  }
}

const openfSucker = (isOpen) => {
  if (isOpen) {
    // ... canvas be created
    // bgPicker.value.suckerCanvas = canvas
    // bgPicker.value.suckerArea = [x1, y1, x2, y2]
  } else {
    // bgPicker.value.suckerCanvas && bgPicker.value.suckerCanvas.remove
  }
}

let checkboxAllChannel = ref(false);
let checkedChannelToAdd = ref([]);
let tmpChannelList = ref({data: []});
let tmpChannelModel = ref([]);

watch(checkboxAllChannel, (after, before) => {
    if(after == true) {
        checkedChannelToAdd.value = [];
        for(let c of tmpChannelList.value.data) {
            checkedChannelToAdd.value.push(c.id);
        }
    }else if(after == false && checkedChannelToAdd.value.length == tmpChannelList.value.data.length) {
        checkedChannelToAdd.value = [];
    }
})

watch(checkedChannelToAdd,  (after, before) => {
    if(tmpChannelList.value.data.length > after.length){
        checkboxAllChannel.value = false
    }else if(tmpChannelList.value.data.length == after.length){
        checkboxAllChannel.value = true
    }
})

const createWebsite = async () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    await store
        .dispatch('createWebsite', model['_rawValue'])
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            isDisabled.value = false;
            store.dispatch("setSuccessNotification", res.message);
            router.push({name: 'Website'});
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const getChannelList = async (ev) => {
    ev.preventDefault();
    isChannelSet.value = 1;
    store
        .dispatch('getChannelList')
        .then((res) => {
            if(res.data.length)
                isChannelSet.value = 2;
            else
                isChannelSet.value = 3;

            tmpChannelList.value.data = res.data;
            checkedChannelToAdd.value = [];
        })
        .catch((err) => {
            isChannelSet.value = 0;
            openChannelList.value = false;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        });
    openChannelList.value = true;
}

const addChannel = () => {
    // validate checks
    if(!checkedChannelToAdd.value.length){
        return false;
    }

    isDisabled.value = true;
    // model.value.channel = [];
    // tmpChannelModel.value = [];

    for (let c of checkedChannelToAdd['_rawValue']) {
        for(let cid of tmpChannelList['_rawValue'].data) {
            if(c == cid.id) {
                model.value.channel.push(cid)
                tmpChannelModel.value.push(cid)
            }
        }
    }

    model.value.channel = model['_rawValue'].channel.filter((v,i,a)=>a.findIndex(v2=>(v2.id===v.id))===i); 
    tmpChannelModel.value = tmpChannelModel['_rawValue'].filter((v,i,a)=>a.findIndex(v2=>(v2.id===v.id))===i);
    openChannelList.value = false;
    isDisabled.value = false;
}

const removeChannel = (id) => {
    let filtered = model['_rawValue'].channel.filter(data => data.id != id)
    let tmpfiltered = tmpChannelModel['_rawValue'].filter(data => data.id != id)

    model.value.channel = [];
    tmpChannelModel.value = [];

    for (let f of filtered) {
        model.value.channel.push(f)
    }
    for (let f of tmpfiltered) {
        tmpChannelModel.value.push(f)
    }
}

const onLogoChoose = (ev) => {
    const file = ev.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        model.value.logo = reader.result;
        model.value.logoUrl = reader.result;
    }
    reader.readAsDataURL(file);
}

const onFaviconChoose = (ev) => {
    const file = ev.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        model.value.favicon = reader.result;
        model.value.faviconUrl = reader.result;
    }
    reader.readAsDataURL(file);
}
</script>

<style>

</style>