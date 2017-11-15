<?php

use yii\bootstrap\Html;
use yii\web\View;


/** @var $this View */
/** @var $uniqueId string */
/** @var $imageUrl string */
/** @var $cropperOptions mixed */
/** @var $jsOptions mixed */
/** @var $inputOptions  mixed */
/** @var $template string */


\dbfernandes\cropper\CropperAsset::register($this);

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
$aspectRatio = $cropWidth / $cropHeight;

$minHeight = isset($cropperOptions['minHeight'])?$cropperOptions['minHeight']:0;
$minWidth = isset($cropperOptions['minWidth'])?$cropperOptions['minWidth']:0;

$maxHeight = isset($cropperOptions['maxHeight'])?$cropperOptions['maxHeight']:0;
$maxWidth = isset($cropperOptions['maxWidth'])?$cropperOptions['maxWidth']:0;

$minImageHeight = isset($cropperOptions['minImageHeight'])?$cropperOptions['minImageHeight']:0;
$minImageWidth = isset($cropperOptions['minImageWidth'])?$cropperOptions['minImageWidth']:0;

$minCanvasWidth = isset($cropperOptions['minCanvasWidth'])?$cropperOptions['minCanvasWidth']:0;
$minCanvasHeight = isset($cropperOptions['minCanvasHeight'])?$cropperOptions['minCanvasHeight']:0;
$minContainerWidth = isset($cropperOptions['minContainerWidth'])?$cropperOptions['minContainerWidth']:200;
$minContainerHeight = isset($cropperOptions['minContainerHeight'])?$cropperOptions['minContainerHeight']:100;
$minCropBoxWidth = isset($cropperOptions['minCropBoxWidth'])?$cropperOptions['minCropBoxWidth']:0;
$minCropBoxHeight = isset($cropperOptions['minCropBoxHeight'])?$cropperOptions['minCropBoxHeight']:0;

$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . Yii::t('cropper', 'Crop');
$closeLabel = $cropperOptions['icons']['close'] . ' ' . Yii::t('cropper', 'Crop') . ' & ' . Yii::t('cropper', 'Close');

$label = $inputOptions['label'];
if ($label !== false) {
    $browseLabel = $cropperOptions['icons']['browse'] . ' ' . $label;
}
?>





<?php
// template
$buttonContent = Html::button($browseLabel, [
    'class' => $cropperOptions['buttonCssClass'],
    'data-toggle' => 'modal',
    'style' => 'width: ' . $cropperOptions['preview']['width'] . 'px; margin-top: 4px',
    'data-target' => '#cropper-modal-' . $uniqueId,
    //'data-keyboard' => 'false',
    'data-backdrop' => 'static',
    'id' => 'cropper-select-button-' . $uniqueId,
]);
$previewContent = null;
$previewOptions = $cropperOptions['preview'];
if ($cropperOptions['preview'] !== false) {
    $src = $previewOptions['url'];
    //$previewImage = null;

    $previewImage = null;
    if (isset($previewOptions['url'])) {
        $previewImage = Html::img($src, [
            'id' => 'cropper-image-'.$uniqueId,
            'width' => $previewOptions['width'],
            'height' => $previewOptions['height'],
        ]);
    }

    if (is_string($previewOptions['width'])) {
        if (strstr($previewOptions['width'], '%') || strstr($previewOptions['width'], 'px')) {
            $previewWidth = $previewOptions['width'];
            $previewHeight = $previewOptions['width'];
        } else {
            $previewWidth = $previewOptions['width'] . 'px';
            $previewHeight = ($previewOptions['width'] / $aspectRatio) . 'px' ;
        }
    } else if (is_integer($previewOptions['width'])) {
        $previewWidth = $previewOptions['width'] . 'px';
        $previewHeight = ($previewOptions['width'] / $aspectRatio) . 'px';
    }

    if (isset($previewOptions['height'])) {
        if (is_string($previewOptions['height'])) {
            if (strstr($previewOptions['height'], '%') || strstr($previewOptions['height'], 'px')) {
                $previewHeight = $previewOptions['height'];
            } else {
                $previewHeight = $previewOptions['height'] . 'px';
            }
        } else if (is_integer($previewOptions['height'])) {
            $previewHeight = $previewOptions['height'] . 'px';
        }
    }

    $previewContent = '<div class="cropper-container clearfix">' . Html::tag('div', $previewImage, [
            'id' => 'cropper-result-'.$uniqueId,
            'class' => 'cropper-result',
            'style' => 'width: '.$previewWidth.'; height: '.$previewHeight.';',
            'data-buttonid' => 'cropper-select-button-' . $uniqueId
        ]) . '</div>';
} else {
    $previewContent = Html::img(null, ['class' => 'hidden', 'id' => 'cropper-image-'.$uniqueId]);
}
$input = '<input type="text" id="'.$inputOptions['id'].'" name="'.$inputOptions['name'].'" title="" style="display: none;" value="'.$inputOptions['value'].'">';
$template = str_replace('{button}',  $input . $buttonContent, $template);
$template = str_replace('{preview}', $previewContent, $template);
?>

