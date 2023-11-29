<?php
return [
    'header' => [
        'language' => 'Set To Eng',
        'profile' => 'プロフィール',
        'logout' => 'ログアウト',
        'record' => '戦績',
    ],
    'home' => [
        'welcome' => "様、ようこそ。",
        'match' => 'マッチングスタート',
        'first' => 'BinGonichiwaへようこそ。',
        'second' => 'このサービスは他の人と簡単にビンゴゲームができます。',
        'third' => 'ログインして楽しんでみませんか。',
        'games' => '戦',
        'wins' => '勝',
        'loses' => '敗',
        'winning_rate' => ':name様の勝率',
    ],
    'auth' => [
        'logout' => 'ログアウトしますか？',
        'login' => 'ログイン',
        'password' => 'パスワード',
        'error' => '問題が発生しました。',
        'register' => '登録',
        'already_registered' => 'すでに登録済みです。',
        'name' => '名前',
        'confirm_password' => 'パスワードの確認',
        'wrong' => 'この情報は私たちの情報と一致しません。',
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
                'button' => 'アカウントを削除',
                'wrong' => 'このパスワードは私たちの情報と一致しません。',
            ],
        ],
    ],
    'validation' => [
        'id' => [
            'unique' => 'このIDは既に使用されています。',
        ],
        'password' => [
            'confirmed' => '入力されたパスワードは確認用のパスワードと一致しません。',
            'match' => '入力されたパスワードは現在のパスワードと一致しません。'
        ],
    ],
    'custom_password_messages' => [
        'default' => ':attributeは少なくとも:length文字です。',
    ],
    'records' => [
        'name' => ' 様の戦績',
        'win' => '勝',
        'lose' => '敗',
        'opponent' => '相手',
        'result' => '結果',
        'time' => '時間',
        'games' => '戦',
        'winning_rate' => '勝率',
        'page_prev' => '前へ',
        'page_next' => '次へ',
        'withdrawal' => '脱退者',
        'no_records' => '記録がありません。。。',
    ],
    'errors' => [
        '404' => 'このページはすでに削除されているか、URLが間違っている可能性があります。',
        'button' => 'トップページへ',
    ],
    'waiting' => [
        'wait' => '相手を探しています。。。',
        'match_cancel' => 'キャンセル',
        'cancel_confirm' => 'キャンセルしてもよろしいです？',
        'start' => '相手を見つけました。ゲームを始めます。',
        'error' => 'エラーが発生しました。後でもう一度試してください。',
    ],
    'match' => [
        'users' => 'あなたのボード',
        'opponents' => '\'様のボード',
        'submit' => '入力',
    ],
];
