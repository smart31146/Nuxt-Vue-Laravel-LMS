<template>
  <Html>
    <Head>
      <Title>カリキュラム追加</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ is_open: globlaStore.state.stateIsMenuOpen }">
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
        <section class="category table-page">
          <h1 class="sec-title curriculum-title">カリキュラム追加</h1>
          <p class="inner-text"><span>*</span>は必須入力</p>
          <form class="form curriculum-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-curriculum-name" class="label-name"
                      >管理者用カリキュラム名<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="curriculum_name_admin"
                      class="input-block"
                      id="user-curriculum-name"
                      name="cuser-curriculum-name"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="curriculum-name" class="label-name"
                      >カリキュラム名<span>*</span></label
                    >
                  </th>
                  <td>
                    <input
                      type="text"
                      v-model="curriculum_name"
                      class="input-block"
                      id="curriculum-name"
                      name="curriculum-name"
                    />
                  </td>
                </tr>
                <tr class="input-box curriculum-img">
                  <th>カリキュラム画像</th>
                  <td>
                    <FileInputComponent
                      ref="curriculum_image"
                      file_kind="image"
                    />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="category-type" class="label-name"
                      >カテゴリ名<span>*</span></label
                    >
                  </th>
                  <td>
                    <SelectComponent
                      ref="categorySelect"
                      item_name="category_id"
                      defaultValue=""
                      :data="categoryOptions"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">カリキュラム種別<span>*</span></th>
                  <td>
                    <RadioButtonComponent
                      ref="curriculumTypeRadio"
                      item_name="curriculum_type"
                      :data="curriculumTypeData"
                      defaultValue="1"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box curriculum-video">
                  <th v-if="is_movie_selected">動画URL<span>*</span></th>
                  <td class="vieo-td" v-if="is_movie_selected">
                    <input type="url" v-model="movie_url" maxlength="255" />
                  </td>
                  <th v-if="is_audio_file_selected">
                    音声ファイル<span>*</span>
                  </th>
                  <td class="vieo-td" v-if="is_audio_file_selected">
                    <FileInputComponent ref="audio_file" file_kind="audio" />
                  </td>
                </tr>
                <tr class="input-box file-block">
                  <th>PDFファイル</th>
                  <td class="file-area">
                    <ul>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file1 === undefined"
                      >
                        <FileInputComponent ref="pdf_file1" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file2 === undefined"
                      >
                        <FileInputComponent ref="pdf_file2" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file3 === undefined"
                      >
                        <FileInputComponent ref="pdf_file3" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file4 === undefined"
                      >
                        <FileInputComponent ref="pdf_file4" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file5 === undefined"
                      >
                        <FileInputComponent ref="pdf_file5" file_kind="pdf" />
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr class="input-box edit-box">
                  <th class="label-name-th">カリキュラム説明文</th>
                  <td class="edit-menu">
                    <div class="edit-menu-inner">
                      <TinyMCEComponent
                        ref="curriculum_text"
                        :data="curriculumTextData"
                        :init="{height: 500}"
                      />
                    </div>
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">閲覧権限ランク<span>*</span></th>
                  <td class="rank">
                    <CheckboxComponent
                      ref="authority_ranks"
                      item_name="authority_ranks"
                      :data="authorityRankData"
                      :defaultValue="[]"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">必修/任意<span>*</span></th>
                  <td>
                    <RadioButtonComponent
                      ref="is_required"
                      item_name="is_required"
                      :data="isRequiredData"
                      defaultValue="0"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">公開タイプ<span>*</span></th>
                  <td>
                    <RadioButtonComponent
                      ref="release_type"
                      item_name="release_type"
                      :data="ReleaseTypedData"
                      defaultValue="1"
                      @notifyChanging="notifyChanging"
                    />
                  </td>
                </tr>
                <tr class="input-box">
                  <th v-if="is_limited_type" class="label-name-th">
                    公開日時<span>*</span>
                  </th>
                  <td v-if="is_limited_type">
                    <input type="datetime-local" v-model="released_at" />
                  </td>
                </tr>
                <tr class="input-box">
                  <th v-if="is_limited_type" class="label-name-th">
                    終了日時<span>*</span>
                  </th>
                  <td v-if="is_limited_type">
                    <input type="datetime-local" v-model="closed_at" />
                  </td>
                </tr>
                <tr class="input-box date-box">
                  <th>
                    <label for="start-date" class="label-name"
                      >会員登録からの公開開始の日数と時間</label
                    >
                    <p class="start-date-text">
                      *時間設定を未設定する場合は未入力
                    </p>
                  </th>
                  <td>
                    <div class="date-block">
                      <input
                        type="number"
                        v-model="released_date_count"
                        min="0"
                        maxlength="3"
                        class="input-block"
                        id="start-date"
                        name="category-name"
                      />
                      <p>日後</p>
                      <input
                        type="time"
                        v-model="released_time"
                        class="input-block"
                        id="start-time"
                        name="time"
                      />
                    </div>
                  </td>
                </tr>
                <tr class="input-box date-box">
                  <th>
                    <label for="end-date" class="label-name"
                      >会員登録からの公開終了の日数と時間</label
                    >
                    <p class="end-date-text">
                      *時間設定を未設定する場合は未入力
                    </p>
                  </th>
                  <td class="last">
                    <div class="date-block">
                      <input
                        type="number"
                        v-model="closed_date_count"
                        class="input-block"
                        id="end-date"
                        name="category-name"
                      />
                      <p>日後</p>
                      <input
                        type="time"
                        v-model="closed_time"
                        class="input-block"
                        id="end-time"
                        name="time"
                      />
                    </div>
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
import {
  ReleaseType,
  CurriculumType,
  AuthorityRank,
  RequiredType,
} from "@/types/const";
import globlaStore from "@/store";
const curriculum_name_admin = ref("");
const curriculum_name = ref("");
const categoryOptions = ref(<SelectOptionItems | null>[]);
const curriculumTypeData = ref(<SelectOptionItems | null>[]);
const authorityRankData = ref(<SelectOptionItems | null>[]);
const isRequiredData = ref(<SelectOptionItems | null>[]);
const ReleaseTypedData = ref(<SelectOptionItems | null>[]);
const curriculum_image = ref(null);
const curriculum_text = ref(null);
const categorySelect = ref(null);
const movie_url = ref("");
const audio_file = ref(null);
const pdf_file1 = ref(null);
const pdf_file2 = ref(null);
const pdf_file3 = ref(null);
const pdf_file4 = ref(null);
const pdf_file5 = ref(null);
const is_movie_selected = ref(false);
const is_audio_file_selected = ref(false);
const released_at = ref("");
const closed_at = ref("");
const curriculumTypeRadio = ref(null);
const authority_ranks = ref(null);
const is_required = ref(null);
const release_type = ref(null);
const released_date_count = ref(0);
const released_time = ref("");
const closed_date_count = ref(0);
const closed_time = ref("");
const is_limited_type = ref(false);
const error_message = ref<HTMLParagraphElement | null>();
const { getActiveCategory } = category();
const { storeCurriculum } = curriculum();