<div class="cropper-wrapper clearfix">
    <?php echo $template ?>
    <?= Html::hiddenInput('url-change-input-' . $uniqueId, '', [
        'id' => 'cropper-url-change-input-' . $uniqueId,
    ]) ?>
</div>

<?php $this->registerCss('
    .cropper-result {
        margin-top: 0px;
        border: 1px dotted #bfbfbf;
        background-color: #f5f5f5;
        position: relative;
        cursor: pointer;
    }
    #cropper-modal-'.$uniqueId.' img{
        max-width: 100%;
    }
    #cropper-modal-'.$uniqueId.' .btn-file {
        position: relative;
        overflow: hidden;
    }
    #cropper-modal-'.$uniqueId.' .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    #cropper-modal-'.$uniqueId.' .input-group .input-group-addon {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #efefef;
        color: #555;
    }
    #cropper-modal-'.$uniqueId.' .height-warning.has-success .input-group-addon,
    #cropper-modal-'.$uniqueId.' .width-warning.has-success .input-group-addon{
        background-color: #00a65a;
        border-color: #00a65a;
        color: #fff;
    }
    #cropper-modal-'.$uniqueId.' .height-warning.has-error .input-group-addon,
    #cropper-modal-'.$uniqueId.' .width-warning.has-error .input-group-addon{
        background-color: #dd4b39;
        border-color: #dd4b39;
        color: #fff;
    }
') ?>


<?php
$inputId = $inputOptions['id'];
$modal = $this->render('modal', [
    'unique' => $uniqueId,
    'cropperOptions' => $cropperOptions,
]);

$modal = preg_replace('/\n/','',$modal);

