<?php

use Pagekit\Application as App;

App::config()->set('system', App::config('system')->merge([
    'site' => [
        "theme" => "theme-aurora"
    ],
    'extensions' => [
        "0" => "driven/listings",
        "1" => "slideshow-widget",
        "4" => "spqr/cookiewarning"
    ]
]));

App::config()->set('system/site', App::config('system/site')->merge([
    "menus"=> [
        "main" => [
            "id" => "main",
            "label" => "Main"
        ]
    ],
    "frontpage" => 1,
    "view" => [
        "logo" => "storage/ttags-logo.png"
    ],
    "description" => "",
    "maintenance" => [
        "enabled" => true,
        "logo" => "",
        "msg" => ""
    ],
    "icons" => [
        "favicon" => "storage/favicon.ico",
        "appicon" => "storage/apple_touch_icon.png"
    ],
    "code" => [
        "header" => "",
        "footer" => "<script>window.gtranslateSettings = {\n        \"default_language\":\"de\",\n        \"native_language_names\":true,\n        \"detect_browser_language\":true,\n        \"languages\":[\"de\",\"en\",\"ru\",\"tr\",\"it\",\"fr\",\"es\",\"ca\"],\n        \"wrapper_selector\":\".gtranslate_wrapper\",\n        \"switcher_horizontal_position\":\"right\",\n        \"switcher_vertical_position\":\"top\",\n        \"float_switcher_open_direction\":\"bottom\"\n    }\n\t$(document).ready(function() {\n        $(\".gt-current-lang\").append($(\".gt-current-lang img\"));\n    });\n</script>\n<script src=\"https://cdn.gtranslate.net/widgets/latest/float.js\" defer></script>"
    ]
]));

App::db()->insert('@system_config', [
    'name' => 'theme-aurora',
    'value' => '{
        "_positions":{
            "toolbar":[],
            "navbar":[],
            "hero":[1],
            "content_top":[],
            "top":[],
            "top_d":[],
            "sidebar":[],
            "bottom":[],
            "bottom_c":[2],
            "bottom_d":[3,4],
            "content_bottom":[5],
            "footer":[],
            "sidebar_menu":[],
            "sidebar_main":[],
            "sidebar_social":[],
            "offcanvas":[]
        },
        "_menus":{
            "main":"main",
            "offcanvas":"main"
        },
        "style":"yellow",
        "logo_small":"storage\/ttags-logo.png",
        "logo_offcanvas":"storage\/ttags-logo.png",
        "section_divider":true,
        "sidebar_width":"25",
        "sidebar_parallax":false,
        "sidebar_fixed":false,
        "totop_scroller":true,
        "_nodes":{
            "1":{
                "title_hide":true,
                "title_large":false,
                "alignment":"",
                "html_class":"home",
                "sidebar_first":false,
                "hero_image":"",
                "hero_viewport":"",
                "hero_contrast":"",
                "hero_parallax":"",
                "content_top_padding":true,
                "content_bottom_padding":true
            }
        },
        "_widgets":{
            "1":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":false,
                "html_class":"",
                "panel":""
            },
            "2":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":"true",
                "html_class":"",
                "panel":""
            },
            "3":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":"true",
                "html_class":"",
                "panel":""
            },
            "4":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":"true",
                "html_class":"",
                "panel":""
            },
            "5":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":"true",
                "html_class":"",
                "panel":""
            },
            "6":{
                "title_hide":true,
                "title_size":"uk-panel-title",
                "alignment":"true",
                "html_class":"",
                "panel":"uk-panel-header"
            }
        }
    }'
]);

App::db()->insert('@system_node', [
    'priority' => 1,
    'status' => 1,
    'title' => 'Home',
    'slug' => 'home',
    'path' => '/home',
    'link' => '@page/1',
    'type' => 'page',
    'menu' => 'main',
    'data' => '{
        "defaults":{
            "id":1
        }
    }'
]);

App::db()->insert('@system_node', [
    'priority' => 2,
    'status' => 1,
    'title' => 'Getränkekarte',
    'slug' => 'getraenke',
    'path' => '/getraenke',
    'link' => '@page/2',
    'type' => 'page',
    'menu' => 'main',
    'data' => '{
        "defaults":{
            "id":2
        }
    }'
]);

App::db()->insert('@system_node', [
    'priority' => 3,
    'status' => 1,
    'title' => 'Speisekarte',
    'slug' => 'getraenke',
    'path' => '/speisen',
    'link' => '@page/3',
    'type' => 'page',
    'menu' => 'main',
    'data' => '{
        "defaults":{
            "id":3
        }
    }'
]);

App::db()->insert('@system_node', [
    'priority' => 4,
    'status' => 1,
    'title' => 'Getränkekarte',
    'slug' => 'getränke',
    'path' => '/getränke',
    'link' => '@page/2',
    'type' => 'link',
    'menu' => '',
    'data' => '{
        "alias":false,
        "redirect":"@page\/2",
        "menu_hide":true
    }'
]);

