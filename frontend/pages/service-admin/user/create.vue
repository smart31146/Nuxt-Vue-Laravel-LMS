<template>
  <Html>
    <Head>
      <Title>ユーザー追加</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': globlaStore.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
        
          <li class="gnav-item">
            <NuxtLink to="/service-admin/categories/" class="gnav-link"
              >カテゴリ管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/curriculums/" class="gnav-link"
              >カリキュラム管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/user/" class="gnav-link"
              >ユーザー管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <NuxtLink to="/service-admin/account/" class="gnav-link"
              >管理者アカウント管理</NuxtLink
            >
          </li>
          <li class="gnav-item">
            <span @click.prevent="logout" class="gnav-link logout"
              >ログアウト</span
            >
          </li>
          
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="user table-page">
          <h1 class="sec-title user-title">ユーザー編集</h1>
          <p class="inner-text"><span>*</span>は必須入力</p>
          <form class="form user-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-name" class="label-name"
                      >ユーザー名<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="user_name"
                      maxlength="100"
                      class="input-block"
                      id="user-name"
                      name="user-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="email" class="label-name"
                      >E-mail<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="email"
                      v-model="user_email"
                      maxlength="255"
                      class="input-block"
                      id="email"
                      name="email"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="pass" class="label-name"
                      >パスワード<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="password"
                      maxlength="100"
                      class="input-block"
                      id="pass"
                      name="pass"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th class="label-name-th">氏名</th>
                  <td>
                    <div class="input-flex">
                      <label for="miyozi" class="label-name name-label"
                        >姓:</label
                      >
                      <input
                        type="text"
                        v-model="sei"
                        maxlength="100"
                        class="input-block"
                        id="miyozi"
                        name="miyozi"
                      />
                    </div>
                  </td>
                  <td>
                    <div class="input-flex">
                      <label for="namae" class="label-name name-label"
                        >名:</label
                      >
                      <input
                        type="text"
                        v-model="mei"
                        maxlength="100"
                        class="input-block"
                        id="namae"
                        name="namae"
                      />
                    </div>
                  </td>
                </tr>
                <tr class="input-box">
                  <th class="label-name-th">カナ</th>
                  <td>
                    <div class="input-flex">
                      <label for="miyozi-kana" class="label-name name-label"
                        >姓カナ:</label
                      >
                      <input
                        type="text"
                        v-model="sei_kana"
                        maxlength="100"
                        class="input-block"
                        id="miyozi-kana"
                        name="miyozi-kana"
                      />
                    </div>
                  </td>
                  <td>
                    <div class="input-flex">
                      <label for="namae-kana" class="label-name name-label"
                        >名カナ:</label
                      >
                      <input
                        type="text"
                        v-model="mei_kana"
                        maxlength="100"
                        class="input-block"
                        id="namae-kana"
                        name="namae-kana"
                      />
                    </div>
                  </td>
                </tr>
                <tr class="input-box radio">
                  <th class="label-name-th">性別</th>
                  <td>
                    <RadioButtonComponent
                      ref="sexRadio"
                      item_name="sex"
                      :data="sexData"
                      defaultValue=""
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="tel" class="label-name">電話番号</label>
                  </th>
                  <td>
                    <input
                      type="tel"
                      v-model="tel"
                      maxlength="20"
                      class="input-block"
                      id="tel"
                      name="tel"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="yuubin-bango" class="label-name"
                      >郵便番号</label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="zip"
                      maxlength="8"
                      @change="getAddress"
                      class="input-block"
                      id="yuubin-bango"
                      name="yuubin-bango"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="prefectures" class="label-name">都道府県</label>
                  </th>
                  <td>
                    <SelectComponent
                      ref="prefectureSelect"
                      item_name="prefecture"
                      :defaultValue="PrefectureValue"
                      :data="prefectureOptions"
                      :key="prefectureUpdate"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="address" class="label-name"
                      >住所（市区町村番地）</label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="address_01"
                      maxlength="255"
                      class="input-block"
                      id="address"
                      name="address"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="address-apartment" class="label-name"
                      >住所（マンション名号室）</label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="address_02"
                      maxlength="255"
                      class="input-block"
                      id="address-apartment"
                      name="address-apartment"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="rank" class="label-name"
                      >会員ランク<span>*</span></label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="userRankSelect"
                      item_name="user_rank"
                      :defaultValue="UserRankValue"
                      :data="userRankOptions"
                      :key="userRankUpdate"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="type" class="label-name"
                      >ユーザータイプ<span>*</span></label
                    >
                  </th>
                  <td class="last">
                    <SelectComponent
                      ref="userTypeSelect"
                      item_name="user_type"
                      :defaultValue="UserTypeValue"
                      :data="userTypeOptions"
                      :key="userTypeUpdate"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
            <button class="serch-btn btn" @click.prevent="store">作成</button>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { SelectOptionItems } from "@/types/index";
