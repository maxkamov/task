<?php

namespace app\controllers;

use app\models\Tag;
use app\models\TagAssign;
use Yii;
use app\models\Logo;
use app\models\search\LogoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LogoController implements the CRUD actions for Logo model.
 */
class LogoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Logo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        /*print_r(Yii::$app->request->queryParams);
        die;*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Logo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$_POST['Logo[image]']   $model->validate()
        $model = new Logo();

        $hold = array();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $images = UploadedFile::getInstances($model, 'image');

           // print_r($_POST['tags']);
           // die;

            foreach ($images as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
               // echo $file->baseName . '.' . $file->extension . "<br>";
                array_push($hold,$file->baseName . '.' . $file->extension);
            }

            /*print_r($hold);
            die;*/

            $model->image = json_encode($hold);
            $model->save();


            ////TAG ASSIGN////

            foreach ($_POST['tags'] as $tag){
                $tag_assign = new TagAssign();
                $tag_assign->logo_id = $model->id;

                if(!is_numeric($tag)){
                    $newTag = new Tag();
                    $newTag->name = $tag;
                    $newTag->save();
                    $tag_assign->tag_id = $newTag->id;
                }else{
                    $tag_assign->tag_id = $tag;
                }

                $tag_assign->save();
            }

            ///TAG ASSIGN////


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Logo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function existingTags($tags){

        $existingTags = array();

        foreach ($tags as $t){
            array_push($existingTags,$t['tag_id']);
        }

        return $existingTags;
    }



    public function handleTags($postedTags,$existingTags,$model){

        if(isset($postedTags)) {////TAG ASSIGN////


            foreach ($postedTags as $tag) {

                ///ALREADY EXISTS//
                if (!in_array($tag, $existingTags)) {
                    $tag_assign = new TagAssign();
                    $tag_assign->logo_id = $model->id;

                    if (!is_numeric($tag)) {
                        $newTag = new Tag();
                        $newTag->name = $tag;
                        $newTag->save();
                        $tag_assign->tag_id = $newTag->id;
                    } else {
                        $tag_assign->tag_id = $tag;
                    }

                    $tag_assign->save();
                }
                ///ALREADY EXISTS//

                //////DELETING EXTRA ASSIGNMents

                $result = array_diff($existingTags, $postedTags);

                foreach ($result as $r) {
                    $find = TagAssign::find()->where(['tag_id' => $r])->andWhere(['logo_id' => $model->id])->one();
                    if (!empty($find)) {
                        $find->delete();
                    }

                }

                //////DELETING EXTRA ASSIGNMents

            }

        }else{
            foreach ($existingTags as $r) {
                $find = TagAssign::find()->where(['tag_id' => $r])->andWhere(['logo_id' => $model->id])->one();
                if (!empty($find)) {
                    $find->delete();
                }
            }
        }///TAG ASSIGN////

    }


    public function handleImages($model){

        $hold = array();
        $images = UploadedFile::getInstances($model, 'image');

        foreach (Yii::$app->request->post()['OldImage'] as $old) {
            array_push($hold,$old);
        }

        foreach ($images as $file) {
            $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            array_push($hold,$file->baseName . '.' . $file->extension);
        }



        $model->image = json_encode($hold);

        $model->save();
    }





    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->image = json_decode($model->image);


        //////////////getting an existing tag assigns

        $existingTags = $this->existingTags($model->tagAssigns);

        //////////////getting an existing tag assigns


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $this->handleTags($_POST['tags'],$existingTags,$model);

            $this->handleImages($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'exist' => $existingTags
        ]);
    }

    /**
     * Deletes an existing Logo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Logo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Logo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Logo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
