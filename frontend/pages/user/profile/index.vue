<template>
<Html>
<Head>
<Title>プロフィール情報</Title>
</Head>
</Html>

<section>
    
      <div class="m-auto mt-32">
        <div class="inner">
          <section class="category table-page m-auto pt-8">
            <h1 class="result sec-title curriculum-title">ユーザー詳細</h1>
            <form class="mt-34 mb-24 px-8 py-12 bg-white m-auto">
              <table class="w-full text-2xl border-2 bg-white">
                <tbody class="w-full">
                  <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                       ユーザー名
                      
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ user_name }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                     E-Mail                     
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ user_email }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      氏名
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ sei }} {{ mei }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      カナ
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ sei_kana }} {{ mei_kana }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      性別
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ sex }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      電話番号
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ tel }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      郵便番号
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ zip }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      都道府県
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ prefecture }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      住所（市区町村番地）
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ address_01 }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                     住所（マンション名号室）
                 
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ address_02 }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      会員ランク
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ user_rank }}
                    </td>
                  </tr>
                   <tr class="grid grid-cols-1 md:grid-cols-2 items-center">
                    <th class="bg-[#eff4f9] px-3 py-1 border h-[35px]">
                      ユーザータイプ
                    </th>
                    <td class="px-3 py-1 border h-[35px]">
                        {{ user_type}}
                    </td>
                  </tr>
                </tbody>
              </table>
              <button class="serch-btn btn w-full flex justify-center items-center mt-4"><NuxtLink to="/user/profile/edit">編集する</NuxtLink></button>
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