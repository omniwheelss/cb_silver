        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?=CONFIG::HOME_FOOTER_TITLE?> 	 
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="./follow/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./follow/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./follow/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="./follow/nprogress/nprogress.js"></script>
	<!-- daterangepicker -->
	<script type="text/javascript" src="./js/moment/moment.min.js"></script>
	<script type="text/javascript" src="./js/datepicker/daterangepicker_time.js"></script>
	

	<script src="./follow/datatables.net/js/jquery.dataTables_1_10_16.js"></script>
	<script src="./follow/datatables.net-buttons/js/dataTables.buttons_1_5_1.js"></script>
	<script src="./follow/pdfmake/build/pdfmake_0_1_32.js"></script>
	<script src="./follow/pdfmake/build/vfs_fonts.js"></script>
	<script src="./follow/datatables.net-buttons/js/buttons.html5_1_5_1.js"></script>
	<script src="./follow/datatables.net-buttons/js/buttons.print_1_5_1.js"></script>
    <script src="./follow/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	
    <script src="./follow/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="./follow/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="./follow/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="./follow/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="./follow/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="./follow/jszip/dist/jszip.min.js"></script>
	
	<?php
	/*
    <!-- Datatables -->
    <!--<script src="./follow/datatables.net/js/dataTables.min.js"></script>
    <script src="./follow/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->
    <script src="./follow/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <!--<script src="./follow/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="./follow/datatables.net-buttons/js/buttons.flash.min.js"></script>-->
    <!--<script src="./follow/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="./follow/datatables.net-buttons/js/buttons.print.min.js"></script>-->
    <script src="./follow/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="./follow/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="./follow/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="./follow/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="./follow/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="./follow/jszip/dist/jszip.min.js"></script>
    <!--<script src="./follow/pdfmake/build/pdfmake.min.js"></script>
    <script src="./follow/pdfmake/build/vfs_fonts.js"></script>
	-->
	*/
	?>

    <!-- Custom Theme Scripts -->
    <script src="./build/js/custom.min.js"></script>
  <!-- /datepicker -->
	<?php
		// Based on the date & Time format List will have both datetime and add will have only date
		if(isset($calendar_fields))
			echo $calendar_fields;
		
		//Show except the option column in excel and print option
		$list_fields_count = count($list_fields);
		if($list_fields_count > 0){
			$list_count = range(0,$list_fields_count);
			$show_records = join(",",$list_count);
		}
	?>
  <!-- /datepicker -->

    <!-- Datatables -->
    <script>
		$(document).ready(function() {
			$('#dashboard_table').DataTable( {
				"paging":   false,
				"ordering": true,
				"info":     false,
				"searching": false
			} );
		} );	
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
			<?php if (!isset($options)) { ?>
              /*  {
                  extend: 'copy',
                  className: "btn btn-default buttons-copy buttons-html5 btn-sm"
                },
                {
                  extend: 'csv',
                  className: "btn btn-default buttons-csv buttons-html5 btn-sm"
                },*/
                {
                  extend: 'excel',
                  className: "btn btn-default buttons-excel buttons-html5 btn-sm",
				  <? if ($list_fields_count > 0){ ?>
				  exportOptions: {
                    columns: [<?=$show_records?>]
				  }
				  <? } ?>
                },
                {
                  extend: 'pdf',
                  className: "btn btn-default buttons-pdf buttons-html5 btn-sm",
				  <? if ($list_fields_count > 0){ ?>
				  exportOptions: {
                    columns: [<?=$show_records?>]
				  }
				  <? } ?>
                },
                {
                  extend: 'print',
                  className: "btn btn-default buttons-print buttons-html5 btn-sm",
				  <? if ($list_fields_count > 0){ ?>		  
				  exportOptions: {
                    columns: [<?=$show_records?>]
				  }
				  <? } ?>
                }
			  <?php } ?>
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });

	  
    </script>
	
    <!-- /Datatables -->
  </body>
</html>