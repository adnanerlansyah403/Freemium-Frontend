<?php

use App\Http\Livewire\User\Article;

// livewire
use App\Http\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\User\EditArticle;
use App\Http\Controllers\ArticleController;

// dipakai
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Article\CreateArticle;

// !dipakai
use App\Http\Controllers\MyArticleController;
use App\Http\Controllers\TransactionController;

// Admin
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("pages.frontend.article.list");
})->name('homepage');

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::get('/logout', function () {

})->name('logout');

// //backend user
// Route::prefix('user')
//     ->name('user.')
//     ->controller(UserController::class)
//     ->group(function () {
//         Route::get('/', 'list')->name('list')->middleware('withauth');
//         Route::get('/editdetail/{id}', 'editdetail')->name('editdetail')->middleware('withauth');
//         Route::post('/update/{id}', 'update')->name('update')->middleware('withauth');
//         Route::get('/create', 'create')->name('create');
//         Route::post('/add', 'add')->name('add');
//     });


// Route::get("/test", Test::class)->name('test');

// //backend category
// Route::prefix('category')
// ->name('category.')
// ->controller(CategoryController::class)
// ->group(function () {
//     Route::get('/', 'list')->name('list')->middleware('withauth');
//     Route::get('/editdetail/{id}', 'editdetail')->name('editdetail')->middleware('withauth');
//     Route::post('/update/{id}', 'update')->name('update')->middleware('withauth');
//     Route::get('/create', 'create')->name('create');
//     Route::post('/add', 'add')->name('add');
// });

// //frontend article
Route::prefix('article')
    ->name('article.')
    ->controller(ArticleController::class)
    ->group(function () {
        Route::get('/', 'list')->name('list');
        // Route::get('/create', 'create')->name('create');
        Route::get('/detail/{id}', 'show')->name('show');

        Route::post('/add', 'add')->name('add');
        Route::post('/delete/{id}', 'delete')->name('delete');
        Route::post('/update/{id}', 'update')->name('update');
    });

// Route::get("/article/create", CreateArticle::class)->name('article.create');

// //frontend authentication
// Route::any('/login', [AuthController::class, 'login'])->name('login')->middleware('noauth');
// Route::any('/logout', [AuthController::class, 'logout']) ->name('logout')->middleware('withauth');
// Route::any('/register', [AuthController::class, 'register']) ->name('register')->middleware('withauth');

// //frontend author
// Route::prefix('myarticle')
//     ->name('myarticle.')
//     ->controller(MyArticleController::class)
//     ->group(function () {
//         Route::get('/', 'index')->name('index');

//     });

Route::get("/profile", Profile::class)->name('profile.index');

Route::get("/myarticle", Article::class)->name('article.index');
Route::get('/article/edit/{id}', EditArticle::class)->name('article.edit');
Route::get('/article/create', CreateArticle::class)->name('article.create');

//frontend profile
// Route::prefix('profile')
//     ->name('profile.')
//     ->controller(ProfileController::class)
//     ->group(function () {
//         Route::get('/', 'index')->name('index');

//     });

//frontend subscription
Route::prefix('transaction')
    ->name('transaction.')
    ->controller(TransactionController::class)
    ->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/details', 'show')->name('show');

    });





// Backend Routes

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::prefix('dashboard')
            ->name('dashboard.')
            ->controller(DashboardController::class)
            ->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::get("/categories", function () {
            return view("pages.admin.category.list");
        })->name('categories.index');

        Route::get("/plans", function () {
            return view("pages.admin.plan.list");
        })->name('plans.index');
        Route::get("/users", function () {
            return view("pages.admin.user.list");
        })->name('users.index');

});
