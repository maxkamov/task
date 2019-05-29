<?php
/**
 * Created by PhpStorm.
 * User: akmal
 * Date: 28.05.2019
 * Time: 21:55
 */

namespace app\modules\api\controllers;


use app\models\Logo;
use app\models\search\LogoSearch;
use Yii;


class LogosController extends \yii\rest\ActiveController
{

    public $modelClass = 'app\models\Logo';



    public function actionSearch(){

        $temp = array();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $searchModel = new LogoSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getBodyParams());


        if(Yii::$app->request->isPost){

            foreach ($dataProvider->getModels() as $model){

                array_push($temp,
                    [
                        'id'=>$model->id,
                        'name'=>$model->name,
                        'image'=>$model->image,
                        'category_id'=>$model->category_id
                    ]
                );
            }

        }

        return json_encode($temp);
    }




    public function actionDownload(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;




        if(Yii::$app->request->isPost){

            $pictureName = Yii::$app->getRequest()->getBodyParams();

            $path = Yii::getAlias('@webroot') . '/uploads';


            $file = $path . '/'.$pictureName['picture'];


            if (file_exists($file)) {

                return Yii::$app->response->sendFile($file);

            }else{
                return "File doesnt exist";
            }


        }

        return 0;

    }







}