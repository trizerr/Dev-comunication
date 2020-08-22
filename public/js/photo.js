let photo = document.getElementById('photo');
let form = document.getElementById('form-photo');
if(photo!=null) {
    photo.addEventListener("click", function tweet() {
        if(form!=null) {
            form.style.display='block';
        }
    });
}