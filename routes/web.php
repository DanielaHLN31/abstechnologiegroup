<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ClientController;
use App\Http\Controllers\Backend\CommandController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Middleware\LoginRedirectAfterAuthenticate;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Backend\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== ROUTES PUBLIQUES ====================
Route::middleware('guest')->group(function () {
    // Admin login
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login/store', [AuthController::class, 'LoginFormStore'])->name('login.Store');

    // Client login/register
    Route::get('/connexion', [AuthController::class, 'Clientlogin'])->name('client.login');
    Route::post('/client/login/store', [AuthController::class, 'ClientLoginFormStore'])->name('client.login.Store');
    Route::get('/register', [AdminController::class, 'register'])->name('client.register');
    Route::post('/register/store', [AuthController::class, 'registerFormStore'])->name('register.client.store');

    // Password reset
    Route::get('/password/forgot', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email.sent');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.modify');
});
Route::get('/politique-de-confidentialite' , function(){
    return view('politique-de-confidentialite');
});
// Route AJAX (publique)
Route::post('/check-user', [AuthController::class, 'checkUser'])->name('check.user');

// ==================== ROUTES CLIENT PUBLIQUES ====================
Route::prefix('client')->name('client.')->group(function () {
    // Pages publiques (accessibles sans connexion)
    Route::get('/index', [ClientController::class, 'index'])->name('index');
    Route::get('/about', [ClientController::class, 'about'])->name('about');
    Route::get('/product', [ClientController::class, 'product'])->name('product');
    Route::get('/products/{id}', [ClientController::class, 'show'])->name('product.detail');
    Route::get('/new', [ClientController::class, 'new'])->name('new');
    Route::get('/contact',[ClientController::class,'contact'])->name('contact');
    Route::get('/faqs', [ClientController::class, 'faqs'])->name('faqs');
    
    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
    
    // Cart (peut être publique ou protégée selon votre logique)
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    
    // Wishlist (protégée)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist')->middleware('auth.client');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add')->middleware('auth.client');
    Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('auth.client');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('auth.client');
    Route::get('/wishlist/ids', [WishlistController::class, 'ids'])->name('wishlist.ids')->middleware('auth.client');
});

