<template>
  <Html>
    <Head>
      <Title>カリキュラム編集</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
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
          <li class="gnav-item">
            <NuxtLink to="/service-admin/curriculums" class="gnav-link"
              >カテゴリ管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="category table-page">
          <h1 class="sec-title curriculum-title">カリキュラム編集</h1>
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
                    <UploadedImageComponent
                      :src="current_curriculum_image"
                      @closeImage="closeImage"
                      v-if="is_current_curriculum_image"
                    />
                    <FileInputComponent
                      ref="curriculum_image"
                      file_kind="image"
                      v-if="!is_current_curriculum_image"
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
                      :defaultValue="categoryIdValue"
                      :data="categoryOptions"
                      @notifyChanging="notifyChanging"
                      :key="categoryUpdate"
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
                      :defaultValue="curriculumTypeValue"
                      @notifyChanging="notifyChanging"
                      :key="curriculumTypeUpdate"
                    />
                  </td>
                </tr>
                <tr class="input-box curriculum-video">
                  <th v-if="is_movie_selected">動画URL<span>*</span></th>
                  <td class="vieo-td" v-if="is_movie_selected">
                    <MediaManagementComponent
                      :url="current_movie_url"
                      media_kind="youtube"
                      :is_member="false"
                      :is_completed="true"
                      v-if="current_movie_url !== undefined && is_youtube"
                    />
                    <MediaManagementComponent
                      :url="current_movie_url"
                      media_kind="vimeo"
                      :is_member="false"
                      :is_completed="true"
                      v-if="current_movie_url !== undefined && is_vimeo"
                    />
                  </td>
                  <td class="vieo-td" v-if="is_movie_selected">
                    <input type="url" v-model="movie_url" maxlength="255" />
                  </td>
                  <th v-if="is_audio_file_selected">
                    音声ファイル<span>*</span>
                  </th>
                  <td
                    class="vieo-td"
                    v-if="
                      is_audio_file_selected && current_audio_file !== undefined
                    "
                  >
                    <ul
                      class="u-display--flex u-flex__align_items--center u-flex__gap--0_5rem"
                    >
                      <li>
                        <MediaManagementComponent
                          ref="media_audio"
                          :url="current_audio_file"
                          media_kind="audio_file"
                          :is_member="false"
                          :is_completed="true"
                          v-if="current_audio_file !== undefined"
                        />
                      </li>
                      <li>
                        <span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deleteAudioFile"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
                      </li>
                    </ul>
                  </td>
                  <td
                    class="vieo-td"
                    v-if="
                      is_audio_file_selected && current_audio_file === undefined
                    "
                  >
                    <FileInputComponent
                      ref="audio_file"
                      file_kind="audio"
                      :is_completed="true"
                    />
                  </td>
                </tr>
                <tr class="input-box file-block">
                  <th>PDFファイル</th>
                  <td class="file-area">
                    <ul>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file1 !== undefined"
                      >
                        <NuxtLink
                          :to="current_pdf_file1"
                          target="_blank"
                          class="u-text-decoration--underline u-margin-right--0_75rem"
                          >現在のPDFファイルを表示</NuxtLink
                        ><span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deletePdfFile(1)"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file1 === undefined"
                      >
                        <FileInputComponent ref="pdf_file1" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file2 !== undefined"
                      >
                        <NuxtLink
                          :to="current_pdf_file2"
                          target="_blank"
                          class="u-text-decoration--underline u-margin-right--0_75rem"
                          >現在のPDFファイルを表示</NuxtLink
                        ><span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deletePdfFile(2)"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file2 === undefined"
                      >
                        <FileInputComponent ref="pdf_file2" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file3 !== undefined"
                      >
                        <NuxtLink
                          :to="current_pdf_file3"
                          target="_blank"
                          class="u-text-decoration--underline u-margin-right--0_75rem"
                          >現在のPDFファイルを表示</NuxtLink
                        ><span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deletePdfFile(3)"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file3 === undefined"
                      >
                        <FileInputComponent ref="pdf_file3" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file4 !== undefined"
                      >
                        <NuxtLink
                          :to="current_pdf_file4"
                          target="_blank"
                          class="u-text-decoration--underline u-margin-right--0_75rem"
                          >現在のPDFファイルを表示</NuxtLink
                        ><span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deletePdfFile(4)"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file4 === undefined"
                      >
                        <FileInputComponent ref="pdf_file4" file_kind="pdf" />
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file5 !== undefined"
                      >
                        <NuxtLink
                          :to="current_pdf_file5"
                          target="_blank"
                          class="u-text-decoration--underline u-margin-right--0_75rem"
                          >現在のPDFファイルを表示</NuxtLink
                        ><span
                          class="u-cursor--pointer u-font-size--1_5rem"
                          @click="deletePdfFile(5)"
                          ><i class="fa fa-circle-xmark"></i
                        ></span>
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
                      :defaultValue="authorityRankValue"
                      @notifyChanging="notifyChanging"
                      :key="authorityRanksUpdate"
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
                      :defaultValue="isRequiredValue"
                      @notifyChanging="notifyChanging"
                      :key="isRequiredValue"
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
                      :defaultValue="ReleaseTypeValue"
                      @notifyChanging="notifyChanging"
                      :key="releaseTypeUpdate"
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
            <button class="serch-btn btn" @click.prevent="update">更新</button>
          </form>
        </section>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type {
  SelectOptionItems,
  CurriculumDirPath,
  Curriculum,
} from "@/types/index";
import {
  AuthorityRank,
  CurriculumType,
  RequiredType,
  ReleaseType,
} from "@/types/const";
import store from "@/store";
const curriculum_data = ref<Curriculum | null>();
const curriculum_name_admin = ref("");
const curriculum_name = ref("");
const categoryOptions = ref(<SelectOptionItems | null>[]);
const curriculumTypeData = ref(<SelectOptionItems | null>[]);
const authorityRankData = ref(<SelectOptionItems | null>[]);
const isRequiredData = ref(<SelectOptionItems | null>[]);
const ReleaseTypedData = ref(<SelectOptionItems | null>[]);
const current_curriculum_image = ref("");
const curriculum_image = ref(null);
const curriculum_text = ref(null);
const categorySelect = ref(null);
const movie_url = ref<string | null>();
const audio_file = ref(null);
const current_movie_url = ref<string | undefined>();
const current_audio_file = ref<string | undefined>();
const pdf_file1 = ref(null);
const current_pdf_file1 = ref<string | undefined>();
const pdf_file_change1 = ref(false);
const pdf_file2 = ref(null);
const current_pdf_file2 = ref<string | undefined>();
const pdf_file_change2 = ref(false);
const pdf_file3 = ref(null);
const current_pdf_file3 = ref<string | undefined>();
const pdf_file_change3 = ref(false);
const pdf_file4 = ref(null);
const current_pdf_file4 = ref<string | undefined>();
const pdf_file_change4 = ref(false);
const pdf_file5 = ref(null);
const current_pdf_file5 = ref<string | undefined>();
const pdf_file_change5 = ref(false);
const is_movie_selected = ref(false);
const is_audio_file_selected = ref(false);
const released_at = ref("");
const closed_at = ref("");
const curriculumTypeRadio = ref(null);
const authority_ranks = ref(null);
const is_required = ref(null);
const release_type = ref(null);
const released_date_count = ref(0);
const closed_date_count = ref(0);
const is_limited_type = ref(false);
const error_message = ref<HTMLParagraphElement | null>();
const curriculum_image_change = ref(false);
const audio_file_change = ref(false);
const is_current_curriculum_image = ref(true);
const categoryIdValue = ref<number | string | Object | undefined>();
const curriculum_dir_path = ref<CurriculumDirPath>();
const curriculumTypeValue = ref<string | undefined>();
const categoryUpdate = ref(0);
const curriculumTypeUpdate = ref(0);
const isRequiredUpdate = ref(0);
const releaseTypeUpdate = ref(0);
const authorityRanksUpdate = ref(0);
const curriculumTextData = ref("");
const isRequiredValue = ref<string | undefined>();
const ReleaseTypeValue = ref<string | undefined>();
const authorityRankValue = ref<Array<string>>();
const is_youtube = ref(false);
const is_vimeo = ref(false);
const released_time = ref<string | null>();
const closed_time = ref<string | null>();
const media_audio = ref(null);

