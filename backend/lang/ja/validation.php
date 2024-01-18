<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'accepted_if'          => ':otherが:valueの時、:attributeは承認してください。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:dateより次の日付にしてください。',
    'after_or_equal'       => ':attributeは:date以降の日付にしてください。',
    'alpha'                => ':attributeは英字のみにしてください。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num'            => ':attributeは英数字のみにしてください。',
    'array'                => ':attributeは配列にしてください。',
    'ascii'                => ':attributeは、半角の英数と特殊文字にしてください。',
    'before'               => ':attributeは:dateより前の日付にしてください。',
    'before_or_equal'      => ':attributeは:date以前の日付にしてください。',
    'between'              => [
        'numeric' => ':attributeは:min〜:maxまでにしてください。',
        'file'    => ':attributeは:min〜:max KBまでのファイルにしてください。',
        'string'  => ':attributeは:min〜:max文字にしてください。',
        'array'   => ':attributeは:min〜:max個までにしてください。',
    ],
    'boolean'              => ':attributeは、trueかfalseにしてください。',
    'can'                  => ':attributeには、認証されていない値が含まれています。',
    'confirmed'            => ':attributeは確認用項目と一致していません。',
    'current_password'     => 'パスワードが正しくありません。',
    'date'                 => ':attributeは正しい日付ではありません。',
    'date_equals'          => ':attributeは:dateと同じ日付にしてください。',
    'date_format'          => ':attributeは":format"書式と一致していません。',
    'decimal'              => ':attributeは小数点第 :decimal 位を入力してください。',
    'declined'             => ':attributeは少なくしてください。',
    'declined_if'          => ':otherが:valueの時、:attributeは少なくしてください。',
    'different'            => ':attributeは:otherと違うものにしてください。',
    'digits'               => ':attributeは:digits桁にしてください',
    'digits_between'       => ':attributeは:min〜:max桁にしてください。',
    'dimensions'           => ':attributeは正しくないイメージの大きさです。',
    'distinct'             => ':attributeフィールドは重複した値を持っています。',
    'doesnt_end_with'      => ':attributeは、「:values」の1つで終わらないでください。',
    'doesnt_start_with'    => ':attributeは、「:values」の1つで始まらないでください。',
    'email'                => ':attributeを正しいE-mailにしてください。',
    'ends_with'            => ':attributeは、「 :values」の1つで終わってください。',
    'enum'                 => '選択された:attributeは、正しくありません。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeはファイルである必要があります。',
    'filled'               => ':attributeは必須です。',
    'gt' => [
        'numeric' => ':attributeは:valueより大きくしてください。',
        'file' => ':attributeは:valueKBより大きくしてください。',
        'string' => ':attributeは:value文字より大きくしてください。',
        'array' => ':attributeは:value項目数より多くしてください。',
    ],
    'gte' => [
        'numeric' => ':attributeは:value以上にしてください。',
        'file' => ':attributeは:valueKB以上にしてください。',
        'string' => ':attributeは:value文字以上にしてください。',
        'array' => ':attributeは:value項目数以上にしてください。',
    ],
    'image'                => ':attributeは画像にしてください。',
    'in'                   => '入力された:attributeは正しくありません。',
    'in_array'             => ':attributeフィールドは:otherに存在しません。',
    'integer'              => ':attributeは整数にしてください。',
    'ip'                   => ':attributeを正しいIPアドレスにしてください。',
    'ipv4'                 => ':attributeを正しいIP4アドレスにしてください。',
    'ipv6'                 => ':attributeを正しいIP6アドレスにしてください。',
    'json'                 => ':attributeを正しいJSON文字列にしてください。',
    'lowercase'            => ':attributeは全て小文字にしてください。',
    'lt' => [
        'numeric' => ':attributeは:valueより小さくしてください。',
        'file' => ':attributeは:valueKBより小さくしてください。',
        'string' => ':attributeは:value文字より小さくしてください。',
        'array' => ':attributeは:value項目数より少なくしてください。',
    ],
    'lte' => [
        'numeric' => ':attributeは:value以下にしてください。',
        'file' => ':attributeは:valueKB以下にしてください。',
        'string' => ':attributeは:value文字以下にしてください。',
        'array' => ':attributeは:value項目数以下にしてください。',
    ],
    'mac_address' => ':attributeは正しいMACアドレスにしてください。',
    'max'                  => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。.',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'max_digits' => ':attributeは:max桁以上にしないでください。',
    'mimes'                => ':attributeは:values形式のファイルにしてください。',
    'mimetypes'            => ':attributeは:values形式のファイルにしてください。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。.',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'min_digits' => ':attributeは最低:min桁にしてください。',
    'missing' => ':attributeは未入力にしてください。',
    'missing_if' => ':otherが:valueの時、:attributeは未入力にしてください。',
    'missing_unless' => ':otherが:valueではない場合、:attributeは未入力にしてください。',
    'missing_with' => ':valuesが存在する時、:attributeは未入力にしてください。',
    'missing_with_all' => ':valuesが全て存在する時、:attributeは未入力にしてください。',
    'multiple_of' => ':attributeは複数の:valueにしてください。',
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式は正しくありません。',
    'numeric'              => ':attributeは数字にしてください。',
    'password' => [
        'letters' => ':attributeは、最低1文字を入力してください。',
        'mixed' => ':attributeは、大文字と小文字を各々、最低1文字は入力してください。',
        'numbers' => ':attributeは、最低1文字の数値を入力してください。',
        'symbols' => ':attributeは、最低1文字の特殊文字を入力してください。',
        'uncompromised' => '入力した:attributeは、情報漏洩の危険があります。違う:attributeを選択してください。',
    ],
    'present'              => ':attributeは存在している必要があります。',
    'prohibited' => ':attributeは入力できません。',
    'prohibited_if' => ':otherが:valueの時、:attributeは入力できません。',
    'prohibited_unless' => ':otherが:valueにはない場合、:attributeは入力できません。',
    'prohibits' => ':attributeは:otherが存在するために、入力できません。',
    'regex'                => ':attribute の書式が正しくありません。',
    'required'             => ':attribute は必須です。',
    'required_array_keys' => ':attributeは、:valuesの一覧を入力してください。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_if_accepted' => ':attributeは:otherが承認される時には必須です。',
    'required_unless'      => ':otherが:valuesにあるとき、:attributeフィールドは必須です',
    'required_with'        => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBにしてください。.',
        'string'  => ':attribute:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'starts_with' => ':attributeは次の1つで始まっている必要があります: :values',
    'string'               => ':attributeは文字列にしてください。',
    'timezone'             => ':attributeは正しいタイムゾーンをしていしてください。',
    'unique'               => ':attributeは既に存在します。',
    'uploaded'             => ':attributeはアップロードに失敗しました。',
    'uppercase'            => ':attributeは大文字にしてください。',
    'url'                  => ':attributeを正しい書式にしてください。',
    'ulid' => ':attributeは正しいULIDにしてください。',
    'uuid' => ':attributeは正しいUUIDにしてください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'user_name' => 'ユーザー名',
        'user_email' => 'E-Mail',
        'admin_email' => 'E-Mail',
        'password' => 'パスワード',
        'new_password' => '新しいパスワード',
        'your_name' => 'お名前',
        'your_email' => 'E-Mail',
        'your_body' => '本文',
        'category_slug' => 'カテゴリスラッグ',
        'category_name_admin' => '管理者用カテゴリ名',
        'category_name' => 'カテゴリ名',
        'category_level' => '階層',
        'parent_id' => '親カテゴリ',
        'category_image' => 'カテゴリ画像',
        'category_text' => 'カテゴリ説明文',
        'curriculum_name_admin' => '管理者用カリキュラム名',
        'curriculum_name' => 'カリキュラム名',
        'curriculum_image' => 'カリキュラム画像',
        'category_id' => 'カテゴリ',
        'curriculum_type' => 'カリキュラム種別',
        'movie_url' => '動画URL',
        'audio_file' => '音声ファイル',
        'pdf_file1' => 'PDFファイル',
        'pdf_file2' => 'PDFファイル',
        'pdf_file3' => 'PDFファイル',
        'pdf_file4' => 'PDFファイル',
        'pdf_file5' => 'PDFファイル',
        'curriculum_text' => 'カリキュラム説明文',
        'authority_ranks' => '閲覧権限ランク',
        'release_type' => '公開タイプ',
        'released_at' => '公開日時',
        'closed_at' => '終了日時',
        'released_date_count' => '公開開始日数',
        'closed_date_count' => '公開終了日数',
        'sei' => '氏名の姓',
        'mei' => '氏名の名',
        'sei_kana' => '姓カナ',
        'mei_kana' => '名カナ',
        'sex' => '性別',
        'tel' => '電話番号',
        'zip' => '郵便番号',
        'prefecture' => '都道府県',
        'address_01' => '住所（市区町村番地）',
        'address_02' => '住所（マンション名号室）',
        'user_rank' => '会員ランク',
        'user_type' => 'ユーザータイプ',
        'admin_name' => '管理者名',
        'start_date' => '利用開始日',
        'end_date' => '利用終了日',
        'admin_type' => '管理者タイプ',


    ],

];
