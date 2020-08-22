let follow = document.getElementById('follow-button');
let userId = document.getElementById('user-id');
let following = document.getElementById('following');

if(follow!=null){
    follow.addEventListener('click', function () {
        let id=userId.innerHTML;
        followUnfollow(id,'follow-button');
    });

}
function followUnfollow(id,buttonName){
    let button = document.getElementById(buttonName);
    if(button.innerHTML=='Follow'){
        $.ajax({
            url: '../follower/follow',
            type: 'post',
            data: {user_id: id},
            success: function (response) {
                button.innerHTML='Following';
            }
        });
    }else{
        $.ajax({
            url: '../follower/unfollow',
            type: 'post',
            data: {user_id: id},
            success: function (response) {
                button.innerHTML='Follow';
            }
        });
    }
}
/*
    following.addEventListener('click', function () {
        let id=userId.innerHTML;
        $.ajax({
            url: '../follower/getTotalFollowing',
            type: 'post',
            data: {user_id: id},
            success: function (response) {
                let root = document.getElementById('user-cards');
                root.append(response);
            }
        });

    });*/

