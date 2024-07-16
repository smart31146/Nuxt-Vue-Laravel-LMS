<template>
<dl class="py-4 px-6 shadow-lg rounded-lg">
    <dd class="relative mb-8">
        <NuxtLink :to="`${props.mode}/curriculums/${props.curriculum_slug}`" class="block py-2">
            <img :src="props.curriculum_image !== null ? props.image_path+props.curriculum_image : props.no_image_path" class="curriculum-img mb-4 rounded-t-lg aspect-12-9">
            <div class="text-xl font-bold mb-2">{{ props.curriculum_name }}</div>
            <div class="text-base text-gray-600 mb-4">{{ props.category_name }}</div>
            <span class="absolute right-0 px-4 py-2 text-base text-right bg-green-600 text-white" v-if="props.take_status=='N'">受講中</span>
            <span class="absolute right-0 px-4 py-2 text-base text-right bg-yellow-600 text-white" v-if="props.take_status=='F'">受講済</span>
            <span class="absolute right-0 px-4 py-2 text-base text-right bg-blue-600 text-white" v-if="props.take_status=='NOT'">未受講</span>
        </NuxtLink>
    </dd>
</dl>
</template>

<script setup lang="ts">
import type { CardCurriculum } from '@/types/index';

const props = defineProps<CardCurriculum>();
console.log("test props", props.category_name);
</script>