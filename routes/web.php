<?php
 use App\Http\Controllers\FormController;
use App\Http\Controllers\FormResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
   


});

Route::view('/form-builder', 'form-builder');
Route::post('/form/store', [FormController::class, 'store'])->name('forms.store');
Route::get('/forms/{slug}', [FormController::class, 'show'])->name('forms.show');
Route::post('/forms/{slug}', [FormController::class, 'submitResponse'])->name('forms.submit');
Route::get('/admin/forms/{slug}/responses', [FormController::class, 'responses'])->name('forms.responses');
Route::get('/admin/forms', [FormController::class, 'index'])->name('forms.index');
Route::post('/forms/{slug}/submit', [FormResponseController::class, 'store'])->name('forms.submit');



