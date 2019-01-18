<?php

class Users extends Model
{
    public static $_id_column = 'user_id';

    /**
    * Rolesテーブルとの関連
    */
    public function roles()
    {
        return $this->belongs_to('Roles');
    }

    /**
    * オブジェクトにパラメータをセットする
    */
    public function setParams($params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
    * DBへ保存する
    */
    public function save()
    {
        if ($this->checkValid()) {
            $password = $this->password;
            try {
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                parent::save();
                return true;
            } catch (Exception $e) {
                $this->password = $password;
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * バリデーションチェック
    * params => user_id, password, name, roles_id
    * user_id: 半角英数字8文字以上, 重複不可, not null
    * password: 半角英数字8文字以上, not null
    * name: not null
    */
    private function checkValid()
    {
        if (!$this->checkParams()) return false;
        if (!$this->checkFormat($this->user_id)) return false;
        if (!$this->checkDouble('user_id', $this->user_id)) return false;
        if (!$this->checkFormat($this->password)) return false;
        if (!$this->checkNotBlank($this->name)) return false;
        return true;
    }

    /**
    * 保存に必要な要素が存在しているか確認する
    */
    private function checkParams()
    {
        $expected = array('user_id', 'password', 'name', 'roles_id');
        foreach ($expected as $param) {
            if (is_null($this->$param)) return false;
        }
        return true;
    }

    /**
    * 渡された要素が半角英数8文字以上か確認する
    */
    private function checkFormat($param)
    {
        $pattern = '/\A[a-z\d]{8,254}+\z/i';
        if (preg_match($pattern, $param)) return true;
        return false;
    }

    /**
    * 渡された要素が空文字のみでないことを確認する
    */
    private function checkNotBlank($param)
    {
        $pattern = '/[^\s　]/';
        if (preg_match($pattern, $param)) return true;
        return false;
    }

    /**
    * 渡された要素がすでにDBへ登録されていないか確認する
    */
    private function checkDouble($column, $param)
    {
        if (!Model::factory('Users')->where($column, $param)->find_one()) return true;
        return false;
    }
}
