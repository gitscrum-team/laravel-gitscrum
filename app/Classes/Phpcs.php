<?php

namespace GitScrum\Classes;

use Storage;
use GitScrum\CommitFile;
use GitScrum\CommitFilePhpcs;

class Phpcs
{
    private $id;

    public function init($fileContents, $commitFileId)
    {
        $this->id = $commitFileId;
        $filename = uniqid(strtotime('now'), true);
        Storage::disk('local_tmp')->put($filename.'.php', $fileContents);
        $result = shell_exec('phpcs --report=diff '.storage_path('tmp').DIRECTORY_SEPARATOR.$filename.'.php 2>&1; echo $?');
        $this->addSuggestionFix($result);
        $result = shell_exec('phpcs '.storage_path('tmp').DIRECTORY_SEPARATOR.$filename.'.php 2>&1; echo $?');
        Storage::delete(storage_path('tmp').DIRECTORY_SEPARATOR.$filename.'.php');
        $this->convertToLines($result);
    }

    private function addSuggestionFix($result)
    {
        $arr = explode('<br />', nl2br($result));
        $data = [];
        $rows = array_slice($arr, 2, (count($arr) - 5));
        $row = str_replace('<br />', '', implode('<br />', $rows));
        $commit = CommitFile::find($this->id)->first();
        $commit->phpcs = $row;
        $commit->save();
    }

    private function addPhpcs($data)
    {
        $commitReturn = $commit = CommitFilePhpcs::where('commit_file_id', '=', $data['commit_file_id'])
            ->where('line', '=', $data['line'])
            ->first();
        if ($commit === null) {
            return $commit = CommitFilePhpcs::create($data);
        } else {
            $commit->update($data);

            return $commitReturn;
        }
    }

    private function convertToLines($result)
    {
        $arr = explode('<br />', nl2br($result));
        $data = [];
        $row = '';
        foreach ($arr as $value) {
            $cols = explode('|', $value);
            foreach ($cols as $col) {
                $row .= trim(str_replace(['[ ]', '[x]'], '', $col)).'|';
            }
        }
        $rows = explode('|', str_replace('|||', ' ', $row));
        $rows = array_slice($rows, 5, (count($rows) - 14));
        $i = 0;
        $columns = ['line', 'type', 'message'];
        foreach ($rows as $row) {
            $data[$columns[$i]] = $row;
            if ($i == 2) {
                $data['commit_file_id'] = $this->id;
                $this->addPhpcs($data);
                $i = 0;
            } else {
                ++$i;
            }
        }
    }
}
