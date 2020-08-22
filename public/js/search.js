let search = document.getElementById('search');
let searchResult =document.getElementById('search-result');
search.addEventListener('keyup',function () {
    searching();
});
search.addEventListener('change',function () {
    searching();
});
function searching(){
        $.ajax({
            url: '/user/searching',
            type: 'post',
            data: {text: search.value},
            success: function (response) {
                var child = searchResult.lastElementChild;
                while (child) {
                    searchResult.removeChild(child);
                    child = searchResult.lastElementChild;
                }
                $("#search-result").prepend(response);
            }
        });
}
