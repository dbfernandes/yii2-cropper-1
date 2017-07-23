# Yii2 Image Cropper InputWidget

Forked from Ercan Bilgin (bilginnet@gmail.com).
Original repository: bilginnet/yii2-cropper.

Features
------------
+ Crop
+ Image Rotate
+ Image Flip
+ Image Zoom
+ Coordinates
+ Image Sizes Info
+ Base64 Data

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dbfernandes/yii2-cropper-cb "dev-master"
```

or add

```
"dbfernandes/yii2-cropper-cb": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Let's add into config in your main-local config file before return[]
````php
       $baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());
       $baseUrl = str_replace('/frontend/web', '', $baseUrl);

       Yii::setAlias('@uploadUrl', $baseUrl.'/uploads/');
       Yii::setAlias('@uploadPath', realpath(dirname(__FILE__).'/../../uploads/'));
       // image file will upload in //root/uploads   folder

       return [
           ....
       ]
````

Let's add  in your model file
````php
    public $_image

    public function rules()
    {
        return [
            ['_image', 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (is_string($this->_image) && strstr($this->_image, 'data:image')) {

            // creating image file as png
            $data = $this->_image;
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            $fileName = time() . '-' . rand(100000, 999999) . '.png';
            file_put_contents(Yii::getAlias('@uploadPath') . '/' . $fileName, $data);


            // deleting old image
            // $this->image is real attribute for filename in table
            // customize your code for your attribute            
            if (!$this->isNewRecord && !empty($this->image)) {
                unlink(Yii::getAlias('@uploadPath/'.$this->image));
            }

            // set new filename
            $this->image = $fileName;
        }

        return parent::beforeSave($insert);
    }
````



Advanced usage in _form file
-----
````php
 echo $form->field($model, '_image')->widget(\dbfernandes\cropper\Cropper::className(), [
    'cropperOptions' => [
        'width' => 100, // must be specified
        'height' => 100, // must be specified

        // optional
        // url must be set in update action
        'preview' => [
            'url' => '', // set in update action // (!$model->isNewRecord) ? Yii::getAlias('@uploadUrl/$model->image') : ''
            'width' => 100, // default 100 // default is cropperWidth if cropperWidth < 100
            'height' => 100, // Will calculate automatically by aspect ratio if not set
        ],

        // optional // defaults following code
        // you can customize
        'icons' => [
            'browse' => '<i class="fa fa-image"></i>',
            'crop' => '<i class="fa fa-crop"></i>',
            'close' => '<i class="fa fa-crop"></i>',
        ]
    ],

    // optional // defaults following code
    // you can customize
    'label' => '$model->attribute->label',

 ]);
````


Simple usage in _form file
-----
````php
 echo $form->field($model, '_image')->widget(\dbfernandes\cropper\Cropper::className(), [
    'cropperOptions' => [
        'width' => 100, // must be specified
        'height' => 100, // must be specified
     ]
]);
````


Notes
-----
Don't forget to add this line into root in .htaccess file
````
RewriteRule ^uploads/(.*)$ uploads/$1 [L]
````

I will add jsOptions[] soon
-----
