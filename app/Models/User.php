<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'name_kana', // name_kanaを追加
        'username',
        'email',
        'password',
        'del_flg',
    ];

    protected $casts = [
        'del_flg' => 'boolean',
    ];

    /**
     * パスワードの自動ハッシュ化
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * name_kanaのミューテタ (保存時にひらがなに変換)
     *
     * @param  string  $value
     * @return void
     */
    public function setNameKanaAttribute($value)
    {
        $this->attributes['name_kana'] = mb_convert_kana($value, 'c'); // カタカナをひらがなに変換
    }

    /**
     * name_kanaのアクセサ (取得時にカタカナに変換)
     *
     * @param  string  $value
     * @return string
     */
    public function getNameKanaAttribute($value)
    {
        return mb_convert_kana($value, 'C'); // ひらがなをカタカナに変換
    }
}
