let navBar = document.querySelector('.navbar');
document.querySelector('#menu-btn').onclick = () =>{
    navBar.classList.toggle('active')
    profile.classList.remove('open')
} 


// show btn-user
let profile = document.querySelector('.profile');
document.querySelector('#users-btn').onclick = () =>{
    profile.classList.toggle('open')
    navBar.classList.remove('active')
}


window.onscroll = () =>{
    navBar.classList.remove('active')
    profile.classList.remove('.open')
}

// slider navigation active
const marker = document.getElementById("#marker");
const navItem = document.querySelectorAll(".navbar a");

function indicator(e) {
    marker.style.left = e.offsetLeft + 'px';
    marker.style.width = e.offsetWidth + 'px';
}

navItem.forEach((detail) =>{
    detail.addEventListener('click', (e) =>{
        indicator(e.target);
    })
})