<template>
<ul class="u-width--fit-content u-display--flex u-flex__gap--1rem">
<li v-for="(item, i) in props.data" :key="i">
<label class="u-cursor--pointer"><input type="radio" :value="item.key" v-model="radio_item" @change="notifyChanging">{{ item.value }}</label>
</li>
</ul>
</template>

<script setup lang="ts">
import type { RadioButtonComponent } from '@/types/index';

const radio_item = ref();

const props = withDefaults(defineProps<RadioButtonComponent>(),
{
    item_name: '',
    defaultValue: '',
    data: () => [],
});

const getCheckedValue = (): string[] | undefined =>
{
    return radio_item.value;
}

const notifyChanging = (): void =>
{

    emit('notifyChanging', props.item_name, radio_item.value);

}

const init = () =>
{

    radio_item.value = props.defaultValue;

}

init();

const setCheckedValue = (value: string | undefined) =>
{

    radio_item.value = value;

}

const emit = defineEmits<{
    (event: 'notifyChanging', item_name: string, key: string): void;
}>();

defineExpose(
{
    getCheckedValue,
    setCheckedValue
});
</script>