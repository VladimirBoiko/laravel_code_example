<?php

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

Route::group(['middleware' => 'activity'], function () {

    Route::get('/comments/{object}/{id}', 'CommentController@pagination')->name('comments.pagination');
    Route::get('/email/verified/{token}', 'Auth\RegisterController@emailVerified')->name('email_verified');
    Route::middleware(['guest'])->group(function () {
        Route::post('/login', 'Auth\LoginController@userLogin')->name('login');

        Route::group(['prefix' => 'password'], function () {
            Route::get('/update', 'Auth\ResetPasswordController@updateOldPassword')->name('get_update_password');
            Route::get('/new/{token}', 'Auth\ResetPasswordController@viewNewPassword')->name('update_old_password');
            Route::post('/new', 'Auth\ResetPasswordController@saveNewPassword')->name('save_new_password');
            Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
        });
    });

    Route::group(['prefix' => 'forum'], function () {
        Route::get('/', 'ForumController@index')->name('forum.index');
        Route::group(['prefix' => 'section'], function () {
            Route::get('/{name}', 'ForumController@section')->name('forum.section.index');
            Route::get('/{name}/pagination', 'ForumController@sectionPagination')->name('forum.section.pagination');
        });
        Route::group(['prefix' => 'topic'], function () {
            Route::get('search', 'ForumController@searchTopic')->name('forum.topic.search');
            Route::get('search/pagination',
                'ForumController@searchPaginationTopic')->name('forum.topic.search.pagination');

            /**reputation forum topic list*/
            Route::get('{id}/get_rating', 'TopicRatingController@getRating')->name('forum.topic.get_rating');
            Route::get('{id}/paginate', 'TopicRatingController@paginate')->name('forum.topic.paginate');

            Route::group(['middleware' => 'auth'], function () {
                Route::get('/my', 'ForumTopicController@getUserTopic')->name('forum.topic.my_list');
                Route::get('/create', 'ForumTopicController@create')->name('forum.topic.create');
                Route::post('/store', 'ForumTopicController@store')->name('forum.topic.store');
                Route::get('{id}/delete', 'ForumTopicController@destroy')->name('forum.topic.delete');
                Route::get('{id}/edit', 'ForumTopicController@edit')->name('forum.topic.edit');
                Route::post('{id}/update', 'ForumTopicController@update')->name('forum.topic.update');
                Route::post('{id}/rebase', 'ForumTopicController@rebase')->name('forum.topic.rebase');

                Route::group(['prefix' => 'comment'], function () {
                    Route::post('/store', 'TopicCommentController@store')->name('forum.topic.comment.store');
                    Route::get('{id}/delete', 'TopicCommentController@destroy')->name('forum.topic.comment.delete');
                    Route::post('{id}/update', 'TopicCommentController@update')->name('forum.topic.comment.update');
                });
            });
            Route::get('/{id}', 'ForumTopicController@index')->name('forum.topic.index');
        });
    });


    /**Admin Panel**/
    Route::group(['middleware' => ['auth', 'admin_panel'], 'prefix' => 'admin_panel', 'namespace' => 'Admin'],
        function () {
            Route::get('/', 'BaseController@index')->name('admin.home');
            Route::group(['prefix' => 'comment'], function () {
                Route::get('/{object_name}/{id}', 'CommentController@getComments')->name('admin.comments');
                Route::get('/{id}', 'CommentController@removeComment')->name('admin.comments.remove');
            });

            Route::group(['prefix' => 'forum'], function () {
                Route::get('/', 'ForumController@index')->name('admin.forum_sections');
                Route::get('/pagination', 'ForumController@pagination')->name('admin.forum_sections.pagination');
                Route::get('/add', 'ForumController@getSectionAdd')->name('admin.forum.section.add');
                Route::post('/add', 'ForumController@createSection')->name('admin.forum.section.create');
                Route::get('{id}/active', 'ForumController@active')->name('admin.forum.section.active');
                Route::get('{id}/unactive', 'ForumController@unactive')->name('admin.forum.section.not_active');
                Route::get('{id}/general', 'ForumController@general')->name('admin.forum.section.general');
                Route::get('{id}/not_general', 'ForumController@notGeneral')->name('admin.forum.section.not_general');
                Route::get('{id}/user_can', 'ForumController@userCan')->name('admin.forum.section.user_can');
                Route::get('{id}/user_not_can', 'ForumController@userNotCan')->name('admin.forum.section.user_not_can');
                Route::get('{id}/remove', 'ForumController@remove')->name('admin.forum.section.remove');
                Route::get('{id}/edit', 'ForumController@getSectionEdit')->name('admin.forum.section.edit');
                Route::post('{id}/edit', 'ForumController@saveSection')->name('admin.forum.section.edit.save');


                Route::group(['prefix' => 'topic'], function () {
                    Route::get('/', 'ForumTopicController@topics')->name('admin.forum_topic');
                    Route::get('/pagination', 'ForumTopicController@pagination')->name('admin.forum_topic.pagination');
                    Route::get('/add', 'ForumTopicController@getTopicAdd')->name('admin.forum.topic.add');
                    Route::post('/add', 'ForumTopicController@createTopic')->name('admin.forum.topic.create');
                    Route::get('/{id}/news', 'ForumTopicController@news')->name('admin.forum.topic.news');
                    Route::get('/{id}/not_news', 'ForumTopicController@notNews')->name('admin.forum.topic.not_news');
                    Route::get('/{id}/approve', 'ForumTopicController@approve')->name('admin.forum.topic.approve');
                    Route::get('/{id}/unapprove',
                        'ForumTopicController@unapprove')->name('admin.forum.topic.unapprove');
                    Route::get('/{id}/remove', 'ForumTopicController@remove')->name('admin.forum.topic.remove');
                    Route::get('/{id}/edit', 'ForumTopicController@getTopicEdit')->name('admin.forum.topic.edit');
                    Route::post('/{id}/edit', 'ForumTopicController@saveTopic')->name('admin.forum.topic.edit.save');
                    Route::get('/{id}', 'ForumTopicController@getTopic')->name('admin.forum.topic.get');
                    Route::post('/{id}/send_comment',
                        'TopicCommentController@sendComment')->name('admin.forum.topic.comment_send');
                });
            });
        });
});