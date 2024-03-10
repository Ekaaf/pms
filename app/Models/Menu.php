<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public function children()
{
    return $this->hasMany('App\Models\Menu', 'parent_id');
}

public function parent()
{
    return $this->belongsTo('App\Models\Menu', 'parent_id');
}

public function getRoot()
{
    $cur = $this;
    while ($cur->parent) {
        $cur = $cur->parent;
    }
    return $cur;
}
    
}
