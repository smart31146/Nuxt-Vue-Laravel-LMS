<template>
<input type="file" class="pdf-file" ref="fileInput" :accept="accept" @change="handleFileChange">
</template>

<script setup lang="ts">
import { FileType } from '@/types/const';

const fileInput = ref<HTMLInputElement | null>()
const file = ref<FileList | null | undefined>();
const accept = ref<string | undefined>();

interface Props
{
    file_kind: string
}

const props = withDefaults(defineProps<Props>(),
{
    file_kind: '',
});

const init = () =>
{

    accept.value = FileType.get(props.file_kind);

}

init();

const getInputFile = (): FileList | null | undefined =>
{
    return file.value !== null && file.value !== undefined ? file.value[0] : null;
}

const handleFileChange = () =>
{
    file.value = fileInput.value?.files
}

defineExpose(
{
    getInputFile
});
</script>