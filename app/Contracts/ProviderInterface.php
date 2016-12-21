<?php

namespace GitScrum\Contracts;

interface ProviderInterface
{
    public function templateUser($obj);

    public function templateRepository($repo, $slug = false);

    public function templateIssue($obj, $productBacklogId);

    public function readRepositories();

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null);

    public function organization($login);

    public function readCollaborators($owner, $repo);

    public function createBranches($owner, $product_backlog_id, $repo);

    public function readIssues();

    public function createOrUpdateIssue($obj);

    public function createOrUpdateIssueComment($obj, $verb = 'POST');

    public function deleteIssueComment($obj);
}
