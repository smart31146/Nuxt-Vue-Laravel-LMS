<template>

<Player class="custom-player"
:controls="props.is_seeker"
:currentTime="props.startFrame"
@vmCurrentTimeChange="timeChange"
@vmPlaybackEnded="ended"
@vmDurationChange="durationChange"
>
<Youtube class="custom-player"
:videoId="props.url"
/>
<Ui v-if="!props.is_seeker">
<ClickToPlay />
</Ui>
</Player>
</template>

<script setup lang="ts">
import type { MediaMeta } from '@/types/index';
import { Player, Youtube, Ui, ClickToPlay } from '@vime/vue-next';

const keepTime = ref(0);
const is_once_completed = ref(false);
const total_curriculum_second = ref(0);

const props = withDefaults(defineProps<MediaMeta>(),
{
    url: '',
    startFrame: 0,
    is_seeker: false,
});

const timeChange = (time: number) =>
{

    keepTime.value = Math.floor(time);

}

const ended = () =>
{

    if (!is_once_completed.value)
    {

        emit('sendProgress', true, keepTime.value, total_curriculum_second.value);
        is_once_completed.value = true;

    }

}

const durationChange = (second: number) =>
{

    total_curriculum_second.value = second;

}

const init = () =>
{

    is_once_completed.value = false;

    setInterval(() =>
    {

        if (!is_once_completed.value)
        {

            emit('sendProgress', false, keepTime.value, total_curriculum_second.value);

        }

    }, 3000);

}

init();


const emit = defineEmits<{
    (event: 'sendProgress', is_completed: boolean, currentTime: number, total_curriculum_second: number): void;
}>();

</script>