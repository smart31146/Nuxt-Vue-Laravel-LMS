<template>
<dl class="u-display--block u-width--100pct">
<dd class="u-width--fit-content u-margin-left--auto u-margin-right--auto u-margin-bottom--0_375rem">
<NuxtLink :to="`${props.mode}/curriculums/${props.curriculum_slug}`">
<img :src="props.curriculum_image !== null ? props.image_path+props.curriculum_image : props.no_image_path" class="u-text-align--center u-border__all--0_0625rem-brown u-border-radius--0_5rem">
</NuxtLink>
</dd>
<dt class="u-text-align--center">
<NuxtLink :to="`${props.mode}/curriculums/${props.curriculum_slug}`">
{{ props.curriculum_name }}
</NuxtLink>
</dt>
</dl>
</template>

<script setup lang="ts">
import type { CardCurriculum } from '@/types/index';

const props = defineProps<CardCurriculum>();

</script>