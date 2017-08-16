<?php echo validation_errors() ?>

<?php echo form_open('signup_client') ?>

<?php echo form_label('Client ID', 'clientid') ?>
<?php echo form_input(['name' => 'clientid',
                       'class' => 'form-control',
                       'value' => set_value('clientid')]) ?>

<?php echo form_label('Username', 'user') ?>
<?php echo form_input(['name' => 'user',
                       'class' => 'form-control',
                       'value' => set_value('user')]) ?>

<?php echo form_label('Password', 'pass') ?>
<?php echo form_password(['name' => 'pass',
                          'class' => 'form-control',
                          'value' => set_value('pass')]) ?>

<?php echo form_label('Office', 'office') ?>
<?php echo form_input(['name' => 'office',
                       'class' => 'form-control',
                       'value' => set_value('office')]) ?>

<?php echo form_label('Permission Code', 'permcode') ?>
<?php echo form_input(['name' => 'permcode',
                       'class' => 'form-control',
                       'value' => set_value('permcode')]) ?>

<?php echo form_submit('submit', 'Sign Up') ?>
<?php echo form_close() ?>
