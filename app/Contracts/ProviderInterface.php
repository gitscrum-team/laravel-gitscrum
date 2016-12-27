<?php

namespace GitScrum\Contracts;

interface ProviderInterface
{
    public function tplUser($obj);

    public function tplRepository($repo, $slug = false);

    public function tplIssue($obj, $productBacklogId);

    public function readRepositories();

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null);

    public function organization($login);

    public function readCollaborators($owner, $repo, $providerId = null);

    public function createBranches($owner, $product_backlog_id, $repo, $providerId = null);

    public function readIssues();

    public function createOrUpdateIssue($obj);

    public function createOrUpdateIssueComment($obj, $verb = 'POST');

    public function deleteIssueComment($obj);
}
