<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\QuestionCategory;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{

    use Importable;

    /**
     * @var int
     */
    private int $rows = 0;
    /**
     * @var array
     */
    protected array $failures = [];

    /**
     * @param  array  $row
     * @return Question|null
     */
     public function model(array $row): ?Question
    {

        ++$this->rows;
        $questionCategory = QuestionCategory::where('title', $row['category'])->first();
        if ($questionCategory) {
            $slug = Str::slug($row['title']);
            $existingQuestion = Question::where("slug", $slug)->first();
            if ($existingQuestion) return  $existingQuestion;

            $options = [];

            for($i=1;$i<=4;$i++){
                if(isset($row["option$i"]) && $row["option$i"] !== ""){
                    $options[] = $row["option$i"];
                }
            }
            return new Question([
                'category_id' => $questionCategory->id,
                'title' => $row['title'],
                'slug' => Str::slug($row['title']),
                'description' => $row['description'],
                'options' => $options,
                'answer' => $row['answer'],
                'weightage' => (string) $row['weightage']
            ]);
        }
        return null;
    }

    /**
     * @param $data
     * @param $index
     * @return mixed
     */
    public function prepareForValidation($data, $index)
    {
        $data['option1'] = (string) ($data['option1'] ?? "");
        $data['option2'] = (string) ($data['option2'] ?? "");
        $data['option3'] = (string) ($data['option3'] ?? "");
        $data['option4'] = (string) ($data['option4'] ?? "");
        $data['answer'] = (string) ($data['answer'] ?? "");
        return $data;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'category' => 'required|exists:question_categories,title',
            'title' => "string|required|max:255",
            'description' => "string|nullable|max:5000",
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'string',
            'option4' => 'string',
            'answer' => 'required|string',
            'weightage' => 'required|in:5,10,15',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages(): array
    {
        return [
            'category_slug.exists' => 'The category slug does not exist in the question_categories table.',
        ];
    }

    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
