<template>
    <div>
        <page-component title="Channels">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <slot name="header"></slot>
                </div>
                <div class="border-t border-gray-200">
                    <slot></slot>
                </div>
            </div>
        </page-component>
    </div>
</template>

<script setup>
import PageComponent from './PageComponent.vue'
</script>

<style>

</style>