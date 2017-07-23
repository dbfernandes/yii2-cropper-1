<?php
/**
 *
 * this html text must be 1 line for javascript content
 *
 */
/** @var $unique string */
/** @var $cropperOptions [] */

$modalLabel = Yii::t('cropper', 'Image Crop Editor');
$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . Yii::t('cropper', 'Crop');
$closeLabel = $cropperOptions['icons']['close'] . ' ' . Yii::t('cropper', 'Crop') . ' & ' . Yii::t('cropper', 'Close');

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
?>
<div class="modal fade" tabindex="-1" role="dialog" id="cropper-modal-<?= $unique ?>"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="modalLabel-<?= $unique ?>"><?= $modalLabel ?></h4></div><div class="modal-body"><div><img id="cropper-image-<?= $unique ?>" src="" alt=""></div></div><div class="modal-footer"><div class="pull-left"><span class="btn btn-primary btn-file"><?= $browseLabel ?><input type="file" id="cropper-input-<?= $unique ?>" title="<?= Yii::t('cropper', 'Browse') ?>" accept="image/*"></span>&nbsp;<div class="btn-group"><button type="button" class="btn btn-primary zoom-in"><span class="fa fa-search-plus"></span></button><button type="button" class="btn btn-primary zoom-out"><span class="fa fa-search-minus"></span></button></div>&nbsp;<div class="btn-group"><button type="button" class="btn btn-primary rotate-left"><span class="fa fa-rotate-left"></span></button><button type="button" class="btn btn-primary rotate-right"><span class="fa fa-rotate-right"></span></button><button type="button" class="btn btn-primary flip-horizontal"><span class="fa fa-arrows-h"></span></button><button type="button" class="btn btn-primary flip-vertical"><span class="fa fa-arrows-v"></span></button></div>&nbsp;<div class="btn-group"><button type="button" class="btn btn-primary move-left"><span class="fa fa-arrow-left"></span></button><button type="button" class="btn btn-primary move-right"><span class="fa fa-arrow-right"></span></button><button type="button" class="btn btn-primary move-up"><span class="fa fa-arrow-up"></span></button><button type="button" class="btn btn-primary move-down"><span class="fa fa-arrow-down"></span></button></div></div><button type="button" id="crop-button-<?= $unique ?>" class="btn btn-success"><?= $cropLabel ?></button><button type="button" id="close-button-<?= $unique ?>" class="btn btn-danger" data-dismiss="modal"><?= $closeLabel ?></button></div></div></div></div>
