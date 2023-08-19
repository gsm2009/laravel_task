<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class LogException extends Model
{
    use HasFactory;
    protected $table = 'log_exception_';
    public $timestamps = false;

    protected $fillable = [
        'message',
        'code',
        'line',
        'file',
        'created_at',
    ];

    public function setTable($table = '')
    {
        $this->table = $table ?: $this->table.date("Ymd"); // 设置动态表名
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function ($table) {
                $table->increments('id');
                $table->text('message');
                $table->string('code',100);
                $table->string('line',100);
                $table->string('file',1000);
                $table->dateTime('created_at');
            });
        }

         return $this;
    }
}

