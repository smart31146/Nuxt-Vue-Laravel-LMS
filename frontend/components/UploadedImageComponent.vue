<template>
<p class="u-margin-bottom--0 u-position--relative u-width--fit-content">
<img :src="props.src">
<span class="u-position--absolute u-cursor--pointer u-font-size--1_5rem u-position__right--0 u-position__top--0 u-color--red u-display--none" @click="close" ref="icon_close"><i class="fa fa-circle-xmark"></i></span>
</p>
</template>

<script setup lang="ts">
const icon_close = ref(null);

interface Props
{
    src: string
}

const props = withDefaults(defineProps<Props>(),
{
    src: '',
});

const close = () =>
{

    emit('closeImage');

}

const init = () =>
{

    const intervalId = setInterval(() =>
    {

        if (props.src !== '')
        {

            icon_close.value.classList.remove('u-display--none');
            clearInterval(intervalId);

        }

    }, 1000);

}

init();

const emit = defineEmits<{
    (event: 'closeImage'): void;
}>();
</script>