const route = useRoute();
const { getActiveCategory } = category();
const {
  getCurriculumDirectoryPath,
  getYoutubeVideoId,
  getVimeoVideoId,
  storeCurriculum,
  getOneCurriculumData,
} = curriculum();

const update = async () => {
  const fd: FormData = new FormData();
  fd.append("mode", "update");
  fd.append("curriculum_slug", route.params.curriculum_slug);
  fd.append("curriculum_name_admin", curriculum_name_admin.value);
  fd.append("curriculum_name", curriculum_name.value);

  if (curriculum_image.value !== null) {
    if (curriculum_image.value.getInputFile() !== null) {
      fd.append("curriculum_image", curriculum_image.value.getInputFile());
    }
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
    if (audio_file.value !== null) {
      if (audio_file.value.getInputFile() !== null) {
        fd.append("audio_file", audio_file.value.getInputFile());
      }
    } else {
      fd.append("audio_file_keeping", "1");
    }
  }

  if (pdf_file1.value !== null) {
    if (pdf_file1.value.getInputFile() !== null) {
      fd.append("pdf_file1", pdf_file1.value.getInputFile());
    }
  }

  if (pdf_file2.value !== null) {
    if (pdf_file2.value.getInputFile() !== null) {
      fd.append("pdf_file2", pdf_file2.value.getInputFile());
    }
  }

  if (pdf_file3.value !== null) {
    if (pdf_file3.value.getInputFile() !== null) {
      fd.append("pdf_file3", pdf_file3.value.getInputFile());
    }
  }

  if (pdf_file4.value !== null) {
    if (pdf_file4.value.getInputFile() !== null) {
      fd.append("pdf_file4", pdf_file4.value.getInputFile());
    }
  }

  if (pdf_file5.value !== null) {
    if (pdf_file5.value.getInputFile() !== null) {
      fd.append("pdf_file5", pdf_file5.value.getInputFile());
    }
  }

  fd.append("curriculum_text", curriculum_text.value.getTextAreaValue());
  fd.append("authority_ranks", authority_ranks.value.getCheckedValue());
  fd.append("is_required", is_required.value.getCheckedValue());
  fd.append("release_type", release_type.value.getCheckedValue());
  if (release_type.value.getCheckedValue() === "2") {
    fd.append("released_at", released_at.value.replace("T", " "));
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

  if (curriculum_image_change.value) {
    fd.append("curriculum_image_change", "1");
  }

  if (audio_file_change.value) {
    fd.append("audio_file_change", "1");
  }

  if (pdf_file_change1.value) {
    fd.append("pdf_file_change1", "1");
  }

  if (pdf_file_change2.value) {
    fd.append("pdf_file_change2", "1");
  }

  if (pdf_file_change3.value) {
    fd.append("pdf_file_change3", "1");
  }

  if (pdf_file_change4.value) {
    fd.append("pdf_file_change4", "1");
  }

  if (pdf_file_change5.value) {
    fd.append("pdf_file_change5", "1");
  }

  error_message.value.innerHTML = await storeCurriculum("update", fd);
  if (error_message.value.innerHTML) {
    window.scroll({ top: 0, behavior: "smooth" });
  }

  if (media_audio.value !== null) {
    media_audio.value.stopInterval("audio_file");
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

      if (media_audio.value !== null) {
        media_audio.value.startInterval("audio_file");
      }
    }

    if (key !== "2") {
      if (media_audio.value !== null) {
        media_audio.value.stopInterval("audio_file");
      }
    }
  }

  if (item_name === "release_type") {
    is_limited_type.value = false;

    if (key === "2") {
      is_limited_type.value = true;
    }
  }
};

