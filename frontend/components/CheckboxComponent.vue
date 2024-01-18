<template>
<ul class="u-width--fit-content u-display--flex u-flex__gap--1rem">
<li v-for="(item, i) in props.data" :key="i">
<label class="u-cursor--pointer"><input type="checkbox" :value="item.key" v-model="checkbox_item" @change="notifyChanging">{{ item.value }}</label>
</li>
</ul>
</template>

<script setup lang="ts">
import type { CheckboxComponent } from '@/types/index';

const checkbox_item = ref<Array<string> | undefined>([]);

const props = withDefaults(defineProps<CheckboxComponent>(),
{
    item_name: '',
    defaultValue: () => [],
    data: () => [],
});

const getCheckedValue = (): Array<String> | undefined =>
{
    return checkbox_item.value;
}

const notifyChanging = (): void =>
{

    emit('notifyChanging', props.item_name, checkbox_item.value);

}

const init = () =>
{

    checkbox_item.value = props.defaultValue;

}

init();

const setCheckedValue = (value: Array<string> | undefined) =>
{

    checkbox_item.value = value;

}

const emit = defineEmits<{
    (event: 'notifyChanging', item_name: string, key: Array<string> | undefined): void;
}>();

defineExpose(
{
    getCheckedValue,
    setCheckedValue
});
</script>