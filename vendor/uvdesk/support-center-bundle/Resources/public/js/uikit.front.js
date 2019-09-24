document.addEventListener("DOMContentLoaded",  function(){
    var uvHamburger =  document.querySelector(".uv-hamburger");
    if(uvHamburger) {
        var uvNav =  document.querySelector("nav");
        var uvSlideIn =  function() {
            if(window.innerWidth <= 768){
                uvNav.classList.add("slide-in");
            }else{
                uvNav.classList.remove("slide-in");
            }
        }

        window.onresize = function(){
            uvSlideIn();
        }
        uvSlideIn();

        uvHamburger.addEventListener("click", function(){
            uvNav.classList.toggle("uv-nav-active");
        });
    }
});