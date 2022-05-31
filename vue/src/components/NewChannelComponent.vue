<template>
  <div>
    <page-component title="Channels">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create channel</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Get started in minutes.</p>
            </div>
            <div class="border-t border-gray-200">
                <div class="py-6 px-6">
                    <h3 class="flex items-center mb-1 text-md font-semibold text-gray-900 dark:text-white">
                        {{title}}
                    </h3>
                    <slot></slot>
                </div>
            </div>
        </div>
    </page-component>
  </div>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue'

const props = defineProps({
    title: String,
});

</script>