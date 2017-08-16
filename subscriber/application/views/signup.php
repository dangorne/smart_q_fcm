<div class="container">

  <div class="row">

    <div class="col-md-6 col-md-offset-3">

      <div class="panel panel-default">

        <div class="panel-body">

          <?php echo validation_errors() ?>

          <?php echo form_open('signup_subscriber') ?>

            <?php
             echo '<div class="form-group">';
             echo '<label class="control-label" for="user">Username</label>';
             echo '<input type="text" name="user" id="user" class="form-control" value = "'.set_value('user').'" aria-describedby="help">';
             echo '</div>';
            ?>

            <?php
             echo '<div class="form-group">';
             echo '<label class="control-label" for="pass">Password</label>';
             echo '<input type="password" name="pass" id="pass" class="form-control" value = "'.set_value('pass').'" aria-describedby="help">';
             echo '</div>';
            ?>

            <?php
             echo '<div class="form-group">';
             echo '<label class="control-label" for="confirmpass">Confirm Password</label>';
             echo '<input type="password" name="confirmpass" id="confirmpass" class="form-control" value = "'.set_value('confirmpass').'" aria-describedby="help">';
             echo '</div>';
            ?>

            <?php
             echo '<div class="form-group">';
             echo '<label class="control-label" for="idnum">ID Num</label>';
             echo '<input type="text" name="idnum" id="idnum" class="form-control" value = "'.set_value('idnum').'" aria-describedby="help">';
             echo '</div>';
            ?>

            <?php
             echo '<div class="form-group">';
             echo '<label class="control-label" for="phonenum">Phone Number</label>';
             echo '<input type="text" name="phonenum" id="phonenum" class="form-control" value = "'.set_value('phonenum').'" aria-describedby="help">';
             echo '</div>';
            ?>

            <label class="control-label" for="college">College</label>
            <select class="form-control" name="college">
              <option value="CAS"  selected = "selected" <?php echo  set_select('college', 'CAS') ?> >CAS</option>
              <option value="CASNR" <?php echo  set_select('college', 'CASNR') ?> >CASNR</option>
              <option value="CED" <?php echo  set_select('college', 'CED') ?> >CED</option>
              <option value="CEIT" <?php echo  set_select('college', 'CEIT') ?> >CEIT</option>
            </select>


            <div class="checkbox">
              <label><input type="checkbox" name="term" value="accept" <?php echo set_checkbox('term', 'accept'); ?>>I agree to the Terms of Use and Privacy Policy</label>

            </div>

           <?php echo form_submit('submit', 'Sign Up') ?>
           <?php echo form_close() ?>

        </div>

      </div>

    </div>

  </div>

</div>
