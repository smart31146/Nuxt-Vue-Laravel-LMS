<template>
<Html>
<Head>
<Title>認定証</Title>
</Head>
</Html>

<section>
<div class="w-full p-12 m-auto flex flex-col justify-center items-center">
    <p class="mt-64 ml-8 mb-8 text-black text-3xl md:text-5xl tex-center" v-if="mode === 'cannot'">現在、修了証の申請はできません。</p>
    <p class="mt-64 ml-8 mb-8 text-black text-3xl md:text-5xl tex-center" v-if="mode === 'request'">修了証を申請する場合は、申請ボタンを押してください。</p>
    <p class="mt-64 ml-8 mb-8 text-black text-3xl md:text-5xl " v-if="mode === 'waiting'">現在、運営者で修了証の発行待ちです。</p>
    <p class="mt-64 ml-8 mb-8 text-black text-3xl md:text-5xl" v-if="mode === 'certified'">運営者から修了証が発行されました。</p>
    <p class="mt-12 ml-8 mb-8 text-black text-3xl md:text-5xl" v-if="mode === 'certified'">発行日: {{ certified_date }}</p>
</div>
<button v-if="mode === 'request'" class="flex justify-center items-center m-auto text-center text-white rounded-md w-[300px] text-3xl md:text-5xl p-4 bg-[#3b82f6] mb-8" @click="submit">修了証を申請する</button>

</section>
</template>

<script setup lang="ts">
import type { Certificate } from '@/types/index';

const { getCertificate, requestCertificate, getRequiredCurriculumStatus } = curriculum();

const certificate_data = ref<Certificate| null>();
const certified_date = ref('');
const mode = ref('');
const result = ref(false);
const { userInfo, initUser } = useAuth();

const submit = async () =>
{

    const fd: FormData = new FormData();
    fd.append('user_id', userInfo.value['user_id'].toString());

    await requestCertificate(fd);

}

const init = async () =>
{

    await initUser();
    const fd: FormData = new FormData();
    fd.append('user_id', userInfo.value['user_id'].toString());

    [certificate_data.value, result.value] = await Promise.all([
        getCertificate(fd),
        getRequiredCurriculumStatus(fd)
    ]);

    if (certificate_data.value)
    {

        if (certificate_data.value['status'] === 'R')
        {

            mode.value = 'waiting';

        }

        if (certificate_data.value['status'] === 'C')
        {

            mode.value = 'certified';
            certified_date.value = dateFormat(certificate_data.value['certified_date']).value;

        }

    }
    else
    {
     
        if (result.value)
        {

            mode.value = 'request';

        }
        else
        {

            mode.value = 'cannot';

        }

    }
     

}

init();

definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>