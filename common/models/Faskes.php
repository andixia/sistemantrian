<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faskes".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tipe
 * @property integer $kecamatan
 *
 * @property Kecamatan $kecamatan0
 */
class Faskes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faskes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'tipe'], 'required'],
            [['kecamatan'], 'integer'],
            [['nama', 'tipe'], 'string', 'max' => 50],
            [['kecamatan'], 'exist', 'skipOnError' => true, 'targetClass' => Kecamatan::className(), 'targetAttribute' => ['kecamatan' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'tipe' => 'Tipe',
            'kecamatan' => 'Kecamatan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKecamatan0()
    {
        return $this->hasOne(Kecamatan::className(), ['id' => 'kecamatan']);
    }
}
