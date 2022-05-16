<template>
    <div>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h4 class="text-2xl font-bold text-gray-900">
                    {{ title }}
                </h4>
            </div>
        </header>
        <main class="bg-gray-100">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-6 sm:px-0">
                    <slot></slot>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
</template>

<script setup>
    const props = defineProps({
        title: String,
    });
</script>

<style>

</style>