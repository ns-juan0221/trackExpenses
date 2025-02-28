<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomeSubCategory;

class OutcomeSubCategorySeeder extends Seeder
{
    public function run()
    {
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '食材', 'del_flg' => 0]); //1
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '飲み物', 'del_flg' => 0]); //2
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '外食', 'del_flg' => 0]); //3
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => 'お菓子・スナック', 'del_flg' => 0]); //4
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '惣菜・加工食品', 'del_flg' => 0]); //5
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => '健康食品', 'del_flg' => 0]); //6
        OutcomeSubCategory::create(['main_category_id' => 1, 'name' => 'その他', 'del_flg' => 0]); //7
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '掃除用品', 'del_flg' => 0]); //8
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '洗面・バス用品', 'del_flg' => 0]); //9
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => 'キッチン用品', 'del_flg' => 0]); //10
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => 'トイレ用品', 'del_flg' => 0]); //11
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '衛生用品', 'del_flg' => 0]); //12
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '家庭用消耗品', 'del_flg' => 0]); //13
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '文房具', 'del_flg' => 0]); //14
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => '収納用品', 'del_flg' => 0]); //15
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => 'ペット用品', 'del_flg' => 0]); //16
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => 'こども用品', 'del_flg' => 0]); //17
        OutcomeSubCategory::create(['main_category_id' => 2, 'name' => 'その他', 'del_flg' => 0]); //18
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '公共交通機関', 'del_flg' => 0]); //19
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => 'タクシー・配車サービス', 'del_flg' => 0]); //20
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '自家用車関連', 'del_flg' => 0]); //21
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '自転車関連', 'del_flg' => 0]); //22
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '通学・通勤定期券', 'del_flg' => 0]); //23
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => '長距離移動費', 'del_flg' => 0]); //24
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => 'レンタル・シェアリングサービス', 'del_flg' => 0]); //25
        OutcomeSubCategory::create(['main_category_id' => 3, 'name' => 'その他', 'del_flg' => 0]); //26
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => '携帯電話関連', 'del_flg' => 0]); //27
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => '固定電話関連', 'del_flg' => 0]); //28
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => 'インターネット関連', 'del_flg' => 0]); //29
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => '宅配便', 'del_flg' => 0]); //30
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => '切手・ハガキ', 'del_flg' => 0]); //31
        OutcomeSubCategory::create(['main_category_id' => 4, 'name' => 'その他', 'del_flg' => 0]); //32
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => '家賃・ローン', 'del_flg' => 0]); //33
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => '光熱費', 'del_flg' => 0]); //34
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => '修繕・メンテナンス費', 'del_flg' => 0]); //35
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => '引越し関連', 'del_flg' => 0]); //36
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => '家具・家電', 'del_flg' => 0]); //37
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => 'インテリア・装飾品', 'del_flg' => 0]); //38
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => 'セキュリティ関連', 'del_flg' => 0]); //39
        OutcomeSubCategory::create(['main_category_id' => 5, 'name' => 'その他', 'del_flg' => 0]); //40
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => '飲食関連', 'del_flg' => 0]); //41
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => 'プレゼント・贈答品', 'del_flg' => 0]); //42
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => '冠婚葬祭', 'del_flg' => 0]); //43
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => '交友活動', 'del_flg' => 0]); //44
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => '職場関係', 'del_flg' => 0]); //45
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => 'イベント・パーティ', 'del_flg' => 0]); //46
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => '通信費関連', 'del_flg' => 0]); //47
        OutcomeSubCategory::create(['main_category_id' => 6, 'name' => 'その他', 'del_flg' => 0]); //48
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => 'エンターテイメント', 'del_flg' => 0]); //49
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => 'アウトドア・スポーツ', 'del_flg' => 0]); //50
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => 'インドア', 'del_flg' => 0]); //51
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => '読書・学習', 'del_flg' => 0]); //52
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => '旅行・観光', 'del_flg' => 0]); //53
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => '趣味の収集', 'del_flg' => 0]); //54
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => 'おもちゃ・ボードゲーム', 'del_flg' => 0]); //55
        OutcomeSubCategory::create(['main_category_id' => 7, 'name' => 'その他', 'del_flg' => 0]); //56
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '学費関連', 'del_flg' => 0]); //57
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '教材・参考書', 'del_flg' => 0]); //58
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '通信教育', 'del_flg' => 0]); //59
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '資格取得・試験費', 'del_flg' => 0]); //60
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '自己啓発・教養活動', 'del_flg' => 0]); //61
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => '子どもの教育費', 'del_flg' => 0]); //62
        OutcomeSubCategory::create(['main_category_id' => 8, 'name' => 'その他', 'del_flg' => 0]); //63
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '医療費', 'del_flg' => 0]); //64
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '医療用品', 'del_flg' => 0]); //65
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '保険料', 'del_flg' => 0]); //66
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '住居関連の保険', 'del_flg' => 0]); //67
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '車両関連の保険', 'del_flg' => 0]); //68
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '介護関連', 'del_flg' => 0]); //69
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => '出産・育児関連', 'del_flg' => 0]); //70
        OutcomeSubCategory::create(['main_category_id' => 9, 'name' => 'その他', 'del_flg' => 0]); //71
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => '衣服', 'del_flg' => 0]); //72
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => 'アクセサリー・ファッション小物', 'del_flg' => 0]); //73
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => '美容・ケア用品', 'del_flg' => 0]); //74
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => '美容院・理容院', 'del_flg' => 0]); //75
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => 'フィットネス・健康関連', 'del_flg' => 0]); //76
        OutcomeSubCategory::create(['main_category_id' => 10, 'name' => 'その他', 'del_flg' => 0]); //77
        OutcomeSubCategory::create(['main_category_id' => 11, 'name' => '車両関連', 'del_flg' => 0]); //78
        OutcomeSubCategory::create(['main_category_id' => 11, 'name' => 'メンテナンス費', 'del_flg' => 0]); //79
        OutcomeSubCategory::create(['main_category_id' => 11, 'name' => 'カスタマイズ・アクセサリー', 'del_flg' => 0]); //80
        OutcomeSubCategory::create(['main_category_id' => 11, 'name' => '罰金・トラブル対応', 'del_flg' => 0]); //81
        OutcomeSubCategory::create(['main_category_id' => 11, 'name' => 'その他', 'del_flg' => 0]); //82
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '所得税', 'del_flg' => 0]); //83
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '住民税', 'del_flg' => 0]); //84
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '個人事業税', 'del_flg' => 0]); //85
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '法人税', 'del_flg' => 0]); //86
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '資産に関連する税金', 'del_flg' => 0]); //87
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '住居関連の税金', 'del_flg' => 0]); //88
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '車両関連の税金', 'del_flg' => 0]); //89
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => '贈与・相続関連の税金', 'del_flg' => 0]); //90
        OutcomeSubCategory::create(['main_category_id' => 12, 'name' => 'その他', 'del_flg' => 0]); //91
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '住居関連', 'del_flg' => 0]); //92
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '車両関連', 'del_flg' => 0]); //93
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '教育関連', 'del_flg' => 0]); //94
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '冠婚葬祭', 'del_flg' => 0]); //95
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '旅行・レジャー', 'del_flg' => 0]); //96
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '趣味・コレクション', 'del_flg' => 0]); //97
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '医療', 'del_flg' => 0]); //98
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '投資・資産運用', 'del_flg' => 0]); //99
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => '引越・転居', 'del_flg' => 0]); //100
        OutcomeSubCategory::create(['main_category_id' => 13, 'name' => 'その他', 'del_flg' => 0]); //101
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => '仕送り', 'del_flg' => 0]); //102
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => 'お小遣い', 'del_flg' => 0]); //103
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => '立替金', 'del_flg' => 0]); //104
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => '現金の引き出し', 'del_flg' => 0]); //105
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => 'カードの引き落とし', 'del_flg' => 0]); //106
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => '電子マネーのチャージ', 'del_flg' => 0]); //107
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => '使途不明金', 'del_flg' => 0]); //108
        OutcomeSubCategory::create(['main_category_id' => 14, 'name' => 'その他', 'del_flg' => 0]); //109
    }
}
