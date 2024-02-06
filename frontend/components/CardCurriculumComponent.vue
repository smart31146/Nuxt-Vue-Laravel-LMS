<template>
<dl class="py-4 px-6 shadow-lg rounded-lg">
    <dd class="mb-8">
        <NuxtLink :to="`${props.mode}/curriculums/${props.curriculum_slug}`" class="block py-2">
            <img :src="props.curriculum_image !== null ? props.image_path+props.curriculum_image : props.no_image_path" class="curriculum-img mb-4 rounded-t-lg">
            <div class="text-xl font-bold mb-2">{{ props.curriculum_name }}</div>
            <div class="text-xs text-gray-500">{{ props.category_name }}</div>
        </NuxtLink>
    </dd>
</dl>
</template>

<script setup lang="ts">
import type { CardCurriculum } from '@/types/index';

const props = defineProps<CardCurriculum>();

</script>