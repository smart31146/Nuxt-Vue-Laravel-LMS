<template>
    <VueMultiselect
    :model-value="selectedValue"
    :options="props.data"
    :searchable="false"
    :allow-empty="false"
    label="value"
    track-by="key"
    placeholder="選択"
    @update:model-value="updateSelected"
    />
    </template>
    <script setup lang="ts">
    import type { SelectComponent } from '@/types/index';
    import VueMultiselect from 'vue-multiselect';
    
    const selectedValue = ref<number | string | Object | undefined>();
    const props = defineProps<SelectComponent>();
    
    const getSelectedValue = (): string | number | Object | undefined =>
    {
        return selectedValue.value;
    }
    
    const updateSelected = (newValue: string): void =>
    {
    
        selectedValue.value = newValue;
        emit('notifyChanging', props.item_name, newValue['key']);
    
    }
    
    const init = () =>
    {
    
        selectedValue.value = props.defaultValue;
    
    }
    
    init();
    
    const setSelectedValue = (value: number | string | Object | undefined) =>
    {
    
        selectedValue.value = value;
    
    }
    
    const clearValue = () =>
    {
    
        selectedValue.value = [];
    
    }
    
    const emit = defineEmits<{
        (event: 'notifyChanging', item_name: string, key: string): void;
    }>();
    
    defineExpose(
    {
        clearValue,
        getSelectedValue,
        setSelectedValue
    });
    </script>
    
    <style src="vue-multiselect/dist/vue-multiselect.css"></style>
    <style>
    .multiselect__tags
    {
        border: 1px solid #ccc;
        min-height: auto;
        height: 40px;
    }
    
    .multiselect__element span, .multiselect__placeholder , .multiselect__single {
        color: #adadad !important;
    
    }
    </style>