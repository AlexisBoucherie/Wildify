<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    /* ------------------------------------------ General page -------------------------------------------------*/
    '' => ['HomeController', 'index',], 
    'searchSong' => ['SearchPageController', 'searchSongs',],
    'play' => ['PlayPageController', 'getSongsForPlayPage', ['id']],
    'likepage' => ['LikePageController', 'getSongsForLikePage', ['id']],
    'playlikedsong' => ['LikePageController', 'getSongToPlayLikedSong', ['id', 'user']],
    'logout' => ['HomeController', 'logout'],
    /* ------------------------------------------ Setting page USER --------------------------------------------*/
    'setting/profile' => ['UserController', 'showOneUser', ['id']],
    'setting/profile/edit' => ['UserController', 'editProfile', ['id']],
    'setting/profile/delete' => ['UserController', 'showDeletePage', ['id']],
    'setting/profile/deleteDone' => ['UserController', 'deleteUser'],
    'setting/add_music' => ['SongController', 'addSong'],
    /* ------------------------------------------ Setting page ADMIN -------------------------------------------*/
    'setting/admin' => ['AdminController', 'showAllUsers'],
    'setting/admin/delete' => ['AdminController', 'showDeleteUser', ['id']],
    'setting/admin/deleteDone' => ['AdminController', 'deleteUser', ['id']],
    'setting/admin/manageMusics' => ['AdminController','showAllMusics']
];
