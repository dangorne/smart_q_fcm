<?php echo validation_errors() ?>

<?php echo form_open('createq') ?>

<label class="control-label" for="qname">Queue Name</label>
<input type="text" name="qname" class="form-control" value = "<?php echo set_value('qname')?>" >

<label class="control-label" for="seat">Seats Offered</label>
<input type="text" name="seat" class="form-control" value = "<?php echo set_value('sear')?>" >

<label class="control-label" for="qdesc">Queue Description</label>
<input type="text" name="qdesc" class="form-control" value = "<?php echo set_value('qdesc')?>" >

<label class="control-label" for="req">Requirements</label>
<input type="text" name="req" class="form-control" value = "<?php echo set_value('req')?>" >

<label class="control-label" for="venue">Venue</label>
<input type="text" name="venue" class="form-control" value = "<?php echo set_value('venue')?>" >

<label class="control-label" for="rest">Restriction</label>
<select name="rest">
        <option value="CAS"  selected = "selected" <?php echo  set_select('rest', 'CAS') ?> >CAS</option>
        <option value="CASNR" <?php echo  set_select('rest', 'CASNR') ?> >CASNR</option>
        <option value="CED" <?php echo  set_select('rest', 'CED') ?> >CED</option>
        <option value="CEIT" <?php echo  set_select('rest', 'CEIT') ?> >CEIT</option>
</select>

<?php echo form_submit('submit', 'Log in') ?>
<?php echo form_close() ?>
