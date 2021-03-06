<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
?>
<h1>Selamat Datang <?= $model['nama'] ;?></h1>
<?= Html::beginForm(['reservation/add',], 'post', ['enctype' => 'multipart/form-data', 'id' => 'add-reservation', 'class' => 'form-horizontal']);?>
<div class="form-group">
    <label for="idenity" class="control-label col-sm-2 col-xs-6">NIK</label>
    <div class="col-sm-4 col-xs-6">
    <?= Html::textInput('idnumber', $model['nik'], [
            'disabled' => 'disabled',
            'class' => 'form-control',
            'style' => 'background: white; border: white; box-shadow: none;'
        ]); ?>
    </div>
</div>
<div class="form-group">
    <label for="idenity" class="control-label col-sm-2 col-xs-6">Faskes</label>
    <div class="col-sm-4 col-xs-6">
    <?= Html::textInput('clinic-name', $clinicModel->idFaskes->nama, [
            'disabled' => 'disabled',
            'class' => 'form-control',
            'style' => 'background: white; border: white; box-shadow: none;'
        ]); ?>
    </div>
</div>
<div class="form-group">
    <label for="idenity" class="control-label col-sm-2 col-xs-6">Klinik</label>
    <div class="col-sm-4 col-xs-6">
    <?= Html::textInput('subclinic-map', $clinicModel->nama_klinik, [
            'disabled' => 'disabled',
            'class' => 'form-control',
            'style' => 'background: white; border: white; box-shadow: none;'
        ]); ?>
    </div>
</div>
<div class="form-group">
    <label for="reservation-date" class="control-label col-sm-2 col-xs-6">Tanggal Layanan</label>
    <div class="col-sm-4 col-xs-6">
    <?= DatePicker::widget([
            'name' => 'ReservationForm[arrival_date]',
            'id' => 'tanggal_layanan',
            'type' => DatePicker::TYPE_INPUT,
            'value' => date('Y-m-d'),
            'options' => ['class' => 'form-control'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                'startDate' => date('Y-m-d'),
            ]
        ]);
    ?>
    </div>
</div>
<?php
    echo '<input type="hidden" name="ReservationForm[identity_number]" value="'.$model['nik'].'">';
    echo '<input type="hidden" name="ReservationForm[id_clinic]" value="'.$klinik_id.'">';
    echo ' <br>';
    echo Html::submitButton('Ambil Nomor Antrean', ['id' => 'save-reservation', 'class' => 'btn btn-primary']);
    echo Html::endForm();
    
    echo Html::a('Tampilkan Antrean Anda', ['reservation/show-reservation', 'type' => Yii::$app->request->get('type')], ['id' => 'show-history']);
    ?>
<div id="history-result"></div>
<?php
$js=<<<JS
    jQuery("#show-history").on("click", function(e) {
        
        e.preventDefault();
        jQuery.ajax({
            type : "POST",
            url : jQuery(this).attr("href"),
            dataType : "html",
            data : {"nik" : "{$model['nik']}", "tanggal_reservation" : jQuery("#tanggal_layanan").val()},
            beforeSend:function(){
                jQuery("#history-result").empty();
            },         
            success : function(data) {

                jQuery("#history-result").html(data);
            }
        });
        return false;

    });
    jQuery("#save-reservation").on("click", function(e) {
        e.preventDefault();
        jQuery.ajax({
            type : "POST",
            url : jQuery("#add-reservation").attr("action"),
            dataType : "json",
            data : jQuery("#add-reservation").serialize(),
            success : function(data) {
                if(data.error === true) {
                    var str = "";

                    if(data.message !== undefined) {
                        str += data.message + "\\n";
                    }

                    if(data.items !== undefined) {
                        jQuery.each(data.items, function(a,b) {
                            jQuery.each(b, function(index, val){
                                str += val + "\\n";
                            });
                        });
                    }

                    alert(str);
                }
                else {
                    window.location.href = data.redirect;
                }
            }
        });
        return false;
    });
JS;
$this->registerJs($js);
?>