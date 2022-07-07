<template>
    <div>
        <!-- {{JSON.parse(JSON.stringify(data))}} -->
    </div>
</template>

<script setup>
import store from '../../store';
import { useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';

const route = useRoute();
const data = ref({});

const getRoku = () => {
    store
        .dispatch('rokuChannel', route.params.str)
        .then((res) => {
            data.value = res;
        })
        .catch((err) => {
            console.log(err);
        })
}

onMounted(() => {
    getRoku();
})
</script>

<style>

</style>