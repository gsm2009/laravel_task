<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class LogRequest extends Model
{
    use HasFactory;
    protected $table = 'log_request_';
    public $timestamps = false;

    protected $fillable = [
        'url',
        'request_data',
        'response_data',
        'created_at',
    ];

    public function setTable($table = '')
    {
        $this->table = $table ?: $this->table.date("Ymd"); // 设置动态表名
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function ($table) {
                $table->increments('id');
                $table->string('url',1000);
                $table->string('request_data',1000);
                $table->text('response_data');
                $table->dateTime('created_at');
            });
        }
         return $this;
    }
}