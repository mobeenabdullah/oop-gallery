  </div>
    <!-- /#wrapper -->

    <!-- Google Pie Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- WYSIWYG -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ==" crossorigin="anonymous"></script>

    <!-- Scripts JS -->
    <script src="js/scripts.js"></script>

      <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

              var data = google.visualization.arrayToDataTable([
                  ['Task', 'Hours per Day'],
                  ['Views',     <?php echo $session->count; ?>],
                  ['Comments',      <?php echo Comment::count_all(); ?>],
                  ['Users',      <?php echo User::count_all(); ?>],
                  ['Photo',      <?php echo Photo::count_all(); ?>]
              ]);

              var options = {
                  legend: 'none',
                  pieSliceText: 'label',
                  title: 'My Daily Activities',
                  backgroundColor: 'transparent'
              };

              var chart = new google.visualization.PieChart(document.getElementById('piechart'));

              chart.draw(data, options);
          }
      </script>


  </body>

</html>
