<?php
// Evaluate the actual template call with both supported widget API shapes.
$mode=$argv[1] ?? 'legacy';
$property=$mode==='modern'?'public $enableWorkReminders = false;':'';
eval('namespace skeeks\\cms\\widgets\\admin; class CmsWebNotifyWidget { '.$property.' public static function widget(array $config) { $widget=new self; foreach($config as $key=>$value){if(!property_exists($widget,$key))throw new \RuntimeException("Unknown widget property");$widget->$key=$value;} return $config; } }');
$source=file_get_contents(__DIR__.'/../src/views/layouts/_header-actions.php');
$start=strpos($source,'<?= \skeeks\cms\widgets\admin\CmsWebNotifyWidget::widget(');
if($start===false)throw new RuntimeException('Widget call missing');
$end=strpos($source,'?>',$start);
$call=trim(substr($source,$start+3,$end-$start-3));
$config=eval('return '.$call);
$expected=$mode==='modern'?['enableWorkReminders'=>true]:[];
if($config!==$expected)throw new RuntimeException('Unexpected configuration');
echo 'OK: '.$mode.' notification widget compatibility'.PHP_EOL;
