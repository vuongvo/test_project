<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use backend\models\Cate;
use backend\models\CatePost;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
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
    public function beforeFilter()
    {

    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        */
        $query = Post::find();
        $pagination = new Pagination([
                    'defaultPageSize' => 5,
                    'totalCount' => $query->count(),
            ]);
        $Posts = $query->orderBy('name')
                        ->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->orderBy(['id' => SORT_DESC])
                        ->all();

        return $this->render('index', [
            'Posts' => $Posts,
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $model = new Post();
        $modelCate = new Cate();
        $baseUrl = Url::base(TRUE);
        // get data show select box
        $lists = Post::find()->select(['name','id'])->all();
        $postList = ArrayHelper::map($lists,'id','name');
        // get cate to save multiple
        //$cates = Cate::find()->select(['id','name'])->asArray()->all();
        $request = Yii::$app->request->post();
        if($model->load(Yii::$app->request->post())) {
            $name = $model->name;
            $checkName = Post::find()->select(['name'])
                                     ->where(['name' => $name])
                                     ->exists();
            if ($checkName == FALSE) {
                $desc = $model->description;
                // Upload image
                $imagePath = Yii::getAlias('@backend') .'/web/uploads/';
                $random = rand(1,9999);
                $image = UploadedFile::getInstance($model,'image');
                $model->image = ($image) ? $image->name.'_'.$random : NULL ;
                // Save Data  
                if ($model->save($model)) {
                    //$cateNames = $_POST['cate'] ? $_POST['cate'] : NULL ;
                   /* foreach ($cateNames as $cateName) {
                        $modelCatePost = new CatePost();
                        $modelCatePost->post_id = $model->id;
                        $modelCatePost->cate_id = $cateName;
                        $modelCatePost->created_at = date('11121315');
                        $modelCatePost->updated_at = "1231231";
                        $modelCatePost->save($modelCatePost);
                    }*/
                    $image->saveAs($imagePath.$model->image);
                    Yii::$app->getSession()->setFlash('message', 'Add success');    
                    return $this->redirect($baseUrl.'?r=post');  
                } 
            }
            else {
                 Yii::$app->getSession()->setFlash('error', 'Data exits, please try again');
            }
        }
        return $this->render('create',[
            'model' => $model,
            'postList' => $postList,
            //'cates' => $cates
        ]);
    }

  /*   public function actionCreate()
        {
            $model = new Post();

            if ($model->load(Yii::$app->request->post())) {
                $fileUpload = UploadedFile::getInstance($model, 'image');
                  $imagePath = Yii::getAlias('@backend') .'/web/uploads/';
                $random = rand(1,9999);
                $fileName = $random . $fileUpload->baseName . '.' . $fileUpload->extension;
                $model->image = $fileName;
                $model->save();
             
                    $fileUpload->saveAs($imagePath. $model->$fileName);
                    return $this->redirect(['view', 'id' => $model->id]);
                     
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
*/
    
    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $baseUrl = Url::base(true);
        $post = [];
        if ($id) {
            $post = Post::find()->where(['id' => $id])
                                ->asArray()
                                ->one();                  
            if (empty($post)) {
                return $this->redirect($baseUrl.'?r=post');
            }
            $request = Yii::$app->request->post();
            $model = new Post();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $checkExits = Post::find()->where(['name' => $model->name])
                                            ->andWhere(['!=','id',$id])
                                            ->exists();
                if ($checkExits == TRUE) {
                     Yii::$app->getSession()->setFlash('error', 'Data exits, please try again');
                }
                else {    
                    $data = Post::findOne($id);
                    $data->name = $model->name;
                    $data->description = $model->description; 
                    if ($data->update()) 
                        Yii::$app->getSession()->setFlash('message', 'Update Success');   
                        return $this->redirect($baseUrl.'?r=post');           
                }                          
            }
            return $this->render('/site/post/update',[
                'model' => $model, 
                'post' => $post
            ]);
        }
    }
        
    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
    **/

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
    * Ajax delete post
    *Params (int) id of Post
    */

    public function actionDelete_ajax()
    {
        if (Yii::$app->request->isAjax) {
            $model =  new Post();
            $id = Yii::$app->request->post('id');
            $checkId = Post::find()->where(['id' => $id])
                                    ->asArray()
                                    ->one();   
            if (!empty($checkId)) 
                $post = Post::findOne($id);
                $post->delete();
                Yii::$app->getSession()->setFlash('message', 'Delete Success');       
        }
    }

}
