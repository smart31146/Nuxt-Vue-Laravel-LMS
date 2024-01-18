<template>
<div class="audio-player">
    <div class="timeline" ref="seeker" v-if="props.is_seeker">
        <div class="progress" ref="progress" v-if="props.is_seeker"></div>
    </div>
    <ul class="controls">
        <li class="play-container">
            <span class="toggle-play"><i class="fa fa-play" ref="playButton"></i></span>
        </li>
        <li class="time" ref="time">
            <div class="current" ref="current">0:00</div>
            <div class="divider" ref="divider">/</div>
            <div class="length" ref="frame"></div>
        </li>
        <li class="volume-container" ref="volume-container">
            <div class="volume-button" ref="volumeButton">
                <span class="volume"><i class="fa fa-volume-high" ref="volume"></i></span>
            </div>
            <div class="volume-slider" ref="volumeSlider">
                <div class="volume-percentage" ref="volumePercentage"></div>
            </div>
        </li>
    </ul>
</div>
</template>

<style scoped>
.audio-player {
    background: #444;
    box-shadow: 0 0 20px #000a;
    color: #fff;
    display: flex;
    flex-direction: column;
    font-family: arial;
    font-size: .75em;
    gap: 0.375rem;
    overflow: hidden;
    width: 18rem;
}
.timeline {
    background: #fff;
    box-shadow: 0 2px 10px #0008;
    cursor: pointer;
    height: 0.75rem;
    width: 100%;
}

.progress {
    background: coral;
    height: 100%;
    transition: .25s;
    width: 0;
}

.controls {
    display: inline-flex;
    justify-content: space-between;
    padding: 0 20px;
}

.controls > * {
    align-items: center;
    display: flex;
    justify-content: center;
}

.toggle-play {
    color: var(--white-color);
    cursor: pointer;
}

.time {
    color: var(--white-color);
    display: flex;
    gap: 0.25rem;
}

.volume-container {
    cursor: pointer;
    position: relative;
    z-index: 2;
}

.volume-button {
    align-items: center;
    display: flex;
    height: 26px;
}

.volume {
    color: var(--white-color);
}

.volume-slider {
    background: #fff;
    box-shadow: 0 0 20px #000a;
    height: 15px;
    left: -0.25rem;
    position: absolute;
    top: 0.25rem;
    transition: .25s;
    width: 0;
    z-index: -1;
}

.volume-percentage {
    background: coral;
    height: 100%;
    width: 75%;
}

</style>

<script setup lang="ts">
import type { MediaMeta } from '@/types/index';

const props = withDefaults(defineProps<MediaMeta>(),
{
    url: '',
    startFrame: 0,
    is_seeker: false,
});

const frame = ref<HTMLDivElement>();
const seeker = ref<HTMLDivElement>();
const volumeSlider = ref<HTMLDivElement>();
const volumePercentage = ref<HTMLDivElement>();
const progress = ref<HTMLDivElement>();
const current = ref<HTMLDivElement>();
const playButton = ref<HTMLDivElement>();
const volume = ref<HTMLDivElement>();
const volumeButton = ref<HTMLDivElement>();
const audio: HTMLAudioElement = new Audio(props.url);
let is_once_played = false;
let intervalId: any = null;

const initAudioPlayer = () =>
{

    if (props.startFrame > 0)
    {

        audio.currentTime = props.startFrame;

    }

    if (volumeSlider.value)
    {

        volumeSlider.value.addEventListener('click', (e: MouseEvent) =>
        {
            const sliderWidth = window.getComputedStyle(volumeSlider.value).width;
            const newVolume = e.offsetX / parseInt(sliderWidth);
            audio.volume = newVolume;
            volumePercentage.value.style.width = newVolume * 100 + '%';

            if (newVolume === 0)
            {

                volume.value.classList.remove('fa-volume-high');
                volume.value.classList.add('fa-volume-xmark');

            }
            else
            {

                volume.value.classList.remove('fa-volume-xmark');
                volume.value.classList.add('fa-volume-high');

            }

        }, false);

    }

    if (playButton.value)
    {

        playButton.value.addEventListener('click', () =>
        {

            if (audio.paused)
            {

                playButton.value.classList.remove('fa-play');
                playButton.value.classList.add('fa-pause');
                audio.play();
                is_once_played = true;

            }
            else
            {

                playButton.value.classList.remove('fa-pause');
                playButton.value.classList.add('fa-play');
                audio.pause();

            }

        }, false);

    }

    if (volumeButton.value)
    {

        volumeButton.value.addEventListener('click', () =>
        {

            audio.muted = !audio.muted;
            if (audio.muted)
            {

                volume.value.classList.remove('fa-volume-high');
                volume.value.classList.add('fa-volume-xmark');

            }
            else
            {

                volume.value.classList.remove('fa-volume-xmark');
                volume.value.classList.add('fa-volume-high');

            }

        });

    }

    if (frame.value)
    {

        frame.value.innerText = getTimeCodeFromNumber(audio.duration);
        audio.volume = 1;

    }

    if (seeker.value)
    {

        if (props.is_seeker)
        {

            seeker.value.addEventListener('click', (e) =>
            {

                const timelineWidth = window.getComputedStyle(seeker.value).width;
                const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
                audio.currentTime = timeToSeek;
            }, false);

        }

    }

}

const getTimeCodeFromNumber = (currentSeconds: number): string =>
{

    let ret: string = '';
    let floorSec = Math.floor(currentSeconds);
    let hours: number = Math.floor(floorSec / 3600);
    let minutes: number = Math.floor(floorSec % 3600 / 60);
    let seconds: number = floorSec % 60;

    if (hours === 0)
    {
        ret = `${String(minutes)}:${String(seconds % 60).padStart(2, '0')}`;
    }
    else
    {
        ret = `${String(hours).padStart(2, '0')}:${minutes}:${String(seconds).padStart(2, '0')}`;

    }

    return ret;

}


const startInterval = () =>
{

    let count = 0;
    let is_once_completed = false;
    intervalId = setInterval(() =>
    {

        if (props.is_seeker !== null)
        {

            if (progress.value !== undefined && progress.value != null)
            {

                progress.value.style.width = audio.currentTime / audio.duration * 100 + "%";

            }

        }

        if (current.value !== null && current.value?.textContent !== null)
        {

            current.value.textContent = getTimeCodeFromNumber(audio.currentTime);

        }

        if (count % 3 === 0 && !is_once_completed && is_once_played)
        {

            sendAudioFileState();

        }
        count++;

        if (audio.currentTime === audio.duration)
        {

            if (playButton.value != null)
            {

                playButton.value.classList.add('fa-play');
                playButton.value.classList.remove('fa-pause');

            }

            if (!is_once_completed)
            {

                sendAudioFileState();
                is_once_completed = true;

            }

        }

    }, 1000);

}

const stopInterval = () =>
{
    clearInterval(intervalId);
}

const init = () =>
{

    setTimeout(() =>
    {

        initAudioPlayer();

    }, 500);

    startInterval();

}

init();

onBeforeRouteLeave((to, from, next) =>
{
    stopInterval();
    audio.pause();
    next();
});

const sendAudioFileState = (): void  =>
{

    emit('sendProgress', audio.currentTime === audio.duration, Math.floor(audio.currentTime), Math.floor(audio.duration));

}

const emit = defineEmits<{
    (event: 'sendProgress', is_completed: boolean, currentTime: number, total_curriculum_second: number): void;
}>();

defineExpose(
{
    startInterval,
    stopInterval
});
</script>