$this->registerJs(<<<JS

    $('body').prepend('$modal');

    var options_$uniqueId = {
        croppable: false,
        croppedCanvas: '',

        element: {
            modal: $('#cropper-modal-$uniqueId'),
            image: $('#cropper-image-$uniqueId'),
            _image: document.getElementById('cropper-image-$uniqueId'),
            result: $('#cropper-result-$uniqueId')
        },

        input: {
            model: $('#$inputId'),
            crop: $('#cropper-input-$uniqueId'),
            urlChange: $('#cropper-url-change-input-$uniqueId')
        },

        button: {
            crop: $('#crop-button-$uniqueId'),
            close: $('#close-button-$uniqueId')
        },

        data: {
            cropWidth: $cropWidth,
            cropHeight: $cropHeight,
            scaleX: 1,
            scaleY: 1,
            width: '',
            height: '',
            X: '',
            Y: ''
        },

        inputData: {
            width: $('#dataWidth-$uniqueId'),
            height: $('#dataHeight-$uniqueId'),
            X: $('#dataX-$uniqueId'),
            Y: $('#dataY-$uniqueId')
        }
    };

    var cropper_options_$uniqueId = {
        aspectRatio: $aspectRatio,
        viewMode: 3,
        minHeight: $minHeight,
        minWidth: $minWidth,
        maxHeight: $maxHeight,
        maxWidth: $maxWidth,
        minCanvasWidth: $minCanvasWidth,
        minCanvasHeight: $minCanvasHeight,
        minContainerWidth: $minContainerWidth,
        minContainerHeight: $minContainerHeight,
        minCropBoxWidth: $minCropBoxWidth,
        minCropBoxHeight: $minCropBoxHeight,
        autoCropArea: 0.8,
        responsive: false,
        crop: function (e) {

            options_$uniqueId.data.width = Math.round(e.width);
            options_$uniqueId.data.height = Math.round(e.height);
            options_$uniqueId.data.X = e.scaleX;
            options_$uniqueId.data.Y = e.scaleY;

            options_$uniqueId.inputData.width.val(Math.round(e.width));
            options_$uniqueId.inputData.height.val(Math.round(e.height));
            options_$uniqueId.inputData.X.val(Math.round(e.x));
            options_$uniqueId.inputData.Y.val(Math.round(e.y));

            if (options_$uniqueId.data.width < options_$uniqueId.data.cropWidth) {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-success').addClass('has-error');
            } else {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-error').addClass('has-success');
            }

            if (options_$uniqueId.data.height < options_$uniqueId.data.cropHeight) {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-success').addClass('has-error');
            } else {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-error').addClass('has-success');
            }
        },

        built: function () {
            options_$uniqueId.croppable = true;
        },

        cropend: function () {
            var data = $(this).cropper('getData');
            if (data.width < $minImageWidth || data.height < $minImageHeight) {
                data.width  = $minImageWidth;
                data.height = $minImageHeight;
            }
            $(this).cropper('setData', data);
        }

    }

    // input file change
    options_$uniqueId.input.crop.change(function(event) {
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');
        // image loading
        if (typeof event.target.files[0] === 'undefined') {
            options_$uniqueId.element._image.src = "";
            return;
        }
        options_$uniqueId.element._image.src = URL.createObjectURL(event.target.files[0]);
        // cropper start
        options_$uniqueId.element.image.cropper(cropper_options_$uniqueId);
    });




    var imageUrl_$uniqueId = '$imageUrl';
    var setElement_$uniqueId = function(src) {
        options_$uniqueId.element.modal.find('.modal-body > div').html('<img src="' + src + '" id="cropper-image-$uniqueId">');
        options_$uniqueId.element.image = $('#cropper-image-$uniqueId');
        options_$uniqueId.element._image = document.getElementById('cropper-image-$uniqueId');
    };
    // if imageUrl is set
    if (imageUrl_$uniqueId !== '') {
        setElement_$uniqueId(imageUrl_$uniqueId);
    }
    // when set imageSrc directly from out
    options_$uniqueId.input.urlChange.change(function(event) {
        var _val = $(this).val();
        imageUrl_$uniqueId = _val;
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');
        if (!options_$uniqueId.element.modal.hasClass('in')) {
            setElement_$uniqueId(_val);
            options_$uniqueId.element.modal.modal('show');
        }

    });
    options_$uniqueId.element.modal.on('shown.bs.modal', function() {
        if (imageUrl_$uniqueId !== '') {
            // cropper start
            options_$uniqueId.element.modal.find('.modal-body img').cropper(cropper_options_$uniqueId);
            imageUrl_$uniqueId = '';
        }
    });




    function setCrop$uniqueId() {
        if (!options_$uniqueId.croppable) {
            return;
        }
        options_$uniqueId.croppedCanvas = options_$uniqueId.element.image.cropper('getCroppedCanvas', {
            width: options_$uniqueId.data.cropWidth,
            height: options_$uniqueId.data.cropHeight
        });
        options_$uniqueId.element.result.html('<img src="' + options_$uniqueId.croppedCanvas.toDataURL() + '" id="cropper-image-$uniqueId">');
        options_$uniqueId.input.model.attr('type', 'text');
        options_$uniqueId.input.model.val(options_$uniqueId.croppedCanvas.toDataURL());
    }


    options_$uniqueId.button.crop.click(function() { setCrop$uniqueId(); });
    options_$uniqueId.button.close.click(function() { setCrop$uniqueId(); });
    $('[data-target="#cropper-modal-$uniqueId"]').click(function() {
        var src_$uniqueId = $('#cropper-modal-$uniqueId').find('.modal-body').find('img').attr('src');
        if (src_$uniqueId === '') {
            options_$uniqueId.input.crop.click();
        }
    });






    options_$uniqueId.element.modal.find('.move-left').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', -10, 0);
    });
    options_$uniqueId.element.modal.find('.move-right').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 10, 0);
    });
    options_$uniqueId.element.modal.find('.move-up').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, -10);
    });
    options_$uniqueId.element.modal.find('.move-down').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, 10);
    });
    options_$uniqueId.element.modal.find('.zoom-in').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', 0.1);
    });
    options_$uniqueId.element.modal.find('.zoom-out').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', -0.1);
    });
    options_$uniqueId.element.modal.find('.rotate-left').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', -15);
    });
    options_$uniqueId.element.modal.find('.rotate-right').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', 15);
    });
    options_$uniqueId.element.modal.find('.flip-horizontal').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleX = -1 * options_$uniqueId.data.scaleX;
        options_$uniqueId.element.image.cropper('scaleX', options_$uniqueId.data.scaleX);
    });
    options_$uniqueId.element.modal.find('.flip-vertical').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleY = -1 * options_$uniqueId.data.scaleY;
        options_$uniqueId.element.image.cropper('scaleY', options_$uniqueId.data.scaleY);
    });

JS
    , View::POS_END);

// on click crop or close button
if (isset($jsOptions['onClick'])) :
    $onClick = $jsOptions['onClick'];
    $script = <<<JS
        $('#crop-button-$uniqueId, #close-button-$uniqueId').click($onClick);
JS;
    $this->registerJs($script, View::POS_END);
endif;
?>