const closeImage = (): void => {
  is_current_curriculum_image.value = false;
  curriculum_image_change.value = true;
};

const deleteAudioFile = () => {
  current_audio_file.value = undefined;
  audio_file_change.value = true;
  media_audio.value.stopInterval("audio_file");
};

const deletePdfFile = (no: number) => {
  if (no === 1) {
    current_pdf_file1.value = undefined;
    pdf_file_change1.value = true;
  }

  if (no === 2) {
    current_pdf_file2.value = undefined;
    pdf_file_change2.value = true;
  }

  if (no === 3) {
    current_pdf_file3.value = undefined;
    pdf_file_change3.value = true;
  }

  if (no === 4) {
    current_pdf_file4.value = undefined;
    pdf_file_change4.value = true;
  }

  if (no === 5) {
    current_pdf_file5.value = undefined;
    pdf_file_change5.value = true;
  }
};

const init = async () => {
  curriculumTypeData.value = arrangeAsSelectOptions(CurriculumType);
  authorityRankData.value = arrangeAsSelectOptions(AuthorityRank);
  isRequiredData.value = arrangeAsSelectOptions(RequiredType);
  ReleaseTypedData.value = arrangeAsSelectOptions(ReleaseType);

  const fd: FormData = new FormData();
  fd.append("curriculum_slug", route.params.curriculum_slug);

  [categoryOptions.value, curriculum_data.value, curriculum_dir_path.value] =
    await Promise.all([
      getActiveCategory(),
      getOneCurriculumData(fd),
      getCurriculumDirectoryPath(),
    ]);

  if (!curriculum_data.value) {
    showError({
      statusCode: 404,
      message: "データが存在しません",
    });
  }

  curriculum_name_admin.value = curriculum_data.value["curriculum_name_admin"];
  curriculum_name.value = curriculum_data.value["curriculum_name"];

  if (curriculum_data.value["curriculum_image"] !== null) {
    current_curriculum_image.value =
      curriculum_dir_path.value["image_path"] +
      curriculum_data.value["curriculum_image"];
  } else {
    is_current_curriculum_image.value = false;
  }

  for (let i = 0; i < categoryOptions.value?.length; i++) {
    if (
      parseInt(categoryOptions.value[i]["key"], 10) ===
      curriculum_data.value["category_id"]
    ) {
      categoryIdValue.value = categoryOptions.value[i];
    }
  }
  categoryUpdate.value++;

  CurriculumType.forEach((value, key) => {
    if (key === curriculum_data.value["curriculum_type"].toString()) {
      curriculumTypeValue.value = key;

      if (curriculum_data.value["curriculum_type"].toString() === "1") {
        is_movie_selected.value = true;
        movie_url.value = curriculum_data.value["movie_url"];
        if (curriculum_data.value["movie_url"].includes("youtube.com")) {
          is_youtube.value = true;
          current_movie_url.value = getYoutubeVideoId(
            curriculum_data.value["movie_url"]
          );
        }

        if (curriculum_data.value["movie_url"].includes("vimeo.com")) {
          is_vimeo.value = true;
          current_movie_url.value = getVimeoVideoId(
            curriculum_data.value["movie_url"]
          );
        }
      }

      if (curriculum_data.value["curriculum_type"].toString() === "2") {
        is_audio_file_selected.value = true;
        current_audio_file.value =
          curriculum_dir_path.value["audio_path"] +
          curriculum_data.value["audio_file"];
      }
    }
  });
  curriculumTypeUpdate.value++;

  if (curriculum_data.value["pdf_file1"] !== null) {
    current_pdf_file1.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file1"];
  }

  if (curriculum_data.value["pdf_file2"] !== null) {
    current_pdf_file2.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file2"];
  }

  if (curriculum_data.value["pdf_file3"] !== null) {
    current_pdf_file3.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file3"];
  }

  if (curriculum_data.value["pdf_file4"] !== null) {
    current_pdf_file4.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file4"];
  }

  if (curriculum_data.value["pdf_file5"] !== null) {
    current_pdf_file5.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file5"];
  }

  if (curriculum_data.value["curriculum_text"] !== null) {
    curriculum_text.value.setTextAreaValue(
      curriculum_data.value["curriculum_text"]
    );
  }

  authorityRankValue.value =
    curriculum_data.value["authority_ranks"].split(",");
  authorityRanksUpdate.value++;

  RequiredType.forEach((value, key) => {
    if (key === curriculum_data.value["is_required"].toString()) {
      isRequiredValue.value = key;
    }
  });
  isRequiredUpdate.value++;

  ReleaseType.forEach((value, key) => {
    if (key === curriculum_data.value["release_type"].toString()) {
      ReleaseTypeValue.value = key;

      if (key === "2") {
        is_limited_type.value = true;
        released_at.value = curriculum_data.value["released_at"];
        closed_at.value = curriculum_data.value["closed_at"];
      }
    }
  });
  releaseTypeUpdate.value++;

  released_date_count.value = curriculum_data.value["released_date_count"];
  closed_date_count.value = curriculum_data.value["closed_date_count"];
  released_time.value = curriculum_data.value["released_time"];
  closed_time.value = curriculum_data.value["closed_time"];
};
init();

definePageMeta({
  layout: "admin-after-login",
  middleware: "admin",
});
</script>
