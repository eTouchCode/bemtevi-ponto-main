<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camera extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        "name",
        "location",
        "ip",
        "port",
        "user",
        "password",
        "path",
        "status",
    ];

    public function getCameraUrl()
    {

        $rtsp = sprintf(
            '%s:%s@%s:%s/%s',
            $this->user,
            $this->password,
            $this->ip,
            $this->port,
            $this->path,
        );

        return config('app.rtsp_url') . "?ip=" . $rtsp;
    }
}
