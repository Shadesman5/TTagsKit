$(function () {
    $('#slides').superslides({

        hashchange: false,
        play: 2500,
        pagination: true,
        inherit_height_from: $('#slideshowWindow')
    });


});

// $('#slides').on('animated.slides', function () {
//     var current_index = $(this).superslides('current');
//
//     if (current_index == 2) { // third slide
//         var disp = function test1() {
//
//             setTimeout(function (){
//                 $('#slides').superslides('start')
//             }, 20000);
//
//         };
//         disp();
//
//     }
//
// });