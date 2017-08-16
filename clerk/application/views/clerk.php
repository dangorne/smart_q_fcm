<script type="text/javascript" language="javascript" >

  $(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'pointer'});
  }).ajaxStop(function() {
    $(document.body).css({'cursor' : 'pointer'});
  });

 $(document).ready(function(){

   var selected_list
   var selected_table
   var panel_toggle

   var fetchtable = function(){

    var txt = $('#q-search-txt').val();

    if(txt == ''){

      $.ajax({
        url: "<?php echo site_url('fetchtable'); ?>",
        method: "POST",
        dataType: "text",
        success:function(data){
          $('#q-tbl-body').html(data);

          var tableRow = $("#q-tbl-body td").filter(function(){
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

          var tableRow = $("#q-tbl-body td").filter(function(){
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

  var fetchqueuers = function(){
    $.ajax({
      url: "<?php echo site_url('fetchqueuers'); ?>",
      method: "POST",
      data: {selected:selected_table},
      dataType: "text",
      success:function(data){
        $('#q-tbl-queuer-body').html(data);
      },
      error:function(){
        alert("ajax error");
      },
    });
  };

   $('#q-search-txt').keyup(function(){

      fetchtable();
    });

   $('.btn-join').click(function(){

      if(selected_table != null){

        $.ajax({
         type: "POST",
         url: "<?php echo site_url('join'); ?>",
         data: {selected: selected_table},
         dataType: "json",
         success:function(data){

           if(data.res == "ONGOING"){
             fetchtable();
             fetchqueuers();
           }else{
             alert("You can't join. The queue is paused.")
           }
         },
         error:function(){
           alert("ajax error");
         },
       });

      $('.btn-join').attr("disabled", "disabled").html('<span class="glyphicon glyphicon-ban-circle"></span>');

      setTimeout(function() {
        $('.btn-join').removeAttr("disabled").html('JOIN!');
      }, 5000);

     }
    });

    $('#q-tbl-body').on('click', 'tr', function(){
      $(this).not(".head").addClass('success').siblings().removeClass('success');

      selected_table=$(this).find('td:first').text();
      fetchqueuers();
    });

    $(".panel-body-toggle").hide();

    var interval = 5000;
    function dbUpdate(){

      fetchqueuers();
      fetchtable();
      setTimeout(dbUpdate, interval);
    }

    setTimeout(dbUpdate, interval);
  });

 </script>
