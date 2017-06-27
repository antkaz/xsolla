<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;
use yii\helpers\FileHelper;

/**
 * @property int $file_id
 * @property int $user_id
 * @property string $filename
 */
class File extends ActiveRecord
{

    CONST SCENARIO_UPDATE = 'update';

    public $text;
    /**
     * User directory for files
     * 
     * @var strind
     */
    private $path;

    public function init()
    {
        parent::init();
        
        $this->path = Yii::getAlias('@app/' . Yii::$app->params['uploadDir']) . Yii::$app->user->identity->username . '/';
        $this->user_id = Yii::$app->user->id;
        $filename = (explode('/', $this->filename));
        $this->filename = array_pop($filename);
    }

    public static function tableName()
    {
        return '{{%file}}';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['filename', 'text'],
            self::SCENARIO_UPDATE => ['text'],
        ];
    }

    public function rules()
    {
        return [
            [['filename', 'text'], 'required', 'on' => self::SCENARIO_DEFAULT],
            ['text', 'required', 'on' => self::SCENARIO_UPDATE],
            ['filename', 'unique', 'on' => self::SCENARIO_DEFAULT],
            ['user_id', 'safe'],
            [['filename', 'text'], 'string', 'on' => self::SCENARIO_DEFAULT],
            [['user_id'], 'exist', 'targetClass' => User::classname()],
        ];
    }

    public function fields()
    {
        if (Yii::$app->controller->action->id == 'view') {
            return ['file_id', 'filename', 'text'];
        } else {
            return ['file_id', 'filename'];
        }
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            return $this->createFile();
        } else {
            return $this->updateFile();
        }
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (file_exists($this->path . $this->filename)) {
            return unlink($this->path . $this->filename);
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        if (Yii::$app->controller->action->id == 'view') {
            if (!file_exists($this->path . $this->filename)) {
                throw new \yii\base\Exception('The file does not exist');
            }

            $this->text = file_get_contents($this->path . $this->filename);
        }
    }

    /**
     * Returns file metadata (filename, size, updated, myme_type, md5_hash)
     * 
     * @return array File metadata
     * @throws \yii\web\NotFoundHttpException
     */
    public function getMeta()
    {
        $path = $this->path . $this->filename;
        if (!file_exists($path)) {
            throw new \yii\web\NotFoundHttpException('The file does not exist');
        }

        $meta = [];
        $meta['name'] = $this->filename;
        $meta['size'] = filesize($path);
        $meta['updated'] = date("d.m.Y H:i:s", filemtime($path));

        $finfo = finfo_open(FILEINFO_MIME);
        $meta['mime_type'] = finfo_file($finfo, $path);
        $meta['md5_hash'] = md5_file($path);

        return $meta;
    }

    /**
     * Creates a file and writes data to it
     * 
     * @return boolean TRUE if created file, or FALSE if file is not created
     */
    private function createFile() : bool
    {

        if (!FileHelper::createDirectory($this->path)) {
            return false;
        }

        if (file_exists($this->path . $this->filename)) {
            return false;
        }

        if (!file_put_contents($this->path . $this->filename, $this->text)) {
            return false;
        }

        return true;
    }

    /**
     * Updated data in a file
     * 
     * @return boolean TRUE if data updated, or FALSE
     */
    private function updateFile()
    {
        if (!file_exists($this->path . $this->filename)) {
            return false;
        }

        if (!file_put_contents($this->path . $this->filename, $this->text)) {
            return false;
        }

        return true;
    }

}
