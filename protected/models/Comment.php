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
			array('board_id, res_id, user_id, contents, created_at, del_flg', 'required'),
			array('board_id, res_id, user_id, del_flg', 'numerical', 'integerOnly'=>true),
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
			'author'=>array(self::BELONGS_TO,'Users','user_id'),
			'board'=>array(self::BELONGS_TO,'Board','board_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'board_id' => 'Board',
			'res_id' => 'Res',
			'user_id' => 'User',
			'contents' => 'Contents',
			'image_file_t' => 'Image File T',
			'image_file_o' => 'Image File O',
			'created_at' => 'Created At',
			'del_flg' => 'Del Flg',
		);
	}

	public function insertContens($id,$contents,$user_id)
	{
		$comment = new Comment;
		$comment->board_id = $id;
		$comment->contents = $contents;
		$comment->user_id = $user_id;
		$comment->save();
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