// ==================== ROUTES CLIENT PROTÉGÉES ====================
Route::middleware(['auth.client'])->prefix('client')->name('client.')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

    // Mes commandes
    Route::get('/orders', [CheckoutController::class, 'myOrders'])->name('my.orders');
    Route::get('/orders/{orderNumber}', [CheckoutController::class, 'show'])->name('order.show');
    Route::patch('/orders/{orderNumber}/cancel', [CheckoutController::class, 'cancel'])->name('order.cancel');
    
    // Compte
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});
Route::middleware(['auth'])->post('/logout', [AdminController::class, 'logout'])->name('auth.logout');
// ==================== ROUTES ADMIN ====================
Route::middleware(['auth.admin'])->group(function () {
    // Logout (accessible depuis admin et client)

    // Dashboard
    Route::get('/dashboardVendors', [CommandController::class,'dashboardVendors'])->name('dashboardVendors');

    // Paramètres
    Route::get('/parametre', [AdminController::class, 'ViewParametre'])->name('parametre');
    Route::post('/user/profile/update', [AdminController::class, 'UserProfileStore'])->name('user.parametre.update');
    Route::post('/update-profile-image', [AdminController::class, 'UpdateProfileImage'])->name('update.profile.image');
    Route::get('/delete/image', [AdminController::class, 'DeleteProfileImage'])->name('delete.image');
    Route::get('/get/password', [AdminController::class, 'GetPassword'])->name('get.password');
    Route::post('/update-password', [AdminController::class, 'UpdatePassword'])->name('Password.update.profil');
    Route::get('/check-profile-photo-status', [AdminController::class, 'checkProfilePhotoStatus'])->name('check.profile.photo.status');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/all', [UserController::class, 'AllUsers'])->name('all.users');
        Route::get('/add', [UserController::class, 'AddUsers'])->name('add.users');
        Route::post('/store', [UserController::class, 'StoreUsers'])->name('store.users');
        Route::get('/{user}/edit',[UserController::class,'EditUsers'])->name('edit.users');
        Route::post('/update',[UserController::class,'UpdateUsers'])->name('update.users');
        Route::get('/delete/{id}',[UserController::class,'DeleteUsers'])->name('delete.users');
        Route::get('/inactive/{id}', [UserController::class, 'InactiveUsers'])->name('inactive.users');
        Route::get('/active/{id}', [UserController::class, 'ActiveUsers'])->name('active.users');
        Route::post('/check-email', [UserController::class, 'CheckEmailUsers'])->name('check.email');
        Route::get('/show/user/{id}', [UserController::class, 'ShowUsers'])->name('show.user');
        Route::post('/role/activate/{user}', [UserController::class, 'activateRole'])->name('role.activate');
    });

    // Roles
    Route::prefix('roles')->group(function (){
        Route::get('/all', [RoleController::class, 'AllRoles'])->name('all.roles');
        Route::get('/add', [RoleController::class, 'AddRoles'])->name('add.roles');
        Route::post('/store', [RoleController::class, 'StoreRoles'])->name('store.roles');
        Route::get('/{role}/edit', [RoleController::class, 'EditRoles'])->name('edit.roles');
        Route::post('/update', [RoleController::class, 'UpdateRoles'])->name('update.roles');
        Route::get('/delete/{id}', [RoleController::class, 'DeleteRoles'])->name('delete.roles');
        Route::get('/inactive/{id}', [RoleController::class, 'InactiveRoles'])->name('inactive.roles');
        Route::get('/active/{id}', [RoleController::class, 'ActiveRoles'])->name('active.roles');
    });

    // Products
    Route::prefix('products')->group(function (){
        Route::get('/all', [ProductController::class, 'Allproducts'])->name('all.products');
        Route::post('/store', [ProductController::class, 'Storeproducts'])->name('store.products');
        Route::get('/edit/{id}',[ProductController::class,'Editproducts'])->name('edit.products');
        Route::post('/update',[ProductController::class,'Updateproducts'])->name('update.products');
        Route::get('/{id}', [ProductController::class, 'ShowProduct'])->name('show.product');
        Route::delete('/{id}', [ProductController::class, 'DeleteProduct']);
        Route::post('/{id}/status', [ProductController::class, 'ToggleStatus']);
    });

    // Categories
    Route::prefix('category')->group(function (){
        Route::get('/all', [CategoryController::class, 'AllCategory'])->name('all.category');
        Route::post('/store', [CategoryController::class, 'StoreCategory'])->name('store.category');
        Route::get('/edit/{id}',[CategoryController::class,'EditCategory'])->name('edit.category');
        Route::post('/update',[CategoryController::class,'UpdateCategory'])->name('update.category');
        Route::get('/delete/{id}',[CategoryController::class,'DeleteCategory'])->name('delete.category');
        Route::get('/active/{id}', [CategoryController::class, 'ActiveCategory'])->name('active.category');
        Route::get('/inactive/{id}', [CategoryController::class, 'InactiveCategory'])->name('inactive.category');
        Route::get('/show/category/{id}', [CategoryController::class, 'ShowCategory'])->name('show.type.category');
    });

    // Brands
    Route::prefix('brand')->group(function (){
        Route::get('/all', [BrandController::class, 'AllBrand'])->name('all.brand');
        Route::post('/store', [BrandController::class, 'StoreBrand'])->name('store.brand');
        Route::get('/edit/{id}',[BrandController::class,'EditBrand'])->name('edit.brand');
        Route::post('/update',[BrandController::class,'UpdateBrand'])->name('update.brand');
        Route::get('/delete/{id}',[BrandController::class,'DeleteBrand'])->name('delete.brand');
        Route::get('/active/{id}', [BrandController::class, 'ActiveBrand'])->name('active.brand');
        Route::get('/inactive/{id}', [BrandController::class, 'InactiveBrand'])->name('inactive.brand');
        Route::get('/show/brand/{id}', [BrandController::class, 'ShowBrand'])->name('show.type.brand');
    });

    // Commandes
    Route::prefix('commandes')->group(function () {
        Route::get('/', [CommandController::class, 'index'])->name('commandes.index');
        Route::get('/{orderNumber}', [CommandController::class, 'show'])->name('commandes.show');
        Route::patch('/{orderNumber}/status', [CommandController::class, 'updateStatus'])->name('commandes.update-status');
        Route::post('/{orderNumber}/mark-paid', [CommandController::class, 'markPaid'])->name('commandes.mark-paid');
        Route::post('/{orderNumber}/start-processing', [CommandController::class, 'startProcessing'])->name('commandes.start-processing');
        
    });

    // Historiques
    Route::prefix('historique')->group(function () {
        Route::get('/command', [CommandController::class, 'historique'])->name('commandes.historique');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/count', [NotificationController::class, 'count'])->name('count');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
        Route::post('/{id}/read',[NotificationController::class, 'markRead'])->name('read');
    });

});

    // Paiements (protégés par auth)
    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::post('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
// ==================== WEBHOOK (PUBLIC) ====================
Route::post('/payment/webhook/fedapay', [PaymentController::class, 'webhook'])
    ->name('payment.webhook.fedapay')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);