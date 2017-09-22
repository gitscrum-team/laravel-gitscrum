<?php

namespace GitScrum\Http\Responses\Issue;

use GitScrum\Classes\Helper;

class Store
{
    public function response($request,$issue)
    {
        return $request->ajax() ? $this->toAjax($request,$issue) : $this->toHtml($issue);
    }

    private function toHtml($issue)
    {
        return redirect()->route('issues.show', ['slug' => $issue->slug])
                         ->with('success', trans('gitscrum.congratulations-the-issue-has-been-created-with-successfully'));

    }

    private function toAjax($request,$issue)
    {
        $relation = $request->input('user_story_id') ? 'userStory' : 'sprint';

        $data = $this->data($relation,$issue->{$relation});

        return response()->json(['data' => $data , 'message' => trans('gitscrum.congratulations-the-issue-has-been-created-with-successfully') ]);
    }

    private function data($relation,$relationModel)
    {
        $data =  [
            'issueStatusChart' => view('partials.boxes.chart-donut', ['list' => $relationModel->issueStatus()])->render(),
            'issuesCount' => $relationModel->issues->count(),
            'issuesBox' => view('partials.boxes.issue', ['list' => $relationModel->issues, 'messageEmpty' => trans('gitscrum.this-does-not-have-any-issue-yet')])->render()
        ];

        return $relation == 'sprint' ? array_merge($data,$this->sprintData($relationModel)) : $data ;
    }

    private function sprintData($sprint)
    {
        return [
            'issueTypes' => view('partials.boxes.issue-type', ['list' => $sprint->issueTypes()])->render(),
            'issueBurndownChart' => view('partials.boxes.burndown', ['title' => ('Burndown Chart'), 'list' => Helper::burndown($sprint)])->render()
        ];
    }


}