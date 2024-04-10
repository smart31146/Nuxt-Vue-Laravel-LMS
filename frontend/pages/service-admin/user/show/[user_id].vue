<template>
  <Html>
    <Head>
      <Title>ユーザー詳細</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
            <NuxtLink to="/service-admin/user" class="gnav-link"
              >ユーザー管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="user table-page">
          <h1 class="result sec-title user-title">ユーザー詳細</h1>
          <form class="form user-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label class="label-name">ユーザー名</label>
                  </th>
                  <td>
                    {{ user_name }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label class="label-name">E-mail</label>
                  </th>
                  <td>
                    {{ user_email }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th class="label-name-th">氏名</th>
                  <td>{{ sei }} {{ mei }}</td>
                </tr>
                <tr class="input-box">
                  <th class="label-name-th">カナ</th>
                  <td>{{ sei_kana }} {{ mei_kana }}</td>
                </tr>
                <tr class="input-box radio">
                  <th class="label-name-th">性別</th>
                  <td>
                    {{ sex }}
                  </td>
                </tr>
                <tr class="input-box">
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
                <tr v-if="address_01 !== undefined" class="input-box">
                  <th v-if="address_01 !== undefined">
                    <label
                      v-if="address_01 !== undefined"
                      for="address"
                      class="label-name"
                      >住所（市区町村番地）</label
                    >
                  </th>
                  <td style="height: 45px" v-if="address_01 !== undefined">
                    {{ address_01 }}
                  </td>
                </tr>
                <tr v-if="address_02 !== undefined" class="input-box">
                  <th>
                    <label class="label-name"
                      >住所（マンション名号室）</label
                    >
                  </th>
                  <td style="height: 45px">
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
                  <td class="last">
                    {{ user_type }}
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { SelectOptionItems, User } from "@/types/index";
import { Prefecture, Sex, UserRank, UserType } from "@/types/const";
import store from "@/store";
const user_data = ref<User | null>();
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
const PrefectureValue = ref<number | string | Object | undefined>();
const user_type = ref<string | null>();
const user_rank = ref<string | null>();
const prefecture = ref<string | null>();
const sex = ref<string | null>();
const sex_label = ref("");
const route = useRoute();

const { getOneUserData } = user();

const init = async () => {
  const fd: FormData = new FormData();
  fd.append("user_id", route.params.user_id.toString());
  user_data.value = await getOneUserData(fd);

  if (!user_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  sexData.value = arrangeAsSelectOptions(Sex);
  prefectureOptions.value = arrangeAsSelectOptions(Prefecture);
  userRankOptions.value = arrangeAsSelectOptions(UserRank);
  userTypeOptions.value = arrangeAsSelectOptions(UserType);

  Sex.forEach((value, key) => {
    if (key === user_data.value["sex"]) {
      sex.value = value;
    }
  });

  for (let i = 0; i < prefectureOptions.value?.length; i++) {
    if (prefectureOptions.value[i]["key"] === user_data.value["prefecture"]) {
      prefecture.value = prefectureOptions.value[i]["value"];
    }
  }

  for (let i = 0; i < userRankOptions.value?.length; i++) {
    if (
      userRankOptions.value[i]["key"] ===
      user_data.value["user_rank"].toString()
    ) {
      user_rank.value = userRankOptions.value[i]["value"];
    }
  }

  for (let i = 0; i < userTypeOptions.value?.length; i++) {
    if (
      userTypeOptions.value[i]["key"] ===
      user_data.value["user_type"].toString()
    ) {
      user_type.value = userTypeOptions.value[i]["value"];
    }
  }

  user_email.value = user_data.value["user_email"];
  user_name.value = user_data.value["user_name"];
  sei.value = user_data.value["sei"];
  mei.value = user_data.value["mei"];
  sei_kana.value = user_data.value["sei_kana"];
  mei_kana.value = user_data.value["mei_kana"];
  tel.value = user_data.value["tel"];
  zip.value = user_data.value["zip"];
  address_01.value = user_data.value["address_01"];
  address_02.value = user_data.value["address_02"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
