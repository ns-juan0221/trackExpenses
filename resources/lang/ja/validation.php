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

    'accepted' => ':attributeを承認する必要があります',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認する必要があります',
    'active_url' => ':attributeは有効なURLではありません',
    'after' => ':attributeは:dateより後の日付でなければなりません',
    'after_or_equal' => ':attributeは:date以降の日付でなければなりません',
    'alpha' => ':attributeは文字のみを含む必要があります',
    'alpha_dash' => ':attributeは文字、数字、ダッシュ、アンダースコアのみを含む必要があります',
    'alpha_num' => ':attributeは文字と数字のみを含む必要があります',
    'array' => ':attributeは配列でなければなりません',
    'before' => ':attributeは:dateより前の日付でなければなりません',
    'before_or_equal' => ':attributeは:date以前の日付でなければなりません',
    'between' => [
        'numeric' => ':attributeは:minから:maxの間でなければなりません',
        'file' => ':attributeは:minから:maxキロバイトの間でなければなりません',
        'string' => ':attributeは:minから:max文字の間でなければなりません',
        'array' => ':attributeは:minから:max個のアイテムを含む必要があります',
    ],
    'boolean' => ':attributeフィールドはtrueまたはfalseでなければなりません',
    'confirmed' => ':attributeが一致しません',
    'current_password' => 'パスワードが正しくありません',
    'date' => ':attribute は有効な日付ではありません',
    'date_equals' => ':attributeは:dateと同じ日付でなければなりません',
    'date_format' => ':attributeは:format形式と一致しません',
    'declined' => ':attributeを拒否する必要があります',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否する必要があります',
    'different' => ':attributeと:otherは異なる必要があります',
    'digits' => ':attributeは:digits桁でなければなりません',
    'digits_between' => ':attributeは:minから:max桁の間でなければなりません',
    'dimensions' => ':attributeの画像サイズが無効です',
    'distinct' => ':attributeフィールドに重複した値があります',
    'email' => ':attributeは有効なメールアドレスでなければなりません',
    'ends_with' => ':attributeは次のいずれかで終了する必要があります::values',
    'enum' => '選択された:attributeは無効です',
    'exists' => '選択された:attributeは無効です',
    'file' => ':attributeはファイルでなければなりません',
    'filled' => ':attributeフィールドには値が必要です',
    'gt' => [
        'numeric' => ':attributeは:valueより大きくなければなりません',
        'file' => ':attributeは:valueキロバイトより大きくなければなりません',
        'string' => ':attributeは:value文字より多くなければなりません',
        'array' => ':attributeには:value個以上のアイテムが必要です',
    ],
    'gte' => [
        'numeric' => ':attributeは:value以上でなければなりません',
        'file' => ':attributeは:valueキロバイト以上でなければなりません',
        'string' => ':attributeは:value文字以上でなければなりません',
        'array' => ':attributeには:value個以上のアイテムが必要です',
    ],
    'image' => ':attributeは画像でなければなりません',
    'in' => '選択された:attributeは無効です',
    'in_array' => ':attributeフィールドは:otherに存在しません',
    'integer' => ':attributeは整数でなければなりません',
    'ip' => ':attributeは有効なIPアドレスでなければなりません',
    'ipv4' => ':attributeは有効なIPv4アドレスでなければなりません',
    'ipv6' => ':attributeは有効なIPv6アドレスでなければなりません',
    'json' => ':attributeは有効なJSON文字列でなければなりません',
    'lt' => [
        'numeric' => ':attributeは:value未満でなければなりません',
        'file' => ':attributeは:valueキロバイト未満でなければなりません',
        'string' => ':attributeは:value文字未満でなければなりません',
        'array' => ':attributeには:value個未満のアイテムが必要です',
    ],
    'lte' => [
        'numeric' => ':attributeは:value以内で入力してください',
        'file' => ':attributeは:valueキロバイト以内で入力してください',
        'string' => ':attributeは:value文字以内で入力してください',
        'array' => ':attributeには:value個以下のアイテムが必要です',
    ],
    'mac_address' => ':attributeは有効なMACアドレスでなければなりません',
    'max' => [
        'numeric' => ':attributeは:max以内で入力してください',
        'file' => ':attributeは:maxキロバイト以内で入力してください',
        'string' => ':attributeは:max文字以内で入力してください',
        'array' => ':attributeには:max個以下のアイテムが必要です',
    ],
    'mimes' => ':attributeは次のタイプのファイルでなければなりません::values',
    'mimetypes' => ':attributeは次のタイプのファイルでなければなりません::values',
    'min' => [
        'numeric' => ':attributeは少なくとも:minでなければなりません',
        'file' => ':attributeは少なくとも:minキロバイトでなければなりません',
        'string' => ':attributeは少なくとも:min文字でなければなりません',
        'array' => ':attributeには少なくとも:min個のアイテムが必要です',
    ],
    'multiple_of' => ':attributeは:valueの倍数でなければなりません',
    'not_in' => '選択された:attributeは無効です',
    'not_regex' => ':attributeの形式が無効です',
    'numeric' => ':attributeは数値でなければなりません',
    'password' => 'パスワードが正しくありません',
    'present' => ':attributeフィールドが存在している必要があります',
    'prohibited' => ':attributeフィールドは禁止されています',
    'prohibited_if' => ':otherが:valueの場合、:attributeフィールドは禁止されています',
    'prohibited_unless' => ':otherが:valuesに含まれていない限り、:attributeフィールドは禁止されています',
    'prohibits' => ':attributeフィールドは:otherの存在を禁止します',
    'regex' => ':attributeの形式が無効です',
    'required' => ':attributeを入力してください',
    'required_array_keys' => ':attributeフィールドには次のエントリを含む必要があります::values',
    'required_if' => ':otherが:valueの場合、:attributeフィールドは必須です',
    'required_unless' => ':otherが:valuesに含まれていない場合、:attributeフィールドは必須です',
    'required_with' => ':valuesが存在する場合、:attributeフィールドは必須です',
    'required_with_all' => ':valuesがすべて存在する場合、:attributeフィールドは必須です',
    'required_without' => ':valuesが存在しない場合、:attributeフィールドは必須です',
    'required_without_all' => ':valuesがすべて存在しない場合、:attributeフィールドは必須です',
    'same' => ':attributeと:otherは一致する必要があります',
    'size' => [
        'numeric' => ':attributeは:sizeでなければなりません',
        'file' => ':attributeは:sizeキロバイトでなければなりません',
        'string' => ':attributeは:size文字でなければなりません',
        'array' => ':attributeには:size個のアイテムを含む必要があります',
    ],
    'starts_with' => ':attributeは次のいずれかで始まる必要があります::values',
    'string' => ':attributeは文字列でなければなりません',
    'timezone' => ':attributeは有効なタイムゾーンでなければなりません',
    'unique' => ':attributeは既に使用されています',
    'uploaded' => ':attributeのアップロードに失敗しました',
    'url' => ':attributeは有効なURLでなければなりません',
    'uuid' => ':attributeは有効なUUIDでなければなりません',

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
        'email' => [
            'required' => 'メールアドレスを入力してください',
            'email' => '有効なメールアドレスを入力してください',
        ],
        'password' => [
            'required' => 'パスワードを入力してください',
            'min' => '最低 :min 文字以上必要です',
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
        'name' => '名前',
        'name_kana' => 'カナ',
        'username' => 'ユーザーネーム',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
    ],

];
