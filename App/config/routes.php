<?php

return [
  '' => [
    'controller' => 'page',
    'action' => 'index'
  ],

  'user/registration' => [
    'controller' => 'user',
    'action' => 'registration'
  ],

  'user/login' => [
    'controller' => 'user',
    'action' => 'login'
  ],

  'user/logout' => [
    'controller' => 'user',
    'action' => 'logout'
  ],

  'user/home' => [
    'controller' => 'user',
    'action' => 'home'
  ],

  'user/search' => [
    'controller' => 'user',
    'action' => 'search'
  ],

  'user/inform' => [
    'controller' => 'user',
    'action' => 'inform'
  ],
  'user/uploadPhoto' => [
    'controller' => 'user',
    'action' => 'uploadPhoto'
  ],
  'user/profile' => [
    'controller' => 'user',
    'action' => 'profile'
  ],

  'post/create' => [
    'controller' => 'post',
    'action' => 'create'
  ],
  'post/delete' => [
    'controller' => 'post',
    'action' => 'delete'
  ],
  'post/isliked' => [
    'controller' => 'post',
    'action' => 'isliked'
  ],
  'user/searching' => [
    'controller' => 'user',
    'action' => 'searching'
  ],
  'user/.*' => [
    'controller' => 'user',
    'action' => 'userProfile'
  ],
  'post/like' => [
    'controller' => 'post',
    'action' => 'like'
  ],
  'post/unlike' => [
    'controller' => 'post',
    'action' => 'unlike'
  ],
  'post/getTotalLikes' => [
    'controller' => 'post',
    'action' => 'getTotalLikes'
  ],
  'post/addImage' => [
    'controller' => 'post',
    'action' => 'addImage'
  ],
  'follower/follow' => [
    'controller' => 'follower',
    'action' => 'follow'
  ],
  'follower/unfollow' => [
    'controller' => 'follower',
    'action' => 'unfollow'
  ],
  'follower/getTotalFollowing' => [
    'controller' => 'follower',
    'action' => 'getTotalFollowing'
  ],

  'message/create' => [
    'controller' => 'message',
    'action' => 'create'
  ],

];