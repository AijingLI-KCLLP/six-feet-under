<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('the-void', function () {
    return true;
});

Broadcast::channel('presence-the-void', function () {
    return ['id' => session()->getId()];
});
