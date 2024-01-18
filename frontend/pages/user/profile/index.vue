<template>
<Html>
<Head>
<Title>プロフィール情報</Title>
</Head>
</Html>

<section>
<h1 class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">ユーザー詳細</h1>

<dl class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">
<dt class="u-margin-bottom--0_375rem">ユーザー名</dt>
<dd class="u-margin-bottom--0_75rem">{{ user_name }}</dd>
<dt class="u-margin-bottom--0_375rem">E-Mail</dt>
<dd class="u-margin-bottom--0_75rem">{{ user_email }}</dd>
<dt class="u-margin-bottom--0_375rem">氏名</dt>
<dd class="u-margin-bottom--0_75rem">{{ sei }} {{ mei }}</dd>
<dt class="u-margin-bottom--0_375rem">カナ</dt>
<dd class="u-margin-bottom--0_75rem">{{ sei_kana }} {{ mei_kana }}</dd>
<dt class="u-margin-bottom--0_375rem">性別</dt>
<dd class="u-margin-bottom--0_75rem">{{ sex }}</dd>
<dt class="u-margin-bottom--0_375rem">電話番号</dt>
<dd class="u-margin-bottom--0_75rem">{{ tel }}</dd>
<dt class="u-margin-bottom--0_375rem">郵便番号</dt>
<dd class="u-margin-bottom--0_75rem">{{ zip }}</dd>
<dt class="u-margin-bottom--0_375rem">都道府県</dt>
<dd class="u-margin-bottom--0_75rem">{{ prefecture }}</dd>
<dt class="u-margin-bottom--0_375rem">住所（市区町村番地）</dt>
<dd class="u-margin-bottom--0_75rem">{{ address_01 }}</dd>
<dt class="u-margin-bottom--0_375rem">住所（マンション名号室）</dt>
<dd class="u-margin-bottom--0_75rem">{{ address_02 }}</dd>
<dt class="u-margin-bottom--0_375rem">会員ランク</dt>
<dd class="u-margin-bottom--0_75rem">{{ user_rank }}</dd>
<dt class="u-margin-bottom--0_375rem">ユーザータイプ</dt>
<dd class="u-margin-bottom--0_75rem">{{ user_type }}</dd>
</dl>

<p class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content"><NuxtLink to="/user/profile/edit" class="p-button p-button--green u-width--15rem">編集する</NuxtLink></p>
</section>
</template>

<script setup lang="ts">
import type { SelectOptionItems } from '@/types/index';
import { Prefecture, Sex, UserRank, UserType } from '@/types/const';

const user_email = ref<string | null>();
const user_name = ref<string | null>();
const sei = ref<string | null>();
const mei = ref<string | null>();
const sei_kana = ref<string | null>();
const mei_kana = ref<string | null>();
const sexData = ref(<SelectOptionItems | null>[]);
const tel = ref<string | null>();
const zip = ref<string | null>();
const prefectureOptions = ref(<SelectOptionItems | null>[]);
const address_01 = ref<string | null>();
const address_02 = ref<string | null>();
const userRankOptions = ref(<SelectOptionItems | null>[]);
const userTypeOptions = ref(<SelectOptionItems | null>[]);
const user_type = ref<string | null>();
const user_rank = ref<string | null>();
const prefecture = ref<string | null>();
const sex = ref<string | null>();

const { userInfo, initUser } = useAuth();

const init = async () =>
{

    await initUser();

    sexData.value = arrangeAsSelectOptions(Sex);
    prefectureOptions.value = arrangeAsSelectOptions(Prefecture);
    userRankOptions.value = arrangeAsSelectOptions(UserRank);
    userTypeOptions.value = arrangeAsSelectOptions(UserType);

    Sex.forEach((value, key) =>
    {

        if (key === userInfo.value['sex'])
        {

            sex.value = value;

        }

    });


    for (let i = 0; i < prefectureOptions.value?.length; i++)
    {

        if (prefectureOptions.value[i]['key'] === userInfo.value['prefecture'])
        {

            prefecture.value = prefectureOptions.value[i]['value'];

        }

    }

    for (let i = 0; i < userRankOptions.value?.length; i++)
    {

        if (userRankOptions.value[i]['key'] === userInfo.value['user_rank'].toString())
        {

            user_rank.value = userRankOptions.value[i]['value'];

        }

    }

    for (let i = 0; i < userTypeOptions.value?.length; i++)
    {

        if (userTypeOptions.value[i]['key'] === userInfo.value['user_type'].toString())
        {

            user_type.value = userTypeOptions.value[i]['value'];

        }

    }

    user_email.value = userInfo.value['user_email'];
    user_name.value = userInfo.value['user_name'];
    sei.value = userInfo.value['sei'];
    mei.value = userInfo.value['mei'];
    sei_kana.value = userInfo.value['sei_kana'];
    mei_kana.value = userInfo.value['mei_kana'];
    tel.value = userInfo.value['tel'];
    zip.value = userInfo.value['zip'];
    address_01.value = userInfo.value['address_01'];
    address_02.value = userInfo.value['address_02'];

}
init();

definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>