<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
<<<<<<< HEAD
=======


Broadcast::channel('item-out-of-stock', function ($user) {
    return $user->can('add item	');
});
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
