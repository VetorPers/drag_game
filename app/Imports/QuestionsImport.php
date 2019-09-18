<?php

namespace App\Imports;

use App\Pest;
use App\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

/**
 * Class QuestionsImport
 *
 * @package App\Imports
 */
class QuestionsImport implements ToCollection
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $k => $row) {
            if ( !$k) continue;
            $pest = $this->storePest($row);
            $question = $this->storeQuestions($pest->id, $row);
            $question->answers()->createMany($this->answers($row));
        }
    }

    /**
     * @param $row
     *
     * @return mixed
     */
    public function storePest($row)
    {
        return Pest::firstOrCreate([
            'name'      => $row[6],
            'tree_sign' => $row[5],
        ]);
    }

    /**
     * @param $pestId
     * @param $row
     *
     * @return mixed
     */
    public function storeQuestions($pestId, $row)
    {
        return Question::create([
            'pest_id' => $pestId,
            'title'   => $row[0],
            'type'    => $row[1],
            'desc'    => $row[2],
            'img'     => $row[3],
            'level'   => $row[4],
        ]);
    }

    /**
     * @param $row
     *
     * @return array
     */
    public function answers($row)
    {
        $answers = [];
        $c = count($row);
        for ($i = 7; $i <= $c; $i = $i + 2) {
            if ( !empty($row[$i])) {
                $answers[] = [
                    'title'    => $row[$i],
                    'is_right' => !empty($row[$i + 1]) && ((int)$row[$i + 1]) == 1 ? 1 : 0,
                ];
            }
        }

        return $answers;
    }
}
