<?php

//
// NOTE Migration Created: 2016-09-23 12:17:22
// --------------------------------------------------

class CreateDevelopDatabase {
//
// NOTE - Make changes to the database.
// --------------------------------------------------

public function up()
{

//
// NOTE -- attachments
// --------------------------------------------------

Schema::create('attachments', function($table) {
 $table->increments('id')->unsigned();
 $table->string('attachmentable_type', 45)->nullable();
 $table->unsignedInteger('attachmentable_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->string('filename_original', 255)->nullable();
 $table->string('filename_new', 255)->nullable();
 $table->string('mimetype', 60)->nullable();
 $table->decimal('size', 10,2)->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- branches
// --------------------------------------------------

Schema::create('branches', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('sprint_id')->nullable()->unsigned();
 $table->unsignedInteger('product_backlog_id')->nullable()->unsigned();
 $table->string('sha', 255)->nullable();
 $table->string('name', 255)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- comments
// --------------------------------------------------

Schema::create('comments', function($table) {
 $table->increments('id')->unsigned();
 $table->string('commentable_type', 45)->nullable();
 $table->unsignedInteger('commentable_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->text('comment')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('created_at')->nullable();
 });


//
// NOTE -- commit_file_phpcs
// --------------------------------------------------

Schema::create('commit_file_phpcs', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('commit_file_id')->nullable()->unsigned();
 $table->unsignedInteger('line')->nullable()->unsigned();
 $table->string('message', 255)->nullable();
 $table->string('type', 45)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 });


//
// NOTE -- commit_files
// --------------------------------------------------

Schema::create('commit_files', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('commit_id')->nullable()->unsigned();
 $table->string('sha', 255)->nullable();
 $table->string('filename', 255)->nullable();
 $table->string('status', 255)->nullable();
 $table->unsignedInteger('additions')->nullable()->unsigned();
 $table->unsignedInteger('deletions')->nullable()->unsigned();
 $table->unsignedInteger('changes')->nullable()->unsigned();
 $table->string('raw_url', 255)->nullable();
 $table->('raw')->nullable();
 $table->('phpcs')->nullable();
 $table->('patch')->nullable();
 $table->unsignedInteger('phploc_size')->nullable();
 $table->unsignedInteger('phploc_lines_of_code')->nullable();
 $table->decimal('phploc_lines_of_code_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_comment_lines_of_code')->nullable();
 $table->decimal('phploc_comment_lines_of_code_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_non-comment_lines_of_code')->nullable();
 $table->decimal('phploc_non-comment_lines_of_code_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_logical_lines_of_code')->nullable();
 $table->decimal('phploc_logical_lines_of_code_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_namespaces')->nullable();
 $table->unsignedInteger('phploc_interfaces')->nullable();
 $table->unsignedInteger('phploc_traits')->nullable();
 $table->unsignedInteger('phploc_classes')->nullable();
 $table->unsignedInteger('phploc_scope_non-static')->nullable();
 $table->unsignedInteger('phploc_scope_static')->nullable();
 $table->unsignedInteger('phploc_visibility_public')->nullable();
 $table->decimal('phploc_visibility_public_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_visibility_non-public')->nullable();
 $table->decimal('phploc_visibility_non-public_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_named_functions')->nullable();
 $table->decimal('phploc_named_functions_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_anonymous_functions')->nullable();
 $table->unsignedInteger('phploc_constants_global')->nullable();
 $table->decimal('phploc_constants_global_percent', 10,2)->nullable();
 $table->unsignedInteger('phploc_constants_class')->nullable();
 $table->decimal('phploc_constants_class_percent', 10,2)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- commits
// --------------------------------------------------

Schema::create('commits', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('product_backlog_id')->nullable()->unsigned();
 $table->unsignedInteger('branch_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('issue_id')->nullable()->unsigned();
 $table->string('sha', 255)->nullable();
 $table->string('url', 255)->nullable();
 $table->text('message')->nullable();
 $table->string('html_url', 255)->nullable();
 $table->timestamp('date')->nullable();
 $table->string('tree_sha', 255)->nullable();
 $table->string('tree_url', 255)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- config_statuses
// --------------------------------------------------

Schema::create('config_statuses', function($table) {
 $table->increments('id')->unsigned();
 $table->string('type', 45)->nullable();
 $table->string('name', 45)->nullable();
 $table->('position')->nullable();
 });


//
// NOTE -- issue_types
// --------------------------------------------------

Schema::create('issue_types', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('parent_id')->nullable()->unsigned();
 $table->string('alias', 45)->nullable();
 $table->string('name', 45)->nullable();
 $table->unsignedInteger('position')->nullable()->unsigned();
 $table->('enabled')->nullable()->default("1");
 });


//
// NOTE -- issues
// --------------------------------------------------

Schema::create('issues', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('issue_type_id')->nullable()->unsigned();
 $table->bigInteger('github_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('product_backlog_id')->nullable()->unsigned();
 $table->unsignedInteger('branch_id')->nullable()->unsigned();
 $table->unsignedInteger('sprint_id')->nullable()->unsigned();
 $table->unsignedInteger('number')->nullable()->unsigned();
 $table->unsignedInteger('effort')->nullable();
 $table->string('slug', 255)->nullable();
 $table->string('title', 255)->nullable();
 $table->text('description')->nullable();
 $table->string('state', 255)->nullable();
 $table->('status')->nullable()->unsigned();
 $table->unsignedInteger('position')->nullable()->unsigned();
 $table->timestamp('closed_at')->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('deleted_at')->nullable();
 });


//
// NOTE -- organizations
// --------------------------------------------------

Schema::create('organizations', function($table) {
 $table->increments('id')->unsigned();
 $table->bigInteger('github_id')->nullable()->unsigned()->unique();
 $table->string('login', 255)->nullable();
 $table->string('url', 255)->nullable();
 $table->string('repos_url', 255)->nullable();
 $table->string('events_url', 255)->nullable();
 $table->string('hooks_url', 255)->nullable();
 $table->string('issues_url', 255)->nullable();
 $table->string('members_url', 255)->nullable();
 $table->string('public_members_url', 255)->nullable();
 $table->string('avatar_url', 255)->nullable();
 $table->string('description', 255)->nullable();
 $table->string('name', 255)->nullable();
 $table->string('blog', 255)->nullable();
 $table->string('location', 255)->nullable();
 $table->string('email', 255)->nullable();
 $table->string('public_repos', 255)->nullable();
 $table->string('html_url', 255)->nullable();
 $table->unsignedInteger('total_private_repos')->nullable()->unsigned();
 $table->timestamp('since')->nullable();
 $table->unsignedInteger('disk_usage')->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- password_resets
// --------------------------------------------------

Schema::create('password_resets', function($table) {
 $table->string('email', 255);
 $table->string('token', 255);
 $table->timestamp('created_at');
 });


//
// NOTE -- pull_requests
// --------------------------------------------------

Schema::create('pull_requests', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('github_id')->nullable()->unsigned()->unique();
 $table->unsignedInteger('head_branch_id')->nullable()->unsigned();
 $table->unsignedInteger('base_branch_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable();
 $table->unsignedInteger('product_backlog_id')->nullable()->unsigned();
 $table->unsignedInteger('number')->nullable()->unsigned();
 $table->string('url', 255)->nullable();
 $table->string('html_url', 255)->nullable();
 $table->string('issue_url', 255)->nullable();
 $table->string('commits_url', 255)->nullable();
 $table->string('state', 255)->nullable();
 $table->string('title', 255)->nullable();
 $table->('body')->nullable();
 $table->timestamp('github_created_at')->nullable();
 $table->timestamp('github_updated_at')->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- pull_requests_has_commits
// --------------------------------------------------

Schema::create('pull_requests_has_commits', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('pull_request_id')->nullable()->unsigned();
 $table->unsignedInteger('commit_id')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- repositories
// --------------------------------------------------

Schema::create('product_backlogs', function($table) {
 $table->increments('id')->unsigned();
 $table->bigInteger('github_id')->nullable()->unsigned();
 $table->unsignedInteger('organization_id')->nullable()->unsigned();
 $table->string('name', 255)->nullable();
 $table->string('fullname', 255)->nullable();
 $table->boolean('private')->nullable();
 $table->string('html_url', 255)->nullable();
 $table->text('description')->nullable();
 $table->boolean('fork')->nullable();
 $table->string('url', 255)->nullable();
 $table->timestamp('since')->nullable();
 $table->timestamp('pushed_at')->nullable();
 $table->string('git_url', 255)->nullable();
 $table->string('ssh_url', 255)->nullable();
 $table->string('clone_url', 255)->nullable();
 $table->string('homepage', 255)->nullable();
 $table->string('default_branch', 255)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- sprints
// --------------------------------------------------

Schema::create('sprints', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('product_backlog_id')->nullable()->unsigned();
 $table->string('slug', 255);
 $table->string('name', 255)->nullable();
 $table->text('description')->nullable();
 $table->string('version', 10)->nullable();
 $table->date('date_start')->nullable();
 $table->date('date_finish')->nullable();
 $table->('state')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- statuses
// --------------------------------------------------

Schema::create('statuses', function($table) {
 $table->increments('id')->unsigned();
 $table->string('statusesable_type', 45)->nullable();
 $table->unsignedInteger('statusesable_id')->nullable()->unsigned();
 $table->('config_status_id')->nullable()->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- user_stats
// --------------------------------------------------

Schema::create('user_stats', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('code_lines')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 });


//
// NOTE -- users
// --------------------------------------------------

Schema::create('users', function($table) {
 $table->increments('id')->unsigned();
 $table->bigInteger('github_id')->nullable()->unique();
 $table->string('username', 255)->nullable()->unique();
 $table->string('name', 255);
 $table->string('avatar', 255)->nullable();
 $table->string('html_url', 255)->nullable();
 $table->string('email', 255);
 $table->string('password', 255);
 $table->string('remember_token', 100)->nullable();
 $table->string('bio', 255)->nullable();
 $table->string('location', 255)->nullable();
 $table->string('blog', 255)->nullable();
 $table->timestamp('since')->nullable();
 $table->string('token', 255)->nullable();
 $table->unsignedInteger('main_repository')->nullable()->unsigned();
 $table->rememberToken();
 $table->timestamps();
 });


//
// NOTE -- users_has_issues
// --------------------------------------------------

Schema::create('users_has_issues', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('issue_id')->nullable()->unsigned();
 $table->unsignedInteger('status')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- users_has_organizations
// --------------------------------------------------

Schema::create('users_has_organizations', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->unsignedInteger('organization_id')->nullable()->unsigned();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- attachments_foreign
// --------------------------------------------------

Schema::table('attachments', function($table) {
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- branches_foreign
// --------------------------------------------------

Schema::table('branches', function($table) {
 $table->foreign('product_backlog_id')->references('id')->on('product_backlogs');
 $table->foreign('sprint_id')->references('id')->on('sprints');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- comments_foreign
// --------------------------------------------------

Schema::table('comments', function($table) {
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- commit_file_phpcs_foreign
// --------------------------------------------------

Schema::table('commit_file_phpcs', function($table) {
 $table->foreign('commit_file_id')->references('id')->on('commit_files');
 });


//
// NOTE -- commit_files_foreign
// --------------------------------------------------

Schema::table('commit_files', function($table) {
 $table->foreign('commit_id')->references('id')->on('commits');
 });


//
// NOTE -- commits_foreign
// --------------------------------------------------

Schema::table('commits', function($table) {
 $table->foreign('branch_id')->references('id')->on('branches');
 $table->foreign('issue_id')->references('id')->on('issues');
 $table->foreign('product_backlog_id')->references('id')->on('product_backlogs');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- issues_foreign
// --------------------------------------------------

Schema::table('issues', function($table) {
 $table->foreign('branch_id')->references('id')->on('branches');
 $table->foreign('issue_type_id')->references('id')->on('issue_types');
 $table->foreign('product_backlog_id')->references('id')->on('product_backlogs');
 $table->foreign('sprint_id')->references('id')->on('sprints');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- pull_requests_foreign
// --------------------------------------------------

Schema::table('pull_requests', function($table) {
 $table->foreign('base_branch_id')->references('id')->on('branches');
 $table->foreign('head_branch_id')->references('id')->on('branches');
 $table->foreign('product_backlog_id')->references('id')->on('product_backlogs');
 });


//
// NOTE -- pull_requests_has_commits_foreign
// --------------------------------------------------

Schema::table('pull_requests_has_commits', function($table) {
 $table->foreign('commit_id')->references('id')->on('commits');
 $table->foreign('pull_request_id')->references('id')->on('pull_requests_has_commits');
 });


//
// NOTE -- repositories_foreign
// --------------------------------------------------

Schema::table('product_backlogs', function($table) {
 $table->foreign('organization_id')->references('id')->on('organizations');
 });


//
// NOTE -- sprints_foreign
// --------------------------------------------------

Schema::table('sprints', function($table) {
 $table->foreign('product_backlog_id')->references('id')->on('product_backlogs');
 });


//
// NOTE -- statuses_foreign
// --------------------------------------------------

Schema::table('statuses', function($table) {
 $table->foreign('id')->references('id')->on('config_statuses');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- users_has_issues_foreign
// --------------------------------------------------

Schema::table('users_has_issues', function($table) {
 $table->foreign('issue_id')->references('id')->on('issues');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- users_has_organizations_foreign
// --------------------------------------------------

Schema::table('users_has_organizations', function($table) {
 $table->foreign('organization_id')->references('id')->on('organizations');
 $table->foreign('user_id')->references('id')->on('users');
 });



}

//
// NOTE - Revert the changes to the database.
// --------------------------------------------------

public function down()
{

Schema::drop('attachments');
Schema::drop('branches');
Schema::drop('comments');
Schema::drop('commit_file_phpcs');
Schema::drop('commit_files');
Schema::drop('commits');
Schema::drop('config_statuses');
Schema::drop('issue_types');
Schema::drop('issues');
Schema::drop('organizations');
Schema::drop('password_resets');
Schema::drop('pull_requests');
Schema::drop('pull_requests_has_commits');
Schema::drop('product_backlogs');
Schema::drop('sprints');
Schema::drop('statuses');
Schema::drop('user_stats');
Schema::drop('users');
Schema::drop('users_has_issues');
Schema::drop('users_has_organizations');

}
}
