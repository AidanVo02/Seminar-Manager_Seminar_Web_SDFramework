<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Dự án này chưa cần binding container tùy biến.
    public function register(): void
    {
        //
    }

    // Hàm boot để trống vì dự án ưu tiên các class tường minh ở tầng riêng.
    public function boot(): void
    {
        //
    }
}
