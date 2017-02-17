コード規約

PHP

1.クラス

Upper Camel Case

書き方

class CLASS 
{
}

2.ファイル名

3.メソッド名

Lower Camel Case

4.変数

Lower Camel Case

5.定数

定数半角英数字、アンダースコア

6.配列

[]に統一
array()関数は使わない

7.制御構造

書き方
if {
} else {
}

8.コメント

//

関数なんかにコメントをつけたい場合は、/* エンターを押して保管されるヘッダーを利用する（その際のみ/*のコメントは許可する)

9.新しいファイルの追加

長いSQLはRepositoryに記述
特定の処理を書く関数はServiceに記述

10.インデント

インデントには４つのスペースを使う（タブは使わない)

11.php終了タグ

開始タグ?>は使わない

12.$_POSTを使わない

laravelのInput::get('ポスト値')とかを使う

13.Repository

検索

findNameByUserIdWithMemberIdAndGroupId(find + select文(複数の場合は何も入れない) + 検索文字(2つの場合はWith、3つ以上の場合はAndで続ける)）

更新

updateByUserId(update + あとは検索と一緒)

削除

deleteByUserId(delete + ソフトDELETEの場合では、deleteByを使う)

挿入

insertByUserId(insert + あとは検索と一緒)

14.クラス

Repository(SQL文をここに書く）

Service(ビジネスロジックなんかをControllerから切り出したい場合とか、ライブラリっぽいのとかはServiceに記述する（ここは曖昧でいいっぽい）

js

その他

英語は基本訳さない

detailをdtlとかはやめましょう！ダサいです！長くてもいいので、きちんと英語で書く。

