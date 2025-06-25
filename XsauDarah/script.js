// buat ngatur pergerakan pada tombol user profile
let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   search.classList.remove('active');
}

// buat mengubah var unset menjadi var mixed
var unset;
unset = $nik;
var mixed = unset;