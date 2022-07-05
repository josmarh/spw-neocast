<template>
  
</template>

<script setup>
import store from '../store';
import { computed, watch, onMounted } from 'vue';

const props = defineProps({
    can: String,
});

watch(props.can, (newVal, oldVal) => {
    validatePermission(newVal);
})

const userPermissions = computed(() => store.state.user.permissions);

const validatePermission = (name) => {
    let permissions = userPermissions.value;

    if(permissions.split(',').length) {
        if(permissions.includes(name)) {
            return true;
        }else{
            return false;
        }
    }else {
        return false;
    }
}

onMounted(() => {
    validatePermission(props.can);
});
</script>

<style>

</style>