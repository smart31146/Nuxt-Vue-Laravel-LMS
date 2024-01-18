<template>
  <Html>
    <Head>
      <Title>カリキュラム詳細</Title>
    </Head>
  </Html>

  <section>
    <div class="nav-area" :class="{ 'is_open': store.state.stateIsMenuOpen }">
      <nav class="gnav">
        <ul class="gnav-list">
          <li class="gnav-item">
            <NuxtLink to="/service-admin/curriculums" class="gnav-link"
              >カリキュラム管理に戻る</NuxtLink
            >
          </li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="inner">
        <section class="category table-page">
          <h1 class="result sec-title curriculum-title">カリキュラム詳細</h1>
          <form class="form curriculum-form">
            <table class="form-table">
              <tbody class="form-tbody">
                <tr class="input-box">
                  <th>
                    <label for="user-curriculum-slug" class="label-name"
                      >カリキュラムスラッグ</label
                    >
                  </th>
                  <td>
                    {{ curriculum_slug }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="user-curriculum-name" class="label-name"
                      >管理者用カリキュラム名</label
                    >
                  </th>
                  <td>
                    {{ curriculum_name_admin }}
                  </td>
                </tr>
                <tr class="input-box">
                  <th>
                    <label for="curriculum-name" class="label-name"
                      >カリキュラム名</label
                    >
                  </th>
                  <td>
                    {{ curriculum_name }}
                  </td>
                </tr>
                <tr
                  v-if="curriculum_image !== undefined"
                  class="input-box curriculum-img"
                >
                  <th>カリキュラム画像</th>
                  <td v-if="curriculum_image !== undefined">
                    <img :src="curriculum_image" />
                  </td>
                </tr>
                <tr class="select-box">
                  <th>
                    <label for="category-type" class="label-name"
                      >カテゴリ名</label
                    >
                  </th>
                  <td>
                    {{ category_name }}
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">カリキュラム種別</th>
                  <td>
                    {{ curriculum_type_label }}
                  </td>
                </tr>
                <tr class="input-box curriculum-video">
                  <th v-if="curriculum_type === '1'">動画URL</th>
                  <td v-if="movie_url !== undefined" class="vieo-td">
                    <MediaManagementComponent
                      media_kind="youtube"
                      :url="movie_url"
                      :is_member="false"
                      :is_completed="true"
                      v-if="movie_url !== undefined && is_youtube"
                    />
                    <MediaManagementComponent
                      media_kind="vimeo"
                      :url="movie_url"
                      :is_member="false"
                      :is_completed="true"
                      v-if="movie_url !== undefined && is_vimeo"
                    />
                  </td>
                  <th v-if="curriculum_type === '2'">音声ファイル</th>
                  <td class="vieo-td" v-if="curriculum_type === '2'">
                    <MediaManagementComponent
                      media_kind="audio_file"
                      :url="audio_file"
                      :is_member="false"
                      :is_completed="true"
                      v-if="audio_file !== undefined"
                    />
                  </td>
                </tr>
                <tr v-if="pdf_file" class="input-box file-block">
                  <th>PDFファイル</th>
                  <td class="file-area">
                    <ul>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="pdf_file1 !== undefined"
                      >
                        <NuxtLink
                          :to="pdf_file1"
                          target="_blank"
                          class="u-text-decoration--underline"
                          >別ウィンドウ表示</NuxtLink
                        >
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file2 === undefined"
                      >
                        <NuxtLink
                          :to="pdf_file2"
                          target="_blank"
                          class="u-text-decoration--underline"
                          >別ウィンドウ表示</NuxtLink
                        >
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file3 === undefined"
                      >
                        <NuxtLink
                          :to="pdf_file3"
                          target="_blank"
                          class="u-text-decoration--underline"
                          >別ウィンドウ表示</NuxtLink
                        >
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file4 === undefined"
                      >
                        <NuxtLink
                          :to="pdf_file4"
                          target="_blank"
                          class="u-text-decoration--underline"
                          >別ウィンドウ表示</NuxtLink
                        >
                      </li>
                      <li
                        class="u-margin-bottom--0_75rem"
                        v-if="current_pdf_file5 === undefined"
                      >
                        <NuxtLink
                          :to="pdf_file5"
                          target="_blank"
                          class="u-text-decoration--underline"
                          >別ウィンドウ表示</NuxtLink
                        >
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr
                  v-if="curriculum_text !== undefined"
                  class="input-box edit-box"
                >
                  <th class="label-name-th">カリキュラム説明文</th>
                  <td v-if="curriculum_text !== undefined" class="edit-menu">
                    <div
                      v-html="curriculum_text"
                      class="text-wrap edit-menu-inner"
                    ></div>
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">閲覧権限ランク</th>
                  <td class="rank">
                    {{ authority_ranks }}
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">必修/任意</th>
                  <td>
                    {{ is_required }}
                  </td>
                </tr>
                <tr class="input-box radio radio-option">
                  <th class="label-name-th">公開タイプ</th>
                  <td>
                    {{ release_type }}
                  </td>
                </tr>
                <tr v-if="is_limited_release" class="input-box">
                  <th v-if="is_limited_release" class="label-name-th">
                    公開日時
                  </th>
                  <td v-if="is_limited_release">
                    {{ released_at }}
                  </td>
                </tr>
                <tr v-if="is_limited_release" class="input-box">
                  <th v-if="is_limited_release" class="label-name-th">
                    終了日時
                  </th>
                  <td v-if="is_limited_release">
                    {{ closed_at }}
                  </td>
                </tr>
                <tr class="input-box date-box">
                  <th>
                    <label for="start-date" class="label-name"
                      >会員登録からの公開開始の日数と時間</label
                    >
                  </th>
                  <td>
                    <div class="date-block">
                      {{ released_date_count }}日後 {{ released_time }}
                    </div>
                  </td>
                </tr>
                <tr class="input-box date-box">
                  <th>
                    <label for="end-date" class="label-name"
                      >会員登録からの公開終了の日数と時間</label
                    >
                  </th>
                  <td class="last">
                    <div class="date-block">
                      {{ closed_date_count }}日後 {{ closed_time }}
                    </div>
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
const curriculum_slug = ref("");
const curriculum_name_admin = ref("");
const curriculum_name = ref("");
const categoryOptions = ref(<SelectOptionItems | null>[]);
const curriculum_image = ref<string | null>();
const curriculum_dir_path = ref<CurriculumDirPath>();
const category_name = ref<string | null>();
const movie_url = ref<string | undefined>();
const audio_file = ref<string | undefined>();
const pdf_file = ref(false);
const pdf_file1 = ref<string | undefined>();
const pdf_file2 = ref<string | undefined>();
const pdf_file3 = ref<string | undefined>();
const pdf_file4 = ref<string | undefined>();
const pdf_file5 = ref<string | undefined>();
const curriculum_text = ref<string | null>();
const curriculum_type = ref("");
const curriculum_type_label = ref("");
const is_youtube = ref(false);
const is_vimeo = ref(false);
const authority_ranks = ref("");
const is_required = ref("");
const release_type = ref("");
let released_at: any;
let closed_at: any;
const released_date_count = ref(0);
const closed_date_count = ref(0);
const released_time = ref<string | null>();
const closed_time = ref<string | null>();
const is_limited_release = ref(false);

const route = useRoute();
const { getActiveCategory } = category();
const {
  getCurriculumDirectoryPath,
  getYoutubeVideoId,
  getVimeoVideoId,
  getOneCurriculumData,
} = curriculum();

const setMovieURL = (
  item_name: string
): [string | null | undefined, boolean, boolean] => {
  let url: string | null | undefined = undefined;
  let is_youtube: boolean = false;
  let is_vimeo: boolean = false;

  if (curriculum_data.value[item_name]) {
    if (curriculum_data.value[item_name].includes("youtube.com")) {
      is_youtube = true;
      url = getYoutubeVideoId(curriculum_data.value[item_name]);
    }

    if (curriculum_data.value[item_name].includes("vimeo.com")) {
      is_vimeo = true;
      url = getVimeoVideoId(curriculum_data.value[item_name]);
    }
  }

  return [url, is_youtube, is_vimeo];
};

const init = async () => {
  const fd: FormData = new FormData();
  fd.append("curriculum_slug", route.params.curriculum_slug.toString());

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

  curriculum_slug.value = curriculum_data.value["curriculum_slug"];
  curriculum_name_admin.value = curriculum_data.value["curriculum_name_admin"];
  curriculum_name.value = curriculum_data.value["curriculum_name"];

  if (curriculum_data.value["curriculum_image"] !== null) {
    curriculum_image.value =
      curriculum_dir_path.value["image_path"] +
      curriculum_data.value["curriculum_image"];
  }

  for (let i = 0; i < categoryOptions.value?.length; i++) {
    if (
      parseInt(categoryOptions.value[i]["key"], 10) ===
      curriculum_data.value["category_id"]
    ) {
      category_name.value = categoryOptions.value[i]["value"];
    }
  }

  CurriculumType.forEach((value, key) => {
    if (key === curriculum_data.value["curriculum_type"].toString()) {
      curriculum_type.value = key;
      curriculum_type_label.value = value;

      if (curriculum_data.value["curriculum_type"].toString() === "1") {
        [movie_url.value, is_youtube.value, is_vimeo.value] =
          setMovieURL("movie_url");
      }

      if (curriculum_data.value["curriculum_type"].toString() === "2") {
        if (curriculum_data.value["audio_file"] !== null) {
          audio_file.value =
            curriculum_dir_path.value["audio_path"] +
            curriculum_data.value["audio_file"];
        }
      }
    }
  });

  if (curriculum_data.value["pdf_file1"] !== null) {
    pdf_file.value = true;
    pdf_file1.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file1"];
  }

  if (curriculum_data.value["pdf_file2"] !== null) {
    pdf_file.value = true;
    pdf_file2.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file2"];
  }

  if (curriculum_data.value["pdf_file3"] !== null) {
    pdf_file.value = true;
    pdf_file3.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file3"];
  }

  if (curriculum_data.value["pdf_file4"] !== null) {
    pdf_file.value = true;
    pdf_file4.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file4"];
  }

  if (curriculum_data.value["pdf_file5"] !== null) {
    pdf_file.value = true;
    pdf_file5.value =
      curriculum_dir_path.value["pdf_path"] +
      curriculum_data.value["pdf_file5"];
  }

  if (curriculum_data.value["curriculum_text"] !== null) {
    curriculum_text.value = curriculum_data.value["curriculum_text"];
  }

  let ranks: string[] = [];
  AuthorityRank.forEach((value, key) => {
    let rank_values = curriculum_data.value["authority_ranks"].split(",");
    for (let i = 0; i < rank_values.length; i++) {
      if (key === rank_values[i].toString()) {
        ranks.push(value);
      }
    }
  });

  authority_ranks.value = ranks.join("、");

  RequiredType.forEach((value, key) => {
    if (key === curriculum_data.value["is_required"].toString()) {
      is_required.value = value;
    }
  });

  ReleaseType.forEach((value, key) => {
    if (key === curriculum_data.value["release_type"].toString()) {
      release_type.value = value;

      if (key === "2") {
        is_limited_release.value = true;
        released_at = dateTimeFormat(curriculum_data.value["released_at"]);
        closed_at = dateTimeFormat(curriculum_data.value["closed_at"]);
      }
    }
  });

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
