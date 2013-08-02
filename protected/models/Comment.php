<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property integer $board_id
 * @property integer $res_id
 * @property integer $user_id
 * @property string $contents
 * @property string $image_file_t
 * @property string $image_file_o
 * @property string $created_at
 * @property integer $del_flg
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */

	public $title;
	public $nickname;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('board_id, res_id, user_id, contents', 'required'),
			array('board_id, res_id, user_id', 'numerical', 'integerOnly'=>true),
			array('image_file_t, image_file_o', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, board_id, res_id, user_id, contents, image_file_t, image_file_o, created_at, del_flg', 'safe', 'on'=>'search'),
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
			'author'=>array(self::BELONGS_TO, 'Users', 'user_id'),
			'board'=>array(self::BELONGS_TO,'Board','board_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title' => 'タイトル',
			'contents' => 'コメント',
			'id' => 'ID',
			'board_id' => 'Board',
			'res_id' => 'Res',
			'user_id' => 'User',
			'nickname' => 'ニックネーム',
			'image_file_t' => 'Image File T',
			'image_file_o' => 'Image File O',
			'created_at' => '投稿日',
			'del_flg' => 'Del Flg',
		);
	}

	public function getUrl($mode)
	{

		if($mode==0)
		{
			//編集
			return Yii::app()->createUrl('comment/update', array(
				'id'=>$this->id,
			));

		}elseif($mode==1){
			return Yii::app()->createUrl('comment/view', array(
				'id'=>$this->id,
			));
		}
/*

		if($board===null)
		{
			$board=$this->board;
		}

		return $board->url.'#c'.$this->id;
*/
	}

	public function insertContens($id,$contents,$user_id,$org_image_path)
	{
		$comment = new Comment;
		$comment->board_id = $id;
		$comment->res_id = 0;
		$comment->contents = $contents;
		$comment->image_file_o = $org_image_path;
		$comment->user_id = $user_id;
		$comment->del_flg = 0;
		$comment->save();
	}

	public function getNickname($user_id)
	{

		$criteria=new CDbCriteria;
		$criteria->select='nickname';
		$criteria->condition='id=:user_id';
		$criteria->params=array(':user_id'=>$user_id);
		$users=Users::model()->find($criteria);
		$nickname=$users->nickname;
		return $nickname;
	}



	public function getTitle($board_id)
	{
		$board=Board::model()->findByPk($board_id);
		$title=$board->title;
		return $title;
	}

	public function getMaxResNum()
	{
		$criteria=new CDbCriteria;
		$criteria->select='MAX(res_id) as res_id';
		$criteria->condition='board_id=:board_id';
		$criteria->params=array(':board_id'=>$this->board_id);
		$comment=Comment::model()->find($criteria);
		$cnt=$comment->res_id;

		return $cnt+1;
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
		$criteria->compare('board_id',$this->board_id);
		$criteria->compare('res_id',$this->res_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('contents',$this->contents,true);
		$criteria->compare('image_file_t',$this->image_file_t,true);
		$criteria->compare('image_file_o',$this->image_file_o,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('del_flg',$this->del_flg);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}