App::db()->insert('@system_widget', [
    'title' => 'Slideshow',
    'type' => 'jebster/slideshowWidget',
    'status' => 1,
    'nodes' => 1,
    'data' => '{
        "config":{
            "height":"225",
            "animation":"slide",
            "animation_speed":"slow",
            "time_interval":"4000",
            "pagination":true
        },
        "images":[
            {
                "src":"storage\/slide1.jpg",
                "alt":"Slide1",
                "text":"",
                "header":"",
                "color":"gold"
            },
            {
                "src":"storage\/slide2.jpg",
                "alt":"Slide2"
            },
            {
                "src":"storage\/slide3.jpg",
                "alt":"Slide3"
            },
            {
                "src":"storage\/slide4.jpg",
                "alt":"Slide4"
            }
        ]
    }'
]);

App::db()->insert('@system_widget', [
    'title' => 'Feedback',
    'type' => 'system/text',
    'status' => 1,
    'nodes' => 1,
    'data' => '{
        "content":"<a class=\"uk-thumbnail\" href=\"https:\/\/www.ttags.de\/\" target=\"_blank\">\n    <span class=\"img-box img-feedback\">\n        <img src=\"storage\/shot.png\" alt=\"Vote for free Shot\" object-fit=\"cover\">\n    <\/span>\n<\/a>"
    }'
]);

App::db()->insert('@system_widget', [
    'title' => 'Website',
    'type' => 'system/text',
    'status' => 1,
    'nodes' => 1,
    'data' => '{
        "content":"<a class=\"uk-thumbnail\" href=\"https:\/\/www.ttags.de\/\" target=\"_blank\">\n    <span class=\"img-box img-website\">\n        <img src=\"storage\/ttags-logo.png\" alt=\"TTAGS Logo\" object-fit=\"cover\">\n    <\/span>\n<\/a>"
    }'
]);

App::db()->insert('@system_widget', [
    'title' => 'Instagram',
    'type' => 'system/text',
    'status' => 1,
    'nodes' => 1,
    'data' => '{
        "content":"<a class=\"uk-thumbnail\" href=\"https:\/\/www.instagram.com\/ttags.de\/\" target=\"_blank\">\n    <span class=\"img-box\">\n        <img src=\"\/storage\/insta.jpg\" alt=\"Instagram\" object-fit=\"cover\">\n    <\/span>\n<\/a>"
    }'
]);

App::db()->insert('@system_widget', [
    'title' => 'Öffnungszeiten',
    'type' => 'system/text',
    'status' => 1,
    'nodes' => 1,
    'data' => '{
        "content":"<table class=\"uk-table uk-table-small uk-table-divider\">\n    <tbody>\n        <tr>\n            <td>Di. + Mi. + Do. + So.<\/td>\n            <td>12:00 - 22:00<\/td>\n        <\/tr>\n        <tr>\n            <td>Fr. + Sa.<\/td>\n            <td>12:00 - 22:30<\/td>\n        <\/tr>\n    <\/tbody>\n<\/table>"
    }'
]);

App::db()->insert('@system_page', [
    'title' => 'Home',
    'content' => '
        <!-- Speise- und Getränkekarte -->
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-1-2">
                <a class="uk-thumbnail" href="/getraenke">
                    <span class="img-box">
                        <img src="/storage/getraenke.jpg" alt="Getränkekarte" object-fit="cover">
                    </span>
                    <div class="uk-thumbnail-caption">Getränkekarte</div>
                </a>
            </div>
            <div class="uk-width-1-2">
                <a class="uk-thumbnail" href="/speisen">
                    <span class="img-box">
                        <img src="/storage/kuchen.jpg" alt="Speisekarte" object-fit="cover">
                    </span>
                    <div class="uk-thumbnail-caption">Speisekarte</div>
                </a>
            </div>
        </div>
    ',
    'data' => '{"title":true}'
]);

App::db()->insert('@system_page', [
    'title' => 'Getränkekarte',
    'content' => '(menu){"id":"1"}',
    'data' => '{"title":true}'
]);

App::db()->insert('@system_page', [
    'title' => 'Speisekarte',
    'content' => '(menu){"id":"2"}',
    'data' => '{"title":true}'
]);

App::db()->insert('@system_user', [
    'id' => 1,
    'name' => 'TTAGS - Superadmin',
    'username' => 'admin',
    'email' => 'info@ttags.de',
    'password' => '$2y$10$IjXaPCjST49uob5Y4LV6De5QPamjfMj/ZPdWx8ogG6VQLkKFkKICe',
    'status' => 1,
    'registered' => date('Y-m-d H:i:s'),
    'roles' => '2,3',
    'data' => '{
        "admin":{
            "menu":{
                "site":1,
                "dashboard":2,
                "user":3,
                "system: system":4,
                "system: marketplace":5
            }
        }
    }'
]);

App::db()->insert('@system_role', [
    'name' => 'Webmaster',
    'priority' => 3,
    'permissions' => 'system: access admin area,listings: manage lists,system: manage storage,system: manage widgets'
]);

// if (App::db()->getUtility()->tableExists('@blog_post')) {
//     App::db()->insert('@blog_post', [
//         'user_id' => 1,
//         'slug' => 'hello-pagekit',
//         'title' => 'Hello Pagekit',
//         'status' => 2,
//         'date' => date('Y-m-d H:i:s'),
//         'modified' => date('Y-m-d H:i:s'),
//         'content' => $content_blog,
//         'excerpt' => '',
//         'comment_status' => 1,
//         'data' => '{"title":null,"markdown":true}'
//     ]);
// }
