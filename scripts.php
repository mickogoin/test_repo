  <!-- Bootstrap core JavaScript-->
  
  <script src="vendor/jquery/jquery.min.js"></script>
  
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  

  <!-- Page level plugin JavaScript-->
  <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  
  <script src="js/demo/datatables-demo.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <!-- additonal  -->
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <!-- addtional  -->
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>


  <!-- Demo scripts for this page-->
  
  <!-- <script src="js/demo/chart-area-demo.js"></script> -->


  
  
<script type="text/javascript">
var url = window.location;
// Will only work if string in href matches with location
// $('ul li a.nav-link[href="'+ url +'"]').parent().addClass('active');

// Will also work for relative and absolute hrefs
$('ul li a.nav-link').filter(function() {
    return this.href == url;
}).parent().addClass('active');

// Will also work for relative and absolute hrefs
$('ul li a.dropdown-item').filter(function() {
    return this.href == url;
}).parent().addClass('active');
</script> 




<script type="text/javascript">
    
    // // Total seconds to wait
    // var seconds = 300;
    
    // function countdown() {
    //     seconds = seconds - 1;
    //     if (seconds < 0) {
    //         // Chnage your redirection link here
    //         alert("You have been inactive, please login again!");
    //         window.location = "timeout.php";
    //     } else {
    //         // Update remaining seconds
    //         // document.getElementById("countdown").innerHTML = seconds;
    //         // Count down using javascript
    //         window.setTimeout("countdown()", 1000);
    //     }
    // }
    
    // // Run countdown function
    // countdown();
    
</script>



  <script>
  $(document).ready(function(){
  // updating the view with notifications using ajax
  function load_unseen_notification(view = '')
  {
  $.ajax({
    url:"fetch.php",
    method:"POST",
    data:{view:view},
    dataType:"json",
    success:function(data)
    {
    $('.dd').html(data.notification);
    if(data.unseen_notification > 0)
    {
      $('.count').html(data.unseen_notification);
    }
    }
  });
  }
  load_unseen_notification();


  // load new notifications
  $(document).on('click', '.dt', function(){
  $('.count').html('');
  load_unseen_notification('yes');
  });
  setInterval(function(){
  load_unseen_notification();;
  }, 5000);
  
});
  </script>





