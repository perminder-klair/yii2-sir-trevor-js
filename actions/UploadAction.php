<?php

namespace kato\sirtrevorjs\actions;

use Yii;
use yii\helpers\Inflector;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class SirTrevorUploadAction
 * @package kato\sirtrevorjs\actions
 *
 * TODO: Create MEDIA Model
 * @var $media \app\frontend\Media
 */

class UploadAction extends \yii\base\Action
{

    /**
     * Uploads the file and update database
     */
    public function run()
    {
        $file = UploadedFile::getInstanceByName('attachment[file]');

        $result = $this->insertMedia($file);

        $response = new Response();
        $response->setStatusCode(200);
        $response->format = Response::FORMAT_JSON;

        if ($result['success'] === true) {

            $response->setStatusCode(200);
            $response->data = [
                'file' => [
                    'url' => '/' . $result['data']['source'],
                    'media_id' => $result['data']['id'],
                ],
            ];
            $response->send();
        } else {
            $response->statusText = $result['message'];
            $response->setStatusCode(500);
            $response->send();
            Yii::$app->end();
        }
    }

    private function insertMedia($file)
    {
        /**
         * @var \yii\web\UploadedFile $file
         */

        $result = ['success' => false, 'message' => 'File could not be saved.'];

        if ($file->size > Yii::$app->params['maxUploadSize']) {
            $result['message'] = 'Max upload size limit reached';
        }

        $uploadTime = date("Y-m-W");
        $media = new Media(); //TODO create your own model active record

        $media->filename = Inflector::slug(str_replace($file->extension, '', $file->name)) . '.' . $file->extension;
        $media->mimeType = $file->type;
        $media->byteSize = $file->size;
        $media->extension = $file->extension;
        $media->source = basename(\Yii::$app->params['uploadPath']) . '/' . $uploadTime . '/' . $media->filename;


        if (!is_file($media->source)) {
            //If saved upload the file
            $uploadPath = \Yii::$app->params['uploadPath'] .  $uploadTime;
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

            if ($file->saveAs($uploadPath . '/' . $media->filename)) {
                //Save to media table
                if ($media->save(false)) {
                    $result['success'] = true;
                    $result['message'] = 'Upload Success';
                    $result['data'] = $media;
                } else {
                    $result['message'] = "Database record could not be saved.";
                }
            } else {
                $result['message'] = "File could not be saved.";
            }
        } else {
            $result['message'] = "File already exists.";
        }

        return $result;
    }
}
