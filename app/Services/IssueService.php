<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Services;

use Carbon\Carbon;
use GitScrum\Http\Requests\IssueRequest;
use GitScrum\Models\ConfigStatus;
use GitScrum\Models\Issue;
use Auth;

class IssueService extends Service
{
    public function create(IssueRequest $request)
    {
        $issue = Issue::create($request->all());
        $this->syncUsers($request, $issue);

        return $issue;
    }

    public function update(IssueRequest $request)
    {
        $issue = Issue::slug($request->slug)->first();
        $issue->update($request->all());
        $this->syncUsers($request, $issue);

        return $issue;
    }

    public function updateStatus(Issue $issue = null, $status = null, $position = null)
    {
        if (is_null($issue)) {
            $issue = Issue::slug($this->getRequest()->slug)
                ->firstOrFail();
        }

        return $this->saveStatus($issue, $status, $position);
    }

    public function updateStatusByJson()
    {
        $request = $this->getRequest();
        $status = ConfigStatus::find($request->status_id);

        $position = 1;

        try {
            foreach (json_decode($request->json) as $id) {
                $issue = Issue::find($id);
                $this->updateStatus($issue, $status, $position);
                ++$position;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function saveStatus(Issue $issue, ConfigStatus $configStatus = null, $position = null)
    {
        $issue->config_status_id = $this->getRequest()->status_id;

        if (!empty($configStatus->is_closed) && is_null($issue->closed_at)) {
            $issue->closed_user_id = Auth::id();
            $issue->closed_at = Carbon::now();
        } elseif (empty($configStatus->is_closed)) {
            $issue->closed_user_id = null;
            $issue->closed_at = null;
        }

        if (!is_null($position)) {
            $issue->position = $position;
        }

        return $issue->save();
    }

    private function syncUsers(IssueRequest $request, Issue $issue)
    {
        if (is_array($request->members)) {
            $issue->users()->sync($request->members);
        }
    }
}
