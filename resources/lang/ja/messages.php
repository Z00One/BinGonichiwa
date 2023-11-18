<?php
return [
    'language' => 'Set To Eng',
    'dashboard' => [
        'first' => 'BinGonichiwaへようこそ。',
        'second' => 'このサービスは他の人と簡単にビンゴゲームができます。',
        'third' => 'ログインして楽しんでみませんか。',
    ],
    'auth' => [
        'logout' => 'ログアウトしますか？',
        'login' => 'ログイン',
        'password' => 'パスワード',
        'error' => '問題が発生しました。',
        'register' => '登録',
        'already_registered' => 'すでに登録済みです',
        'name' => '名前',
        'confirm_password' => 'パスワードの確認',
    ],
    'profile' => [
        'saved' => '保存しました。',
        'save' => '保存',
        'update_information' => [
            'title' => 'プロフィール情報',
            'description' => 'アカウントのプロフィール情報とメールアドレスを更新してください。',
            'name' => '名前',
            'id' => 'ID',
        ],
        'update_password' => [
            'title' => 'パスワードを更新',
            'description' => 'アカウントが安全であるためには、長くランダムなパスワードを使用してください。',
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
            'confirm_password' => 'パスワードの確認',
        ],
        'delete_account' => [
            'title' => 'アカウントを削除',
            'description' => 'アカウントを永久に削除します。',
            'content' => 'アカウントを削除すると、すべてのリソースとデータが永久に削除されます。',
            'modal' => [
                'title' => 'アカウントを削除',
                'content' => '本当にアカウントを削除しますか？ アカウントを削除すると、すべてのリソースとデータが永久に削除されます。 アカウントを永久に削除することを確認するには、パスワードを入力してください。',
                'input_placehorder' => 'パスワード',
                'cancel' => 'キャンセル',
                'delete_account_button' => 'アカウントを削除',
            ],
        ],
    ],
    'validation' => [
        'id' => [
            'unique' => 'このIDは既に使用されています。',
        ],
        'password' => [
            'confirmed' => '入力されたパスワードは確認用のパスワードと一致しません',
            'match' => '入力されたパスワードは現在のパスワードと一致しません'
        ],
    ],
    'custom_password_messages' => [
        'default' => ':attributeは少なくとも:length文字です。',
    ],
];