import { Prefecture, Sex, UserRank, UserType } from "@/types/const";
import globlaStore from "@/store";
const user_email = ref("");
const password = ref("");
const user_name = ref("");
const sei = ref("");
const mei = ref("");
const sei_kana = ref("");
const mei_kana = ref("");
const sexData = ref(<SelectOptionItems | null>[]);
const tel = ref("");
const zip = ref("");
const prefectureOptions = ref(<SelectOptionItems | null>[]);
const address_01 = ref("");
const address_02 = ref("");
const userRankOptions = ref(<SelectOptionItems | null>[]);
const userTypeOptions = ref(<SelectOptionItems | null>[]);
const sexRadio = ref(null);
const prefectureSelect = ref(null);
const userRankSelect = ref(null);
const userTypeSelect = ref(null);
const userRankUpdate = ref(0);
const userTypeUpdate = ref(0);
const prefectureUpdate = ref(0);
const UserRankValue = ref<number | string | Object | undefined>();
const UserTypeValue = ref<number | string | Object | undefined>();
const PrefectureValue = ref<number | string | Object | undefined>();
const error_message = ref<HTMLParagraphElement | null>(null);

const { storeUser, getAddressInfo } = user();

const getAddress = async () => {
  document.getElementById("zip").focus();

  const addressInfo = await getAddressInfo(zip.value, prefectureOptions.value);
  if (addressInfo.address !== "") {
    document.getElementById("address_01").focus();
    PrefectureValue.value = addressInfo.prefecture;
    address_01.value = addressInfo.address;
    prefectureUpdate.value++;
  }
};

const store = async () => {
  const fd: FormData = new FormData();
  fd.append("mode", "create");
  fd.append("user_email", user_email.value);
  fd.append("password", password.value);
  fd.append("user_name", user_name.value);
  fd.append("sei", sei.value);
  fd.append("mei", mei.value);
  fd.append("sei_kana", sei_kana.value);
  fd.append("mei_kana", mei_kana.value);
  fd.append("sex", sexRadio.value.getCheckedValue());
  fd.append("tel", tel.value);
  fd.append("zip", zip.value);
  if (prefectureSelect.value.getSelectedValue() !== undefined) {
    fd.append("prefecture", prefectureSelect.value.getSelectedValue()["key"]);
  }
  fd.append("address_01", address_01.value);
  fd.append("address_02", address_02.value);
  fd.append("user_rank", userRankSelect.value.getSelectedValue()["key"]);
  fd.append("user_type", userTypeSelect.value.getSelectedValue()["key"]);

  error_message.value.innerHTML = await storeUser("store", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};

const init = async () => {
  sexData.value = arrangeAsSelectOptions(Sex);
  prefectureOptions.value = arrangeAsSelectOptions(Prefecture);
  userRankOptions.value = arrangeAsSelectOptions(UserRank);
  userTypeOptions.value = arrangeAsSelectOptions(UserType);

  for (let i = 0; i < userRankOptions.value?.length; i++) {
    if (userRankOptions.value[i]["key"] === "2") {
      UserRankValue.value = userRankOptions.value[i];
    }
  }
  userRankUpdate.value++;

  for (let i = 0; i < userTypeOptions.value?.length; i++) {
    if (userTypeOptions.value[i]["key"] === "1") {
      UserTypeValue.value = userTypeOptions.value[i];
    }
  }
  userTypeUpdate.value++;
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
