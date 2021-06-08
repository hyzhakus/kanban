<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $role
 *
 * @property Task[] $tasks
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    CONST ROLE_USER  = 1;
    CONST ROLE_ADMIN = 2;
    CONST ROLE_OWNER = 3;

    public $avatar;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'role'], 'required'],
            [['password'], 'required', 'on'=>'create'],
            [['email', 'name'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min'=>8],
            [['role'], 'integer'],
            [['role'], 'in', 'range' => array_keys(self::getList('role'))],
            [['role'], 'default', 'value' => self::ROLE_USER],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'E-Mail'),
            'password' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'avatar' => Yii::t('app', 'Avatar'),
        ];
    }

    public function store() {
        if($res = $this->save()) {
            if($file = UploadedFile::getInstance($this, 'avatar')) {
                $filepath = Yii::getAlias('@app/web/uploads/') . md5($this->id) . '.png';
                $file->saveAs($filepath);
            }
        }
        return $res;
    }

    public function beforeSave($insert)
    {
        if( !empty($this->password) ) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        } else {
            unset($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
    }

    /**
      * Finds an identity by the given ID.
      * @param string|int $id the ID to be looked for
      * @return IdentityInterface|null the identity object that matches the given ID.
      * Null should be returned if such an identity cannot be found
      * or the identity is not in an active state (disabled, deleted, etc.)
      */
    public static function findIdentity($id)
    {
        return static::findOne($id);;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * The returned key is used to validate session and auto-login (if [[User::enableAutoLogin]] is enabled).
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string|null a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return true;
    }

    /**
     * Validates the given auth key.
     *
     * @param string $authKey the given auth key
     * @return bool|null whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
        return static::findOne(['email'=>$email]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \password_verify($password, $this->password);
    }

    public static function getList($name = null, $value = null)
    {
        switch($name) {
            case 'role':
            case null:
                $items = [
                    self::ROLE_USER  => Yii::t('app', 'Developer'),
                    self::ROLE_ADMIN => Yii::t('app', 'Customer'),
                    self::ROLE_OWNER => Yii::t('app', 'Manager'),
                ];
                break;
            default:
                throw new \Exception(Yii::t('app', 'User model: Error list type.'));

        }
        return is_null($value) ? $items : ( $items[$value] ?? \Yii::$app->formatter->nullDisplay );
    }

}
