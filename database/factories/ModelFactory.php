<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\GitScrum\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\GitScrum\Models\Attachment::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Branch::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Comment::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Commit::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\CommitFile::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\CommitFilePhpc::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\ConfigIssueEffort::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\ConfigPriority::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\ConfigStatus::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Favorite::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Issue::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\IssueType::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Label::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Note::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Organization::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\ProductBacklog::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\PullRequest::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Sprint::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\Status::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\UserStat::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(\GitScrum\Models\UserStory::class, function (Faker\Generator $faker) {
    return [
    ];
});
