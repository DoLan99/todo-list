<?php

namespace App\Models;

use App\Core\Model;

class Work extends Model
{
    public static function tableName()
    {
        return 'works';
    }

    public function attributes()
    {
        return ['work_name', 'starting_date', 'ending_date', 'status'];
    }
}