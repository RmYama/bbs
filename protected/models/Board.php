<?php

/**
 * This is the model class for table "board".
 *
 * The followings are the available columns in table 'board':
 * @property integer $id
 * @property string $title
 * @property string $created_at
 */
class Board extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Board the static model class
	 */

	public $nickname;
	public $contents;
	public $image;
	public $fileType;
	public $fileWidth;
	private $_newImage;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'board';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$file = array(
			'image',
			'file',
			'types'=>'jpg,png,gif',
			'maxSize'=>1024*1024*1,
			'message'=>'{attribute}が未選択です',
			'tooLarge'=>'{attribute}のファイルサイズが大きすぎます',
			'wrongType'=>'{attribute}には {extensions} 以外のファイルはアップロードできません',
			'on'=>'insert',
		);

		return array(
			array('title, contents', 'required'),
			array('title', 'length', 'max'=>128),
			$file,
			array_merge($file,array('on'=>'update','allowEmpty'=>true)),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, created_at', 'safe', 'on'=>'search')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Comments'=>array(self::HAS_MANY,'Comment','board_id'),
			'resCount'=>array(self::STAT,'Comment','res_id','condition'=>'res_id > 0'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'id' => 'ID',
			'title' => 'タイトル',
			'nickname' => 'ニックネーム',
			'contents' => 'コメント',
			'image' => '画像',
//			'created_at' => 'Created At',
		);
	}



	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->title=htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
			$this->contents=htmlspecialchars($this->contents, ENT_QUOTES, 'UTF-8');
			return true;
		}else{
			return false;
		}
	}

	protected function afterSave()
	{
		var_dump($this->image);
		exit();
		parent::afterSave();
		Comment::model()->insertContens($this->id,$this->contents,Yii::app()->user->id,$this->image);
	}

	public function dispImage($file)
	{
		$this->fileType = $file->getType();

		switch($this->fileType){
			case "image/jpeg" || "image/pjpeg":
				$this->_newImage = ImageCreateFromJPEG($this->image);
				break;
			case "image/gif":
				$this->_newImage = ImageCreateFromGIF($this->image);
				break;
			default:
				exit();
		}

		$this->fileWidth = imageSx($this->_newImage);

		if($this->fileWidth > 700)
		{
			$this->fileWidth = 700;
		}
	}
}