export const WeekDay = [
    '日','月','火','水','木','金','土'
];

export const Prefecture = new Map(
[
    ['01', '北海道'],
    ['02', '青森県'],
    ['03', '岩手県'],
    ['04', '宮城県'],
    ['05', '秋田県'],
    ['06', '山形県'],
    ['07', '福島県'],
    ['08', '茨城県'],
    ['09', '栃木県'],
    ['10', '群馬県'],
    ['11', '埼玉県'],
    ['12', '千葉県'],
    ['13', '東京都'],
    ['14', '神奈川県'],
    ['15', '新潟県'],
    ['16', '富山県'],
    ['17', '石川県'],
    ['18', '福井県'],
    ['19', '山梨県'],
    ['20', '長野県'],
    ['21', '岐阜県'],
    ['22', '静岡県'],
    ['23', '愛知県'],
    ['24', '三重県'],
    ['25', '滋賀県'],
    ['26', '京都府'],
    ['27', '大阪府'],
    ['28', '兵庫県'],
    ['29', '奈良県'],
    ['30', '和歌山県'],
    ['31', '鳥取県'],
    ['32', '島根県'],
    ['33', '岡山県'],
    ['34', '広島県'],
    ['35', '山口県'],
    ['36', '徳島県'],
    ['37', '香川県'],
    ['38', '愛媛県'],
    ['39', '高知県'],
    ['40', '福岡県'],
    ['41', '佐賀県'],
    ['42', '長崎県'],
    ['43', '熊本県'],
    ['44', '大分県'],
    ['45', '宮崎県'],
    ['46', '鹿児島県'],
    ['47', '沖縄県'],
]);

export const CategoryLevels = new Map(
[
    ['P', '大カテゴリ'],
    ['C', '小カテゴリ'],
]);

export const CategoryLevelsParentOnly = new Map(
[
    ['P', '大カテゴリ']
]);

export const CategoryStatus = new Map(
[
    ['A', '有効'],
    ['D', '無効'],
]);

export const ReleaseType = new Map(
[
    ['1', '無期限'],
    ['2', '期間限定公開'],
]);

export const CurriculumType = new Map(
[
    ['1', '動画講義'],
    ['2', '音声講義'],
    ['3', 'カスタム講義'],
]);

export const FileType = new Map(
[
    ['pdf', '.pdf'],
    ['audio', 'audio/*'],
    ['image', 'image/*'],
]);

export const RequiredType = new Map(
[
    ['0', '任意'],
    ['1', '必修'],
]);

export const CurriculumStatus = new Map(
[
    ['A', '有効'],
    ['D', '無効'],
]);

export const UserStatus = new Map(
[
    ['A', '有効'],
    ['D', '無効'],
]);

export const Sex = new Map(
[
    ['M', '男性'],
    ['F', '女性'],
    ['U', '不明'],
]);

export const UserRank = new Map(
[
    ['1', 'ランク1'],
    ['2', 'ランク2'],
    ['3', 'ランク3'],
    ['4', 'ランク4'],
    ['5', 'ランク5'],
]);

export const RankEveryOne = new Map(
[
    ['0', '誰でも可能'],
]);

export const AuthorityRank = new Map([...RankEveryOne, ...UserRank]);

export const UserType = new Map(
[
    ['1', 'タイプ1'],
    ['2', 'タイプ2'],
    ['3', 'タイプ3'],
    ['4', 'タイプ4'],
    ['5', 'タイプ5'],
]);

export const TakingCurriculumStatus = new Map(
[
    ['N', '途中'],
    ['F', '終了'],
]);

export const AdminType = new Map(
[
    ['0', '管理者'],
    ['1', 'ユーザー'],
]);

export const AdminStatus = new Map(
[
    ['A', '有効'],
    ['D', '無効'],
]);