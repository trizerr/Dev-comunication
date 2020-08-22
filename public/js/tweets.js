


let liked, totalLikes;
function tweets(id, username, user_id, author,date,body,photo,server,firstname,lastname, post_photo) {
    let words = date.split(' ');
    let post_time = words[1];
    let roots = document.getElementById('root');
    let charCount = document.querySelectorAll('.character-counter');
    let tweetForm = document.getElementById('tweet-form');
    let userTag = document.getElementById('usertag');
    // if (formTweet[0].value === '') {
    //   alert('Write text!');
    // } else {

    const newTable = document.createElement('div');
    newTable.className =
        'flex-tweet row container my-3 mx-auto p-3 col-lg-12 border tweet';
    newTable.id="tweet"+id;
    roots.insertBefore(newTable, roots.firstChild);

    const row = document.createElement('div');
    row.className ="row ";
    newTable.insertBefore(row, newTable.firstChild);

    const column = document.createElement('div');
    column.className = 'column pl-3 col-lg-12';
    newTable.appendChild(column);

    const flex = document.createElement('div');
    flex.className = ' align-items-center';
    flex.style.wordWrap = "break-word";
    column.appendChild(flex);


    const tweetOf = document.createElement('div');
    tweetOf.className = 'h4 text-dark font-weight-normal pl-2 pt-3';
    tweetOf.innerHTML = body;
    flex.appendChild(tweetOf);

    const avatar = document.createElement('img');
    avatar.className = 'rounded-circle tweet-img ml-3';
    avatar.style.width='100px';
    avatar.style.height='100px';
    if(photo!="")
    avatar.src=server+photo;
    else
    avatar.src=server+'img/default.png';
    row.appendChild(avatar);

    const usertag = document.createElement('div');
    usertag.className = 'h3 font-weight-normal pl-2';
    usertag.style.paddingTop='20px';
    usertag.innerHTML = firstname +" "+lastname+'<br>'+ '<span class="h4" style="color:dodgerblue">'+"@"+username+'</span>';
    row.appendChild(usertag);

    // const timeTweet = document.createElement('div');
    // timeTweet.className = 'h6 pl-2 pt-4';
    // timeTweet.innerHTML = time.getHours() + ':' + time.getMinutes();
    // flex.appendChild(timeTweet);
    if(post_photo!=""){
        const img = document.createElement('img');
        img.style.maxWidth='100%';
        img.src = server+post_photo;
        flex.appendChild(img);
    }
    const btn = document.createElement('div');
    btn.className = 'btn__new-tweet d-flex';
    column.appendChild(btn);

    const like = document.createElement('button');
    like.className = 'fas fa-heart flip-icon pr-2 p icon btn like';
    btn.appendChild(like);
    isliked(like, id);
    like.addEventListener('click',function() {

        if (liked==false){
            $.ajax({
                url: '../post/like',
                type: 'post',
                data: {post_id: id},
                success: function (response) {
                    liked = true;
                    like.style.color="red";
                    getTotalLikes(like,id);
                }
            });
            getTotalLikes(like,id);
        } else{
            $.ajax({
                url: '../post/unlike',
                type: 'post',
                data: {post_id: id},
                success: function (response) {
                    liked = false;
                    like.style.color="black";
                    getTotalLikes(like,id);
                }
            });

        }

    });
    getTotalLikes(like,id);


    if(author=="me"){
        let del = document.createElement('button');
        del.className = 'fas fa-trash-alt pr-2 icon btn';
        btn.appendChild(del);
        del.addEventListener('click', function () {

            $.ajax({
                url: '../post/delete',
                type: 'post',
                data: {id: id},
                success: function (response) {
                    let element = document.getElementById("tweet" + id);
                    element.parentNode.removeChild(element);
                }
            });

        });
    }
    const datediv = document.createElement('div');
    datediv.className = 'h5 text-gray font-weight-normal pl-2 pt-3 d-flex justify-content-end';
    datediv.innerHTML = post_time;
    btn.appendChild(datediv);

    // formTweet[0].value = '';
    // current.innerHTML='0';
    // createBtn.disabled =true;
    // tweetForm.action ='tweet';
    // tweetForm.submit();
    //}

}
function getTotalLikes(like, id){
    $.ajax({
        url: '../post/getTotalLikes',
        type: 'post',
        data: {post_id: id},
        success: function (response) {
            totalLikes = response;
            like.innerHTML=totalLikes;
        }
    });
}

function checklike(like){
    if(liked==false){
        like.style.color="black";
    }else{
        like.style.color="red";
    }
}
function isliked(like, id){
    $.ajax({
        url: '../post/isliked',
        type: 'post',
        data: {post_id: id},
        success: function (response) {
            if(response)
                liked = true;
            else
                liked = false;
            checklike(like);
        }
    });
}
//file input
let inputs = document.querySelectorAll('.input-file');
Array.prototype.forEach.call(inputs, function(input){
    let label = input.nextElementSibling,
        labelVal = label.innerHTML;
    input.addEventListener('change', function(e){
        let fileName = '';
        if( this.files && this.files.length > 1 )
            fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
        else
            fileName = e.target.value.split( '\\' ).pop();
        if( fileName )
            label.querySelector( 'span' ).innerHTML = '' + fileName;
        else
            label.innerHTML = labelVal;
    });
});






