<script type="text/javascript" language="javascript">

$(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'pointer'});
  }).ajaxStop(function() {
    $(document.body).css({'cursor' : 'pointer'});
  });

$(document).ready(function(){

  var create_input = {};
  var selected_list

  //ok
  function editdetail(type, $newinput, $currtext){

    $.ajax({
      url: "<?php echo site_url('editdetail'); ?>",
      method: "POST",
      data: {type:type, content:$newinput.val()},
      dataType: "json",
      success:function(data){
        if(data['success']){
          $currtext.text($newinput.val());
        }
      },
      error:function(){
       alert("ajax errorx");
      },
    });
  }

  //ok
  function fetchdisplay(){

    $.ajax({
      url: "<?php echo site_url('fetchdisplay'); ?>",
      method: "POST",
      data: {content:$('#new-display').val()},
      dataType: "text",
      success:function(data){
        $('#display-name').text(data);
      },
      error:function(){
       alert("ajax errorx");
      },
    });
  }
  //ok
  $('#editDisplay').click(function(){

    $('#new-display').val($('#display-name').text());
  });

  //ok
  $('#save-display').click(function(){

    $.ajax({
      url: "<?php echo site_url('editdisplay'); ?>",
      method: "POST",
      data: {content:$('#new-display').val()},
      dataType: "json",
      success:function(data){
        if(data['success']){
          fetchdisplay();
        }

      },
      error:function(){
       alert("ajax errorx");
      },
    });
  });

  //ok
  $('#editSeats').click(function(){

    $('#new-seats').val($('#detail-seats').text());
  });

  //ok
  $('#save-seats').click(function(){

    editdetail('seats_offered', $('#new-seats'), $('#detail-seats'));
  });

  //ok
  $('#editDesc').click(function(){

    $('#new-desc').val($('#detail-desc').text());
  });

  //ok
  $('#save-desc').click(function(){

    editdetail('queue_description', $('#new-desc'), $('#detail-desc'));
  });

  //ok
  $('#editReq').click(function(){

    $('#new-req').val($('#detail-req').text());
  });

  //ok
  $('#save-req').click(function(){

    editdetail('requirements', $('#new-req'), $('#detail-req'));
  });

  //ok
  $('#editVenue').click(function(){

    $('#new-venue').val($('#detail-venue').text());
  });

  //ok
  $('#save-venue').click(function(){

    editdetail('venue', $('#new-venue'), $('#detail-venue'));
  });

  //ok
  $('#editRest').click(function(){

    $('#new-rest').val($('#detail-rest').text());

  });

  //ok
  $('#save-rest').click(function(){

    editdetail('queue_restriction', $('#new-rest'), $('#detail-rest'));
  });

  //ok
  function fetchlist(){

    $.ajax({
     url: "<?php echo site_url('fetchlist'); ?>",
     method: "GET",
     dataType: "text",
     success:function(data){

       if(data != ''){
         $('.list-group-class').html(data);

         var listGroup = $(".list-group-class .list-qname").filter(function() {
             return $(this).text() == selected_list;
         }).closest(".list-group-item");

         if(listGroup.find('.list-qname').text() != ''){

           listGroup.addClass('list-group-item-success');
         }else{
           selected_list = null;
         }

          $('.panel-qlist').show();
       }
     },
     error:function(){
       alert("ajax error");
     },
   });
  }

  //ok
  function status(){
    $.ajax({
      url: "<?php echo site_url('status'); ?>",
      method: "GET",
      dataType: "json",
      success:function(data){

        if(data['success']){
          $('.queue-num').html(data['qnum']);
          $('.id-num').html(data['idnum']);
          $('.q-status').html(data['qstatus']);
          $('.q-total-sub').html(data['totalsub']);

          // if(data['qstatus'] == 'PAUSED'){
          //
          //   if($('.btn-pause-glyph').hasClass('glyphicon glyphicon-pause')){
          //     $('.btn-pause').removeClass("btn-warning").addClass("btn-info");
          //     $('.btn-pause-glyph').removeClass("glyphicon glyphicon-pause").addClass("glyphicon glyphicon-play");
          //   }
          // }

          // if(data['qstatus'] == 'ONGOING'){
          //
          //   if($('.btn-pause-glyph').hasClass('glyphicon glyphicon-play')){
          //     $('.btn-pause').removeClass("btn-info").addClass("btn-warning");
          //     $('.btn-pause-glyph').removeClass("glyphicon glyphicon-play").addClass("glyphicon glyphicon-pause");
          //   }
          // }
        }
      },
      error:function(){
       alert("ajax error");
      },
    });
  }

  //ok
  function fetchdetail(){
    $.ajax({
      url: "<?php echo site_url('fetchdetail'); ?>",
      method: "GET",
      dataType: "json",
      success:function(data){

        if(data['display'] == 'true'){
          $('#detail-qname').html(data['qname']);
          $('#detail-code').html(data['code']);
          $('#detail-desc').html(data['desc']);
          $('#detail-seats').html(data['seats']);
          $('#detail-venue').html(data['venue']);
          $('#detail-req').html(data['req']);
          $('#detail-venue').html(data['venue']);
          $('#detail-rest').html(data['rest']);
          $('.content-detail').show();
          fetchdisplay();
          $('.window-panel').show();
        }else{
          fetchlist();
          $('.content-detail').hide();
          $('.window-panel').hide();
        }
      },
      error:function(data){
       alert("ajax error");
      },
    });
  }

  fetchdetail();

  //ok
  $('.btn-create').click(function(){

    input = {
      name:$('#create-name').val(),
      code:$('#create-code').val(),
      seat:$('#create-seat').val(),
      venue:$('#create-venue').val(),
      req:$('#create-req').val(),
      venue:$('#create-venue').val(),
      rest:$('#create-rest').val()
    };

    $.ajax({
       url: "<?php echo site_url('create'); ?>",
       method: "POST",
       data: {input: input},
       dataType: "text",
       success:function(data){
         if(data.Result === 'CREATED'){
           fetchlist();
         }else if(data.Result === 'EXISTING'){
           alert("Queue name already exists!")
         }else if(data.Result === 'ERROR'){
           alert("Failed! Check for invalid input!")
         }
       },
       error:function(){
         alert("ajax error");
       },
     });
  });

  //ok
  $('.btn-join').click(function(){

    if(selected_list){
      $.ajax({
         url: "<?php echo site_url('join'); ?>",
         method: "POST",
         data: {selected: selected_list},
         dataType: "text",
         success:function(data){

           if(data == "JOINED"){
             fetchdetail();
             $('.panel-qlist').hide();
           }else if(data === 'HAS_QUEUE'){
             alert("Failed to join queue!")
           }else if(data === 'ERROR'){
             alert("Failed to join queue!")
           }
         },
         error:function(){
           alert("ajax error");
         },
       });
    }else{
      alert("You must choose a queue!");
    }
  });

  //ok
  $('.btn-leave').click(function(){

     $.ajax({
      type: "GET",
      url: "<?php echo site_url('leave'); ?>",
      dataType: "json",
      success:function(data){

        if(data['success']){
          fetchdetail();
        }else{
          alert('Failed to leave queue!')
        }
      },
      error:function(){
        alert("ajax error");
      },
    });
  });

  //ok
  $('.btn-status').click(function(){
    status();
  });

  //ok
  $('.btn-close').click(function(){
    $.ajax({
       url: "<?php echo site_url('close'); ?>",
       method: "GET",
       success:function(data){
          status();
       },
       error:function(){
          alert("ajax error");
       },
     });
  });

  //ok
  $('.btn-next').click(function(){
    $.ajax({
      type: 'GET',
      url: "<?php echo site_url('next'); ?>",
      dataType: 'json',
      error: function () {alert("ajax error")},
      success: function (data) {

        $('.queue-num').html(data['servicenum']);
        $('.id-num').html(data['idnum']);
      }
    });

    $('.btn-next').attr("disabled", "disabled");
    $('.btn-success-glyph').removeClass("glyphicon glyphicon-forward").addClass("glyphicon glyphicon-ban-circle");

    setTimeout(function() {
      $('.btn-success-glyph').removeClass("glyphicon glyphicon-ban-circle").addClass("glyphicon glyphicon-forward");
      $('.btn-next').removeAttr("disabled");
    }, 3000);
  });

  //ok
  $('.btn-resume').click(function(){

    $.ajax({
        type: 'GET',
        url: "<?php echo site_url('resume'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          $('.q-status').html(data);
        }
      });
  });

  //ok
  $('.btn-pause').click(function(){

      $.ajax({
        type: 'GET',
        url: "<?php echo site_url('pause'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          $('.q-status').html(data);
        }
      });
  });

  //ok
  $('.btn-close').click(function(){

      $.ajax({
        type: 'GET',
        url: "<?php echo site_url('close'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          $('.q-status').html(data);
        }
      });
  });

  //ok
  $('.btn-reset').click(function(){

      $.ajax({
        type: 'GET',
        url: "<?php echo site_url('reset'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          if(data.True){
            $('.q-status').html(data);
            alert('Queue has been reset');
          }else{
            alert('Queue reset failed!');
          }
        }
      });
  });

  //ok
  $('.list-group-class').on('click', '.list-selected', function(){

    $(this).addClass('list-group-item-success').siblings().removeClass('list-group-item-success');

    selected_list=$(this).find('.list-qname').text();
  });

  //ok
  function check_session(){
    $.ajax({
      type: 'GET',
      url: "<?php echo site_url('check_session'); ?>",
      dataType: 'json',
      success: function (data) {
        if(data.REDIRECT){
          window.location.replace('<?php echo site_url('logout'); ?>');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        alert('Error!  Status = ' + xhr.status);
      }
    });
  }

  var interval = 5000;
  function dbUpdate() {

    check_session();
    fetchlist();
    status();

    setTimeout(dbUpdate, interval);
  }
  setTimeout(dbUpdate, interval);

});

</script>
