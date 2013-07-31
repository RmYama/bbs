<?php

class BoardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_uploadDir;
	private $_tmpUploadDir;
	private $_imageUrl = 'http://localhost/bbs/images/tmp/';
	private $_imageValue;
	private $_model;

	public function init()
	{
		$this->_uploadDir = Yii::getPathOfAlias('webroot.images')."/";
		$this->_tmpUploadDir = Yii::getPathOfAlias('webroot.images')."/tmp/";
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$board=$this->loadModel();
		$comment=$this->newComment($board);

		$this->render('view',array(
			'model'=>$board,
			'comment'=>$comment,
		));
	}

	protected function newComment($board)
	{
		$comment=new Comment;
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($board->addComment($comment))
			{
				$this->refresh();
			}
		}
		return $comment;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Board();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['confirm']))
//		if(isset($_POST['Board']))
		{
			$model->attributes=$_POST['Board'];
			
			if($model->validate())
			{
				$file = CUploadedFile::getInstance($model,'image');
				if(!is_null($file)){
					$model->image = $this->uniqId.'.'.$file->extensionName;
					$file->saveAs($this->_tmpUploadDir.$model->image);
					$_POST['Board']['image'] = $this->_tmpUploadDir.$model->image;
					$model->image = $this->_imageUrl.$model->image;
					$model->dispImage($file);
				}
				$this->setPageState('create',$_POST['Board']);
				$this->render('confirm', compact('model'));
				return;
			}
/*
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
*/
		}else if (isset($_POST['back'])) {
			$model->attributes = $this->getPageState('create');


		}else if (isset($_POST['finish'])) {
			$model->attributes = $this->getPageState('create');
			var_dump($model->contents);
			var_dump($model->image);
			exit();
//			$this->_imageValue = $this->getPageState('create');
//			var_dump($this->_imageValue['image']);
//			exit();

			$model->save(false);
			$this->redirect(array('index'));
		}
		$this->render('_form',compact('model'));
/*
		$this->render('create',array(
			'model'=>$model,
		));
*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Board']))
		{
			$model->attributes=$_POST['Board'];
			if($model->validate())
			{
				if($file=CuploadedFile::getInstance($model, 'image'))
				{
					$file->saveAs($this->_uploadDir.$model->image);
				}
				$model->save(false);
				$this->redirect(array('index'));
			}
/*
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
*/
		}
		$this->render('_form', compact('model'));
/*
		$this->render('update',array(
			'model'=>$model,
		));
*/
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
//		$this->loadModel($id)->delete();
		$model = $this->loadModel();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		unlink($this->_uploadDir.$model->image);
		$model->delete();

		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'order'=>'id DESC',
			'with'=>'resCount',
		));

		$dataProvider=new CActiveDataProvider('Board',array(
			'pagination'=>array(
					'pageSize'=>10,
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Board('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Board']))
			$model->attributes=$_GET['Board'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Board the loaded model
	 * @throws CHttpException
	 */
/*
	public function loadModel($id)
	{
		$model=Board::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
*/

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				$id = $_GET['id'];
				$this->_model=Board::model()->findByPk($id);
			}
			if($this->_model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Board $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='board-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * ユニークなＩＤを作って、その値を返す
	*/
	protected function getUniqId()
	{
		return md5(uniqid(rand(),true));
	}
}
