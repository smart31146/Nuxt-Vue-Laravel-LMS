<template>
<Html>
<Head>
<Title>プロフィール編集</Title>
</Head>
</Html>

<section>
<h1 class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">プロフィール編集</h1>
<p class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem"><span class="u-color--red">*</span>は必須入力</p>
<p class="u-width__min--95vw-48rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-color--red" ref="error_message"></p>

<form>
<dl class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">
<dt class="u-margin-bottom--0_375rem">ユーザー名<span class="u-color--red">*</span></dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" v-model="user_name" maxlength="100"></dd>
<dt class="u-margin-bottom--0_375rem">E-Mail<span class="u-color--red">*</span></dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" v-model="user_email" maxlength="255"></dd>
<dt class="u-margin-bottom--0_375rem">パスワード(必要な場合)</dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" v-model="password" maxlength="100"></dd>
<dt class="u-margin-bottom--0_375rem">氏名</dt>
<dd class="u-margin-bottom--0_75rem">姓: <input type="text" v-model="sei" maxlength="100"> 名: <input type="text" v-model="mei" maxlength="100"></dd>
<dt class="u-margin-bottom--0_375rem">カナ</dt>
<dd class="u-margin-bottom--0_75rem">姓カナ: <input type="text" v-model="sei_kana" maxlength="100"> 名カナ: <input type="text" v-model="mei_kana" maxlength="100"></dd>
<dt class="u-margin-bottom--0_375rem">性別</dt>
<dd class="u-margin-bottom--0_75rem">
<RadioButtonComponent
ref="sexRadio"
item_name="sex"
:data="sexData"
:defaultValue="sexValue"
:key="sexUpdate"
/>
</dd>
<dt class="u-margin-bottom--0_375rem">電話番号</dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" v-model="tel" maxlength="20"></dd>
<dt class="u-margin-bottom--0_375rem">郵便番号</dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" id="zip" v-model="zip" maxlength="8" @change="getAddress"></dd>
<dt class="u-margin-bottom--0_375rem">都道府県</dt>
<dd class="u-margin-bottom--0_75rem">
<SelectComponent
ref="prefectureSelect"
item_name="prefecture"
:defaultValue="PrefectureValue"
:data="prefectureOptions"
:key="prefectureUpdate"
/>
</dd>
<dt class="u-margin-bottom--0_375rem">住所（市区町村番地）</dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" id="address_01" v-model="address_01" maxlength="255"></dd>
<dt class="u-margin-bottom--0_375rem">住所（マンション名号室）</dt>
<dd class="u-margin-bottom--0_75rem"><input type="text" v-model="address_02" maxlength="255"></dd>
</dl>
<p class="u-margin-left--auto u-margin-right--auto u-margin-bottom--0_75rem u-width--fit-content"><button class="p-button p-button--green u-width--15rem" @click.prevent="update">更新</button></p>
</form>
</section>
</template>

<script setup lang="ts">
import type { SelectOptionItems, User } from '@/types/index';
import { Prefecture, Sex, UserRank, UserType } from '@/types/const';

const user_email = ref('');
const password = ref('');
const user_name = ref('');
const sei = ref('');
const mei = ref('');
const sei_kana = ref('');
const mei_kana = ref('');
const sexData = ref(<SelectOptionItems | null>[]);
const tel = ref('');
const zip = ref('');
const prefectureOptions = ref(<SelectOptionItems | null>[]);
const address_01 = ref('');
const address_02 = ref('');
const userRankOptions = ref(<SelectOptionItems | null>[]);
const userTypeOptions = ref(<SelectOptionItems | null>[]);
const sexRadio = ref(null);
const prefectureSelect = ref(null);
const userRankUpdate = ref(0);
const userTypeUpdate = ref(0);
const sexUpdate = ref(0);
const prefectureUpdate = ref(0);
const PrefectureValue = ref<number | string | Object | undefined>();
const UserRankValue = ref<number | string | Object | undefined>();
const UserTypeValue = ref<number | string | Object | undefined>();
const sexValue = ref<string | undefined>();
const error_message = ref<HTMLParagraphElement | null>(null);

const { userInfo, initUser } = useAuth();
const { storeUser, getAddressInfo } = user();

const getAddress = async () =>
{

    document.getElementById('zip').focus();

    const addressInfo = await getAddressInfo(zip.value, prefectureOptions.value);
    if (addressInfo.address !== '')
    {

        document.getElementById('address_01').focus();
        PrefectureValue.value = addressInfo.prefecture;
        address_01.value = addressInfo.address;
        prefectureUpdate.value++;

    }

}

const update = async () =>
{

    const fd: FormData = new FormData();
    fd.append('mode', 'update');
    fd.append('user_id', userInfo.value['user_id'].toString());
    fd.append('user_email', user_email.value);

    if (password.value !== '')
    {

        fd.append('password', password.value);
        fd.append('token', 1);

    }

    fd.append('user_name', user_name.value);
    fd.append('sei', sei.value);
    fd.append('mei', mei.value);
    fd.append('sei_kana', sei_kana.value);
    fd.append('mei_kana', mei_kana.value);
    fd.append('sex', sexRadio.value.getCheckedValue());
    fd.append('tel', tel.value);
    fd.append('zip', zip.value);

    if (prefectureSelect.value.getSelectedValue() !== undefined)
    {

        fd.append('prefecture', prefectureSelect.value.getSelectedValue()['key']);

    }
    fd.append('address_01', address_01.value);
    fd.append('address_02', address_02.value);

    error_message.value.innerHTML = await storeUser('update', fd, true);
    if (error_message.value.innerHTML)
    {

        window.scroll({ top: 0, behavior: 'smooth'});

    }
    else
    {

        userInfo.value = null;

    }

}

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

            sexValue.value = key;

        }

    });
    sexUpdate.value++;


    for (let i = 0; i < prefectureOptions.value?.length; i++)
    {

        if (userInfo.value['prefecture'])
        {

            if (prefectureOptions.value[i]['key'] === userInfo.value['prefecture'].toString())
            {

                PrefectureValue.value = prefectureOptions.value[i];

            }

        }

    }
    prefectureUpdate.value++;

    for (let i = 0; i < userRankOptions.value?.length; i++)
    {

        if (userRankOptions.value[i]['key'] === userInfo.value['user_rank'].toString())
        {

            UserRankValue.value = userRankOptions.value[i];

        }

    }
    userRankUpdate.value++;

    for (let i = 0; i < userTypeOptions.value?.length; i++)
    {

        if (userTypeOptions.value[i]['key'] === userInfo.value['user_type'].toString())
        {

            UserTypeValue.value = userTypeOptions.value[i];

        }

    }
    userTypeUpdate.value++;

    user_email.value = userInfo.value['user_email'];
    user_name.value = userInfo.value['user_name'];
    sei.value = userInfo.value['sei'];
    mei.value = userInfo.value['mei'];
    sei_kana.value = userInfo.value['sei_kana'];
    mei_kana.value = userInfo.value['mei_kana'];
    tel.value = userInfo.value['tel'];
    zip.value = userInfo.value['zip'];

}
init();

definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>