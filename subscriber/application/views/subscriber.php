<script type="text/javascript" language="javascript" >

  $(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'pointer'});
  }).ajaxStop(function() {
    $(document.body).css({'cursor' : 'pointer'});
  });

 $(document).ready(function(){

    var selected_list
    var selected_list_ref
    var selected_table
    var selected_table_ref
    var panel_toggle
    var fetchpanel

   var init = function(){
     $('.text-title').html("No Queue Selected");
     $('.text-status').html("");
     $('.text-current').html("#");
     $('.text-last').html("#");
     $('.text-self').html("#");
     $('.text-desc').html("");
     $('.text-rest').html("");
     $('.text-req').html("");
     $('.text-venue').html("");
   }

   init();

   var fetchlist = function(){
      $.ajax({
       url: "<?php echo site_url('fetchlist'); ?>",
       method: "POST",
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
       },
       error:function(){
         alert("ajax error");
       },
     });
   }

   fetchlist();

   var fetchtable = function() {

     var txt = $('#q-search-txt').val();

     if(txt == ''){
       $.ajax({
         url: "<?php echo site_url('fetchtable'); ?>",
         method: "POST",
         dataType: "text",
         success:function(data){
           $('#q-tbl-body').html(data);
           var tableRow = $("#q-tbl-body td").filter(function() {
                return $(this).text() == selected_table;
            }).closest("tr");
           if(tableRow.find('td:first').text() != ''){
             tableRow.addClass('success');
           }else{
              selected_table = null;
           }
         },
         error:function(){
           alert("ajax error");
         },
       });
     }else{
       $.ajax({
         url: "<?php echo site_url('fetchtable'); ?>",
         method: "POST",
         data: {search:txt},
         dataType: "text",
         success:function(data){
           $('#q-tbl-body').html(data);

           var tableRow = $("#q-tbl-body td").filter(function() {
                return $(this).text() == selected_table;
            }).closest("tr");

           if(tableRow.find('td:first').text() != ''){
             tableRow.addClass('success');
           }else{
             selected_table = null;
           }
         },
         error:function(){
           alert("ajax error");
         },
       });
     }
   }

   fetchtable();

   $('#q-search-txt').keyup(function(){

     fetchtable();
  });

  $('.btn-leave').click(function(){

     if(selected_list != null){

       $.ajax({
        type: "POST",
        url: "<?php echo site_url('leave'); ?>",
        data: {selected: selected_list},
        dataType: "json",
        success:function(data){

           if(data.res == "NOTINQUEUE"){
             alert("You have not joined this queue!");
           }else if(data.res == "LEFT"){
             fetchlist();
             init();
             $(".panel-body-toggle").hide();
             $(".footer").hide();
             alert("You have left the queue!");
           }else{
             alert("An error occured.")
           }
        },
        error:function(){
          alert("ajax error");
        },
      });
    }
   });

    $('.btn-join').click(function(){

      if(selected_table != null){
        $.ajax({
         type: "POST",
         url: "<?php echo site_url('join'); ?>",
         data: {selected: selected_table},
         dataType: "json",
         success:function(data){

            if(data.res == "EXIST"){
              alert("You are already in the queue!");
            }else if(data.res == "ONGOING"){
              fetchlist();
            }else{
              alert("You can't join. The queue is paused.")
            }
         },
         error:function(){
           alert("ajax error");
         },
       });
     }
    });

    $('#q-tbl-body').on('click', 'tr', function(){

      $(this).not(".head").addClass('success').siblings().removeClass('success');
      selected_table=$(this).find('td:first').text();
    });

    fetchpanel = function(){
      if(selected_list){
        $.ajax({
          type: "POST",
          url: "<?php echo site_url('fetchpanel'); ?>",
          data: {selected: selected_list},
          dataType: "json",
          success:function(data){

            $('.text-title').html(data.queue_name);
            $('.text-status').html(data.status);
            $('.text-current').html(data.serving_atNo);
            $('.text-last').html(data.total_deployNo);
            $('.text-self').html(data.self);
            $('.text-desc').html(data.queue_description);
            $('.text-rest').html(data.queue_ristriction);
            $('.text-req').html(data.requirements);
            $('.text-venue').html(data.venue);
            $('.footer').show();

          },
          error:function(){
            alert("ajax errors");
          },
        });
      }
    };

    $('.list-group-class').on('click', '.list-selected', function(){

      $(this).addClass('list-group-item-success').siblings().removeClass('list-group-item-success');

      selected_list=$(this).find('.list-qname').text();

      $(".panel-body-toggle").show();

      fetchpanel();
    });

    $(".panel-body-toggle").hide();

    var interval = 5000;
    function dbUpdate() {

      fetchlist();
      fetchtable();
      fetchpanel();
      // $(document.body).css({'cursor' : 'crosshair'});
      setTimeout(dbUpdate, interval);
    }

    setTimeout(dbUpdate, interval);

  });
 </script>
