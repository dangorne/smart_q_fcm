
<script type="text/javascript" language="javascript">

$(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'pointer'});
  }).ajaxStop(function() {
    $(document.body).css({'cursor' : 'pointer'});
  });

$(document).ready(function(){

  var create_input = {};
  var selected_list

  function editdetail(type, $newinput, $currtext){

    $.ajax({
      url: "<?php echo site_url('editdetail'); ?>",
      method: "POST",
      data: {type:type, content:$newinput.val()},
      dataType: "json",
      success:function(data){
        $currtext.text($newinput.val());
      },
      error:function(){
       alert("ajax errorx");
      },
    });
  }

  $('#editDisplay').click(function(){

    $('#new-display').val($('#display-name').text());
  });

  $('#save-display').click(function(){

    $.ajax({
      url: "<?php echo site_url('editdisplay'); ?>",
      method: "POST",
      data: {content:$('#new-display').val()},
      dataType: "json",
      success:function(data){
        $('#display-name').text($('#new-display').val());
      },
      error:function(){
       alert("ajax errorx");
      },
    });
  });

  $('#editSeats').click(function(){

    $('#new-seats').val($('#detail-seats').text());
  });

  $('#save-seats').click(function(){

    editdetail("seat", $('#new-seats'), $('#detail-seats'));
  });

  $('#editDesc').click(function(){

    $('#new-desc').val($('#detail-desc').text());
  });

  $('#save-desc').click(function(){

    editdetail("desc", $('#new-desc'), $('#detail-desc'));
  });

  $('#editReq').click(function(){

    $('#new-req').val($('#detail-req').text());
  });

  $('#save-req').click(function(){

    editdetail("req", $('#new-req'), $('#detail-req'));
  });

  $('#editVenue').click(function(){

    $('#new-venue').val($('#detail-venue').text());
  });

  $('#save-venue').click(function(){

    editdetail("venue", $('#new-venue'), $('#detail-venue'));
  });

  $('#editRest').click(function(){

    $('#new-rest').val($('#detail-rest').text());

  });

  $('#save-rest').click(function(){

    editdetail("rest", $('#new-rest'), $('#detail-rest'));
  });

  var fetchlist = function(){

    $.ajax({
     url: "<?php echo site_url('fetchlist'); ?>",
     method: "GET",
     dataType: "text",
     success:function(data){
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
     },
     error:function(){
       alert("ajax error");
     },
   });
  }

  var status = function(){
    $.ajax({
      url: "<?php echo site_url('status'); ?>",
      method: "GET",
      dataType: "json",
      success:function(data){
         $('.queue-num').html(data['qnum']);
         $('.id-num').html(data['idnum']);
         $('.q-status').html(data['qstatus']);
         $('.q-total-sub').html(data['totalsub']);

         if(data['qstatus'] == 'PAUSED'){

           if($('.btn-pause-glyph').hasClass('glyphicon glyphicon-pause')){
             $('.btn-pause').removeClass("btn-warning").addClass("btn-info");
             $('.btn-pause-glyph').removeClass("glyphicon glyphicon-pause").addClass("glyphicon glyphicon-play");
           }
         }

         if(data['qstatus'] == 'ONGOING'){

           if($('.btn-pause-glyph').hasClass('glyphicon glyphicon-play')){
             $('.btn-pause').removeClass("btn-info").addClass("btn-warning");
             $('.btn-pause-glyph').removeClass("glyphicon glyphicon-play").addClass("glyphicon glyphicon-pause");
           }
         }
      },
      error:function(){
       alert("ajax error");
      },
    });
  }

  var fetchdetail = function(){
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
          $('.window-panel').show();
        }else{
          fetchlist();
          $('.window-panel').hide();
        }
      },
      error:function(data){
       alert("ajax error");
      },
    });
  }

  fetchdetail();

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
         if(data){
           fetchlist();
         }else{
           alert("Queue cannot be closed!")
         }
       },
       error:function(){
         alert("ajax error");
       },
     });
  });

  $('.btn-join').click(function(){

    if(selected_list){
      $.ajax({
         url: "<?php echo site_url('join'); ?>",
         method: "POST",
         data: {selected: selected_list},
         dataType: "text",
         success:function(data){
           if(data){
             fetchdetail();
             $('.panel-qlist').hide();
           }else{
             alert("Queue cannot be closed!")
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

  $('.btn-leave').click(function(){

     $.ajax({
      type: "GET",
      url: "<?php echo site_url('leave'); ?>",
      dataType: "json",
      success:function(data){

        if(data['success']){
          $('.content-detail').hide();
          $('.panel-qlist').show();
          fetchlist();
          $('.window-panel').hide();
        }
      },
      error:function(){
        alert("ajax error");
      },
    });
  });

  $('.btn-status').click(function(){
    status();
  });

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

  $('.btn-pause').click(function(){

    if($('.btn-pause-glyph').hasClass('glyphicon glyphicon-pause')){
      $(this).removeClass("btn-warning").addClass("btn-info");
      $('.btn-pause-glyph').removeClass("glyphicon glyphicon-pause").addClass("glyphicon glyphicon-play");

      $.ajax({
        type: 'GET',
        url: "<?php echo site_url('pause'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          $('.q-status').html(data);
        }
      });
    }else{
      $(this).removeClass("btn-info").addClass("btn-warning");
      $('.btn-pause-glyph').removeClass("glyphicon glyphicon-play").addClass("glyphicon glyphicon-pause");

      $.ajax({
        type: 'GET',
        url: "<?php echo site_url('resume'); ?>",
        dataType: 'json',
        error: function () {alert("ajax error")},
        success: function (data) {
          $('.q-status').html(data);
        }
      });
    }
  });

  $('.list-group-class').on('click', '.list-selected', function(){

    $(this).addClass('list-group-item-success').siblings().removeClass('list-group-item-success');

    selected_list=$(this).find('.list-qname').text();
  });

  var interval = 5000;
  function dbUpdate() {

    if($('.panel-qlist').is(":visible")){

      fetchlist();
    }

    if($('.content-detail').is(":visible")){

      status();
    }
    setTimeout(dbUpdate, interval);
  }
  setTimeout(dbUpdate, interval);

});

</script>
