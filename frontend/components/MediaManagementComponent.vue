<template>
<AudioFileComponent
ref="audioFile"
:url="props.url"
:startFrame="props.startFrame"
:is_seeker="is_seeker"
v-if="media_kind === 'audio_file'"
@sendProgress="sendProgress"
:key="mediaUpdate"
/>
<YoutubeComponent
class="player video"
ref="youtube"
:url="props.url"
:startFrame="props.startFrame"
:is_seeker="is_seeker"
v-if="media_kind === 'youtube'"
@sendProgress="sendProgress"
:key="mediaUpdate"
/>
<VimeoComponent class="player video"
ref="vimeo"
:url="props.url"
:startFrame="props.startFrame"
:is_seeker="is_seeker"
v-if="media_kind === 'vimeo'"
@sendProgress="sendProgress"
:key="mediaUpdate"
/>
</template>

<script setup lang="ts">
import type { EmbedOptions } from '@/types/index';

const { takingCurriculum } = curriculum();

const is_seeker = ref(false);
const audioFile = ref(null);
const mediaUpdate = ref(0);

const props = withDefaults(defineProps<EmbedOptions>(),
{
    url: '',
    is_member: false,
    media_kind: '',
    user_id: 0,
    curriculum_slug: '',
    startFrame: 0,
    is_completed: false,
    content_id: '',
});

const sendProgress = async (is_play_completed: boolean, currentTime: number, total_curriculum_second: number): Promise<void> =>
{

    let status: string = 'N';
    if (is_play_completed)
    {

        status = 'F';

    }

    if (!props.is_completed && props.is_member)
    {

        const fd: FormData = new FormData;
        fd.append('curriculum_slug', props.curriculum_slug);
        fd.append('user_id', props.user_id.toString());
        fd.append('content_id', props.content_id);
        fd.append('second', currentTime.toString());
        fd.append('total_curriculum_second', total_curriculum_second.toString());
        fd.append('curriculum_slug', props.curriculum_slug);
        fd.append('status', status);
        await takingCurriculum(fd);

    }

}

const init = () =>
{

    if (!props.is_member ||
        (props.is_completed && props.is_member))
    {

        is_seeker.value = true;

    }

    mediaUpdate.value++;

}

init();

const stopInterval = (mode: string) =>
{

    if (mode === 'audio_file')
    {

        audioFile.value.stopInterval();

    }

}

const startInterval = (mode: string) =>
{

    if (mode === 'audio_file')
    {

        audioFile.value.startInterval();

    }

}

defineExpose(
{
    startInterval,
    stopInterval
});
</script>