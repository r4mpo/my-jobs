<?php

use App\Http\Controllers\Users\AuthController as Auth;
use App\Http\Controllers\Vacancies\VacanciesController as Vacancy;
use App\SwaggerComments as Swagger;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacanciesUsers\MyPublishedVacanciesController as MyPublishedVacancies;
use App\Http\Controllers\VacanciesUsers\VacanciesApplicationsController as Applications;
use App\Http\Controllers\Users\InfosController as Infos;
use App\Http\Controllers\Profiles\ProfilesController as Profiles;

Route::post('documentation', [Swagger::class, 'documentation'])->name('api.documentation.swagger');

Route::middleware(['api', 'permissions'])->group(function () {
    Route::group(['prefix' => 'vacancies'], function () {
        Route::get('/', [Vacancy::class, 'index'])->name('api.vacancies.index');
        Route::post('/', [Vacancy::class, 'store'])->name('api.vacancies.store');
        Route::get('/{vacancy}', [Vacancy::class, 'show'])->name('api.vacancies.show');
        Route::put('/{vacancy}', [Vacancy::class, 'update'])->name('api.vacancies.update');
        Route::delete('/{vacancy}', [Vacancy::class, 'destroy'])->name('api.vacancies.destroy');
    });

    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/', [Profiles::class, 'index'])->name('api.profiles.index');
        Route::post('/', [Profiles::class, 'store'])->name('api.profiles.store');
        Route::get('/{profile}', [Profiles::class, 'show'])->name('api.profiles.show');
        Route::put('/{profile}', [Profiles::class, 'update'])->name('api.profiles.update');
        Route::delete('/{profile}', [Profiles::class, 'destroy'])->name('api.profiles.destroy');
        Route::get('/assign_role_for_user/{user_id}', [Profiles::class, 'assignRoleForUser'])->name('api.profiles.assign_role_for_user');
    });

    Route::group(['prefix' => 'infos'], function () {
        Route::get('/', [Infos::class, 'index'])->name('api.infos.index');
        Route::post('/', [Infos::class, 'store'])->name('api.infos.store');
        Route::get('/{info}', [Infos::class, 'show'])->name('api.infos.show');
        Route::put('/{info}', [Infos::class, 'update'])->name('api.infos.update');
        Route::delete('/{info}', [Infos::class, 'destroy'])->name('api.infos.destroy');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [Auth::class, 'login'])->name('api.auth.login');
        Route::post('register', [Auth::class, 'create'])->name('api.auth.create');
        Route::post('logout', [Auth::class, 'logout'])->name('api.auth.logout');
        Route::post('refresh', [Auth::class, 'refresh'])->name('api.auth.refresh');
        Route::post('me', [Auth::class, 'me'])->name('api.auth.me');
        Route::get('infos/{user_id?}', [Auth::class, 'getInfos'])->name('api.auth.infos');
    });

    Route::group(['prefix' => 'vacancies_user'], function () {
        Route::get('my_published_vacancies', [MyPublishedVacancies::class, 'myPublishedVacancies'])->name('api.vacancies_user.my_published_vacancies');
        Route::get('my_applications_vacancies', [Applications::class, 'myApplications'])->name('api.vacancies_user.my_applications_vacancies');
        Route::get('to_apply_or_unapply/{vacancy_id}', [Applications::class, 'toApplyOrUnapply'])->name('api.vacancies_user.to_apply_or_unapply');
        Route::get('vacancy_applications/{vacancy_id}', [Applications::class, 'vacancyApplications'])->name('api.vacancies_user.vacancy_applications');
    });
});
