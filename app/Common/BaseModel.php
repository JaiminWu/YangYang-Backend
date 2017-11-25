<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午3:20
 */

namespace App\Common;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public function insertData($data){

    }

    public function updateData($where){

    }

    public function replaceData($where){

    }

    public function getDataInArray($where, $field, $order){

    }

    public function getDataInRow($where, $field, $order){

    }

    public function deleteData($where){

    }

}