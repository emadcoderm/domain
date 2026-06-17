var elixir = require('laravel-elixir');

var bowerDir  = './resources/assets/vendor/';

var adminCss = [
    'bootstrap/dist/css/bootstrap.css',
    'font-awesome/css/font-awesome.css',
    'admin-lte/dist/css/AdminLTE.css',
    'admin-lte/dist/css/skins/skin-blue.css',
    '../admin/css/admin.css',
    'ionicons/css/ionicons.css'
];

var adminJs = [
    'jquery/dist/jquery.js',
    'bootstrap/dist/js/bootstrap.js',
    'admin-lte/dist/js/app.js',
    'jquery-confirm/jquery.confirm.js',
    '../admin/js/admin.js'
];

var frontCss = [
    'bootstrap/dist/css/bootstrap.css',
    'font-awesome/css/font-awesome.css',
    '../front/css/bootstrap-theme.css',
    '../front/css/main.css',
    '../front/css/dashboard-sidebar.css'
];

var frontJs = [
    'jquery/dist/jquery.js',
    'bootstrap/dist/js/bootstrap.js',
    'jquery-confirm/jquery.confirm.js',
    '../front/js/headroom.min.js',
    '../front/js/jQuery.headroom.min.js',
    '../front/js/template.js'
];

elixir(function(mix) {
    // build css and js for front and admin
    mix.styles(adminCss, 'public/css/admin.css', bowerDir)
        .scripts(adminJs, 'public/js/admin.js', bowerDir)
        .styles(frontCss, 'public/css/front.css', bowerDir)
        .scripts(frontJs, 'public/js/front.js', bowerDir)
        .version(['css/admin.css', 'js/admin.js', 'css/front.css', 'js/front.js'])
        .copy(bowerDir + 'font-awesome/fonts', 'public/build/fonts')
        .copy(bowerDir + 'bootstrap/fonts', 'public/build/fonts')
        .copy(bowerDir + '../front/images/bg_header.jpg', 'public/build/images')
        .copy(bowerDir + '../front/images/logo.png', 'public/build/images')
        .copy(bowerDir + 'admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js', 'public/js')
        .copy(bowerDir + 'admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css', 'public/css')
        .copy(bowerDir + 'ionicons/fonts', 'public/build/fonts')
        .copy(bowerDir + 'ionicons/png/512/*.png', 'public/build/png/512')
    ;
});
