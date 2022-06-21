<?php

namespace app\services;

use Yii;
use app\models\User;
use app\models\Customs;
use app\models\CustomEditForm;
use app\models\Pages;
use app\models\PageEditFormModel;
use app\models\QuestionsForm;
use app\models\Questions;
use app\services\HelperService;


class QuestionService
{
    function addQuestion(QuestionsForm $QuestionsFormModel)
    {
        $question = new Questions();

        $question->question_dt_add = (new HelperService())->getCurrentDate();
        $question->user_name = $QuestionsFormModel->user_name;
        $question->form_content = $QuestionsFormModel->form_content;

        if ($QuestionsFormModel->user_email) {
            $question->user_email = $QuestionsFormModel->user_email;
        } else {
            $question->user_email = 'Ответ не требуется';
        }

        foreach ($QuestionsFormModel->files as $file) {
            $file_path = uniqid('file_') . '.' . $file->extension;
            $file->saveAs(Yii::getAlias('@webroot') . '/upload/files/' . $file_path);

            // $task_file = new TasksFiles;
            // $task_file->link = $file_path;
            // $task_file->task_id = $task_id;
            // $task_file->save();
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $question->save();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }
}
