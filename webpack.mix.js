const mix = require('laravel-mix');


// Main CSS
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();



//auth JS 
mix.js('resources/js/auth/js/app.js', 'public/js/auth/app.js').vue().version();
//auth CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/auth/style.css',
    ], 'public/css/auth/app.css').version();



//dashboard JS 
mix.js('resources/js/dashboard/js/app.js', 'public/js/dashboard/app.js')
    .vue().version();
//dashboard CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/dashboard/style.css',
    ], 'public/css/dashboard/app.css').version();

//*********Start super_admin *********Start
//super_admin JS 
mix.js('resources/js/super_admin/js/app.js', 'public/js/super_admin/app.js')
    .vue().version();
//super_admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/super_admin/style.css',
    ], 'public/css/super_admin/app.css').version();

//*********End super_admin *********End


// // *********Start Room *********Start

//room admin JS 
mix.js('resources/js/room/admin/js/app.js', 'public/js/room/admin/app.js')
    .vue().version(); 
//room admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/room/admin/style.css',
    ], 'public/css/room/admin/app.css').version();


//room user JS 
mix.js('resources/js/room/user/js/app.js', 'public/js/room/user/app.js')
    .vue().version();
//room user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/room/user/style.css',
    ], 'public/css/room/user/app.css').version();

// *********End Room *********End



// *********Start carpool *********Start

//carpool admin JS 
mix.js('resources/js/carpool/admin/js/app.js', 'public/js/carpool/admin/app.js')
    .vue().version();
    
//carpool admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/carpool/admin/style.css',
], 'public/css/carpool/admin/app.css').version();


//carpool user JS 
mix.js('resources/js/carpool/user/js/app.js', 'public/js/carpool/user/app.js')
    .vue().version();
    
//carpool user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/carpool/user/style.css',
    ], 'public/css/carpool/user/app.css').version();

// *********End carpool *********End



// *********Start SMS *********Start

//sms admin JS 
mix.js('resources/js/sms/admin/js/app.js', 'public/js/sms/admin/app.js')
    .vue().version(); 
//sms admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/sms/admin/style.css',
    ], 'public/css/sms/admin/app.css').version();


//sms user JS 
mix.js('resources/js/sms/user/js/app.js', 'public/js/sms/user/app.js')
    .vue().version();
//sms user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/sms/user/style.css',
    ], 'public/css/sms/user/app.css').version();

// *********End SMS *********End




// *********Start ivca *********Start

//ivca admin JS 
mix.js('resources/js/ivca/admin/js/app.js', 'public/js/ivca/admin/app.js')
    .vue().version();
    
//ivca admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/ivca/admin/style.css',
    ], 'public/css/ivca/admin/app.css').version();
    


//ivca user JS 
mix.js('resources/js/ivca/user/js/app.js', 'public/js/ivca/user/app.js')
    .vue().version();
    
//ivca user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/ivca/user/style.css',
    ], 'public/css/ivca/user/app.css').version();


// *********End ivca *********End




// *********Start cms *********Start

//cms admin_application JS 
mix.js('resources/js/cms/admin_application/js/app.js', 'public/js/cms/admin_application/app.js')
    .vue().version();
    
//cms admin_application CSS 
mix.styles([
       'resources/css/common/preloader.css',
    ], 'public/css/cms/admin_application/app.css').version();
    

//cms admin_hardware JS 
mix.js('resources/js/cms/admin_hardware/js/app.js', 'public/js/cms/admin_hardware/app.js')
    .vue().version();
    
//cms admin_hardware CSS 
mix.styles([
       'resources/css/common/preloader.css',
    ], 'public/css/cms/admin_hardware/app.css').version();
    


//cms user JS 
mix.js('resources/js/cms/user/js/app.js', 'public/js/cms/user/app.js')
    .vue().version();
    
//cms user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/cms/user/app.css').version();


// *********End cms *********End



// *********Start Inventory *********Start

//inventory admin JS 
mix.js('resources/js/inventory/admin/js/app.js', 'public/js/inventory/admin/app.js')
    .vue().version(); 
//inventory admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/inventory/admin/app.css').version();

// *********End Inventory *********End


// *********Start pbi *********Start

//pbi admin JS 
mix.js('resources/js/pbi/admin/js/app.js', 'public/js/pbi/admin/app.js')
    .vue().version(); 
//pbi admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/pbi/admin/app.css').version();


//pbi user JS 
mix.js('resources/js/pbi/user/js/app.js', 'public/js/pbi/user/app.js')
    .vue().version();
//pbi user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/pbi/user/app.css').version();

// *********End pbi *********End


// *********Start iTemp *********Start

//iTemp admin JS 
mix.js('resources/js/itemp/admin/js/app.js', 'public/js/itemp/admin/app.js')
    .vue().version(); 
//itemp admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/itemp/admin/app.css').version();


//iTemp user JS 
mix.js('resources/js/itemp/user/js/app.js', 'public/js/itemp/user/app.js')
    .vue().version();
//itemp user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/itemp/user/app.css').version();

// *********End itemp *********End



// *********Start network *********Start

//network admin JS 
mix.js('resources/js/network/admin/js/app.js', 'public/js/network/admin/app.js')
    .vue().version();
    
//network admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
], 'public/css/network/admin/app.css').version();

// *********End network *********End




//iaccess user JS 
mix.js('resources/js/iaccess/user/js/app.js', 'public/js/iaccess/user/app.js')
    .vue().version();
//iaccess user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/iaccess/user/app.css').version();


//iaccess admin JS 
mix.js('resources/js/iaccess/admin/js/app.js', 'public/js/iaccess/admin/app.js')
    .vue().version();
    
//iaccess admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
], 'public/css/iaccess/admin/app.css').version();

// *********End iaccess *********End


//mobile_app JS 
mix.js('resources/js/mobile_app/js/app.js', 'public/js/mobile_app/app.js')
    .vue().version();
//mobile_app CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/mobile_app/app.css').version();

// *********End mobile_app *********End




    