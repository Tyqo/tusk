<?php
    echo $this->Form->create($entry, ["class" => "stack"]);
?>

<?= $this->Form->control('name'); ?>
<?= $this->Form->control('active'); ?>
<?= $this->Form->control('type'); ?>
<?= $this->Form->control('parent', ['options' => $pages]); ?>
<?= $this->Form->control('layout_id', ['options' => $layouts]); ?>

<?php
    echo $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button']);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>