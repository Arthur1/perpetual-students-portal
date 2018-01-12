<?php
class Authplus
{
    /**
     * ログインチェック用メソッド
     * @param array $groups	グループの配列
     * @return boolean 該当するグループでログインしていたらtrue、していないならfalse
     */
    public static function check($groups)
    {
        foreach ($groups as $group)
        {
            if (\Auth::member($group))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * ログインチェック用メソッド②、ログインしていないならloginページに飛ぶ
     * @param array $groups	グループの配列
     */
    public static function check_and_redirect($groups)
    {
        foreach ((array)$groups as $group)
        {
            if (\Auth::member($group))
            {
                return;
            }
        }
        \Session::set_flash('url', Uri::current());
        \Response::redirect('/login');
    }
}