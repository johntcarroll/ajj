<?php

class Company extends ActiveRecord\Model{

    static $table_name = 'companies';
    static $before_save = ['dup_check'];

    public function dup_check(){
        if($this->id) $check = static::find(['conditions' => ['ticker LIKE ? AND id <> ?', $this->ticker, $this->id]]);
        else $check = static::find(['conditions' => ['ticker LIKE ?', $this->ticker]]);
        return ($check ? FALSE : TRUE);
    }

    public static function filldrop(){
        $html = '';
        foreach(Company::all() as $comp)
            $html .= "<option value='" . $comp->id .  "'>" . $comp->ticker . "</option>";
        return $html;
    }
}
