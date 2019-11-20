<?php

namespace App\Models;

class Article extends Base
{
      // 黑名单
      protected $guarded = [];
      // 动态添加对象属性
      // 添加修改和删除按钮
      protected $appends=['actionBtn'];

        // 分类
        public function cate() {
            return $this->belongsTo(Cate::class, 'cid');
        }

      // 和访问器合作 
      // 修改按钮和删除按钮
      public function getActionBtnAttribute(){
            return $this->editBtn('admin.article.edit') .' '. $this->delBtn('admin.article.destroy');
      }
}
