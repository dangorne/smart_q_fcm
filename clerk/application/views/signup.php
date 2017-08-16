<div class="container">

  <div class="row">

    <div class="col-md-6 col-md-offset-3">

      <div class="panel panel-default">

        <div class="panel-body">

          <?php echo form_open('signup') ?>

            <?php
              if($this->session->userdata('USER_EXIST') == 'TRUE'){
                echo '<div class="alert alert-danger" role="alert"><strong>Permission Code already exist.</strong></div>';
              }
              if($this->session->userdata('PASS_NOT_MATCH') == 'TRUE'){
                echo '<div class="alert alert-danger" role="alert"><strong>Password does not match.</strong></div>';
              }
            ?>

            <?php

             if($this->session->userdata('SYNTAX_ERROR') == 'TRUE' && form_error('user') != ''){

               echo '<div class="form-group has-error">';
               echo '<label class="control-label" for="user">Permission Code</label>';
               echo '<input type="text" name="user" id="user" class="form-control" value = "'.set_value('user').'" aria-describedby="help">';
               echo '<span id="help" class="help-block">'.form_error('user').'</span>';
               echo '</div>';
             }else{

               echo '<div class="form-group">';
               echo '<label class="control-label" for="user">Permission Code</label>';
               echo '<input type="text" name="user" id="user" class="form-control" value = "'.set_value('user').'" aria-describedby="help">';
               echo '</div>';
             }
            ?>

            <?php

             if($this->session->userdata('SYNTAX_ERROR') == 'TRUE' && form_error('pass') != ''){

               echo '<div class="form-group has-error">';
               echo '<label class="control-label" for="pass">Password</label>';
               echo '<input type="text" name="pass" id="pass" class="form-control" value = "'.set_value('pass').'" aria-describedby="help">';
               echo '<span id="help" class="help-block">'.form_error('pass').'</span>';
               echo '</div>';
             }else{

               echo '<div class="form-group">';
               echo '<label class="control-label" for="pass">Password</label>';
               echo '<input type="text" name="pass" id="pass" class="form-control" value = "'.set_value('pass').'" aria-describedby="help">';
               echo '</div>';
             }
            ?>

            <?php

             if($this->session->userdata('SYNTAX_ERROR') == 'TRUE' && form_error('confirmpass') != ''){

               echo '<div class="form-group has-error">';
               echo '<label class="control-label" for="user">Confirm Password</label>';
               echo '<input type="text" name="user" id="user" class="form-control" value = "'.set_value('user').'" aria-describedby="help">';
               echo '<span id="help" class="help-block">'.form_error('user').'</span>';
               echo '</div>';
             }else{

               echo '<div class="form-group">';
               echo '<label class="control-label" for="user">Confirm Password</label>';
               echo '<input type="text" name="user" id="user" class="form-control" value = "'.set_value('user').'" aria-describedby="help">';
               echo '</div>';
             }
            ?>

            <?php

             if($this->session->userdata('SYNTAX_ERROR') == 'TRUE' && form_error('code') != ''){

               echo '<div class="form-group has-error">';
               echo '<label class="control-label" for="code">Permission Code</label>';
               echo '<input type="text" name="code" id="code" class="form-control" value = "'.set_value('code').'" aria-describedby="help">';
               echo '<span id="help" class="help-block">'.form_error('code').'</span>';
               echo '</div>';
             }else{

               echo '<div class="form-group">';
               echo '<label class="control-label" for="code">Permission Code</label>';
               echo '<input type="text" name="code" id="code" class="form-control" value = "'.set_value('code').'" aria-describedby="help">';
               echo '</div>';
             }
            ?>

           <button type="submit" class="btn btn-info">Sign Up</button>
           <?php echo form_close() ?>

        </div>

      </div>

    </div>

  </div>

</div>
