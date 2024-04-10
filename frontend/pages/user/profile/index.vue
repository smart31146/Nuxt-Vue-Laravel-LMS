<template>
<Html>
<Head>
<Title>プロフィール情報</Title>
</Head>
</Html>

<section>
    
      <div class="m-auto mt-32">
        <div class="inner">
          <section class="category table-page">
            <h1 class="result sec-title curriculum-title">ユーザー詳細</h1>
            <form class="form curriculum-form">
              <table class="form-table">
                <tbody class="form-tbody">
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >ユーザー名</label
                      >
                    </th>
                    <td>
                        {{ user_name }}
                    </td>
                  </tr>
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >E-Mail</label
                      >
                    </th>
                    <td>
                        {{ user_email }}
                    </td>
                  </tr>
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >氏名</label
                      >
                    </th>
                    <td>
                        {{ sei }} {{ mei }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">カナ</label>
                    </th>
                    <td>
                        {{ sei_kana }} {{ mei_kana }}
                    </td>
                  </tr>
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >性別</label
                      >
                    </th>
                    <td>
                        {{ sex }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">電話番号</label>
                    </th>
                    <td>
                        {{ tel }}
                    </td>
                  </tr>
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >郵便番号</label
                      >
                    </th>
                    <td>
                        {{ zip }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">都道府県</label>
                    </th>
                    <td>
                        {{ prefecture }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">住所（市区町村番地）</label>
                    </th>
                    <td>
                        {{ address_01 }}
                    </td>
                  </tr>
                  <tr class="input-box">
                    <th>
                      <label class="label-name"
                        >住所（マンション名号室）</label
                      >
                    </th>
                    <td>
                        {{ address_02 }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">会員ランク</label>
                    </th>
                    <td>
                        {{ user_rank }}
                    </td>
                  </tr>
                  <tr class="select-box">
                    <th>
                      <label class="label-name">ユーザータイプ</label>
                    </th>
                    <td>
                        {{ user_type}}
                    </td>
                  </tr>
                </tbody>
              </table>
              <button class="serch-btn btn"><NuxtLink to="/user/profile/edit">編集する</NuxtLink></button>
            </form>
          </section>
        </div>
      </div>
</section>
</template>

<script setup lang="ts">
import type { SelectOptionItems } from '@/types/index';
import { Prefecture, Sex, UserRank, UserType } from '@/types/const';
import store from "@/store";
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