const store = async () => {
  const fd: FormData = new FormData();
  fd.append("mode", "create");
  fd.append("curriculum_name_admin", curriculum_name_admin.value);
  fd.append("curriculum_name", curriculum_name.value);
  if (curriculum_image.value.getInputFile() !== null) {
    fd.append("curriculum_image", curriculum_image.value.getInputFile());
  }

  if (categorySelect.value !== null) {
    if (categorySelect.value.getSelectedValue()["key"] !== undefined) {
      fd.append("category_id", categorySelect.value.getSelectedValue()["key"]);
    }
  }
  fd.append("curriculum_type", curriculumTypeRadio.value.getCheckedValue());

  if (curriculumTypeRadio.value.getCheckedValue() === "1") {
    fd.append("movie_url", movie_url.value);
  }

  if (curriculumTypeRadio.value.getCheckedValue() === "2") {
    if (audio_file.value.getInputFile() !== null) {
      fd.append("audio_file", audio_file.value.getInputFile());
    }
  }

  if (pdf_file1.value.getInputFile() !== null) {
    fd.append("pdf_file1", pdf_file1.value.getInputFile());
  }

  if (pdf_file2.value.getInputFile() !== null) {
    fd.append("pdf_file2", pdf_file2.value.getInputFile());
  }

  if (pdf_file3.value.getInputFile() !== null) {
    fd.append("pdf_file3", pdf_file3.value.getInputFile());
  }

  if (pdf_file4.value.getInputFile() !== null) {
    fd.append("pdf_file4", pdf_file4.value.getInputFile());
  }

  if (pdf_file5.value.getInputFile() !== null) {
    fd.append("pdf_file5", pdf_file5.value.getInputFile());
  }

  fd.append("curriculum_text", curriculum_text.value.getTextAreaValue());
  fd.append("authority_ranks", authority_ranks.value.getCheckedValue());
  fd.append("is_required", is_required.value.getCheckedValue());
  fd.append("release_type", release_type.value.getCheckedValue());
  if (released_at.value !== null) {
    fd.append("released_at", released_at.value.replace("T", " "));
  }
  if (closed_at.value !== null) {
    fd.append("closed_at", closed_at.value.replace("T", " "));
  }

  if (released_date_count.value) {
    fd.append("released_date_count", released_date_count.value.toString());
  } else {
    fd.append("released_date_count", "0");
  }

  if (released_time.value) {
    fd.append("released_time", released_time.value);
  }

  if (closed_date_count.value) {
    fd.append("closed_date_count", closed_date_count.value.toString());
  } else {
    fd.append("closed_date_count", "0");
  }

  if (closed_time.value) {
    fd.append("closed_time", closed_time.value);
  }

  error_message.value.innerHTML = await storeCurriculum("store", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }
};

const notifyChanging = (
  item_name: string,
  key: string | Array<string> | undefined
) => {
  if (item_name === "curriculum_type") {
    is_movie_selected.value = false;
    is_audio_file_selected.value = false;

    if (key === "1") {
      is_movie_selected.value = true;
    }

    if (key === "2") {
      is_audio_file_selected.value = true;
    }
  }

  if (item_name === "release_type") {
    is_limited_type.value = false;

    if (key === "2") {
      is_limited_type.value = true;
    }
  }
};

const init = async () => {
  curriculumTypeData.value = arrangeAsSelectOptions(CurriculumType);
  authorityRankData.value = arrangeAsSelectOptions(AuthorityRank);
  isRequiredData.value = arrangeAsSelectOptions(RequiredType);
  ReleaseTypedData.value = arrangeAsSelectOptions(ReleaseType);

  categoryOptions.value = await getActiveCategory();

  is_movie_selected.value = true;
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
